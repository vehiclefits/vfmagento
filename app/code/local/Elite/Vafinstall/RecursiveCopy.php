<?php
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