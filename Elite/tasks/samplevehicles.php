<?php
require_once( dirname( __FILE__ ) . '/../Vaf/TestSuite.php' );

class SampleData
{
    function main()
    {
        $schema = new VF_Schema();
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array('make','model','year'));
        
        for($i=2000; $i<=2010; $i++ )
        {
        	$vehicle = VF_Vehicle::create( $schema, array('make'=>'Honda','model'=>'Civic','year'=>$i) );
        	$vehicle->save();
		}
    }

}

$cli = new SampleData();
$cli->main();