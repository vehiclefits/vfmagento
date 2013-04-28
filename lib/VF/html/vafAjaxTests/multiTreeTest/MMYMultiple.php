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
session_start();
require_once '../config.default.php';
require_once(getenv('PHP_MAGE_PATH').'/app/code/local/Elite/Vaf/bootstrap-tests.php');

file_put_contents(sys_get_temp_dir().'/vf-ajax-tests','1');

$schemaGenerator = new VF_Schema_Generator();
$schemaGenerator->dropExistingTables();
$schemaGenerator->execute(array('make','model','year'));
$schema1 = new VF_Schema(1);

$schema2 = VF_Schema::create('foo,bar');

$vehicle = VF_Vehicle::create( $schema1, array(
    'make' => 'Honda_Unique'.uniqid(),
    'model' => 'Civic',
    'year' => '2002'
));
$vehicle->save();
$values = $vehicle->toValueArray();

$vehicle2 = VF_Vehicle::create( $schema2, array(
    'foo'=>123,
    'bar'=>456
));
$vehicle2->save();
$values2 = $vehicle2->toValueArray();
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

<div style="float:left;width:50%;">
    <?php
    include('../multitree.include.php');
    $block = new Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tab_Vaf_AjaxTestStub;
    $block->setSchema($schema1);
    $block->toHtml();
    ?>
</div>
<div style="float:left;width:50%;">
    <?php
    $block = new Elite_Vaf_Adminhtml_Block_Catalog_Product_Edit_Tab_Vaf_AjaxTestStub;
    $block->setSchema($schema2);
    $block->toHtml();
    ?>
</div>
<script type="text/javascript" src="../qunit/qunit.js"></script>
<script type="text/javascript" src="../common.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){

        QUnit.done = function (failures, total) {
            jQuery.ajax('removeTmpLockFile.php');
            console.log('done');
            top.testPageComplete( 'multiTreeTest/MMYMultiple.php', failures, total );
        };

        module("Mutli Tree");

        test("Clicking Make in first section Should Load Models", function() {
            stop();
            expect(1);

            jQuery(".modelSelect").bind( 'vafLevelLoaded', function() {

                jQuery(".modelSelect").unbind('vafLevelLoaded');
                firstOptionTextEquals( jQuery(".modelSelect"), "Civic" );

                start();
            });

            multiTreeClick( 'make', <?=$values['make']?> );
        });

        test("Clicking 'foo' in second section Should Load 'bar'", function() {
            stop();
            expect(1);

            jQuery(".barSelect").bind( 'vafLevelLoaded', function() {

                jQuery(".barSelect").unbind('vafLevelLoaded');
                firstOptionTextEquals( jQuery(".barSelect"), "456" );

                start();
            });

            multiTreeClick( 'foo', <?=$values2['foo']?> );
        });

        test("'quick add' make should 'quick add' new make to make select box", function() {
            stop();
            expect(3);
            jQuery('.vafQuickAdd_make').val('Acura');
            jQuery('.makeSelect').bind('vafLevelQuickAdd', function() {

                jQuery('.makeSelect').unbind('vafLevelQuickAdd');

                equals( jQuery('.makeSelect option:last').text(), 'Acura', "Should add option with title Acura" );
                ok( jQuery('.makeSelect option:last').val() != 0, "Added option should have an id" );
                equals( jQuery('.vafQuickAdd_make').val(), "", "should clear quick add box afterwards" );

                start();

            });
            jQuery('.vafQuickAddSubmit_make').click();
        });

        test("'quick add' foo should 'quick add' new foo to make select box", function() {
            stop();
            expect(3);
            jQuery('.vafQuickAdd_foo').val('abc');
            jQuery('.fooSelect').bind('vafLevelQuickAdd', function() {

                jQuery('.fooSelect').unbind('vafLevelQuickAdd');

                equals( jQuery('.fooSelect option:last').text(), 'abc', "Should add option with title Acura" );
                ok( jQuery('.fooSelect option:last').val() != 0, "Added option should have an id" );
                equals( jQuery('.vafQuickAdd_foo').val(), "", "should clear quick add box afterwards" );

                start();

            });
            jQuery('.vafQuickAddSubmit_foo').click();
        });
    });
</script>
</body>
</html>