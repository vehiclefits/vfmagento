<?php
session_start();
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

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
                top.testPageComplete( 'multiTreeTest/MMY.php', failures, total );
            };

            module("Mutli Tree");
            
            test("Clicking Make Should Load Models", function() {
                stop(); 
                expect(1);
                
                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    jQuery(".modelSelect").unbind('vafLevelLoaded');
                    firstOptionTextEquals( jQuery(".modelSelect"), "Civic" );
                });
                
                multiTreeClick( 'make', <?=$values['make']?> );
            });
            
            test("'quick add' make should 'quick add' new make to make select box", function() {
                stop(); 
                expect(3);
                jQuery('.vafQuickAdd_make').val('Acura');
                jQuery('.makeSelect').bind('vafLevelQuickAdd', function() {
                    start();
                    jQuery('.makeSelect').unbind('vafLevelQuickAdd');
                    
                    equals( jQuery('.makeSelect option:last').text(), 'Acura', "Should add option with title Acura" );
                    ok( jQuery('.makeSelect option:last').val() != 0, "Added option should have an id" );
                    equals( jQuery('.vafQuickAdd_make').val(), "", "should clear quick add box afterwards" );
                    
                });
                jQuery('.vafQuickAddSubmit_make').click();
            });
            
            test("Clicking add Should add make selection", function() {
                stop(); 
                expect(1);
                
                jQuery(".multiTree").bind( 'vafMultiTreeAdded', function() {
                    start();
                    equals( 'make:1;', jQuery('.multiTree-selection').find('.vafcheck').val() );
                    jQuery(".multiTree").unbind( 'vafMultiTreeAdded');
                });
                
                jQuery('.multiTree-Add').click();
            });
            
//            test("Should get selection (make)", function() {
//                stop(); 
//                expect(1);
//                jQuery('.multiTree').getSelected();
//                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
//                    start();
//                    jQuery(".modelSelect").unbind('vafLevelLoaded');
//                    firstOptionTextEquals( jQuery(".modelSelect"), "Civic" );
//                });
//            });
            
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
