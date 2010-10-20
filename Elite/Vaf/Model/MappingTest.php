<?php
class Elite_Vaf_Model_MappingTest extends Elite_Vaf_TestCase
{
    function testSave()
    {
        $vehicle = $this->createMMY();
        $mapping = new Elite_Vaf_Model_Mapping( 1, $vehicle );
        $mapping_id = $mapping->save();
        $this->assertNotEquals(0,$mapping_id);
    }

    function testSaveRepeat()
    {
        $vehicle = $this->createMMY();
        $mapping = new Elite_Vaf_Model_Mapping( 1, $vehicle );
        $mapping_id1 = $mapping->save();
        $mapping_id2 = $mapping->save();
        $this->assertEquals($mapping_id1, $mapping_id2, 'on repeated save should return existing mapping id');
    }
    
    /**
    * @expectedException Exception
    */
    function testRequiresProduct()
    {
        $vehicle = $this->createMMY();
        $mapping = new Elite_Vaf_Model_Mapping( 0, $vehicle );
        $mapping_id = $mapping->save();
    }
}