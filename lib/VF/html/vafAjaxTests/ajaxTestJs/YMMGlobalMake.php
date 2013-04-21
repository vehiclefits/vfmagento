<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
require_once '../config.default.php';
require_once(getenv('PHP_MAGE_PATH').'/app/code/local/Elite/Vaf/bootstrap-tests.php');

$schemaGenerator = new VF_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array(
    'year',
    'make' => array('global'=>true),
    'model'
));

$schema = new VF_Schema();

$vehicle = VF_Vehicle::create( $schema, array(
    'make' => 'Honda',
    'model' => 'Civic',
    'year' => '2002'
));
$vehicle->save();
$mapping = new VF_Mapping( 1, $vehicle );
$mapping->save();

$vehicle2 = VF_Vehicle::create( $schema, array(
    'make' => 'Honda',
    'model' => 'Accord',
    'year' => '2006'
));
$vehicle2->save();
$mapping = new VF_Mapping( 1, $vehicle2 );
$mapping->save();

$values = $vehicle->toValueArray();



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
                top.testPageComplete( 'ajaxTestJs/YMMGlobalMake.php', failures, total );
            };
            
            module("Loading Levels");
            
            test("Clicking Year Should Load Makes", function() {
                stop(); 
                expect(3);
                
                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
                    jQuery(".modelSelect").unbind('vafLevelLoaded');
                    equals( jQuery(".modelSelect option").length, 1, "Models should not crossover different years" );
                    equals( jQuery(".modelSelect option:first").html(), 'Civic' );
                    
                    start();
                });
                
                jQuery(".makeSelect").bind( 'vafLevelLoaded', function() {
                    jQuery(".makeSelect").unbind('vafLevelLoaded');
                    selectionTextEquals( jQuery(".makeSelect"), "Honda" );
                });
                
                click( 'year', <?=$values['year']?> );
            });
            
        });
    </script>
  </body>
</html>
