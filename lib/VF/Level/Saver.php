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
interface VF_Level_Saver
{

    /**
    * @param VF_Level $entity
    * @return VF_Level_Saver
    */
    function __construct( VF_Level $entity, $parent_id = 0 );
    
    function save();
}