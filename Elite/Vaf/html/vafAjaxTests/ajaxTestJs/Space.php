<?php
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array('make','model type','year'));

$schema = new Elite_Vaf_Model_Schema();

$vehicle = Elite_Vaf_Model_Vehicle::create( $schema, array(
    'make' => 'Honda_Unique'.uniqid(),
    'model type' => 'Civic',
    'year' => '2002'
));
$vehicle->save();

$values = $vehicle->toValueArray();

$mapping = new Elite_Vaf_Model_Mapping( 1, $vehicle );
$mapping->save();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <link rel="stylesheet" href="../qunit/qunit.css" type="text/css"/>
    
    <script src="/skin/adminhtml/default/default/jquery-1.7.1.min.js"> </script>
    <script src="/skin/adminhtml/default/default/jquery.metadata.pack.js"> </script>
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="/vaf/ajax/js?front=1"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'ajaxTestJs/Space.php', failures, total );
            };
            
            module("Loading Levels");
            
            test("Selecting a MAKE should display a loading message in the MODEL TYPE select box", function() {
                expect(1);
                click( 'make', <?=$values['make']?> );
                selectionTextEquals( $(".model_typeSelect"), "loading" );
            });
            
            test("Clicking Make Should Load Models", function() {
                stop(); 
                expect(1);
                click( 'make', <?=$values['make']?> );
                $(".model_typeSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    $(".model_typeSelect").unbind('vafLevelLoaded');
                    selectionTextEquals( $(".model_typeSelect"), "Civic" );
                });
            });
            test("Selecting a MODEL TYPE should display a loading message in the YEAR select box", function() {
                expect(1);
                click( 'model_type', <?=$values['make']?> );
                selectionTextEquals( $(".yearSelect"), "loading" );
            });
            
            test("Clicking MODEL TYPE Should Load Years", function() {
                stop(); 
                expect(1);
                click( 'make', <?=$values['make']?> ); 
                $(".model_typeSelect").bind( 'vafLevelLoaded', function() { 
                    click( 'model', <?=$values['model type']?> );
                    $(".yearSelect").bind( 'vafLevelLoaded', function() {
                        start();
                        $(".model_typeSelect").unbind('vafLevelLoaded');
                        $(".yearSelect").unbind('vafLevelLoaded');
                        selectionTextEquals( $(".yearSelect"), "2002" );
                    });
                });
            });
            test("Submitting form should not cause error", function() {
                jQuery().unbind("vafSubmit");
                $("#vafSubmit").trigger("click");
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
    ?>
  </body>
</html>
