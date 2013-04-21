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

class Elite_Vafnote_Model_ImportTest extends Elite_Vaf_TestCase {

    function testImportCode() {
        $csvData = "code,message
code1,message1
";

        $csvFile = TEMP_PATH . '/notes-definitions.csv';
        file_put_contents($csvFile, $csvData);

        $import = new Elite_Vafnote_Model_Import($csvFile);
        $csv = $import->import();

        $finder = new Elite_Vafnote_Model_Finder();
        $actual = $finder->getAllNotes();

        $this->assertEquals('code1', $actual[0]->code, 'should be able to import note definitions code');
    }

    function testImportMessage() {
        $csvData = "code,message
code1,message1
";

        $csvFile = TEMP_PATH . '/notes-definitions.csv';
        file_put_contents($csvFile, $csvData);

        $import = new Elite_Vafnote_Model_Import($csvFile);
        $csv = $import->import();

        $finder = new Elite_Vafnote_Model_Finder();
        $actual = $finder->getAllNotes();

        $this->assertEquals('message1', $actual[0]->message, 'should be able to import note definitions code');
    }

    function testImportUpdatesCode() {
        $csvData = "code,message
code1,message1
";

        $csvFile = TEMP_PATH . '/notes-definitions.csv';
        file_put_contents($csvFile, $csvData);

        $import = new Elite_Vafnote_Model_Import($csvFile);
        $csv = $import->import();


        $csvData = "code,message
code1,message-new
";

        $csvFile = TEMP_PATH . '/notes-definitions.csv';
        file_put_contents($csvFile, $csvData);

        $import = new Elite_Vafnote_Model_Import($csvFile);
        $csv = $import->import();

        $finder = new Elite_Vafnote_Model_Finder();
        $actual = $finder->getAllNotes();

        $this->assertEquals('code1', $actual[0]->code, 'should be able to update note code with importer');
    }

    function testImportUpdatesMessage() {
        $csvData = "code,message
code1,message1
";

        $csvFile = TEMP_PATH . '/notes-definitions.csv';
        file_put_contents($csvFile, $csvData);

        $import = new Elite_Vafnote_Model_Import($csvFile);
        $csv = $import->import();


        $csvData = "code,message
code1,message-new
";

        $csvFile = TEMP_PATH . '/notes-definitions.csv';
        file_put_contents($csvFile, $csvData);

        $import = new Elite_Vafnote_Model_Import($csvFile);
        $csv = $import->import();

        $finder = new Elite_Vafnote_Model_Finder();
        $actual = $finder->getAllNotes();

        $this->assertEquals('message-new', $actual[0]->message, 'should be able to update note message with importer');
    }

}