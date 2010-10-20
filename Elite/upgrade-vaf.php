<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Ne8, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Ne8 llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
require_once( 'app/Mage.php' );
require_once( 'app/code/local/Elite/Vaf/Model/Schema/Generator.php' );
Mage::app();
$helper = Elite_Vaf_Helper_Data::getInstance();
?>
<form action="?" method="post">
	<?php
	$pathEnumerator = new Elite_Vafinstall_PathEnumerator;
	include('Elite/Vafinstall/includes/check-permissions.php');
	include('Elite/Vafinstall/includes/upgrade-db.php');
	include('Elite/Vafinstall/includes/copy-files.php')
	?>

	<input type="submit" name="submit" value="GO" />
</form>

<?php
include('Elite/Vafinstall/includes/jquery.php');