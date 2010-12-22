<?php
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array('make','model','year'));

$schema = new Elite_Vaf_Model_Schema();

$vehicle = Elite_Vaf_Model_Vehicle::create( $schema, array('make'=>'Honda_Unique'.uniqid(), 'model'=>'Civic', 'year'=>'2002') );
$vehicle->save();

$mapping = new Elite_Vaf_Model_Mapping( 1, $vehicle );
$mapping->save();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <link rel="stylesheet" href="../qunit/qunit.css" type="text/css"/>
    <script src="/skin/adminhtml/default/default/jquery-1.4.2.min.js"> </script>
    <script src="/skin/adminhtml/default/default/jquery.metadata.pack.js"> </script>
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript" src="/vaf/ajax/js?front=1&unavailableSelections=disable"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'ajaxTestJs/MMYdisabled.php', failures, total );
            };
            
            test("Make should be enabled by default", function() {
                expect(1);
                equals( '', jQuery( '.makeSelect').attr('disabled') );
            });
            
            test("Model should be disabled by default", function() {
                expect(1);
                equals( true, jQuery( '.modelSelect').attr('disabled') );
            });
            
            test("Year should be disabled by default", function() {
                expect(1);
                equals( true, jQuery( '.yearSelect').attr('disabled') );
            });
            
            test("Clicking Make enable Model", function() {
                stop(); 
                expect(1);
                click( 'make', <?=$vehicle->getLevel('make')->getId()?> );
                $(".modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    $(".modelSelect").unbind('vafLevelLoaded');
                    equals( false, jQuery( '.modelSelect').attr('disabled') );
                });
            });

            test("Clicking Model Should enable Year", function() {
                stop(); 
                expect(1);
                click( 'make', <?=$vehicle->getLevel('make')->getId()?> ); 
                $(".modelSelect").bind( 'vafLevelLoaded', function() { 
                    click( 'model', <?=$vehicle->getLevel('model')->getId()?> );
                    $(".yearSelect").bind( 'vafLevelLoaded', function() {
                        start();
                        $(".modelSelect").unbind('vafLevelLoaded');
                        $(".yearSelect").unbind('vafLevelLoaded');
                        equals( false, jQuery( '.yearSelect').attr('disabled') );
                    });
                });
            });
            
        });
    </script>
  </head>
  <body>
    <h1 id="qunit-header">VAF - MMY (disabled options)</h1>
    <h2 id="qunit-banner"></h2>
    <h2 id="qunit-userAgent"></h2>
    <ol id="qunit-tests">
    </ol>
    
    <?php
    include('../search.include.php');
    ?>
  </body>
</html>