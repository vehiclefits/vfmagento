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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
require_once( dirname( __FILE__ ).'/config.default.php');
require_once( dirname( __FILE__ ) . '/../Vaf/bootstrap-tests.php' );
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
            $vehicleParts = array('make'=>'Honda','model'=>'Civic','year'=>$i);
        	$vehicle = VF_Vehicle::create( $schema, $vehicleParts );
        	$vehicle->save();
            echo "Created vehicle $vehicle \n";
		}
    }

}

$cli = new SampleData();
$cli->main();