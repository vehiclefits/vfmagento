<?php
class VF_Level_Finder_InserterTests_YMMEGlobalTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'year',
            'make' => array('global'=>true),
            'model',
            'engine'
        ));
        $this->startTransaction();
    }

    function testModelsShouldBeYearSpecific()
    {
        $y2000 = $this->newYear('2000');        
        $y2000->save();
        
        $y2001 = $this->newYear('2001');        
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2000->getId() );
        
        $honda = $this->newMake('Honda');
        $honda->save( $y2001->getId() );
        
        $civic = $this->newModel('Civic');
        $civic->save(array('make'=>$honda->getId(), 'year'=>$y2000->getId()));
        
        $civic = $this->newModel('Accord');
        $civic->save(array('make'=>$honda->getId(), 'year'=>$y2001->getId()));
        
        $this->assertTrue($this->vehicleExists(array('year'=>'2000', 'make'=>'Honda','model'=>'Civic'),true));
        $this->assertFalse($this->vehicleExists(array('year'=>'2001', 'make'=>'Honda','model'=>'Civic'),true));
        
        $this->assertTrue($this->vehicleExists(array('year'=>'2001', 'make'=>'Honda','model'=>'Accord'),true));
        $this->assertFalse($this->vehicleExists(array('year'=>'2000', 'make'=>'Honda','model'=>'Accord'),true));
    }
}