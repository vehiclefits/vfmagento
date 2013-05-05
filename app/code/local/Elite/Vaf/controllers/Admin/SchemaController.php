<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
        return VF_Singleton::getInstance()->getReadAdapter()->query($sql);
    }     
}