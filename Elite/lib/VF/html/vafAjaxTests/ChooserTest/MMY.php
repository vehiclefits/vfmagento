<?php
session_start();
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new VF_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array('make','model','year'));

$schema = new VF_Schema();

$vehicle = VF_Vehicle::create( $schema, array(
    'make' => 'Honda_Unique'.uniqid(),
    'model' => 'Civic',
    'year' => '2002'
));
$vehicle->save();

$values = $vehicle->toValueArray();

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
    <h1 id="qunit-header">VAF - MMY</h1>
    <h2 id="qunit-banner"></h2>
    <h2 id="qunit-userAgent"></h2>
    <ol id="qunit-tests">
    </ol>
    
    <?php
    include('../search.include.php');
    $search = new Elite_Vaf_Block_Search_AjaxTestSub();
    $search->toHtml();
    
    require('../chooser.include.php');
    ?>
    
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'chooserTest/MMY.php', failures, total );
            };

            module("Search Form");
            
            test("Selecting a MAKE should display a loading message in the MODEL select box", function() {
                expect(1);
                click( 'make', <?=$values['make']?> );
                selectionTextEquals( jQuery("#vafForm .modelSelect"), "loading" );
            });
            
            test("Selecting a MAKE should NOT affect \"chooser form\"", function() {
                expect(1);
                click( 'make', <?=$values['make']?> );
                selectionTextEquals( jQuery("#vafChooserForm .modelSelect"), "-please select-" );
            });
            
            test("Clicking Make Should Load Models", function() {
                stop(); 
                expect(1);
                
                jQuery("#vafForm .modelSelect").bind( 'vafLevelLoaded', function() {
                    start();
                    jQuery(".modelSelect").unbind('vafLevelLoaded');
                    selectionTextEquals( jQuery("#vafForm .modelSelect"), "Civic" );
                });
                
                click( 'make', <?=$values['make']?> );
            });
            
            module("Chooser Form");
            
            test("Selecting a MAKE should display a loading message in the MODEL select box", function() {
                expect(1);
                chooserClick( 'make', <?=$values['make']?> );
                
                equals( 'loading', jQuery("#vafChooserForm .modelSelect :selected").text() );
            });
            
        });
    </script>
  </body>
</html>
