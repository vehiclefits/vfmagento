<?php
session_start();
require_once('E:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

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

$Fitment = new Elite_Vaf_Model_Fitment( 1, $vehicle );
$Fitment->save();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <link rel="stylesheet" href="../qunit/qunit.css" type="text/css"/>
    
    <script src="/skin/adminhtml/default/default/jquery-1.4.2.min.js"> </script>
    <script src="/skin/adminhtml/default/default/jquery.metadata.pack.js"> </script>
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="/vaf/ajax/js?front=1"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'chooserTest/MMY.php', failures, total );
            };

            module("Search Form");
            
            test("Selecting a MAKE should display a loading message in the MODEL select box", function() {
                expect(1);
                click( 'make', <?=$values['make']?> );
                selectionTextEquals( $("#vafForm .modelSelect"), "loading" );
            });
            
            test("Selecting a MAKE should NOT affect \"chooser form\"", function() {
                expect(1);
                click( 'make', <?=$values['make']?> );
                selectionTextEquals( $("#vafChooserForm .modelSelect"), "-please select-" );
            });
            
            test("Clicking Make Should Load Models", function() {
                stop(); 
                expect(1);
                click( 'make', <?=$values['make']?> );
                $("#vafForm .modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    $(".modelSelect").unbind('vafLevelLoaded');
                    selectionTextEquals( $("#vafForm .modelSelect"), "Civic" );
                });
            });
            
            module("Chooser Form");
            
            test("Selecting a MAKE should display a loading message in the MODEL select box", function() {
                expect(1);
                chooserClick( 'make', <?=$values['make']?> );
                
                equals( 'loading', $("#vafChooserForm .modelSelect :selected").text() );
            });
            
        });
    </script>
  </head>
  <body>
    <h1 id="qunit-header">VAF - MMY</h1>
    <h2 id="qunit-banner"></h2>
    <h2 id="qunit-userAgent"></h2>
    <ol id="qunit-tests">
    </ol>
    
    <?php
    include('../search.include.php');
    include('../chooser.include.php');
    ?>
  </body>
</html>
