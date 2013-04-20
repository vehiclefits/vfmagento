<fieldset>
	<legend>Database Upgrade</legend>
	


	<?php
	if( isset( $_POST['submit']))
	{
		$migrate = new Elite_Vafinstall_Migrate( );
		$migrate->execute( false, null );
		echo "<br /> Database is up to date!";
	}
	?>

</fieldset> 