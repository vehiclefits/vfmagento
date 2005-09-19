<?php
class Elite_Vaf_Model_ObserverTests_YMMGlobalTest extends Elite_Vaf_Model_ObserverTests_TestCase
{
    function doSetUp()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'year' => array('global'=>true),
            'make' => array('global'=>true),
            'model'
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
        $product = $this->product();
        $vehicle1 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $vehicle2 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Accord'));
        $vehicle3 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Civic'));


        // request to add a vehicle based upon it's 'formatted string' (level name [year] and ID).
        $formattedString = 'make:'.$vehicle1->getValue('make').';model:' . $vehicle1->getValue('model') . ';year:'.$vehicle1->getValue('year').';';
        $request = $this->getRequest();
        $request->setParam('vaf', array($formattedString));

        $this->observer($request);

        // request to add a vehicle based upon it's 'formatted string' (level name [year] and ID).
        $formattedString = 'make:'.$vehicle2->getValue('make').';model:' . $vehicle2->getValue('model') . ';year:'.$vehicle2->getValue('year').';';
        $request = $this->getRequest();
        $request->setParam('vaf', array($formattedString));

        $this->observer($request);

        // request to add a vehicle based upon it's 'formatted string' (level name [year] and ID).
        $formattedString = 'make:'.$vehicle3->getValue('make').';model:' . $vehicle3->getValue('model') . ';year:'.$vehicle3->getValue('year').';';
        $request = $this->getRequest();
        $request->setParam('vaf', array($formattedString));

        $this->observer($request);

        $this->assertTrue($product->fitsVehicle($vehicle3));
        $this->assertTrue($product->fitsVehicle($vehicle2));
        $this->assertTrue($product->fitsVehicle($vehicle1));
    }

}
