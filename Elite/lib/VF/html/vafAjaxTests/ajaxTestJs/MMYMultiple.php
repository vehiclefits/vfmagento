<?php
require_once('F:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new VF_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array('make','model','year'));

$schema = new VF_Schema();

$vehicle1 = VF_Vehicle::create( $schema, array(
    'make' => 'Honda',
    'model' => 'Civic',
    'year' => '2002'
));
$vehicle1->save();

$vehicle2 = VF_Vehicle::create( $schema, array(
    'make' => 'Honda',
    'model' => 'Accord',
    'year' => '2002'
));
$vehicle2->save();

$mapping = new VF_Mapping( 1, $vehicle2 );
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
    ?>
    
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'ajaxTestJs/MMYMultiple.php', failures, total );
            };
            
            module("Loading Levels");
            
            test("Clicking Make Should Load Models", function() {
                stop(); 
                expect(1);
                
                jQuery(".yearSelect").bind( 'vafLevelLoaded', function() {
                    jQuery(".yearSelect").unbind('vafLevelLoaded');

                    jQuery(".yearSelect").bind( 'vafLevelLoaded', function() {
                        jQuery(".yearSelect").unbind('vafLevelLoaded');
                        selectionTextEquals( jQuery(".yearSelect"), "2002", "when making a selection and changing it, should load" );
                        start();
                    });

                    click('model', <?=$vehicle2->getValue('model')?>);    
                });

                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
                    jQuery(".modelSelect").unbind('vafLevelLoaded');
                    click('model', <?=$vehicle1->getValue('model')?>);
                });
                
                click( 'make', <?=$vehicle1->getValue('make')?> );
            });
          
        });
    </script>
  </body>
</html>
