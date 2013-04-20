<?php
class Elite_Vafinstall_PathEnumerator
{
	function paths()
	{
		$tasks = $this->tasks();

		$paths = array('.');

        foreach( $tasks as $eachTask )
		{
			array_push( $paths, dirname(realpath($eachTask[1])) );
		}
		return array_unique($paths);
	}
	
	function tasks()
	{
		$tasks = array(
		    array( 'app/code/local/Elite/skin/', './skin/', 'static js & css' ),
		    array( 'app/code/local/Elite/Vaf/Elite_Vaf.xml', './app/etc/modules/Elite_Vaf.xml', 'module XML' ),
            array( 'app/code/local/Elite/Vaf/design/', './app/design/', 'theme phtml & layout xml' ),
            array( 'app/code/local/Elite/Vaf/jsAndCss/', '.', 'dynamic js, css & ajax' )
		);
		if( file_exists( 'app/code/local/Elite/Vafbundle' ) )
		{
		    array_push( $tasks, array( 'app/code/local/Elite/Vafbundle/Elite_Vafbundle.xml', './app/etc/modules/Elite_Vafbundle.xml', 'bundle module XML' ) );
		}
		if( file_exists( 'app/code/local/Elite/Vafimporter' ) )
		{
		    array_push( $tasks, array( 'app/code/local/Elite/Vafimporter/Elite_Vafimporter.xml', './app/etc/modules/Elite_Vafimporter.xml', 'import module XML' ) );
		    array_push( $tasks, array( 'app/code/local/Elite/Vafimporter/design', './app/design', 'import module designs' ) );
		}
		if( file_exists( 'app/code/local/Elite/Vafnote' ) )
		{
		    array_push( $tasks, array( 'app/code/local/Elite/Vafnote/Elite_Vafnote.xml', './app/etc/modules/Elite_Vafnote.xml', 'notes module XML' ) );
            array_push( $tasks, array( 'app/code/local/Elite/Vafnote/design', './app/design', 'notes designs' ) );
		}
		if( file_exists( 'app/code/local/Elite/Vafpaint' ) )
		{
		    array_push( $tasks, array( 'app/code/local/Elite/Vafpaint/Elite_Vafpaint.xml', './app/etc/modules/Elite_Vafpaint.xml', 'paint module XML' ) );
		    array_push( $tasks, array( 'app/code/local/Elite/Vafpaint/design', './app/design', 'paint designs' ) );
		}
		if( file_exists( 'app/code/local/Elite/Vafsitemap' ) )
		{
		    array_push( $tasks, array( 'app/code/local/Elite/Vafsitemap/Elite_Vafsitemap.xml', './app/etc/modules/Elite_Vafsitemap.xml', 'sitemap module XML' ) );
		    array_push( $tasks, array( 'app/code/local/Elite/Vafsitemap/design', './app/design', 'sitemap designs' ) );
		}
        if( file_exists( 'app/code/local/Elite/Vafwheel' ) )
        {
            array_push( $tasks, array( 'app/code/local/Elite/Vafwheel/Elite_Vafwheel.xml', './app/etc/modules/Elite_Vafwheel.xml', 'wheel module XML' ) );
            array_push( $tasks, array( 'app/code/local/Elite/Vafwheel/design', './app/design', 'wheel designs' ) );
        }
        if( file_exists( 'app/code/local/Elite/Vafwheeladapter' ) )
        {
            array_push( $tasks, array( 'app/code/local/Elite/Vafwheeladapter/Elite_Vafwheeladapter.xml', './app/etc/modules/Elite_Vafwheeladapter.xml', 'wheel adapter module XML' ) );
            array_push( $tasks, array( 'app/code/local/Elite/Vafwheeladapter/design', './app/design', 'wheel designs' ) );
        }
		if( file_exists( 'app/code/local/Elite/Vaftire' ) )
		{
		    array_push( $tasks, array( 'app/code/local/Elite/Vaftire/Elite_Vaftire.xml', './app/etc/modules/Elite_Vaftire.xml', 'tire module XML' ) );
		    array_push( $tasks, array( 'app/code/local/Elite/Vaftire/design', './app/design', 'tire designs' ) );
		}
		if( file_exists( 'app/code/local/Elite/Vaflinks' ) )
		{
		    array_push( $tasks, array( 'app/code/local/Elite/Vaflinks/Elite_Vaflinks.xml', './app/etc/modules/Elite_Vaflinks.xml', 'links (directory) XML' ) );
		    array_push( $tasks, array( 'app/code/local/Elite/Vaflinks/design', './app/design', 'Vaflinks designs' ) );
		}
        if( file_exists( 'app/code/local/Elite/Vaflogo' ) )
        {
            array_push( $tasks, array( 'app/code/local/Elite/Vaflogo/Elite_Vaflogo.xml', './app/etc/modules/Elite_Vaflogo.xml', 'logo module XML' ) );
            array_push( $tasks, array( 'app/code/local/Elite/Vaflogo/design', './app/design', 'Vaflogo designs' ) );
        }
		if( file_exists( 'app/code/local/Elite/Vafgarage' ) )
		{
		    array_push( $tasks, array( 'app/code/local/Elite/Vafgarage/Elite_Vafgarage.xml', './app/etc/modules/Elite_Vafgarage.xml', 'garage module XML' ) );
		    array_push( $tasks, array( 'app/code/local/Elite/Vafgarage/design', './app/design', 'Vafgarage designs' ) );
		}
		return $tasks;
	}
}