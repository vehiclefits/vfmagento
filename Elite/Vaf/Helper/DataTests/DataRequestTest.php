<?php
class Elite_Vaf_Helper_DataTests_DataRequestTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{
    function testReqeust()
    {
        $this->setRequestParams(array('make'=>'honda'));
        $this->assertEquals('honda', Elite_Vaf_Helper_Data::getInstance()->getRequest()->getParam('make') );
    }
    
}