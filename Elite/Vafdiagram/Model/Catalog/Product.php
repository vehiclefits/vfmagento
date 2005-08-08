<?php 
class Elite_Vafdiagram_Model_Catalog_Product
{
	/** @var Elite_Vaf_Model_Catalog_Product */
    protected $wrappedProduct;
   
    function __construct(Elite_Vaf_Model_Catalog_Product $productToWrap )
    {
        $this->wrappedProduct = $productToWrap;
    }

    function addServiceCode($serviceCode)
    {
    	$select = $this->getReadAdapter()->select()
            ->from('elite_product_servicecode')
            ->where('product_id = ?', (int)$this->getId())
            ->where('service_code = ?', $serviceCode);
        
        $result = $select->query();
        if($result->fetchColumn())
        {
            return;
        }
        
        $this->getReadAdapter()->insert('elite_product_servicecode', array(
            'product_id' => (int)$this->getId(),
            'service_code' => $serviceCode
        ));
    }
    
    function serviceCodes()
    {
    	$select = $this->getReadAdapter()->select()
            ->from('elite_product_servicecode', array('product_id','service_code'))
            ->where('product_id = ?', (int)$this->getId() );
        
        $result = $this->query($select);
        
        $return = array();
        foreach( $result->fetchAll(Zend_Db::FETCH_OBJ) as $row )
        {
            array_push($return, $row->service_code );
        }
        return $return;
    }
    
    function query($sql)
    {
    	return $this->getReadAdapter()->query($sql);
    }
    
	function __call($methodName,$arguments)
    {
        $method = array($this->wrappedProduct,$methodName);
        return call_user_func_array( $method, $arguments );
    }
    
 	/** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}