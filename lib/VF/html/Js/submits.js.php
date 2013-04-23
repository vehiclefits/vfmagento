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
    
    <?php
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
    <?php
}