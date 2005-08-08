<?php
class Elite_Vafdiagram_Model_ProductFitments_CSV_Import extends Elite_Vafimporter_Model_ProductFitments_CSV_Import
{
	function insertRowsIntoTempTable()
    {
        $this->cleanupTempTable();
        while( $row = $this->getReader()->getRow() )
        {
            $this->row_number++;
            
            $values = $this->getLevelsArray( $row ); 
            if(!$values)
            {
                continue;
            }
            
            $combinations = $this->getCombinations($values, $row);
            
            foreach( $combinations as $combination )
            {
            	$serviceCode = $this->getFieldValue('service_code', $row);
            	foreach($this->serviceCodeCombinations($combination, $serviceCode) as $serviceCodeCombination)
            	{
					$this->insertIntoTempTable($row, $serviceCodeCombination);            		
            	}
            }
        }
    }
    
    function updateProductIdsInTempTable()
    {
    	
    }
    
	function serviceCodeCombinations($combination, $serviceCode)
    {
    	$combinations = array();
    	foreach($this->products($serviceCode) as $product_id)
    	{
    		$combinations[] = $combination + array(
    			'product_id' => $product_id
    		);
    	}
    	return $combinations;
    }
    
    function products($serviceCode)
    {
    	$rs = $this->getReadAdapter()->select()
    		->from('elite_product_servicecode', array('product_id'))
    		->where('elite_product_servicecode.service_code = ?', $serviceCode)
    		->query();
    	$products = array();
    	foreach($rs->fetchAll() as $row)
    	{
    		$products[] = $row['product_id'];
    	}
    	return $products;
    }
}