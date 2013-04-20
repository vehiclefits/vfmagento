<?php
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