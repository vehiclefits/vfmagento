<?php
abstract class VF_Vehicle_FinderTests_TestCase extends Elite_Vaf_TestCase
{
	protected function getFinder()
    {
        $schema = new VF_Schema;
        return new VF_Vehicle_Finder( $schema );
    }
}
	