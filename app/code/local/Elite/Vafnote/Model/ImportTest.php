<?php

class Elite_Vafnote_Model_ImportTest extends Elite_Vaf_TestCase {

    function testImportCode() {
        $csvData = "code,message
code1,message1
";

        $csvFile = TESTFILES . '/notes-definitions.csv';
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

        $csvFile = TESTFILES . '/notes-definitions.csv';
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

        $csvFile = TESTFILES . '/notes-definitions.csv';
        file_put_contents($csvFile, $csvData);

        $import = new Elite_Vafnote_Model_Import($csvFile);
        $csv = $import->import();


        $csvData = "code,message
code1,message-new
";

        $csvFile = TESTFILES . '/notes-definitions.csv';
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

        $csvFile = TESTFILES . '/notes-definitions.csv';
        file_put_contents($csvFile, $csvData);

        $import = new Elite_Vafnote_Model_Import($csvFile);
        $csv = $import->import();


        $csvData = "code,message
code1,message-new
";

        $csvFile = TESTFILES . '/notes-definitions.csv';
        file_put_contents($csvFile, $csvData);

        $import = new Elite_Vafnote_Model_Import($csvFile);
        $csv = $import->import();

        $finder = new Elite_Vafnote_Model_Finder();
        $actual = $finder->getAllNotes();

        $this->assertEquals('message-new', $actual[0]->message, 'should be able to update note message with importer');
    }

}