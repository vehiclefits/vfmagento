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
class VF_Level_FinderTests_ListAllTests_YMMETest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('year,make,model,engine');
    }
    
    function testYMME()
    {
        $y2000 = $this->newLevel('year','2000');
        $y2000->save();
        
        $honda = $this->newLevel('make','Honda');
        $honda->save( $y2000->getId() );
        
        $civic = $this->newLevel('model','Civic');
        $civic->save( $honda->getId() );
        
        $civicEngine = $this->newLevel('engine','1.6L');
        $civicEngine->save( $civic->getId() );
        
        $accord = $this->newLevel('model','Accord');
        $accord->save( $honda->getId() );
        
        $actual = $this->levelFinder()->listAll('engine', $accord->getId() );
        $this->assertEquals( 0, count($actual) );
    }
    
}