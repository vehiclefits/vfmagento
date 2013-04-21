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
class VF_Level_Finder_UpdaterTest extends Elite_Vaf_TestCase
{
    function testSaveLevelWithParent()
    {
        $model = new VF_Level('model');
        $model->setTitle('Civic');
        $model->save();
        $model = $this->findEntityById( $model->getId(), $model->getType());
        
        $model->setTitle('Accord');
        $model->save();
        $model = $this->findEntityById( $model->getId(), $model->getType());
        
        $this->assertSame( 'Accord', $model->getTitle(), 'saved entity should have correct title value' );
    }
    
    function testSaveRootLevel()
    {
        $make = new VF_Level('make');
        $make->setTitle('Honda');
        $make = $this->saveAndReload( $make );
        
        $make->setTitle('Acura');
        $make = $this->saveAndReload( $make );
        
        $this->assertSame('Acura', $make->getTitle(), 'saved entity should have correct title value' );
    }

}