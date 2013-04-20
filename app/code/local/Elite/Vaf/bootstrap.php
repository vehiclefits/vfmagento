<?php
$elite_path = dirname(__FILE__).'/../';
defined( 'ELITE_PATH' ) or define( 'ELITE_PATH', $elite_path ); // put path to app/code/local/Elite
defined( 'ELITE_CONFIG' ) or define(  'ELITE_CONFIG', ELITE_PATH . '/Vaf/config.ini' );

set_include_path( 
     ELITE_PATH
     . PATH_SEPARATOR . ELITE_PATH . '/lib'
     . PATH_SEPARATOR . get_include_path()
);