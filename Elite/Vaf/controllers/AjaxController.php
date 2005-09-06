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
class Elite_Vaf_AjaxController extends Mage_Core_Controller_Front_Action
{    
    
    function jsAction()
    {
        header('Content-Type:application/x-javascript');
        echo 'jQuery.noConflict();';
        require_once('app/code/local/Elite/lib/Vf/html/vafAjax.js.include.php'); 
    }
    
    function processAction()
    {
        require_once('app/code/local/Elite/lib/Vf/html/vafAjax.include.php');
    }

}