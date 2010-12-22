<?php
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute( array('make','model','chassis','trim'));

$schema = new Elite_Vaf_Model_Schema();

$vehicle = Elite_Vaf_Model_Vehicle::create( $schema, array('make'=>'Honda_Unique'.uniqid(), 'model'=>'Civic', 'chassis'=>'chassis', 'trim'=>'trim') );
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
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="/vaf/ajax/js?front=1"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'ajaxTestJs/MMTC.php', failures, total );
            };
            
            module("Loading Levels");
            
            test("Selecting a MAKE should display a loading message in the MODEL select box", function() {
                expect(1);
                click( 'make', <?=$vehicle->getLevel('make')->getId()?> );
                selectionTextEquals( $(".modelSelect"), "loading" );
            });
            
            test("Clicking Make Should Load Models", function() {
                stop(); 
                expect(1);
                click( 'make', <?=$vehicle->getLevel('make')->getId()?> );
                $(".modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    $(".modelSelect").unbind('vafLevelLoaded');
                    selectionTextEquals( $(".modelSelect"), "Civic" );
                });
            });
            
//            test("Selecting a MODEL should display a loading message in the CHASSIS select box", function() {
//                expect(1);
//                click( 'model', <?=$vehicle->getLevel('make')->getId()?> );
//                selectionTextEquals( $(".chassisSelect"), "loading" );
//            });
            
//            test("Clicking Model Should Load Trims", function() {
//                stop(); 
//                expect(1);
//                click( 'make', <?=$vehicle->getLevel('make')->getId()?> );
//                $(".modelSelect").bind( 'vafLevelLoaded', function() {
//                    start();
//                    $(".modelSelect").unbind('vafLevelLoaded');
//                    selectionTextEquals( $(".modelSelect"), "Civic" );
//                });
//            });
            
            
        });
    </script>
  </head>
  <body>
    <h1 id="qunit-header">Vehicle Fits - MMTC</h1>
    <h2 id="qunit-banner"></h2>
    <h2 id="qunit-userAgent"></h2>
    <ol id="qunit-tests">
    </ol>
    
    <?php
    include('../search.include.php');
    ?>
  </body>
</html>
