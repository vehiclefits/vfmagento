<?php
class Elite_Vaftire_Model_FlexibleSearchTests extends Elite_Vaf_TestCase
{

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldSelectAspectRatio()
    {
        $vehicle = $this->createTireMMY('Honda','Civic','2000');
        $vehicle->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $search = $this->flexibleTireSearch($vehicle->toValueArray());
        $this->assertEquals( 55, $search->aspectRatio(), 'should preselect aspect ratio when selecting vehicle');
    }
       
    function testShouldSelectSectionWidth()
    {
        $vehicle = $this->createTireMMY('Honda','Civic','2000');
        $vehicle->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $search = $this->flexibleTireSearch($vehicle->toValueArray());
        $this->assertEquals( 205, $search->sectionWidth(), 'should preselect section width when selecting vehicle');
    }
      
    function testShouldSelectDiameter()
    {
        $vehicle = $this->createTireMMY('Honda','Civic','2000');
        $vehicle->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $search = $this->flexibleTireSearch($vehicle->toValueArray());
        $this->assertEquals( 16, $search->diameter(), 'should preselect diameter when selecting vehicle');
    }
      
    function testShouldBeAbleToOverrideSize()
    {
        $vehicle = $this->createTireMMY('Honda','Civic','2000');
        $vehicle->addTireSize( Elite_Vaftire_Model_TireSize::create('205/55-16') );
        
        $params = $vehicle->toValueArray();
        $params['section_width'] = 3;
        
        $search = $this->flexibleTireSearch($params);
        $this->assertEquals( 3, $search->sectionWidth(), 'should be able to override');
    }
}