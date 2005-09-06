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

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <link rel="stylesheet" href="../qunit/qunit.css" type="text/css"/>
    <link rel="stylesheet" href="/skin/adminhtml/default/default/multiTree.css" type="text/css"/>
   </head>
   <body>
    <h1 id="qunit-header">VAF - Multi Tree</h1>
    <h2 id="qunit-banner"></h2>
    <h2 id="qunit-userAgent"></h2>
    <ol id="qunit-tests">
    </ol>
    
    <?php
    include('../multitree.include.php');
    $block = new Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tab_Vaf_AjaxTestStub;
    $block->getConfig()->search->unavailableSelections = 'hide';
    $block->toHtml();
    ?>
    
    <script type="text/javascript" src="../qunit/qunit.js"></script>
    <script type="text/javascript" src="../common.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            
            QUnit.done = function (failures, total) {
                top.testPageComplete( 'multiTreeTest/MMYHide.php', failures, total );
            };

            module("Should not hide");

            test("Make should be shown by default", function() {
                expect(1);
                equals( jQuery( '.makeSelect').css('display'), "inline" );
            });

            test("Model should be shown by default", function() {
                expect(1);
                equals( jQuery( '.modelSelect').css('display'), "inline" );
            });

            test("Year should be shown by default", function() {
                expect(1);
                equals( jQuery( '.yearSelect').css('display'), "inline" );
            });
        });
    </script>
  </body>
 </html>