<?php
class VF_SearchTest extends Elite_Vaf_Block_SearchTests_TestCase
{

    function testSelected()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        
        $request = new Zend_Controller_Request_Http;
        $request->setParams($vehicle->toTitleArray());
        
        $search = new VF_Search;
        $search->setRequest($request);
        $this->assertEquals($vehicle->getValue('model'),$search->getSelected('model'));
    }
}