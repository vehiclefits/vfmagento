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

/** Set up the call-backs for each level */
$c = count( $levels );
for( $i = 0; $i < $c - 1; $i++ )
{
    ?>
    var callback = load<?=ucfirst( $levels[ $i + 1 ] )?>s;
    jQuery('.<?=$levels[ $i ]?>Select').change( callback );    
    <?php
}
?>