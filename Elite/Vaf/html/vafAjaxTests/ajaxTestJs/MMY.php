<?php
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
                top.testPageComplete( 'ajaxTestJs/MMY.php', failures, total );
            };
            
            module("Loading Levels");
            
            test("Selecting a MAKE should display a loading message in the MODEL select box", function() {
                expect(1);
                click( 'make', <?=$values['make']?> );
                selectionTextEquals( $(".modelSelect"), "loading" );
            });
            
            test("Clicking Make Should Load Models", function() {
                stop(); 
                expect(1);
                click( 'make', <?=$values['make']?> );
                $(".modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    $(".modelSelect").unbind('vafLevelLoaded');
                    selectionTextEquals( $(".modelSelect"), "Civic" );
                });
            });
            test("Selecting a MODEL should display a loading message in the YEAR select box", function() {
                expect(1);
                click( 'model', <?=$values['make']?> );
                selectionTextEquals( $(".yearSelect"), "loading" );
            });
            
            test("Clicking Model Should Load Years", function() {
                stop(); 
                expect(1);
                click( 'make', <?=$values['make']?> ); 
                $(".modelSelect").bind( 'vafLevelLoaded', function() { 
                    click( 'model', <?=$values['model']?> );
                    $(".yearSelect").bind( 'vafLevelLoaded', function() {
                        start();
                        $(".modelSelect").unbind('vafLevelLoaded');
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
