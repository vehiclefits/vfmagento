<?php
class Elite_Vafpaint_Model_Paint_Mapper
{
    /**
    * Find the paint code for a fit
    * 
    * @param mixed $year_id
    * @return array of Elite_Vaf_Model_Paint
    */
    function findByFitId( $fit_id )
    {
        $select = $this->getReadAdapter()->select()
        	->from( 'elite_Fitment_paint' )
        	->where( 'Fitment_id = ?', (int)$fit_id );
        $result = $select->query();
        $return = array();
        while( $code = $result->fetch( Zend_Db::FETCH_OBJ ) )
        {
            array_push( $return, new Elite_Vafpaint_Model_Paint( $code->code, $code->name, $code->color, $code->id ) );
        }
        return $return;
    }
    
    /**
    * Find the paint code for a paint_id
    * 
    * @param mixed $paint_id
    * @return Elite_Vaf_Model_Paint
    */
    function find( $paint_id )
    {
        $select = $this->getReadAdapter()->select()
            ->from( 'elite_Fitment_paint' )
        	->where( 'id = ?', (int)$paint_id );
        $result = $select->query();
        $code = $result->fetch( Zend_Db::FETCH_OBJ );
        $paint = new Elite_Vafpaint_Model_Paint( $code->code, $code->name, $code->color, $code->id );
        return $paint;
    }
    
    /** @return Zend_Db_Statement_Interface */
    protected function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }

}