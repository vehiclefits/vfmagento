<?php
session_start();
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new VF_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array(
    'year',
    'make' => array('global'=>true),
    'model'
));

$schema = new VF_Schema();

$vehicle = VF_Vehicle::create( $schema, array(
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
    <script type="text/javascript" src="/vaf/ajax/js"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'multiTreeTest/YMMGlobalMake.php', failures, total );
            };

            module("Mutli Tree");
            
            test("Clicking Year Should Load Makes", function() {
                stop(); 
                expect(1);
                
                jQuery(".makeSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    jQuery(".makeSelect").unbind('vafLevelLoaded');
                    firstOptionTextEquals( jQuery(".makeSelect"), "Honda" );
                });
                
                multiTreeClick( 'year', <?=$values['year']?> );
            });
            
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
            
            test("'quick add' year should 'quick add' new year to year select box", function() {
                stop(); 
                expect(3);
                
                jQuery('.yearSelect').bind('vafLevelQuickAdd', function() {
                    start();
                    jQuery('.yearSelect').unbind('vafLevelQuickAdd');
                    
                    equals( jQuery('.yearSelect option:last').text(), '2006', "Should add option with title 2006" );
                    ok( jQuery('.yearSelect option:last').val() != 0, "Added option should have an id" );
                    equals( jQuery('.vafQuickAdd_year').val(), "", "should clear quick add box afterwards" );
                    
                });
                
                jQuery('.vafQuickAdd_year').val('2006');
                jQuery('.vafQuickAddSubmit_year').click();
            });
            
            test("'quick add' make should 'quick add' new make to make select box", function() {
                stop(); 
                expect(3);
                
                jQuery('.makeSelect').bind('vafLevelQuickAdd', function() {
                    jQuery('.makeSelect').unbind('vafLevelQuickAdd');

                    equals( jQuery('.makeSelect option:first').text(), 'Honda', "Should add option with title Honda" );
                    ok( jQuery('.makeSelect option:last').val() != 0, "Added option should have an id" );
                    equals( jQuery('.vafQuickAdd_make').val(), "", "should clear quick add box afterwards" );
                    
                    start();
                });

                jQuery(".makeSelect").bind( 'vafLevelLoaded', function() {
                    jQuery(".makeSelect").unbind( 'vafLevelLoaded');
                        
                    jQuery('.vafQuickAdd_make').val('Honda');
                    jQuery('.vafQuickAddSubmit_make').click();
                });
                
                var year2002 = jQuery(".yearSelect option:contains('2002')").val();
                multiTreeClick('year', year2002);
            });

            test("Clicking add Should add make selection", function() {
                stop();
                expect(1);

                jQuery(".multiTree").bind( 'vafMultiTreeAdded', function() {
                    start();
                    equals( 'year:1;make:1;', jQuery('.multiTree-selection').find('.vafcheck').val() );
                    jQuery(".multiTree").unbind( 'vafMultiTreeAdded');
                });

                jQuery(".makeSelect").bind( 'vafLevelLoaded', function() {
                    jQuery(".makeSelect").unbind( 'vafLevelLoaded');
                    var honda = jQuery(".makeSelect option:contains('Honda')").val();
                    multiTreeClick('make', honda);
                    
                    jQuery('.multiTree-Add').click();
                });
                
                var year2002 = jQuery(".yearSelect option:contains('2002')").val();
                multiTreeClick('year', year2002);
                
                
            });
            
        });
    </script>
  </body>
</html>
