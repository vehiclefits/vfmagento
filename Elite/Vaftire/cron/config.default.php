<?php
// Edit: set paths as neccessary
require_once( dirname( __FILE__ ) . '/../../Vaf/bootstrap.php' );
require_once('../../../../../Mage.php');

// Edit: Set to database credentials (should match app/etc/local.xml and empty cache) 
$params = array(
    'host'           => '',
    'username'       => 'root',
    'password'       => '',
    'dbname'         => 'vaf'
);