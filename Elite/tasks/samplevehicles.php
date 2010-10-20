<?php
require_once( dirname( __FILE__ ) . '/../Vaf/TestSuite.php' );

class SampleData
{
    function main()
    {
        $schema = new Elite_Vaf_Model_Schema();
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array('make','model','year'));
        
        for($i=2000; $i<=2010; $i++ )
        {
        	$vehicle = Elite_Vaf_Model_Vehicle::create( $schema, array('make'=>'Honda','model'=>'Civic','year'=>$i) );
        	$vehicle->save();
		}
    }

}

$cli = new SampleData();
$cli->main();