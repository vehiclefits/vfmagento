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
class Elite_Vaf_Block_Product_Result_Grid extends Elite_Vaf_Block_Product_Result
{
    function __construct()
    {
        parent::__construct();
        $this->setTemplate('catalogsearch/result.phtml');
    }
    
    function setListOrders()
    {
        $this->getChild('search_result_list')
            ->setAvailableOrders(array(
                'name' => Elite_Vaf_Helper_Data::getInstance()->__('Name'),
                'price'=>Elite_Vaf_Helper_Data::getInstance()->__('Price'))
            );
    }

    function setListModes()
    {
        $this->getChild('search_result_list')
            ->setModes(array(
                'grid' => Elite_Vaf_Helper_Data::getInstance()->__('Grid'),
                'list' => Elite_Vaf_Helper_Data::getInstance()->__('List'))
            );
    }
}