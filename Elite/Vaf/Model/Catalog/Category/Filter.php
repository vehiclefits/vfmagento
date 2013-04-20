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
interface Elite_Vaf_Model_Catalog_Category_Filter
{

    function isInWhiteList( $id );
    function isInBlackList( $id );

    /**
    * If whitelisting is ON, and category is in whitelist, will filter
    * if whitelisting is on, and category is not in whitelist, will not filter
    * 
    * If blacklist is specified and category is in blacklist, will not filter
    * 
    * If disable=true, will never filter on category page
    */
    function shouldShow( $categoryId );
}