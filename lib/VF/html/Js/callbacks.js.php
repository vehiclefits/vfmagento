<?=$content?>

jQuery('#vafForm .vafSubmit').click(submitVafForm); 
jQuery('#vafChooserForm .vafSubmit').click(submitVafChooserForm); 
jQuery('#vafClear').click( clearVafForm ); 

jQuery( '.vafCheckAll' ).click( function() {
    jQuery( '.vafcheck' ).attr( 'checked', jQuery(this).attr( 'checked' ) );
})



jQuery( '.vaf-cat-toggler' ).click( function() {

    var icon = jQuery(this).children( 'div.vaf-toggle-icon ' );
    icon.toggleClass( 'vaf-toggle-icon-minus' );
    
    var toggleDiv = jQuery(this).nextAll( 'div.vaf-toggle' );
    toggleDiv.toggle();

});
jQuery( 'div.vaf-toggle' ).hide();

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

/** Set up the call-backs for each level */
$c = count( $levels );
for( $i = 0; $i < $c - 1; $i++ )
{
    ?>
    var callback = load<?=str_replace(' ','_',ucfirst( $levels[ $i + 1 ] ))?>s;
    jQuery('.<?=str_replace(' ','_',$levels[ $i ])?>Select').change( callback );    
    <?php
}
?>