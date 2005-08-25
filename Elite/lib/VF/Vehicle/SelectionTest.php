<?php
class VF_Vehicle_SelectionTest extends Elite_Vaf_Helper_DataTestCase
{
    function testShouldNotContainVehicle()
    {
        $vehicle1 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2000));
        $vehicle2 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2001));

        $selection = new VF_Vehicle_Selection($vehicle1);
        $this->assertFalse($selection->contains($vehicle2) );
    }

    function testShouldContainVehicle()
    {
        $vehicle = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2000));
        $selection = new VF_Vehicle_Selection($vehicle);
        $this->assertTrue($selection->contains($vehicle) );
    }

    function testShouldContainMultipleVehicles()
    {
        $vehicle1 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2000));
        $vehicle2 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2001));
        $selection = new VF_Vehicle_Selection(array($vehicle1,$vehicle2));
        $this->assertTrue($selection->contains($vehicle1) );
        $this->assertTrue($selection->contains($vehicle2) );
    }

    function testGetEarliestYear()
    {
        $vehicle1 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2000));
        $vehicle2 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2001));
        $vehicle3 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2002));
        $vehicle4 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2003));
        $selection = new VF_Vehicle_Selection(array($vehicle2,$vehicle1,$vehicle3,$vehicle4));
        $this->assertEquals(2000, $selection->earliestYear());
    }

    function testGetLatestYear()
    {
        $vehicle1 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2000));
        $vehicle2 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2001));
        $vehicle3 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2002));
        $vehicle4 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2003));
        $selection = new VF_Vehicle_Selection(array($vehicle2,$vehicle1,$vehicle4,$vehicle3));
        $this->assertEquals(2003, $selection->latestYear());
    }
    
    function testSelectionShouldContainYearRange()
    {
        return $this->markTestIncomplete();
        /*
        $vehicle1 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2000));
        $vehicle2 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2001));
        $vehicle3 = $this->createVehicle(array('make'=>'Honda','model'=>'civic','year'=>2002));
        $selection = VF_Vehicle_Selection::yearRange(array('make'=>'Honda','model'=>'civic','year_start'=>2000,'year_end'=>'2002'));
        $this->assertTrue($selection->contains($vehicle1) );
        $this->assertTrue($selection->contains($vehicle2) );
        $this->assertTrue($selection->contains($vehicle3) );
*/
    }

}