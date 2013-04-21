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
/** @author Josh Ribakoff ( NE8, llc) */
class Elite_Vafinstall_RecursiveCopy
{
	function main($source, $dest,$nested=1)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // notify user
        $this->notify( $source, $dest, $nested );
        
        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ( substr($entry, 0,1) =='.' || $entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            $this->main("$source/$entry", "$dest/$entry", $nested + 1);
        }

        // Clean up
        $dir->close();
        return true;
    }
    
    protected function notify( $source, $dest, $nested )
    {
        if( $nested < 2 )
        {
            $this->doNotify( $this->formatMessage($source,$dest), $nested );
        }
        else
        {
            $this->doNotify( sprintf('Copy %s%s', basename($dest), filetype($source) == 'dir' ? '/' : '' ), $nested ); 
        }
    }
    
    protected function doNotify( $message, $nested )
    {
        echo '|' . str_repeat( '--', $nested-1) . ' ' .  $message . "\n";
    }
    
    protected function formatMessage( $source, $dest )
    {
        return sprintf( 'Copy [%s] to [%s]', $source, $dest );
    }
}