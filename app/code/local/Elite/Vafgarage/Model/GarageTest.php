<?php

class Elite_Vafgarage_Model_GarageTest extends Elite_Vaf_TestCase {

    function testAddVehicle() {
        $garage = new Elite_Vafgarage_Model_Garage;
        $garage->addVehicle(array('make' => 5, 'model' => 3, 'year' => 2));
        $vehicles = $garage->vehicles();
        $this->assertEquals(array('make' => 5, 'model' => 3, 'year' => 2), $vehicles[0]);
    }

    function testAddPartialVehicle() {
        $garage = new Elite_Vafgarage_Model_Garage;
        $garage->addVehicle(array('make' => 5, 'model' => 0, 'year' => 0));
        $vehicles = $garage->vehicles();
        $this->assertEquals(array('make' => 5, 'model' => 0, 'year' => 0), $vehicles[0]);
    }

    function testOnlyAddsOneOfEachVehicle() {
        $garage = new Elite_Vafgarage_Model_Garage;
        $garage->addVehicle(array('make' => 5, 'model' => 3, 'year' => 2));
        $garage->addVehicle(array('make' => 5, 'model' => 3, 'year' => 2));
        $this->assertEquals(1, count($garage->vehicles()));
    }

    function testRemoveVehicle() {
        $garage = new Elite_Vafgarage_Model_Garage;
        $garage->addVehicle(array('make' => 5, 'model' => 3, 'year' => 2));
        $garage->removeVehicle(array('make' => 5, 'model' => 3, 'year' => 2));
        $this->assertEquals(0, count($garage->vehicles()));
    }

}