<?php
abstract class Elite_Vaf_Model_Catalog_CategoryTests_TestCase extends Elite_Vaf_TestCase
{
    const PRODUCT_ID = 5;
    
    protected function categoryFilterWillReturn( $bool )
    {
        $filter = $this->getMockFilterThatShouldReturn( $bool );
        $category = new Elite_Vaf_Model_Catalog_Category();
        $category->setFilter( $filter );
        return $category;
    }
    
    protected function getMockFilterThatShouldReturn( $bool )
    {
        $filter = $this->getMock( 'Elite_Vaf_Model_Catalog_Category_FilterImpl' );
        $filter->expects( $this->any() )->method('shouldShow')->will( $this->returnValue( $bool ) );
        return $filter;
    }
    
    protected function filterOnAMMY()
    {
        $vehicle = $this->createMMY();
        $this->insertMappingMMY( $vehicle, self::PRODUCT_ID );
        Elite_Vaf_Helper_Data::getInstance()->getRequest()
            ->setParam('make',$vehicle->getLevel('make')->getId())
            ->setParam('model',$vehicle->getLevel('model')->getId())
            ->setParam('year',$vehicle->getLevel('year')->getId());
    }
    
    protected function getCategory()
    {
        $category = new Elite_Vaf_Model_Catalog_Category();
        $category->setConfig( new Zend_Config( array( 'category' => array() ) ) );
        return $category;
    }
}