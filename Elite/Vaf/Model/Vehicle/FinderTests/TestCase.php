<?php
abstract class Elite_Vaf_Model_Vehicle_FinderTests_TestCase extends Elite_Vaf_TestCase
{
	protected function getFinder()
    {
        $schema = new VF_Schema;
        return new Elite_Vaf_Model_Vehicle_Finder( $schema );
    }
}
	