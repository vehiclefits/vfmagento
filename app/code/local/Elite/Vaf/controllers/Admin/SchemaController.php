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
class Elite_Vaf_Admin_SchemaController extends Mage_Adminhtml_Controller_Action
{   
    function indexAction()
    {
        $version = new Elite_Vafinstall_Migrate;
        if( $version->needsUpgrade() )
        {
            echo 'Please run the upgrade-vaf.php script as per the documentation. Your database is out of date.';
            exit();
        }        
        $this->setLevels();
        $this->setSortingLevels();
        
        $this->loadLayout();
        $this->_setActiveMenu('vaf');
        
        $block = $this->getLayout()->createBlock('adminhtml/vaf_schema', 'vaf' );
        $block->setTemplate( 'vf/vaf/schema.phtml' );
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    function setLevels()
    {
        $levels = $this->getLevels();
        if( count($levels)>1 && $levels && isset($_REQUEST['submit']) )
        {
            $this->generator()->dropExistingTables();
            $sql = trim($this->generator()->generator($levels));
            foreach( explode(';',$sql) as $statement )
            {
                if(!empty($statement))
                {
                    $this->query( $statement );
                }
            }  
            
        }
    }
    
    function getLevels()
    {
        $levels = $this->getRequest()->getParam('levels');
        $levels = explode(',', $levels );
        $return = array();
        foreach($levels as $index=>$level)
        {
            $return[$level] = $level;
        }
        return $return;
    }
    
    
    function setSortingLevels()
    {
        $schema = new VF_Schema();
        foreach( $schema->getLevels() as $level )
        {
            if( isset($_GET[$level.'Sorting']) )
            {
                $this->generator()->setSorting($level,$_GET[$level.'Sorting']);
            }
        }
    }
    
    function generator()
    {
        return new VF_Schema_Generator();
    }
    
    function query($sql)
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter()->query($sql);
    }     
}