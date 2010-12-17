<?php
class Elite_Vafwheel_Model_Importer_Bolts extends Ne8Vehicle_Import_Abstract
{
	protected $reader;
	
    function getReader()
    {
    	if(isset($this->reader))
    	{
    		return $this->reader;
    	}
    	return $this->reader = new Csv_Reader( $this->file );
    }
	
	public function import()
    {
        
        $fields = $this->getFieldPositions();
        $reader = $this->getReader();

        while( $row = $this->getReader()->getRow() )
        {
            $sku = $row[ $fields[ 'sku' ] ];
            $pattern = $row[ $fields[ 'boltpattern' ] ];
            $this->doImport( $row, $fields, $sku, $pattern );
        }
    }
    
    protected function doImport( $row, $fields, $sku, $pattern )
    { 
        $boltPatterns = Elite_Vafwheel_Model_BoltPattern::create( $pattern );
        
        if( !is_array( $boltPatterns ) )
        {
            $boltPatterns = array( $boltPatterns );
        }
        foreach( $boltPatterns as $boltPattern )
        {
        	echo $boltPattern;
            if( !( $boltPattern instanceof Elite_Vafwheel_Model_BoltPattern ) )
            {       
                throw new Exception( 'Unable to lookup bolt pattern format [' . $pattern . ']' );
            }
            $product = Mage::getModel('catalog/product')->loadByAttribute('sku',$sku);
        	if( !$product instanceof Mage_Catalog_Model_Product )
            {
                $this->addError( null, 'sku not found ' . $sku );
                continue;
            }
            $product = new Elite_Vafwheel_Model_Catalog_Product($product);
            
            $product->addBoltPattern( $boltPattern );
        }
    }
    
    function addError($code, $msg)
    {
    	echo $msg;
    }
    
}