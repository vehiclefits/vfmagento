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
abstract class Elite_Vaf_Model_Catalog_ProductTests_TestCase extends VF_TestCase
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
        $product = new Elite_Vaf_Model_Catalog_Product;
        $product->setId($id);
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