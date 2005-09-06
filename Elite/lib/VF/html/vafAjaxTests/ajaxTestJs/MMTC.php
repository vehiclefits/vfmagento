<?php
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new VF_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute( array('make','model','chassis','trim'));

$schema = new VF_Schema();

$vehicle = VF_Vehicle::create( $schema, array('make'=>'Honda_Unique'.uniqid(), 'model'=>'Civic', 'chassis'=>'chassis', 'trim'=>'trim') );
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
    <h1 id="qunit-header">Vehicle Fits - MMTC</h1>
    <h2 id="qunit-banner"></h2>
    <h2 id="qunit-userAgent"></h2>
    <ol id="qunit-tests">
    </ol>
    
    <?php
    include('../search.include.php');
    $search = new Elite_Vaf_Block_Search_AjaxTestSub();
    $search->toHtml();
    ?>
    
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'ajaxTestJs/MMTC.php', failures, total );
            };
            
            module("Loading Levels");
            
            test("Selecting a MAKE should display a loading message in the MODEL select box", function() {
                expect(1);
                click( 'make', <?=$vehicle->getLevel('make')->getId()?> );
                selectionTextEquals( jQuery(".modelSelect"), "loading" );
            });
            
            test("Clicking Make Should Load Models", function() {
                stop(); 
                expect(1);
                
                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    jQuery(".modelSelect").unbind('vafLevelLoaded');
                    selectionTextEquals( jQuery(".modelSelect"), "Civic" );
                });
                
                click( 'make', <?=$vehicle->getLevel('make')->getId()?> );
            });
            
//            test("Selecting a MODEL should display a loading message in the CHASSIS select box", function() {
//                expect(1);
//                click( 'model', <?=$vehicle->getLevel('make')->getId()?> );
//                selectionTextEquals( jQuery(".chassisSelect"), "loading" );
//            });
            
//            test("Clicking Model Should Load Trims", function() {
//                stop(); 
//                expect(1);
//                click( 'make', <?=$vehicle->getLevel('make')->getId()?> );
//                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
//                    start();
//                    jQuery(".modelSelect").unbind('vafLevelLoaded');
//                    selectionTextEquals( jQuery(".modelSelect"), "Civic" );
//                });
//            });
            
            
        });
    </script>
  </body>
</html>
