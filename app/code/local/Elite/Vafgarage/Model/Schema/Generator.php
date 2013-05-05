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
class Elite_Vafgarage_Model_Schema_Generator extends VF_Schema_Generator
{
    function generator($levels)
    {
        return '';
    }
    
    function install()
    {
        //$sql = "
//        ALTER TABLE `".$this->tablePrefix()."sales_flat_order_item` ADD `elite_vehicle` VARCHAR( 50 ) NOT NULL ;
//        ALTER TABLE `".$this->tablePrefix()."sales_flat_quote_item` ADD `elite_vehicle` VARCHAR( 50 ) NOT NULL ;
//        ";
        $sql = "
        ALTER TABLE `".$this->tablePrefix()."sales_flat_order` ADD `elite_fit` VARCHAR( 50 ) NOT NULL ;
        ";

        return $sql; 
    }
    
}
