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
class Elite_Vafnote_Observer_Importer_MappingsTests_MultipleTest extends Elite_Vafnote_Observer_Importer_MappingsTests_TestCase
{    
    protected $product_id;
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->insertProduct('sku');
    }
    
    function testNotesMultiple()
    {       
        $this->createNoteDefinition('code1','foo');
        $this->createNoteDefinition('code2','bar');
        $this->import('sku, make, model, year, notes
sku, honda, civic, 2000, "code1,code2",
sku, honda, civic, 2001, "code1,code2",');
        $this->import('sku, make, model, year, notes
sku, honda, civic, 2000, "code1,code2",
sku, honda, civic, 2001, "code1,code2",');
        $this->assertTrue(true,'should not throw exception');
    }

    function testNotesMultiple2()
    {       
        $this->insertProduct('sku1');
        $this->insertProduct('sku2');
        
        $csvData = 'sku, make, model, year, notes
                    sku2, honda, civic, 2000, "code1,code2",
                    sku1, honda, civic, 2000, "code1,code2",';

        $this->createNoteDefinition('code1','foo');
        $this->createNoteDefinition('code2','bar');
        $this->import('sku, make, model, year, notes
sku, honda, civic, 2000, "code1,code2",
sku, honda, civic, 2001, "code1,code2",');
        
        //print_r($this->getReadAdapter()->query('select * from elite_mapping')->fetchAll());
        $count = $this->getReadAdapter()->query('select count(*) from elite_mapping_notes')->fetchColumn();
        $this->assertEquals(4, $count);
    }
}