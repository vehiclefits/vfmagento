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
require_once( dirname( __FILE__ ).'/config.default.php');
require_once( dirname( __FILE__ ) . '/../Vaf/bootstrap-tests.php' );

class Schema_CLI
{
    protected $levels;
    
    protected $generator;
    
    const DONE = "\nDone";
    
    function __construct()
    {
        $this->generator = new VF_Schema_Generator();
    }
    
    function main()
    {
        $this->askUserLevels();
        $this->confirmTablesToDrop();
        $this->generator->dropExistingTables();
        
        $this->createTheNewTables();
    }
    
    protected function isYes( $value )
    {
        return 'y' == strtolower($value);
    }    

    protected function askUserLevels()
    {
        $this->levels = $this->askUser( "Enter Levels, Comma Delim, [enter] for [make,model,year]:" );
        if( empty($this->levels) )
        {
            $this->levels = 'make,model,year';
        }
    }
    
    protected function askUser( $prompt )
    {
        $this->notifyUser( $prompt . ':' );
        return trim(fread(STDIN, 80),"\n\r "); // Read up to 80 characters or a newline
    }
    
    protected function confirmTablesToDrop()
    {
        $tables = $this->generator->getEliteTables();
        $this->notifyUser( "Will drop " . count( $tables ) . ' tables (' . implode( ', ', $tables ) . '), this ok? Y/N' );
        $response = trim(fread(STDIN, 80),"\n\r "); // Read up to 80 characters or a newline
        if( trim(ucfirst($response)) != 'Y' ) exit();
    }
    
    protected function createTheNewTables()
    {
        $this->notifyUser( "Applying Standard Schema" );
        $sql = $this->generator->execute( explode(',', $this->levels), true );
        $this->notifyUser( self::DONE );
    }
    
    protected function notifyUser( $msg )
    {
        echo $msg . "\n";
    }
}

$cli = new Schema_CLI();
$cli->main();