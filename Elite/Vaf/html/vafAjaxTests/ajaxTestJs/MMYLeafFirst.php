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

$mapping = new Elite_Vaf_Model_Mapping( 1, $vehicle );
$mapping->save();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <link rel="stylesheet" href="../qunit/qunit.css" type="text/css"/>
    
    <script src="/skin/adminhtml/default/default/jquery-1.3.2.min.js"> </script>
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="/vaf/ajax/js?front=1&leafFirst=1"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( '<?=basename(__FILE__)?>', failures, total );
            };
            
            module("Loading Levels");
            
            test("Selecting a YEAR should display a loading message in the MAKE select box", function() {
                expect(1);
                click( 'year', <?=$values['year']?> );
                selectionTextEquals( $("#makeSelect"), "loading" );
            });
            
//            test("Clicking Make Should Load Models", function() {
//                stop(); 
//                expect(1);
//                click( 'make', <?=$values['make']?> );
//                $("#modelSelect").bind( 'vafLevelLoaded', function() {
//                    start();
//                    $("#modelSelect").unbind('vafLevelLoaded');
//                    selectionTextEquals( $("#modelSelect"), "Civic" );
//                });
//            });
            
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
    $config = new Zend_Config( array(
    	'search'=>array(),
    	'categorychooser' => array(),
    	'vaf' => array( 'levels' => 'make,model,year')
    ), true );
    $config->search->leafLevelFirst = true;
    include('../search.include.php');
    ?>
  </body>
</html>
