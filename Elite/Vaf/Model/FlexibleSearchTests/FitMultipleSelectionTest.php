<?php
class Elite_Vaf_Model_FlexibleSearchTests_FitMultipleSelectionTest extends Elite_Vaf_Helper_DataTestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
      
    function testMultipleSelections()
    {
        $civic2000 = $this->createMMY('Honda','Civic','2000');
        $civic2001 = $this->createMMY('Honda','Civic','2001');
       
        $requestParams = array(
            'make' => $civic2000->getValue('make'),
            'model' => $civic2000->getValue('model'),
            'year_start' => $civic2000->getValue('year'),
            'year_end' => $civic2001->getValue('year')
        );
        $helper = $this->getHelper( array(), $requestParams );
        
        return $this->markTestIncomplete();
    }

}