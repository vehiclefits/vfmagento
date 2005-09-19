<?php
session_start();
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array('make','model','year'));

$schema = new Elite_Vaf_Model_Schema();

$vehicle = Elite_Vaf_Model_Vehicle::create( $schema, array(
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
    
    <script src="/skin/adminhtml/default/default/jquery-1.4.2.min.js"> </script>
    <script src="/skin/adminhtml/default/default/jquery.metadata.pack.js"> </script>
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="/vaf/ajax/js"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'multiTreeTest/MMY.php', failures, total );
            };

            module("Mutli Tree");
            
            test("Clicking Make Should Load Models", function() {
                stop(); 
                expect(1);
                multiTreeClick( 'make', <?=$values['make']?> );
                $(".modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    $(".modelSelect").unbind('vafLevelLoaded');
                    firstOptionTextEquals( $(".modelSelect"), "Civic" );
                });
            });
            
            test("'quick add' make should 'quick add' new make to make select box", function() {
                stop(); 
                expect(3);
                $('.vafQuickAdd_make').val('Acura');
                $('.makeSelect').bind('vafLevelQuickAdd', function() {
                    start();
                    $('.makeSelect').unbind('vafLevelQuickAdd');
                    
                    equals( $('.makeSelect option:last').text(), 'Acura', "Should add option with title Acura" );
                    ok( $('.makeSelect option:last').val() != 0, "Added option should have an id" );
                    equals( $('.vafQuickAdd_make').val(), "", "should clear quick add box afterwards" );
                    
                });
                $('.vafQuickAddSubmit_make').click();
            });
            
            test("Clicking add Should add make selection", function() {
                stop(); 
                expect(1);
                
                $(".multiTree").bind( 'vafMultiTreeAdded', function() {
                    start();
                    equals( 'make:1;', $('.multiTree-selection').find('.vafcheck').val() );
                    $(".multiTree").unbind( 'vafMultiTreeAdded');
                });
                
                $('.multiTree-Add').click();
            });
            
//            test("Should get selection (make)", function() {
//                stop(); 
//                expect(1);
//                jQuery('.multiTree').getSelected();
//                $(".modelSelect").bind( 'vafLevelLoaded', function() {
//                    start();
//                    $(".modelSelect").unbind('vafLevelLoaded');
//                    firstOptionTextEquals( $(".modelSelect"), "Civic" );
//                });
//            });
            
            test("Clicking Model Should Load Years", function() {
                stop(); 
                expect(1);
                multiTreeClick( 'model', <?=$values['model']?> );
                $(".yearSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    $(".yearSelect").unbind('vafLevelLoaded');
                    firstOptionTextEquals( $(".yearSelect"), "2002" );
                });
            });
            
            test("'quick add' model should 'quick add' new model to model select box", function() {
                stop(); 
                expect(3);
                $('.vafQuickAdd_model').val('Accord');
                
                $('.modelSelect').bind('vafLevelQuickAdd', function() {
                    multiTreeClick( 'make', <?=$values['make']?> );
                });
                
                $(".modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    $('.modelSelect').unbind('vafLevelQuickAdd');
                    
                    equals( $('.modelSelect option:first').text(), 'Accord', "Should add option with title Accord" );
                    ok( $('.modelSelect option:last').val() != 0, "Added option should have an id" );
                    equals( $('.vafQuickAdd_model').val(), "", "should clear quick add box afterwards" );
                    
                });
                $('.vafQuickAddSubmit_model').click();
            });
            
            test("Clicking add Should add model selection", function() {
                stop(); 
                expect(1);
                
                multiTreeClick( 'model', <?=$values['model']?> );
                $(".multiTree").bind( 'vafMultiTreeAdded', function() {
                    start();
                    equals( 'make:1;model:1;', $('.multiTree-selection').find('.vafcheck').val() );
                    $(".multiTree").unbind( 'vafMultiTreeAdded');
                });
                
                $('.multiTree-Add').click();
            });
            
        });
    </script>
  </head>
  <body>
    <h1 id="qunit-header">VAF - Multi Tree</h1>
    <h2 id="qunit-banner"></h2>
    <h2 id="qunit-userAgent"></h2>
    <ol id="qunit-tests">
    </ol>
    
    <?php
    include('../multitree.include.php');
    ?>
  </body>
</html>
