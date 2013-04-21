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
class VF_LevelsTests_ConformTests_MMYTest extends Elite_Vaf_TestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testConformsLevelMake()
    {
        $honda = new VF_Level( 'make' );
        $honda->setTitle('Honda');
        $honda->save();
        
        $honda2 = new VF_Level( 'make' );
        $honda2->setTitle('Honda');
        $honda2->save();
        
        $this->assertEquals( $honda->getId(), $honda2->getId(), 'when saving two makes with same title, they should get the same id' );
    }
    
    function testConformsLevelModel()
    {
        $honda = new VF_Level( 'make' );
        $honda->setTitle('Honda');
        $honda_make_id = $honda->save();
        
        $civic = new VF_Level( 'model' );
        $civic->setTitle('Civic');
        $civic->save( $honda_make_id );
            
        $civic2 = new VF_Level( 'model' );
        $civic2->setTitle('Civic');
        $civic2->save( $honda_make_id );
        
        $this->assertEquals( $civic->getId(), $civic2->getId(), 'when saving two models with the same titles & under the same make, they should get the same id' );
    }
    
    function testDoesntConformModelFromDiffrentMake()
    {
        $honda = new VF_Level( 'make' );
        $honda->setTitle('Honda');
        $honda_make_id = $honda->save();
        
        $civic = new VF_Level( 'model' );
        $civic->setTitle('Civic');
        $civic->save( $honda_make_id );
        
        $ford = new VF_Level( 'make' );
        $ford->setTitle('Ford');
        $ford_make_id = $ford->save();
            
        $civic2 = new VF_Level( 'model' );
        $civic2->setTitle('Civic');
        $civic2->save( $ford_make_id );
        
        $this->assertEquals( $civic->getId(), $civic2->getId(), 'when saving two models with same title, but under different makes, they should get same ids' );
    }
    
          
}
