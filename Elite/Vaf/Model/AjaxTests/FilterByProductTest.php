<?php
class Vf_AjaxTests_FilterByProductTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }    

    function testShouldFilterModelByProduct()
    {
        $vehicle1 = $this->createMMY('Honda', 'Civic', '2000');
        $vehicle2 = $this->createMMY('Honda', 'Accord', '2001');
        
        $this->insertMappingMMY($vehicle1, 1);
        $this->insertMappingMMY($vehicle2, 2);
        
        $_GET['requestLevel'] = 'model';
        $_GET['product'] = 1;
        $_GET['make'] = $vehicle1->getValue('make');
        $this->assertEquals( '<option value="' . $vehicle1->getValue('model') . '">Civic</option>', $this->execute(), 'should list model for correct product only' );
    }
    
    
    function execute()
    {
        ob_start();
        $_GET['front']=1;
        $this->getAjax()->execute( $this->getSchema() );
        return ob_get_clean();
    }
    
    /** @return Vf_Ajax */
    function getAjax()
    {
        return new Vf_Ajax();
    }
    
    /** @return VF_Schema */
    function getSchema()
    {
        return new VF_Schema();
    }
}