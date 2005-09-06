<?php
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new VF_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array('make','model','year'));

$schema = new VF_Schema();

$vehicle = VF_Vehicle::create( $schema, array('make'=>'Honda_Unique'.uniqid(), 'model'=>'Civic', 'year'=>'2002') );
$vehicle->save();

$mapping = new Elite_Vaf_Model_Mapping( 1, $vehicle );
$mapping->save();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <link rel="stylesheet" href="../qunit/qunit.css" type="text/css"/>
  </head>
  <body>
    <h1 id="qunit-header">VAF - MMY (hidden options)</h1>
    <h2 id="qunit-banner"></h2>
    <h2 id="qunit-userAgent"></h2>
    <ol id="qunit-tests">
    </ol>
    
    <?php
    include('../search.include.php');
    $search = new Elite_Vaf_Block_Search_AjaxTestSub();
    $search->getConfig()->search->unavailableSelections = 'hide';
    $search->toHtml();
    ?>
    
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'ajaxTestJs/MMYhide.php', failures, total );
            };
            
            test("Make should be shown by default", function() {
                expect(1);
                equals( jQuery( '.makeSelect').css('display'), "inline" );
            });
            
            test("Model should be hidden by default", function() {
                expect(1);
                equals( jQuery( '.modelSelect').css('display'), "none" );
            });
            
            test("Year should be hidden by default", function() {
                expect(1);
                equals( jQuery( '.yearSelect').css('display'), "none" );
            });
            
            test("Clicking a Make should show Models", function() {
                stop(); 
                expect(1);
                
                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    jQuery(".modelSelect").unbind('vafLevelLoaded');
                    equals( jQuery( '.modelSelect').css('display'), "inline" );
                });
                
                click( 'make', <?=$vehicle->getLevel('make')->getId()?> );
            });
            
            test("Clicking a Model should show Years", function() {
                stop(); 
                expect(1);
                
                jQuery(".yearSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    jQuery(".yearSelect").unbind('vafLevelLoaded');
                    equals( jQuery( '.yearSelect').css('display'), "inline" );
                });
                
                click( 'model', <?=$vehicle->getLevel('make')->getId()?> );
            });

            
        });
    </script>
  </body>
</html>