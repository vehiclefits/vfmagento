<?php
class VF_Level_FinderTests_ListInUseTest extends Elite_Vaf_TestCase
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
        $actual = $model->listInUse();
        $this->assertEquals( 'A', $actual[0]->getTitle() );
        $this->assertEquals( 'B', $actual[1]->getTitle() );
        $this->assertFalse( isset($actual[2]) );
    }

    function testShouldNotIncludeOptionsWhenNoFitments()
    {        
        $vehicle = $this->createMMY( 'A', 'A', '1' );

        $model = new VF_Level('model');
        $actual = $model->listInUse();
        $this->assertEquals(0,count($actual), 'when no fitments, should not list anything');
    }


    function testShouldSort()
    {                   
        $vehicle1 = $this->createMMY( 'A', 'A', '1' ); 
        $vehicle2 = $this->createMMY( 'A', 'B', '1' );
        $vehicle3 = $this->createMMY( 'A', 'C', '1' );
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $model = new VF_Level('model');
        $actual = $model->listInUse();
        $this->assertEquals( 'A', $actual[0]->getTitle(), 'should sort items' );
        $this->assertEquals( 'B', $actual[1]->getTitle(), 'should sort items' );
        $this->assertEquals( 'C', $actual[2]->getTitle(), 'should sort items' );
    }
    
    function testFlexible()
    {                   
        $vehicle1 = $this->createMMY( 'A', 'A', '2000' ); 
        $vehicle2 = $this->createMMY( 'A', 'B', '2000' ); 
        $vehicle3 = $this->createMMY( 'A', 'C', '2000' );
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $parents = array('make' => $vehicle1->getLevel('make')->getId(), 'model' => $vehicle1->getLevel('model')->getId(), 'year' => '-please select-');
        $model = new VF_Level('model');
        $actual = $model->listInUse( $parents );
        $this->assertEquals( 'A', $actual[0]->getTitle(), 'should sort items when flexible selection is made' );
        $this->assertEquals( 'B', $actual[1]->getTitle(), 'should sort items when flexible selection is made' );
        $this->assertEquals( 'C', $actual[2]->getTitle(), 'should sort items when flexible selection is made' );
    }
    
    function testWithSelection()
    {                   
        $vehicle1 = $this->createMMY( 'Honda', 'Civic', '2001' ); 
        $vehicle2 = $this->createMMY( 'Honda', 'Civic', '2002' ); 
        $vehicle3 = $this->createMMY( 'Honda', 'Civic', '2003' ); 
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $parents = array('make'=>$vehicle1->getLevel('make')->getId(),'model'=>$vehicle1->getLevel('model')->getId(), 'year'=>$vehicle1->getLevel('year')->getId());

        $year = new VF_Level('year');
        $actual = $year->listInUse( $parents );
        $this->assertEquals( '2001', $actual[0]->getTitle(), 'If a year is selected (and thus in the parents array), all years should still be listed as available options' );
        $this->assertEquals( '2002', $actual[1]->getTitle(), 'If a year is selected (and thus in the parents array), all years should still be listed as available options' );
        $this->assertEquals( '2003', $actual[2]->getTitle(), 'If a year is selected (and thus in the parents array), all years should still be listed as available options' );
    }  
    
    function testForProduct()
    {
        $vehicle1 = $this->createMMY( 'Honda', 'Civic', '2001' ); 
        $vehicle2 = $this->createMMY( 'Honda', 'Civic', '2002' ); 
        $vehicle3 = $this->createMMY( 'Honda', 'Civic', '2003' ); 
        
        $product_id = 1;
        
        $this->insertMappingMMY( $vehicle1, $product_id );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $model = new VF_Level('model');
        $actual = $model->listInUse( array(), $product_id );
        $this->assertEquals( 1, count($actual), 'should only return 1 model' );
        $this->assertEquals( $vehicle1->getLevel('model')->getId(), $actual[0]->getId(), 'should only return models for which there are fits, and those fits are for this product_id' );
    }  
    
    /**
    * @expectedException VF_Level_Exception
    */
    function testWithInvalidLevelThorwsException()
    {
        $model = new VF_Level('model');
        $actual = $model->listInUse( array( 'foo' => 0 ) );
    }  
    
    function testWithParentId()
    {
        $vehicle1 = $this->createMMY( 'Acura', 'Integra', '2002' ); 
        $vehicle2 = $this->createMMY( 'Honda', 'Accord', '2002' ); 
        $vehicle3 = $this->createMMY( 'Honda', 'Civic', '2002' ); 
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $model = new VF_Level('model');
        $actual = $model->listInUse( array( 'make' => $vehicle2->getLevel('make')->getId() ) );
        $this->assertEquals( 2, count($actual ) );
        $this->assertEquals( $vehicle2->getLevel('model')->getId(), $actual[0]->getId() );
        $this->assertEquals( $vehicle3->getLevel('model')->getId(), $actual[1]->getId() );
    }  
    
    function testWithLeafAsParent()
    {
        $vehicle = $this->createMMY( 'Acura', 'Integra', '2002' ); 
        $this->insertMappingMMY( $vehicle );
        
        $model = new VF_Level('model');
        $actual = $model->listInUse( array( 'year' => $vehicle->getLevel('year')->getId() ) );
        $this->assertEquals( $vehicle->getLevel('model')->getId(), $actual[0]->getId() );
    }
    
    function testIsRepeatable()
    {
        $vehicle1 = $this->createMMY( 'Honda', 'A', '2002' ); 
        $vehicle2 = $this->createMMY( 'Honda', 'B', '2002' ); 
        $vehicle3 = $this->createMMY( 'Honda', 'C', '2002' ); 
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $model = new VF_Level('model');
        $actual = $model->listInUse( array( 'make' => $vehicle1->getLevel('make')->getId() ) );
        
        $this->assertEquals( 3, count($actual ) );
        $this->assertEquals( $vehicle1->getLevel('model')->getId(), $actual[0]->getId() );
        $this->assertEquals( $vehicle2->getLevel('model')->getId(), $actual[1]->getId() );
        $this->assertEquals( $vehicle3->getLevel('model')->getId(), $actual[2]->getId() );
    }
    
    function testMakeDesc()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->setSorting('make','desc');
        
        $schema = new VF_Schema();
        $this->assertEquals( 'desc', $schema->getSorting('make') );
        
        $vehicle1 = $this->createMMY('A', 'Civic', '2000');
        $vehicle2 = $this->createMMY('B', 'Civic', '2000');
        $vehicle3 = $this->createMMY('C', 'Civic', '2000');
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $make = new VF_Level( 'make' );
        $actual = $make->listInUse();
        
        $this->assertEquals( "C", $actual[0]->getTitle(), 'should return makes, in DESC order' );
        $this->assertEquals( "B", $actual[1]->getTitle(), 'should return makes, in DESC order' );
        $this->assertEquals( "A", $actual[2]->getTitle(), 'should return makes, in DESC order' );
    }
    
    function testMakeAsc()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->setSorting('make','asc');
        
        $schema = new VF_Schema();
        $this->assertEquals( 'asc', $schema->getSorting('make') );
        
        $vehicle1 = $this->createMMY('A', 'Civic', '2000');
        $vehicle2 = $this->createMMY('B', 'Civic', '2000');
        $vehicle3 = $this->createMMY('C', 'Civic', '2000');
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $make = new VF_Level( 'make' );
        $actual = $make->listInUse();
        
        $this->assertEquals( "A", $actual[0]->getTitle(), 'should return makes, in ASC order' );
        $this->assertEquals( "B", $actual[1]->getTitle(), 'should return makes, in ASC order' );
        $this->assertEquals( "C", $actual[2]->getTitle(), 'should return makes, in ASC order' );
    }
    
    function testYearDesc()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->setSorting('year','desc');
        
        $schema = new VF_Schema();
        $this->assertEquals( 'desc', $schema->getSorting('year') );
        
        $vehicle1 = $this->createMMY('Honda', 'Civic', '1999');
        $vehicle2 = $this->createMMY('Honda', 'Civic', '2000');
        $vehicle3 = $this->createMMY('Honda', 'Civic', '2001');
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $year = new VF_Level( 'year' );
        $actual = $year->listInUse( array( 'model' => $vehicle1->getLevel('model')->getId() ) );
        
        $this->assertEquals( "2001", $actual[0]->getTitle(), 'should return years, in DESC order' );
        $this->assertEquals( "2000", $actual[1]->getTitle(), 'should return years, in DESC order' );
        $this->assertEquals( "1999", $actual[2]->getTitle(), 'should return years, in DESC order' );
    }

    function testYearAsc()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->setSorting('year','asc');
        
        $schema = new VF_Schema();
        $this->assertEquals( 'asc', $schema->getSorting('year') );
        
        $vehicle1 = $this->createMMY('Honda', 'Civic', '1999');
        $vehicle2 = $this->createMMY('Honda', 'Civic', '2000');
        $vehicle3 = $this->createMMY('Honda', 'Civic', '2001');
        
        $this->insertMappingMMY( $vehicle1 );
        $this->insertMappingMMY( $vehicle2 );
        $this->insertMappingMMY( $vehicle3 );
        
        $year = new VF_Level( 'year' );
        $actual = $year->listInUse( array( 'model' => $vehicle1->getLevel('model')->getId() ) );
        
        $this->assertEquals( "1999", $actual[0]->getTitle(), 'should return years, in ASC order' );
        $this->assertEquals( "2000", $actual[1]->getTitle(), 'should return years, in ASC order' );
        $this->assertEquals( "2001", $actual[2]->getTitle(), 'should return years, in ASC order' );
    }
    
//    protected function createDefinitionAndFit()
//    {
//        $vehicle = $this->createMMYWithAdditionalModels();
//        $this->insertMappingMMY( $vehicle );
//        $this->insertAdditionalModelFits();
//        return $vehicle;
//    }
    
//    protected function insertAdditionalModelFits( )
//    {
//        $this->insertMappingMMY( $this->make_id, $this->model1 );
//        $this->insertMappingMMY( $this->make_id, $this->model2 );
//    }
    
}
