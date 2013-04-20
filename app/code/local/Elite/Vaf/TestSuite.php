<?php
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
