<?php
class VF_Level_FinderTests_FindByTitleInUseTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldNotIncludeOptionsNotInUse()
    {
        $vehicle1 = $this->createMMY( 'A', 'A', '1' );
        $vehicle2 = $this->createMMY( 'A', 'B', '1' );
        $vehicle3 = $this->createMMY( 'A', 'C', '1' );

        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );

        $model = new VF_Level('model');
        $actual = $model->listInUseByTitle();
        $this->assertEquals( 'A', $actual[0]->getTitle() );
        $this->assertEquals( 'B', $actual[1]->getTitle() );
        $this->assertFalse( isset($actual[2]) );
    }
    
    function testWithParentModel()
    {
        $vehicle1 = $this->createMMY( 'Acura', 'Integra', '2002' ); 
        $vehicle2 = $this->createMMY( 'Honda', 'Accord', '2002' ); 
        $vehicle3 = $this->createMMY( 'Honda', 'Civic', '2002' ); 
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $model = new VF_Level('model');
        $actual = $model->listInUseByTitle( array( 'make' => $vehicle2->getLevel('make')->getTitle() ) );
        $this->assertEquals( 2, count($actual ) );
        $this->assertEquals( $vehicle2->getLevel('model')->getId(), $actual[0]->getId() );
        $this->assertEquals( $vehicle3->getLevel('model')->getId(), $actual[1]->getId() );
    } 
    
    function testWithParentYear()
    {
        $vehicle1 = $this->createMMY( 'Acura', 'Integra', '2002' ); 
        $vehicle2 = $this->createMMY( 'Honda', 'Accord', '2002' ); 
        $vehicle3 = $this->createMMY( 'Honda', 'Civic', '2002' ); 
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $year = new VF_Level('year');
        $actual = $year->listInUseByTitle( array( 'make' => $vehicle2->getLevel('make')->getTitle(), 'model'=> $vehicle2->getLevel('model')->getTitle()) );
        $this->assertEquals( 1, count($actual ) );
        $this->assertEquals( $vehicle2->getLevel('year')->getId(), $actual[0]->getId() );

    } 
}