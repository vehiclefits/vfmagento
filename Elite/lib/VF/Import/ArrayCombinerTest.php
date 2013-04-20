<?php
class VF_Import_ArrayCombinerTest extends Elite_Vaf_TestCase
{
    function test()
    {
        $traits = array (
            'make' => array(1,2),
            'model' => array(1,2),
            'year' => array(1,2)
        );

        $combiner = new VF_Import_ArrayCombiner();
        
        $combiner->setTraits($traits);
        $r = $combiner->getCombinations();   
        
        $this->assertEquals( 8, count($r) );
        $this->assertEquals( array('make'=>1,'model'=>1,'year'=>1), $r[0] );
        $this->assertEquals( array('make'=>1,'model'=>1,'year'=>2), $r[1] );
        $this->assertEquals( array('make'=>1,'model'=>2,'year'=>1), $r[2] );
        $this->assertEquals( array('make'=>1,'model'=>2,'year'=>2), $r[3] );
        $this->assertEquals( array('make'=>2,'model'=>1,'year'=>1), $r[4] );
        $this->assertEquals( array('make'=>2,'model'=>1,'year'=>2), $r[5] );
        $this->assertEquals( array('make'=>2,'model'=>2,'year'=>1), $r[6] );
        $this->assertEquals( array('make'=>2,'model'=>2,'year'=>2), $r[7] );

    }
}