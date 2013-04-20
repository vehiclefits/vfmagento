<?php
class Elite_Vaf_Task_Version
{
    function getVersion()
    {
        $config = new SimpleXMLElement( file_get_contents( dirname( __FILE__ ) . '/etc/config.xml' ) );
        return $config->modules->Elite_Vaf->version;
    }
}

$build = new Elite_Vaf_Task_Version();
exit( $build->getVersion() );
