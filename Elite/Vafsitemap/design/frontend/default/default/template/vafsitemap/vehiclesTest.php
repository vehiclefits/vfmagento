<?php
class Elite_Vafsitemap_design_frontend_VehiclesTest extends Elite_Vaf_TestCase
{

	function doSetUp()
	{
		$this->switchSchema('make,model,year');
	}
	
    function testNoExceptions()
    {
        try
        {
            $block = new Elite_Vafsitemap_Block_VehiclesTestSub;
            $block->_toHtml();
        }
        catch( Exception $e )
        {
            // bypasses Magento's error trapping
            $this->fail( $e->getMessage() );
        }
    }
    
    function testShouldBe50PerPage()
    {
        $this->createVehiclesWithMappings(75);
        
        $block = new Elite_Vafsitemap_Block_VehiclesTestSub;
        $output = $block->_toHtml();
        preg_match_all( '#Products for (.*?)#', $output, $matches );
        $this->assertEquals( 50, count($matches[0]), 'should show 50 vehicles per page' );
    }
    
    
    function createVehiclesWithMappings($amount)
    {
		for($i=0; $i<=$amount; $i++ )
		{
			$vehicle = $this->createMMY('Honda'.$i, 'Civic', '2000');
			$this->insertMappingMMY( $vehicle, 1 );
		}
    }
    
    // self shunted:
    
    function start()
    {
        return 0;
    }
    
    function end()
    {
        return 100;
    }
    
    function getVehicleUrl()
    {
		
    }
    
}

class Elite_Vafsitemap_Block_VehiclesTestSub extends Elite_Vafsitemap_Block_Vehicles
{
	function _toHtml()
	{	
		ob_start();
        include('vehicles.phtml');
        $output = ob_get_clean();
        return $output;
	}
	
	function getUrl() {}
	
	function htmlEscape($string)
	{
		return $string;
	}
}