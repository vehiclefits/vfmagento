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
class Elite_Vaf_Adminhtml_Block_DefinitionsTests_ShouldSaveTest extends Elite_Vaf_TestCase
{
    const TITLE = 'test title';
    const ARBITRARY_STRING = 'sdfsdf';

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
       
    function testSaveActionNew()
    {
        $request = $this->getRequest( array(
            'save' => self::ARBITRARY_STRING, // FOR some reason the way this was implemented in the view script, the save button passes the id for editing, but an arbitrary string when doing new
            'title' => self::TITLE,
            'entity'=>'make'
        ));
        $controller = $this->definitionsController($request);
        
        $controller->saveAction();
        $this->assertTrue($this->vehicleExists(array('make'=>self::TITLE), true));
    }
    
    function testSaveActionEdit()
    {
        $make_id = $this->insertMake( self::ARBITRARY_STRING );
        
        $request = $this->getRequest( array(
            'save' => self::ARBITRARY_STRING,
            'title' => self::TITLE,
            'entity'=>'make'
        ));
        $controller = $this->definitionsController($request);
        
        $controller->saveAction();
        $this->assertTrue($this->vehicleExists(array('make'=>self::TITLE),true));
    }

    
}