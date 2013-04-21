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
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_ProductCrossoverTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
	const PRODUCT_ID = 1;
    const PRODUCT_NAME = 'Widget';
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldNotCrossOverProducts()
    {
        $product1 = $this->getProduct(1);
        $product2 = $this->getProduct(2);

        $vehicle1 = $this->createMMY('Make', 'Model1');
        
        $mapping_id = $product1->addVafFit( array('make'=>$vehicle1->getLevel('make')->getId()) );    
        
        $actual = $product1->getFitModels();
        $this->assertEquals( 1, count($actual) );
        
        $actual = $product2->getFitModels();
        $this->assertEquals( 0, count($actual), 'fits should not cross over from one product to another' );
    }
}