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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Model_Catalog_ProductTests_GetMappingIdTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{

    function testMappingId()
    {
        $vehicle = $this->createMMY();
        $mapping_id = $this->insertMappingMMY( $vehicle, 1 );
        
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId( 1 );
        
        $this->assertEquals( $mapping_id, $product->getMappingId( $vehicle ), 'should find the mapping id for a definition' );
    }
    
    function testMappingIdProductDifferent()
    {
        $vehicle= $this->createMMY();
        $mapping_id = $this->insertMappingMMY( $vehicle, 2 );
        
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId( 1 );

        $this->assertEquals( null, $product->getMappingId( $vehicle ), 'should return null if a product has no mappings' );
    }

}