<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Vehicle Fits llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
class VF_Level_Finder_Selector extends VF_Level_Finder_Abstract implements VF_Level_Finder_Interface
{
    /** @var mixed either NULL, or an array representing cached objects for listAll() method */
    protected $objs;
    protected $objs_in_use; 
    
    /** @var integer number of children under this's finder's entity node (cache for getChildCount) */
    protected $child_count;  
    protected $children;
    protected $children_in_use; 
    
    protected $ancestors_in_use;
    
    function find( $level, $id )
    {
        if( !(int)$id )
        {
            return;
        }
        
        if($this->identityMap()->has($level,$id))
        {
            return $this->identityMap()->get($level,$id);
        }
        
        $select = $this->getReadAdapter()->select()
            ->from($this->getTable($level))
            ->where('id =? ', $id )
            ->limit(1);
            
        $row = $select->query()->fetchObject();
        if( !is_object( $row ) )
        {
            throw new VF_Level_Exception_NotFound( 'error initializing model with level [' . $level . '] and id [' . $id . ']' );
        }
        
        $level = new VF_Level($level,$id);
        $level->setTitle( $row->title );
        
        $this->identityMap()->add($level);
        return $level;
    }
    
    function identityMap()
    {
        if(is_null($this->identityMap))
        {
            $this->identityMap = new VF_Level_IdentityMap;
        }
        return $this->identityMap;
    }

    function getChildren( VF_Level $entity )
    {
        if($this->getSchema()->isGlobal($entity->getType()) && $this->getSchema()->getRootLevel() != $entity->getType())
        {
            throw new Exception('ambiguous operation');
        }
        
        if( $entity->getNextLevel() == '' )
        {
            throw new Exception( 'this type doesnt have children' );
        }
        
        $nextLevelsTable = $this->getSchema()->levelTable($entity->getNextLevel());
        $q = $this->getReadAdapter()->select()
            ->from(array('l'=>$nextLevelsTable))
            ->joinLeft(array('d'=>$this->getSchema()->definitionTable()), 'l.id = d.' . $entity->getNextLevel() . '_id', array())
            ->where('d.' . $entity->getType() . '_id = ?', $entity->getId() )
            ->order('title')
            ->group('l.id');
           
        $r = $this->query( $q );
        $children = array();
        foreach( $r->fetchAll( Zend_Db::FETCH_OBJ ) as $row )
        {
            $child = $entity->createEntity( $entity->getNextLevel() );
            $child->setId( $row->id );
            $child->setTitle( $row->title );
            $children[] = $child;
        }
        return $children;
    }
    
    /** @param string level type */
    protected function sortingDirection( $type )
    {
        return $type == $this->getSchema()->getLeafLevel() ? $this->getConfig()->search->leafSorting : 'ASC';
    }
    
    function getChildCount( VF_Level $entity )
    {
        if($this->getSchema()->isGlobal($entity->getType()) && $this->getSchema()->getRootLevel() != $entity->getType())
        {
            throw new Exception('ambiguous operation');
        }
        if( !is_array( $this->child_count ) )
        {
            $this->child_count = $this->doGetChildCount( $entity );
        }
        return $this->child_count; 
    }
    
    protected function doGetChildCount( VF_Level $entity )
    {    
        if( $entity->getNextLevel() == '' )
        {
            return 0;
        }
        
        $q = $this->getReadAdapter()->select()
            ->from(array('l'=>$this->getSchema()->levelTable($entity->getNextLevel())), 'count(distinct(l.id))')
            ->joinLeft(array('d'=>$this->getSchema()->definitionTable()), 'l.id = d.' . $entity->getNextLevel() . '_id', array())
            ->where('d.' . $entity->getType() . '_id = ?', $entity->getId() )
            ->where('d.' . $entity->getNextLevel() . '_id != 0' );
                              
        $r = $this->query( $q );
        return (int)$r->fetchColumn();
    }
    
    function listAll( VF_Level $entity, $parent_id = 0 )
    {
        if( isset( $this->objs[ $entity->getType() ][ $entity->getId() ] ) )
        {
            return $this->objs[ $entity->getType() ][ $entity->getId() ]; 
        }
        return $this->doListAll( $entity, $parent_id );
    }
    
    protected function doListAll( VF_Level $entity, $parent_id = 0 )
    {
        $select = $this->getReadAdapter()->select()
            ->from(array('l'=>$entity->getTable()))
            ->order('title')
            ->group('l.title');
            
        if( is_numeric($parent_id) && $parent_id > 0 && $entity->getPrevLevel() )
        {
            $select
                ->joinLeft(array('d'=>$this->getSchema()->definitionTable()), 'l.id = d.' . $entity->getType() . '_id', array())
                ->where('d.' . $entity->getPrevLevel() . '_id = ?', $parent_id );
        }
        
        if( is_array($parent_id) && $entity->getPrevLevel() )
        {
            $select->joinLeft(array('d'=>$this->getSchema()->definitionTable()), 'l.id = d.' . $entity->getType() . '_id', array());
            foreach( $parent_id as $level => $each_parent_id)
            {
                if(!in_array($level,$this->getSchema()->getLevels(),true))
                {
                    throw new VF_Level_Exception_InvalidLevel('Invalid level [' . $level . ']');
                }
                $select->where('d.' . $level . '_id = ?', $each_parent_id );
            }
        }
        
        $result = $select->query();
        
        $this->objs[ $entity->getType() ][ $entity->getId() ] = array();
        foreach( $result->fetchAll( Zend_Db::FETCH_OBJ ) as $row )
        {
            $obj = $this->find( $entity->getType(), $row->id );
            array_push( $this->objs[ $entity->getType() ][ $entity->getId() ], $obj );
        }
        return $this->objs[ $entity->getType() ][ $entity->getId() ];
    }
    
    function listInUseByTitle( VF_Level $entity, $parents = array(), $product_id = 0)
    {
        foreach($parents as $level=>$title)
        {
            $parentLevel = $this->getSchema()->getPrevLevel($level);
            if($parentLevel)
            {
                $parentId = $parents[$parentLevel];
                $parent = $this->findEntityByTitle($level, $title, $parentId);
            }
            else
            {
                $parent = $this->findEntityByTitle($level, $title);
            }
            $parents[$level] = $parent->getId();
        }
        return $this->listInUse( $entity, $parents, $product_id );
    }
              
    function listInUse( VF_Level $entity, $parents = array(), $product_id = 0 )
    {
        unset( $parents[ $entity->getType() ] );
        if( isset( $this->objs_in_use[ $entity->getType() ][ $entity->getId() ] ) )
        {
            return $this->objs_in_use[ $entity->getType() ][ $entity->getId() ];
        }
        
        $result = $this->doListInUse( $entity, $parents, $product_id );
    
        $this->objs_in_use[ $entity->getType() ][ $entity->getId() ] = array();
        while( $row = $result->fetchObject() )
        {
            $obj = $entity->createEntity( $entity->getType(), 0 );
            $obj->setId( $row->id );
            $obj->setTitle( $row->title );
            array_push( $this->objs_in_use[ $entity->getType() ][ $entity->getId() ], $obj );
        }
        return $this->objs_in_use[ $entity->getType() ][ $entity->getId() ];
    }
    
    /** @todo - highly optomized for performance, write performance test case with 4.5 Million fitments if possible. used to take 100 seconds
     * optomized to take 1-3 seconds.
     */
    protected function doListInUse( $entity, $parents, $product_id = 0 )
    {
        $subQuery = $this->getReadAdapter()->select();
        $subQuery->from($this->getSchema()->mappingsTable().' as fitment', array($entity->getType() .'_id'));

        if( $product_id )
        {
            $subQuery->where( '`entity_id` = ?', $product_id );
        }
        
        foreach( $parents as $parentType => $parentId )
        {
            if( !in_array( $parentType, $this->getSchema()->getLevels() ) )
            {
                throw new VF_Level_Exception( $parentType );
            }
            if( !(int)$parentId )
            {
                continue;
            }
            $subQuery->where( sprintf( 'fitment.`%s_id` = ?', $parentType ), $parentId );
            
        }
        $subQuery->group($entity->getType() .'_id');
        
        $idSet = array();
        foreach( $subQuery->query()->fetchAll() as $id )
        {
            array_push($idSet,$id[$entity->getType() .'_id']);
        }
        
        $select = $this->getReadAdapter()->select();
        $select
        	->from( array('m'=>$this->getSchema()->levelTable($entity->getType()) ), array('id', 'title') )
        	->group('m.title');
        if(count($idSet))
        {
            $select->where('m.id IN (' . implode(',', $idSet) . ')');
        }
        else
        {
            $select->where('m.id IN (0)');
        }
        
        $select->order('m.title ' . $entity->getSortOrder());
        return $this->query( $select );
    }
    
    /** @return VF_Level */
    function findEntityByTitle( $type, $title, $parent_id = 0 )
    {
        $levelId = $this->findEntityIdByTitle($type,$title,$parent_id);
        if(!$levelId)
        {
            return false;
        }
        $level = new VF_Level($type,$levelId);
        $level->setTitle($title);
        return $level;
    }
    
    /** @return integer ID */
    function findEntityIdByTitle( $type, $title, $parent_id = 0 )
    {
        $identityMap = VF_Level_IdentityMap_ByTitle::getInstance();
        if( $identityMap->has($type,$title,$parent_id))
        {
            return $identityMap->get($type,$title,$parent_id);
        }
        
        if( !$this->getSchema()->isGlobal($type) && !$parent_id )
        {
            throw new VF_Level_Finder_SchemaException('Please specify parent level to search under. If you want all possible matches use the vehicle finder, not the level finder. Level requested was '.$type);
        }

        $inflectedType = $this->inflect($type);
        
        $query = $this->getReadAdapter()->select()
            ->from(array('l'=>'elite_level_' . $this->getSchema()->id() . '_' . $inflectedType))
            ->where('`title` LIKE binary ?', $title );
        
        if( !$this->getSchema()->isGlobal($type) && is_numeric($parent_id) && $parent_id )
        {
            $parent_type = $this->getSchema()->getPrevLevel($type);
            $inflected_parent_type = $this->inflect($parent_type);
            $query->joinLeft(array('d'=>'elite_' . $this->getSchema()->id() . '_definition'), "l.id = d.{$inflectedType}_id", array());
            $query->where('d.' . $inflected_parent_type . '_id = ?', $parent_id);
        }
        
        if( is_array($parent_id) )
        {
            $query->joinLeft(array('d'=>'elite_' . $this->getSchema()->id() . '_definition'), 'l.id = d.' . str_replace(' ', '_',$type) . '_id', array());
            foreach($parent_id as $level=>$val)
            {
                $query->where('d.' . str_replace(' ', '_',$level) . '_id = ?', $val);
            }
        }
        
        $result = $this->query($query);
        $id = $result->fetchColumn(0);
        if(!$id)
        {
            return false;
        }
        $identityMap->add($id,$type,$title,$parent_id);
        return $id;
    }

    function inflect($identifier)
    {
        return str_replace(' ', '_', $identifier);
    }
}