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

 * @copyright Copyright (c) 2013 Vehicle Fits, llc
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

$elite_path = dirname(__FILE__).'/../';
defined('ELITE_PATH') or define( 'ELITE_PATH', $elite_path ); // put path to app/code/local/Elite
defined('ELITE_CONFIG_DEFAULT') or define( 'ELITE_CONFIG_DEFAULT', ELITE_PATH . '/Vaf/config.default.ini' );
defined('ELITE_CONFIG') or define( 'ELITE_CONFIG', ELITE_PATH . '/Vaf/config.ini' );
defined('MAGE_PATH') or define( 'MAGE_PATH', realpath($elite_path.'../../../../'));

require_once( __DIR__.'/../vendor/autoload.php' );

$resource = Mage::getSingleton('core/resource');
$read = $resource->getConnection('core_read');
VF_Singleton::getInstance()->setReadAdapter($read);

set_include_path(
    PATH_SEPARATOR . MAGE_PATH . '/lib/'
    . PATH_SEPARATOR . get_include_path()
);