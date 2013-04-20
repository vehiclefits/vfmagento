<?php
class VF_SearchLevelYearRangeTest extends Elite_Vaf_TestCase
{

    function testYearSelected()
    {
        $civic2000 = $this->createMMY('Honda','Civic','2000');
        $civic2001 = $this->createMMY('Honda','Civic','2001');
        
        $searchlevel = new VF_SearchLevel_TestSub2();
        $searchlevel->display( new Elite_Vaf_Block_Search, 'year', null, null, 'year_start' );
        
        Elite_Vaf_Helper_Data::getInstance()->getRequest()->setParams(array(
            'make' => $civic2000->getValue('make'),
            'model' => $civic2000->getValue('model'),
            'year_start' => $civic2000->getLevel('year')->getId(),
            'year_end' => $civic2000->getLevel('year')->getId()
        ));
        
        $this->assertTrue( $searchlevel->getSelected($civic2000->getLevel('year')) );
        $this->assertFalse( $searchlevel->getSelected($civic2001->getLevel('year')) );
    }
    
    function testYearSelected2()
    {
        $civic2000 = $this->createMMY('Honda','Civic','2000');
        $civic2001 = $this->createMMY('Honda','Civic','2001');
        
        $searchlevel = new VF_SearchLevel_TestSub2();
        $searchlevel->display( new Elite_Vaf_Block_Search, 'year', null, null, 'year_start' );
        
        Elite_Vaf_Helper_Data::getInstance()->getRequest()->setParams(array(
            'make' => $civic2000->getValue('make'),
            'model' => $civic2000->getValue('model'),
            'year_start' => $civic2001->getLevel('year')->getId(),
            'year_end' => $civic2001->getLevel('year')->getId()
        ));
        
        $this->assertTrue( $searchlevel->getSelected($civic2001->getLevel('year')) );
        $this->assertFalse( $searchlevel->getSelected($civic2000->getLevel('year')) );
    }
    
    function testYearSelected3()
    {
        $civic2000 = $this->createMMY('Honda','Civic','2000');
        $civic2001 = $this->createMMY('Honda','Civic','2001');
        
        $searchlevel = new VF_SearchLevel_TestSub2();
        $searchlevel->display( new Elite_Vaf_Block_Search, 'year', null, null, 'year_start' );
        
        Elite_Vaf_Helper_Data::getInstance()->getRequest()->setParams(array(
            'make' => $civic2000->getValue('make'),
            'model' => $civic2000->getValue('model'),
            'year_start' => $civic2000->getLevel('year')->getId(),
            'year_end' => $civic2001->getLevel('year')->getId()
        ));
        
        $this->assertTrue( $searchlevel->getSelected($civic2000->getLevel('year')) );
        $this->assertFalse( $searchlevel->getSelected($civic2001->getLevel('year')) );
    }
    
    function testYearSelected_YearEnd()
    {
        $civic2000 = $this->createMMY('Honda','Civic','2000');
        $civic2001 = $this->createMMY('Honda','Civic','2001');
        
        $searchlevel = new VF_SearchLevel_TestSub2();
        $searchlevel->display( new Elite_Vaf_Block_Search, 'year', null, null, 'year_end' );
        
        Elite_Vaf_Helper_Data::getInstance()->getRequest()->setParams(array(
            'make' => $civic2000->getValue('make'),
            'model' => $civic2000->getValue('model'),
            'year_start' => $civic2000->getLevel('year')->getId(),
            'year_end' => $civic2001->getLevel('year')->getId()
        ));
        
        $this->assertFalse( $searchlevel->getSelected($civic2000->getLevel('year')) );
        $this->assertTrue( $searchlevel->getSelected($civic2001->getLevel('year')) );
    }
    
}

class VF_SearchLevel_TestSub2 extends VF_SearchLevel
{
    function __($arg)
    {
        return $arg;
    }
}