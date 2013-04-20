<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Vehicle Fits llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
ini_set('display_errors',1);
error_reporting(E_ALL | E_STRICT);
require_once( 'app/Mage.php' );
require_once( 'app/code/local/Elite/lib/VF/Schema/Generator.php' );
Mage::app();
$helper = Elite_Vaf_Helper_Data::getInstance();
?>
<form action="?" method="post">
	<?php
	$pathEnumerator = new Elite_Vafinstall_PathEnumerator;
	include('Elite/Vafinstall/includes/check-permissions.php');
	include('Elite/Vafinstall/includes/install-db.php');
	include('Elite/Vafinstall/includes/copy-files.php')
	?>

	<input type="submit" name="submit" value="GO" />
</form>

<?php
include('Elite/Vafinstall/includes/jquery.php');