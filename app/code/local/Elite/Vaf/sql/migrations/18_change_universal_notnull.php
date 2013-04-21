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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Vaf18
{
    function run()
    {
        $schema = new VF_Schema();
        $db = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();

        $db->query('DROP TABLE elite_import');
        $db->query('
CREATE TABLE IF NOT EXISTS `elite_import` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `make` varchar(255) NOT NULL,
  `make_id` int(50) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(50) NOT NULL,
  `year` varchar(255) NOT NULL,
  `year_id` int(50) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `product_id` int(255) DEFAULT NULL,
  `universal` int(1) DEFAULT \'0\',
  `existing` int(1) NOT NULL,
  `line` int(255) NOT NULL,
  `mapping_id` int(255) NOT NULL,
  `note_message` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
          
        
    }
}
Vaf18::run();

