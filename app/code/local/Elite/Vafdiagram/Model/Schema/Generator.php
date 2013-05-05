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
class Elite_Vafdiagram_Model_Schema_Generator extends VF_Schema_Generator
{
    function generator($levels)
    {
        return 'CREATE TABLE IF NOT EXISTS `elite_product_servicecode` (
				  `product_id` int(100) NOT NULL,
				  `service_code` varchar(100) NOT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				
				ALTER TABLE  `elite_import` ADD  `service_code` VARCHAR( 100 ) NOT NULL;
				
				ALTER TABLE  `elite_1_definition` ADD  `service_code` VARCHAR( 100 ) NOT NULL;
				
				ALTER TABLE `elite_product_servicecode` ADD `category1_id` INT( 10 ) NOT NULL ,
ADD `category2_id` INT( 10 ) NOT NULL ,
ADD `category3_id` INT( 10 ) NOT NULL ,
ADD `category4_id` INT( 10 ) NOT NULL ;

				ALTER TABLE `elite_product_servicecode` ADD `illustration_id` VARCHAR( 10 )  NULL;
				
				ALTER TABLE  `elite_product_servicecode` ADD  `callout` INT( 3 ) NOT NULL;
				ALTER TABLE `elite_product_servicecode` ADD PRIMARY KEY ( `product_id` , `service_code` , `category1_id` , `category2_id` , `category3_id` , `category4_id` , `illustration_id` , `callout` ) ;
				';
    }
}