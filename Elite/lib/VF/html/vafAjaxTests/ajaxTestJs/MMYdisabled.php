<?php
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new VF_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array('make','model','year'));

$schema = new VF_Schema();

$vehicle = VF_Vehicle::create( $schema, array('make'=>'Honda_Unique'.uniqid(), 'model'=>'Civic', 'year'=>'2002') );
$vehicle->save();

$mapping = new VF_Mapping( 1, $vehicle );
$mapping->save();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <link rel="stylesheet" href="../qunit/qunit.css" type="text/css"/>
  </head>
  <body>
    <h1 id="qunit-header">VAF - MMY (disabled options)</h1>
    <h2 id="qunit-banner"></h2>
    <h2 id="qunit-userAgent"></h2>
    <ol id="qunit-tests">
    </ol>
    
    <?php
    include('../search.include.php');
    $search = new Elite_Vaf_Block_Search_AjaxTestSub();
    $search->getConfig()->search->unavailableSelections = 'disable';
    $search->toHtml();
    ?>
    
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'ajaxTestJs/MMYdisabled.php', failures, total );
            };
            
            test("Make should be enabled by default", function() {
                expect(1);
                equals( undefined, jQuery( '.makeSelect').attr('disabled') );
            });
            
            test("Model should be disabled by default", function() {
                expect(1);
                equals( 'disabled', jQuery( '.modelSelect').attr('disabled') );
            });
            
            test("Year should be disabled by default", function() {
                expect(1);
                equals( 'disabled', jQuery( '.yearSelect').attr('disabled') );
            });
            
            test("Clicking Make enable Model", function() {
                stop(); 
                expect(1);
                
                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    jQuery(".modelSelect").unbind('vafLevelLoaded');
                    equals( undefined, jQuery( '.modelSelect').attr('disabled') );
                });
                
                click( 'make', <?=$vehicle->getLevel('make')->getId()?> );
            });

            test("Clicking Model Should enable Year", function() {
                stop(); 
                expect(1);
                
                jQuery(".yearSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    jQuery(".modelSelect").unbind('vafLevelLoaded');
                    jQuery(".yearSelect").unbind('vafLevelLoaded');
                    equals( undefined, jQuery( '.yearSelect').attr('disabled') );
                });

                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() { 
                    click( 'model', <?=$vehicle->getLevel('model')->getId()?> );
                });
                click( 'make', <?=$vehicle->getLevel('make')->getId()?> ); 
            });
            
        });
    </script>
  </body>
</html>