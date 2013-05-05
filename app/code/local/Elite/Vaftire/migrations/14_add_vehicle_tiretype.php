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
$db = VF_Singleton::getInstance()->getReadAdapter();

$db->query("
CREATE TABLE IF NOT EXISTS `elite_vehicle_tire` (
  `leaf_id` int(50) NOT NULL,
  `section_width` int(3) NOT NULL,
  `aspect_ratio` int(3) NOT NULL,
  `diameter` int(3) NOT NULL,
  `tire_type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

$db->query("
ALTER TABLE `elite_vehicle_tire` ADD UNIQUE (
    `leaf_id` ,
    `section_width` ,
    `aspect_ratio` ,
    `diameter` ,
    `tire_type`
);");