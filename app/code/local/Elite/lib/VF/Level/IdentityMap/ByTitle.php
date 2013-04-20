<?php
class VF_Level_IdentityMap_ByTitle
{
	protected $levels = array();
    
    static function getInstance()
    {
        static $instance;
        if(is_null($instance))
        {
            $instance = new VF_Level_IdentityMap_ByTitle;
        }
        return $instance;
    }
    
    /** TEST ONLY */
    static function reset()
    {
        self::getInstance()->doReset();
    }
    
    /** TEST ONLY */
    function doReset()
    {
        $this->levels = array();
    }
    
    function add($id,$type,$title,$parent_id=null)
    {
        $levelArray = array();
        $levelArray['type'] = $type;
        $levelArray['title'] = $title;
        $levelArray['parent_id' ] = $parent_id;
        $levelArray['id' ] = $id;
        array_push($this->levels,$levelArray);
    }
    
    function remove($type,$id)
    {
        foreach($this->levels as $index => $levelArray)
        {
            if( $levelArray['type'] == $type &&
            	$levelArray['id'] == $id
            )
            {
                unset($this->levels[$index]);
                return;
            }
        }
    }
    
    function has($type,$title,$parent_id=null)
    {
    	foreach($this->levels as $levelArray)
        {
            if( $levelArray['type'] == $type &&
            	$levelArray['title'] === $title &&
            	$levelArray['parent_id' ]== $parent_id
            )
            {
                return true;
            }
        }
        return false;
    }
    
    function get($type,$title,$parent_id=null)
    {
        foreach($this->levels as $levelArray)
        {
            if( $levelArray['type'] == $type &&
            	$levelArray['title'] === $title &&
            	$levelArray['parent_id' ]== $parent_id
            )
            {
                return $levelArray['id'];
            }
        }
        return false;
    }
}