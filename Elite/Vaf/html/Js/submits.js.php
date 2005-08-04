<?php
if( shouldAutoSubmit( $levels ) )
{
    $lastLevel = $levels[$c - 1];
    ?>
    
    function hasOptions(){
        return jQuery( '.' + lastLevel() + 'Select option' ).size() >= 1;
    }
    
    function hasSelection() {
        return selectHasValue( jQuery( '.' + lastLevel() + 'Select' ) );
    }
    
    function selectionHasValue() {
        var val = jQuery( '.' + lastLevel() + 'Select option:selected' ).val();
        return '' != val && 0 != val;
    }

    function autoSubmit()
    {
        if( hasOptions() && hasSelection() && selectionHasValue() )
        {
            submitVafForm();
        }
    }
    
    <?
}
?>

jQuery('#vafForm').bind("vafSubmit", function() {
    jQuery('#vafForm').submit();
});
   
jQuery('#vafChooserForm').bind("vafChooserSubmit", function() {
    jQuery('#vafChooserForm').submit();
});
    
submitVafForm = function()
{
    if( jQuery('#categorySelect').val() != '?' )
    {
        jQuery('#vafForm').attr( 'action', jQuery('#categorySelect').val() );
    }
    var chooser = jQuery('#categorySelect');
    if( !chooser.is('input') && !chooser.is('select')) {
        chooser.html('<option value=""></option>');
    }
    jQuery('#vafForm').trigger("vafSubmit");
    return true;
}
    
submitVafChooserForm = function()
{
    jQuery('#vafChooserForm').trigger("vafChooserSubmit");
    return true;
}

clearVafForm = function()
{
    <?php
    /** Reset applicable paramaters */
    $params = array();
    for( $i = 0; $i < $c; $i++ )
    {
        $params[ $levels[ $i ] ] = 0;
    }
    ?>
    window.location = '<?='?' . http_build_query( $params )?>';
}

<?php
if( shouldAutoSubmit( $levels ) )
{
    ?>
    jQuery( '.<?=$levels[$c - 1]?>Select').change( function() {
        autoSubmit();
    } );
    <?
}