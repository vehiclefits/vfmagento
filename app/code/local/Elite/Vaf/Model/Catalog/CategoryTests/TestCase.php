<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class Elite_Vaf_Model_Catalog_CategoryTests_TestCase extends VF_TestCase
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
        VF_Singleton::getInstance()->getRequest()
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