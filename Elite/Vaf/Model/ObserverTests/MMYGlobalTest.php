<?php
class Elite_Vaf_Model_ObserverTests_MMYGlobalTest extends Elite_Vaf_Model_ObserverTests_TestCase
{

    function doSetUp()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'make' => array('global'=>true),
            'model',
            'year' => array('global'=>true)
        ));
        $this->startTransaction();
    }

    function doTearDown()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }

    function testShouldAddFitment()
    {
        return $this->markTestIncomplete();
        
        $product = $this->product();
        $vehicle1 = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        $vehicle2 = $this->createVehicle(array('make'=>'Ford', 'model'=>'F-150', 'year'=>2000));

        // request to add a vehicle based upon it's 'formatted string' (level name [year] and ID).
        $formattedString = 'make:'.$vehicle2->getValue('make').';model:' . $vehicle2->getValue('model') . ';year:'.$vehicle2->getValue('year').';';
        $request = $this->getRequest();
        $request->setParam('vaf', array($formattedString));

        $this->observer($request);

        $this->assertTrue($product->fitsVehicle($vehicle2), 'should have added the vehicle');
        $this->assertFalse($product->fitsVehicle($vehicle1), 'should NOT add the wrong vehicle');
    }
    
    
}