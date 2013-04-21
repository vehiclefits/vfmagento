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
$schemaGenerator->execute(array('make','model','year'));

$schema = new VF_Schema();

$vehicle0 = VF_Vehicle::create( $schema, array(
    'make' => 'Ford',
    'model' => 'F-150',
    'year' => '2000'
));
$vehicle0->save();
$mapping = new VF_Mapping( 1, $vehicle0 );
$mapping->save();

$vehicle1 = VF_Vehicle::create( $schema, array(
    'make' => 'Honda',
    'model' => 'Civic',
    'year' => '2002'
));
$vehicle1->save();
$mapping = new VF_Mapping( 1, $vehicle1 );
$mapping->save();

$vehicle2 = VF_Vehicle::create( $schema, array(
    'make' => 'Honda',
    'model' => 'Accord',
    'year' => '2003'
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
            
//            test("Clicking Make Should Load Models", function() {
//                stop(); 
//                expect(3);
//                
//
//                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
//                    jQuery(".modelSelect").unbind('vafLevelLoaded');
//                    
//                    equals(1,jQuery(".modelSelect").find('option[text="Accord"]').size(),'should load Accord');
//                    equals(1,jQuery(".modelSelect").find('option[text="Civic"]').size(),'should load Civic');
//                    equals(0,jQuery(".modelSelect").find('option[text="F-150"]').size(),'should NOT load F-150');
//
//                    start();
//                });
//                
//                click( 'make', '<?=$vehicle1->getLevel('make')->getId()?>' );
//            });
//            
//            test("Clicking model Should Load year", function() {
//                stop(); 
//                expect(1);
//                
//                jQuery(".yearSelect").bind( 'vafLevelLoaded', function() {
//                    jQuery(".yearSelect").unbind('vafLevelLoaded');
//
//                    jQuery(".yearSelect").bind( 'vafLevelLoaded', function() {
//                        jQuery(".yearSelect").unbind('vafLevelLoaded');
//                        selectionTextEquals( jQuery(".yearSelect"), "2003", "when making a selection and changing it, should load" );
//                        start();
//                    });
//
//                    click('model', '<?=$vehicle2->getLevel('model')?>');    
//                });
//
//                jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {
//                    jQuery(".modelSelect").unbind('vafLevelLoaded');
//                    click('model', '<?=$vehicle1->getLevel('model')?>');
//                });
//                
//                click( 'make', '<?=$vehicle1->getLevel('make')?>' );
//            });
//          
        });
    </script>
  </body>
</html>
