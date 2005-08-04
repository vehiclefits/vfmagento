<?php
session_start();
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array(
    'year',
    'make' => array('global'=>true),
    'model'
));

$schema = new Elite_Vaf_Model_Schema();

$vehicle = Elite_Vaf_Model_Vehicle::create( $schema, array(
    'make' => 'Honda',
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
    
    <script src="/skin/adminhtml/default/default/jquery-1.7.1.min.js"> </script>
    <script src="/skin/adminhtml/default/default/jquery.metadata.pack.js"> </script>
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="/vaf/ajax/js"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'multiTreeTest/YMMGlobalMake.php', failures, total );
            };

            module("Mutli Tree");
            
            test("Clicking Year Should Load Makes", function() {
                stop(); 
                expect(1);
                multiTreeClick( 'year', <?=$values['year']?> );
                $(".makeSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    $(".makeSelect").unbind('vafLevelLoaded');
                    firstOptionTextEquals( $(".makeSelect"), "Honda" );
                });
            });
            
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
            
            test("'quick add' year should 'quick add' new year to year select box", function() {
                stop(); 
                expect(3);
                $('.vafQuickAdd_year').val('2006');
                $('.yearSelect').bind('vafLevelQuickAdd', function() {
                    start();
                    $('.yearSelect').unbind('vafLevelQuickAdd');
                    
                    equals( $('.yearSelect option:last').text(), '2006', "Should add option with title 2006" );
                    ok( $('.yearSelect option:last').val() != 0, "Added option should have an id" );
                    equals( $('.vafQuickAdd_year').val(), "", "should clear quick add box afterwards" );
                    
                });
                $('.vafQuickAddSubmit_year').click();
            });
            
            test("'quick add' make should 'quick add' new make to make select box", function() {
                stop(); 
                expect(4);
                
                var year2006 = jQuery(".yearSelect option:contains('2006')").val();
                multiTreeClick('year', year2006);
                $(".makeSelect").bind( 'vafLevelLoaded', function() {
                    $(".makeSelect").unbind( 'vafLevelLoaded');
                        
                    $('.vafQuickAdd_make').val('Honda');
                    
                    $('.makeSelect').bind('vafLevelQuickAdd', function() {
                        multiTreeClick( 'make', <?=$values['make']?> );
                    });
                    
                    $(".modelSelect").bind( 'vafLevelLoaded', function() {
                        start();
                        $('.makeSelect').unbind('vafLevelQuickAdd');
                        
                        equals( $('.makeSelect option:first').text(), 'Honda', "Should add option with title Honda" );
                        ok( $('.makeSelect option:last').val() != 0, "Added option should have an id" );
                        equals( $('.vafQuickAdd_make').val(), "", "should clear quick add box afterwards" );
                        equals( 0, $('.modelSelect option').length, "should not have any models yet" );
                        
                    });
                    $('.vafQuickAddSubmit_make').click();
                });
            });

            test("Clicking add Should add make selection", function() {
                stop();
                expect(1);

                $(".multiTree").bind( 'vafMultiTreeAdded', function() {
                    start();
                    equals( 'year:2;make:1;', $('.multiTree-selection').find('.vafcheck').val() );
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
