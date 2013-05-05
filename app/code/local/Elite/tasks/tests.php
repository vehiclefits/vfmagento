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
/**
* Based loosely upon the designs of autotest.rb and ruby auto test utility(s)
* 
* Pass the path you want to recurisvely monitor as the only command line argument
* Override or change doDelay() and runTests() to suite your environment
* 
*
* - override runTests() with the command you want to run
* 
* - override doDelay() to check more/less often
* 
* - pass the path to files in the contstructor
* 
* - pass a log level to the constructor if you would like helpful output
*   (although this may interfere with ability to read your test failures if your delay is a low # )
*
* Invoke like this:
* C:/wamp/bin/php/php5.3.0/php E:\dev\path\phpautotest.php E:\dev\path\to\monitor
* 
* 
* @license code is licensed persuant to Open Software License ("OSL") v. 3.0
* 
* You may use it within your applications without providing credit
* Any modifications or derivative works must be licensed OSL v 3.0 unless express written consent provided
* 
* @author Josh Ribakoff <josh.ribakoff@gmail.com> www.ne8.net
*/
if( isset( $argv[1] ) )
{
    $path = trim( $argv[1] );
}
if( !$path )
{
    exit();
}
$test = new PHPAutoTest( $path );
$test->main();

/**
* The main test controller
*/
class PHPAutoTest
{
    protected $path;
    
    /**
    * No log messages
    */
    const NONE = 0;
    
    /**
    * Notify when file checking starts/stops
    */
    const CHANGE_LOOP = 1;
    
    /**
    * Notify when changes are detected
    */
    const CHANGED_FILES = 2;
    
    /**
    * @var array of PHPAutoTest_File
    */
    protected $files = array();
    
    /**
    * @var PHPAutoTest_Logger
    */
    protected $logger;
    
    /**
    * @param mixed $path path of files to monitor
    * @param mixed $logLevel set to NONE, CHANGE_LOOP, or CHANGED_FILES
    */
    function __construct( $path, $logLevel = 0 )
    {
        $this->path = $path;
        
        $this->logger = new PHPAutoTest_Logger( $logLevel );
    }
    
    function main()
    {
        while( true )
        {
            $this->logger->log( "checking files, please wait", self::CHANGE_LOOP );
            $run = false;
            foreach( $this->filesMonitoring() as $file )
            {
                if( $file->hasDeleted() )
                {
                    $run = true;    
                }
                if( $file->hasModified( ) )
                {
                    $run = true;
                }
            }
            if( $run )
            {
                $this->logger->log( "changes detected", self::CHANGE_LOOP );
                $this->runTests();
            }
            $this->logger->log( "done", self::CHANGE_LOOP );
            $this->doDelay();
        }
    }
    
    protected function doDelay()
    {
        sleep( 4 );   
    }
    
    protected function runTests()
    {
        passthru( 'tests.bat' );
    }
    
    /**
    * @return array of PHPAutoTest_File
    */
    function filesMonitoring()
    {
        $files = $this->recursiveGlob( $this->path );
        $return = array();
        foreach( $files as $file )
        {
            if( isset( $this->files[ md5( $file ) ] ) )
            {
                $fileObj = $this->files[ md5( $file ) ];
                array_push( $return, $fileObj );
                if( $fileObj->hasDeleted() )
                {
                    unset( $this->files[ $fileObj->getHash() ] );
                }
                continue;
            }
            $file = new PHPAutoTest_File( $file, $this->logger );
            array_push( $return, $file );
            $this->files[ $file->getHash() ] = $file;
        }
        return $return;
    }
    
    protected function recursiveGlob( $path )
    {
        $files = Array();
        $file_tmp= glob( $path . '*',GLOB_MARK | GLOB_NOSORT);
        foreach($file_tmp as $item)
        {
            if(substr($item,-1)!=DIRECTORY_SEPARATOR)
            {
                $files[] = $item;
            }
            else
            {
                $files = array_merge($files, $this->recursiveGlob($item));
            }
        }
        return $files;
    }
}

/**
* Each file is a PHPAutoTest_File object
*/
class PHPAutoTest_File
{
    protected $file;
    
    protected $modified;
    
    protected $logger;
    
    function __construct( $file, PHPAutoTest_Logger $logger )
    {
        $this->file = $file;
        $this->logger = $logger;
    }
    
    function isFile()
    {
        return filetype( $this->file ) == 'file';
    }
    
    function hasDeleted()
    {
        if( !file_exists( $this->file ) )
        {
            return true;
        }
    }
    
    /**
    * put your comment there...
    * 
    * @return boolean true if need to re-run tests, otherwise false
    */
    function hasModified()
    {
        if( !$this->isFile() )
        {
            return false;
        }
        $modified = filemtime( $this->file );
        $return = (bool)( $modified > $this->modified && $this->modified != 0 );
        if( $return ) $this->logger->log( $this->file . " modified at " . $modified, PHPAutoTest::CHANGED_FILES );
        $this->modified = $modified;
        return $return;
               
    }
    
    function getHash()
    {
        return md5( $this->file );
    }
}

class PHPAutoTest_Logger
{
    protected $logLevel;
    
    function __construct( $logLevel )
    {
        $this->logLevel = $logLevel;
    }
    
    function log( $msg, $level )
    {
        if( $this->logLevel >= $level )
        {
            echo $msg . "\n";
        }    
    }
}