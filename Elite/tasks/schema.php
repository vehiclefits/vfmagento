<?php
require_once( dirname( __FILE__ ) . '/../Vaf/TestSuite.php' );

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