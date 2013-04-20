<?php
abstract class Elite_Vaf_Model_Catalog_ProductTests_TestCase extends Elite_Vaf_TestCase
{
    const PRODUCT_ID = 1;
    const PRODUCT_NAME = 'Widget';
    
    /**
    * creates a product that inherits a stubbed out abstract class to "break" Magento's inheritence hierarchy
    * see bootstrap-tests.php
    * 
    * @return Elite_Vaf_Model_Catalog_Product
    */
    protected function getProduct( $id = 0 )
    {
        $product = $this->getMock( 'Elite_Vaf_Model_Catalog_Product', array( 'getId' ) );
        $product->expects( $this->any() )->method( 'getId' )->will( $this->returnValue( $id ) );
        return $product;
    }
        
    protected function getMappingRow( $expectedRow, $msg = '' )
    {
        $query = sprintf(
            "SELECT * FROM `elite_1_mapping` WHERE `make_id` = %d AND `model_id` = %d AND `year_id` = %d",
            $expectedRow['make_id'],
            $expectedRow['model_id'],
            $expectedRow['year_id']
        );
        $r = $this->query( $query ) or die( mysql_error() );
        $row = $r->fetch( Zend_Db::FETCH_ASSOC );
        return $row;
    }

    function add100Fitments($product, $amount=100)
    {
        for($i=1; $i<=$amount; $i++)
        {
            $vehicle = $this->createMMY('Honda'.$i,'Civic'.$i,rand(2000,2010));
            $product->addVafFit($vehicle->toValueArray());
        }

        $this->setRequestParams($vehicle->toValueArray());
        $product->setCurrentlySelectedFit( $vehicle);
    }

    function getProduct2($config)
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $product->setName( self::PRODUCT_NAME );
        $product->setConfig($config);
        return $product;
    }
}