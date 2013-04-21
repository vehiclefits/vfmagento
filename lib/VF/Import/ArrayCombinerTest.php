<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
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