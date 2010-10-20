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
class vafAjaxInclude
{
    function execute()
    {
        $schema = new Elite_Vaf_Model_Schema();$leafLevel = Elite_Vaf_Helper_Data::getInstance()->getLeafLevel();
        $ajax = new Elite_Vaf_Model_Ajax();
        return $ajax->execute( $schema );   
    }
}

if( isset($_GET['requestLevel']))
{
    $a = new vafAjaxInclude();
    $a->execute();
}