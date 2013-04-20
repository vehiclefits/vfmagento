<?php
class VF_SchemaTests_SchemaSpaceInLevelNameTest extends VF_Import_TestCase
{
    function doSetUp()
    {
	$this->switchSchema('make,model type,year',true);
    }
    
    function testLevels()
    {
        $schema = new VF_Schema();
        $this->assertEquals( array('make','model type','year'), $schema->getLevels(), 'should allow spaces in level name' );
    }

    function testImport()
    {
	$this->importVehiclesList('make,model type, year' . "\n" .
		'Honda, Civic EX, 2000' );
    }

    function testGetFits()
    {
        $product = $this->newProduct(1);
        $vehicle = $this->createVehicle(array('make'=>'Honda', 'model type'=>'Civic', 'year'=>2000));
        $product->addVafFit( $vehicle->toValueArray() );

        $actual = $product->getFits();
        $this->assertEquals( 1, count($actual) );
        $fit = $actual[0];
        $this->assertEquals( $vehicle->toValueArray(), array('make'=>$fit->make_id,'model type'=>$fit->model_type_id,'year'=>$fit->year_id), 'should get fitment' );
    }
}
