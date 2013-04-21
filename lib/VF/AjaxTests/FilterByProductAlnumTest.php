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
class VF_AjaxTests_FilterByProductAlnumTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }    

    function testShouldFilterModelByProduct()
    {
        $vehicle1 = $this->createMMY('Honda', 'Civic', '2000');
        $vehicle2 = $this->createMMY('Honda', 'Accord', '2001');
        
        $this->insertMappingMMY($vehicle1, 1);
        $this->insertMappingMMY($vehicle2, 2);
        
        $_GET['requestLevel'] = 'model';
        $_GET['product'] = 1;
        $_GET['make'] = $vehicle1->getLevel('make');
        $this->assertEquals( '<option value="' . $vehicle1->getLevel('model') . '">Civic</option>', $this->execute(), 'should list model for correct product only' );
    }
    
    
    function execute()
    {
        ob_start();
        $_GET['front']=1;
        $this->getAjax()->execute( $this->getSchema(), true );
        return ob_get_clean();
    }
    
    /** @return VF_Ajax */
    function getAjax()
    {
        return new VF_Ajax();
    }
    
    /** @return VF_Schema */
    function getSchema()
    {
        return new VF_Schema();
    }
}