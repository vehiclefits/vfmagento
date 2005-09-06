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
class vafAjaxInclude
{
    function execute()
    {
        $schema = new VF_Schema();
        $ajax = new Elite_Vaf_Model_Ajax();
        return $ajax->execute( $schema );   
    }
}

if( isset($_GET['requestLevel']))
{
    $a = new vafAjaxInclude();
    $a->execute();
}