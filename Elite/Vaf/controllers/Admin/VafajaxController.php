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
class Elite_Vaf_Admin_VafajaxController extends Mage_Core_Controller_Front_Action
{    
    
    function jsAction()
    {
        require_once('app/code/local/Elite/Vaf/html/vafAjax.js.include.php'); 
    }
    
    function processAction()
    {
        require_once('app/code/local/Elite/Vaf/html/vafAjax.include.php');
    }

}