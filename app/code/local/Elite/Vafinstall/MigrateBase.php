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
* This source file is subject to the new BSD license that is bundled
* with this package in the file LICENSE.txt.
* 
* @copyright Copyright (c) 2008-2009 Vehicle Fits, LLC <josh.ribakoff@gmail.com>
* @license New BSD License
*/
abstract class Elite_Vafinstall_MigrateBase
{
    abstract function pathToScripts();
    
    /**
    * @return integer
    */
    abstract function getCurrentVersion();
    
    /**
    * @return array
    */
    abstract protected function getTables();

    abstract protected function createVersionTable();
    
    function execute( $reset = false, $toVersion = null )
    {
        try
        {
            $currentVersion = $this->getCurrentVersion();
        } catch ( Exception $e )
        {
            $currentVersion = 0;
        }

        if( $reset || $currentVersion == 0 )
        {
            try{ $this->createVersionTable(); } catch( Exception $E ) {}
            $currentVersion = 0;           
        }                                                                  
         
        self::migrate( $currentVersion, $toVersion );
    }
    
    /**
    * Bring the database to a requested version #
    */
    function migrate( $fromVersion = 0, $toVersion = NULL )
    {
        $files = $this->files();
        foreach( $files as $file )
        {
            $version = $this->versionFromFile($file);
            if( false === $version )
            {
                continue;
            }
            
            if( $version <= $fromVersion )
            {
                // already loaded this version, skip it
                continue;
            }
            if( !is_null( $toVersion ) )
            {
                if( $version > $toVersion )
                {
                    echo 'stopping short at version ' . $toVersion;
                    break;
                }
            }
            self::runScript( $version, $this->pathToScripts() . '/' . $file );
        }
    }
    
    function versionFromFile($file)
    {
        // get the version # from the filename
        preg_match( '#^([0-9]+)_#', basename( $file ), $matches );
        if( !isset( $matches[1] ) )
        {
            return false;
        }
        return $matches[1];
    }
    
    function needsUpgrade()
    {
        return false !== $this->maxVersion() && $this->getCurrentVersion() != $this->maxVersion();
    }
    
    function maxVersion()
    {
        if(!count($this->versions())) {
            return false;
        }
        return max($this->versions());
    }
    
    function versions()
    {
        $versions = array();
        foreach($this->files() as $file)
        {
            array_push($versions,$this->versionFromFile($file));
        }
        return $versions;
    }
    
    function files()
    {
        // get all the database refactoring scripts
        $files = glob( $this->pathToScripts() . '/*' );
        foreach( $files as $key => $val )
        {
            $files[ $key ] = basename( $val );
        }
        // sort the files in version order
        asort( $files, SORT_NUMERIC );
        return $files;
    }
    
    /**
    * run the version + script as php or SQL
    * updates the version table
    */
    function runScript( $version, $file )
    {
        ob_implicit_flush();
        echo basename($file) .  "\n";
                
        if( substr( $file, -3 ) == 'php' )
        {
            require( $file );
        }
        $this->db()->query( 'UPDATE `elite_version` SET `version` = ' . (int)$version );
    }
    
    function db()
    {
		return VF_Singleton::getInstance()->getReadAdapter();
    }
}