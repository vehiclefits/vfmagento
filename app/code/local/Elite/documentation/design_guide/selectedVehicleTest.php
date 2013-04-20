<?php
class selectedVehicleTest extends Elite_Vaf_TestCase
{
    function testSnippet1_WhenNoVehicle()
    {
        ob_start();
        $this->snippet1();
        $html = ob_get_clean();
        $this->assertEquals( '', $html );
    }
    
    function testSnippet1_WhenVehicle()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $this->setRequestParams($vehicle->toValueArray());
        
        ob_start();
        $this->snippet1();
        $html = ob_get_clean();
        $this->assertEquals( 'Showing products for your: Honda Civic 2000', $html );
    }
    
    function testSnippet2_WhenNoVehicle()
    {
        ob_start();
        $this->snippet2();
        $html = ob_get_clean();
        $this->assertEquals( '', $html );
    }
    
    function testSnippet2_WhenVehicle()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $this->setRequestParams($vehicle->toValueArray());
        
        ob_start();
        $this->snippet2();
        $html = ob_get_clean();
        $this->assertEquals( 'Showing products for your: 2000 Honda Civic', $html );
    }
    
    function snippet1()
    {
        // Showing products for your: 2009 Honda Civic
        $vehicleSelection = Elite_Vaf_Helper_Data::getInstance()->vehicleSelection();
        if( !$vehicleSelection->isEmpty() )
        {
            $vehicle = $vehicleSelection->getFirstVehicle();
            echo 'Showing products for your: ';
            echo $this->htmlEscape($vehicle); // 2009 Honda Civic
        }
    }
    
    function snippet2()
    {
        // Showing products for your: 2009 Honda Civic
        $vehicleSelection = Elite_Vaf_Helper_Data::getInstance()->vehicleSelection();
        if( !$vehicleSelection->isEmpty() )
        {
            $vehicle = $vehicleSelection->getFirstVehicle();
            echo 'Showing products for your: ';
            echo $this->htmlEscape($vehicle->getLevel('year')->getTitle());  // 2009
            echo ' ';
            echo $this->htmlEscape($vehicle->getLevel('make')->getTitle());  // Honda
            echo ' ';
            echo $this->htmlEscape($vehicle->getLevel('model')->getTitle());  // Civic
        }
    }
    
    function htmlEscape($val)
    {
        return htmlentities($val);
    }
}