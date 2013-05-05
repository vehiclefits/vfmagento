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
require_once( 'bootstrap-tests.php' );
class TestSuite
{
    static $suite;
    
    public static function suite()
    {
        echo "Discovering tests, please wait.. \n";
        $start = time();
        
        self::$suite = new PHPUnit_Framework_TestSuite( 'All Tests' );
        define( 'VAF_PATH', ELITE_PATH . '/Vaf' );
        
        self::includeTests();
        self::includeCoverage();
    
        $end = time();
        echo "took " . ( $end - $start ) . " seconds to bootstrap\n";
 
        return self::$suite;
    }
    
    static protected function includeTests()
    {        
        self::addTestPath( VAF_PATH, false );
        self::addTestPath( VAF_PATH . '/Model' );
        self::addTestPath( VAF_PATH . '/Adminhtml' );
        self::addTestPath( VAF_PATH . '/Helper' );
        self::addTestPath( VAF_PATH . '/Block' );   
        self::addTestFile( VAF_PATH . '/html/vafAjaxTest.php' );
    }
    
    static protected function includeCoverage()
    {
        PHPUnit_Util_Filter::addFileToWhitelist( VAF_PATH . '/html/vafAjax.include.php' );
    }
        
    static protected function addTestPath( $path, $recursive = true )
    {
        $files = $recursive ? recursive_glob( $path, true ) : glob( $path . '/*' );
        foreach( $files as $file )
        {
            if( $recursive && filetype( $file ) == 'dir' )
            {
                self::addTestPath( $file );
            }
            else if( substr( $file, -8, 8 ) == 'Test.php' )
            {
                self::addTestFile( $file );
            }
        }
        if( $recursive )
        {
            self::addCoverageReportPath( $path );
        }
    }
    
    static protected function addTestFile( $file )
    {
        self::$suite->addTestFile( $file );
    }
    
    static protected function addCoverageReportPath( $path )
    {
        PHPUnit_Util_Filter::addDirectoryToWhitelist( $path );
        self::removeTestFilesFromWhitelist( $path );
    }
    
    static protected function removeTestFilesFromWhitelist( $path )
    {
        $files = recursive_glob( $path, true );
        foreach( $files as $file )
        {
            if( filetype( $file ) == 'dir' )
            {
                self::removeTestFilesFromWhitelist( $file  );
            }
            else if( substr( $file, -8, 8 ) == 'Test.php' )
            {
                PHPUnit_Util_Filter::removeFileFromWhitelist( $file );
            }
            else if( substr( $file, -12, 12 ) == 'TestCase.php' )
            {
                PHPUnit_Util_Filter::removeFileFromWhitelist( $file );
            }
        }
    }

}

function recursive_glob($dir, $showPaths = false )
{
    $files = Array();
    $file_tmp= glob($dir.'*',GLOB_MARK | GLOB_NOSORT);
    foreach($file_tmp as $item)
    {
        if( $showPaths || substr($item,-1)!=DIRECTORY_SEPARATOR)
        {
            $files[] = $item;
        }
        else
        {
            $files = array_merge($files,recursive_glob($item));
        }
        if( $showPaths && filetype( $item) == 'dir' )
        {
            $files = array_merge( $files,recursive_glob( $item, true ) );
        }
    }
    return $files;
}
