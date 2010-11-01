<?php
require_once('E:\dev\vaf\app\code\local\Elite\Vaf\bootstrap-tests.php');

$schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array('make','model','year'));

$schema = new Elite_Vaf_Model_Schema();

$vehicle1 = Elite_Vaf_Model_Vehicle::create( $schema, array(
    'make' => 'Honda',
    'model' => 'Civic',
    'year' => '2002'
));
$vehicle1->save();

$vehicle2 = Elite_Vaf_Model_Vehicle::create( $schema, array(
    'make' => 'Honda',
    'model' => 'Accord',
    'year' => '2002'
));
$vehicle2->save();

$mapping = new Elite_Vaf_Model_Mapping( 1, $vehicle2 );
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
    <script type="text/javascript" src="/vaf/ajax/js?front=1"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'ajaxTestJs/MMYMultiple.php', failures, total );
            };
            
            module("Loading Levels");
            
            test("Clicking Make Should Load Models", function() {
                stop(); 
                expect(1);
                click( 'make', <?=$vehicle1->getValue('make')?> );
                $(".modelSelect").bind( 'vafLevelLoaded', function() {
                    
                    $(".modelSelect").unbind('vafLevelLoaded');
                    click('model', <?=$vehicle1->getValue('model')?>);
                    
                    $(".yearSelect").bind( 'vafLevelLoaded', function() {
                        $(".yearSelect").unbind('vafLevelLoaded');
                        click('model', <?=$vehicle2->getValue('model')?>);    
                        $(".yearSelect").bind( 'vafLevelLoaded', function() {
                            $(".yearSelect").unbind('vafLevelLoaded');
                            selectionTextEquals( $(".yearSelect"), "2002", "when making a selection and changing it, should load" );
                            start();
                        });
                    });
                    
                });
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
