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
session_start();
require_once '../config.default.php';
require_once(getenv('PHP_MAGE_PATH').'/app/code/local/Elite/Vaf/bootstrap-tests.php');

$schemaGenerator = new VF_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array('make','model','year'));

$schema = new VF_Schema();

$vehicle = VF_Vehicle::create( $schema, array(
    'make' => 'Honda_Unique'.uniqid(),
    'model' => 'Civic',
    'year' => '2002'
));
$vehicle->save();

$values = $vehicle->toValueArray();

file_put_contents(sys_get_temp_dir().'/vf-ajax-tests','1');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <link rel="stylesheet" href="../qunit/qunit.css" type="text/css"/>
    <link rel="stylesheet" href="/skin/adminhtml/default/default/multiTree.css" type="text/css"/>
  </head>
  <body>
    <h1 id="qunit-header">VAF - Multi Tree</h1>
    <h2 id="qunit-banner"></h2>
    <h2 id="qunit-userAgent"></h2>
    <ol id="qunit-tests">
    </ol>
    
    <?php
    include('../multitree.include.php');
    $block = new Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tab_Vaf_AjaxTestStub;
    $block->toHtml();
    ?>
    
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            
            QUnit.done = function (failures, total) {
                jQuery.ajax('removeTmpLockFile.php');
                console.log('done');
                top.testPageComplete( 'multiTreeTest/MMY.php', failures, total );
            };

            module("Mutli Tree");
            
            test("Clicking Make Should Load Models", function() {
                stop(); 
                expect(1);
                
                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
                    
                    jQuery(".modelSelect").unbind('vafLevelLoaded');
                    firstOptionTextEquals( jQuery(".modelSelect"), "Civic" );
                    
                    start();
                });
                
                multiTreeClick( 'make', <?=$values['make']?> );
            });
            
            test("'quick add' make should 'quick add' new make to make select box", function() {
                stop(); 
                expect(3);
                jQuery('.vafQuickAdd_make').val('Acura');
                jQuery('.makeSelect').bind('vafLevelQuickAdd', function() {
                    
                    jQuery('.makeSelect').unbind('vafLevelQuickAdd');
                    
                    equals( jQuery('.makeSelect option:last').text(), 'Acura', "Should add option with title Acura" );
                    ok( jQuery('.makeSelect option:last').val() != 0, "Added option should have an id" );
                    equals( jQuery('.vafQuickAdd_make').val(), "", "should clear quick add box afterwards" );
                    
                    start();
                    
                });
                jQuery('.vafQuickAddSubmit_make').click();
            });
            
            test("Clicking add Should add make selection", function() {
                stop(); 
                expect(1);
                
                jQuery(".multiTree").bind( 'vafMultiTreeAdded', function() {
                    
                    equals( 'make:1;', jQuery('.multiTree-selection').find('.vafcheck').val() );
                    jQuery(".multiTree").unbind( 'vafMultiTreeAdded');
                    
                    start();
                });
                
                jQuery('.multiTree-Add').click();
            });
            
            test("Clicking Model Should Load Years", function() {
                stop(); 
                expect(1);
                
                jQuery(".yearSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    jQuery(".yearSelect").unbind('vafLevelLoaded');
                    firstOptionTextEquals( jQuery(".yearSelect"), "2002" );
                });
                
                multiTreeClick( 'model', <?=$values['model']?> );
            });
            
            test("'quick add' model should 'quick add' new model to model select box", function() {
                stop(); 
                expect(3);
                jQuery('.vafQuickAdd_model').val('Accord');
                
                jQuery('.modelSelect').bind('vafLevelQuickAdd', function() {
                    multiTreeClick( 'make', <?=$values['make']?> );
                });
                
                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    jQuery('.modelSelect').unbind('vafLevelQuickAdd');
                    
                    equals( jQuery('.modelSelect option:first').text(), 'Accord', "Should add option with title Accord" );
                    ok( jQuery('.modelSelect option:last').val() != 0, "Added option should have an id" );
                    equals( jQuery('.vafQuickAdd_model').val(), "", "should clear quick add box afterwards" );
                    
                });
                jQuery('.vafQuickAddSubmit_model').click();
            });
            
            test("Clicking add Should add model selection", function() {
                stop(); 
                expect(1);
                
                
                jQuery(".multiTree").bind( 'vafMultiTreeAdded', function() {
                    start();
                    equals( 'make:1;model:1;', jQuery('.multiTree-selection').find('.vafcheck').val() );
                    jQuery(".multiTree").unbind( 'vafMultiTreeAdded');
                });
                
                multiTreeClick( 'model', <?=$values['model']?> );
                jQuery('.multiTree-Add').click();
            });
            
        });
    </script>
  </body>
</html>
