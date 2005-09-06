<?php
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
    $search->getConfig()->search->loadingStrategy = 'offline';
    $search->toHtml();
    ?>
    
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'ajaxTestJs/MMYNonAjax.php', failures, total );
            };
            
            module("Loading Levels");

            test("Clicking Make Should Load Models", function() {

                expect(1);
                click( 'make', <?=$values['make']?> );
                
                var options = jQuery(".modelSelect option");
                equals( jQuery(options[0]).text(), "-please select-" );
                
            });
               //
//            test("Clicking Model Should Load Years", function() {
//                stop(); 
//                expect(1);
//                click( 'make', <?=$values['make']?> ); 
//                jQuery("#modelSelect").bind( 'vafLevelLoaded', function() { 
//                    click( 'model', <?=$values['model']?> );
//                    jQuery("#yearSelect").bind( 'vafLevelLoaded', function() {
//                        start();
//                        jQuery("#modelSelect").unbind('vafLevelLoaded');
//                        jQuery("#yearSelect").unbind('vafLevelLoaded');
//                        selectionTextEquals( jQuery("#yearSelect"), "2002" );
//                    });
//                });
//            });
            
        });
    </script>
  </body>
</html>
