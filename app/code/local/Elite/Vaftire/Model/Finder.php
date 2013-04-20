<?php
class Elite_Vaftire_Model_Finder
{
    function sectionWidths()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_tire','distinct(section_width) section_width')
            ->order('section_width');
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            $return[ $row['section_width'] ] = $row['section_width'];
        }
        return $return;
    }
    
    function aspectRatios()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_tire','distinct(aspect_ratio) aspect_ratio')
            ->order('aspect_ratio');
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            $return[ $row['aspect_ratio'] ] = $row['aspect_ratio'];
        }
        return $return;
    }
    
    function diameters()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_tire','distinct(diameter) diameter')
            ->order('diameter');
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            $return[ $row['diameter'] ] = $row['diameter'];
        }
        return $return;
    }
    
    function productIds( Elite_Vaftire_Model_TireSize $tireSize, $tireType = null )
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_tire','distinct(entity_id) entity_id')
            ->where('section_width = ?', $tireSize->sectionWidth() )
            ->where('aspect_ratio = ?', $tireSize->aspectRatio() )
            ->where('diameter = ?', $tireSize->diameter() );
        if(!is_null($tireType))
        {
			$select->where('tire_type = ?',$tireType);
        }
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            array_push($return,$row['entity_id']);
        }
        return $return;
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}