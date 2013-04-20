jQuery(document).ready( function() {

    jQuery( '.paintOptions' ).hide();

    var findOptionLabelByTitle = function() {
        var label = false;
        jQuery('.product-options').find('label').each( function() {
            var html = jQuery(this).html();
            if( 'Painted' == html.substring( 0, 7 )  )
            {
                label = this;
            }
        });
        return label;
    };
    
    var findSelect = function() {
        var optionLabel = findOptionLabelByTitle();
        var selectBox = jQuery(optionLabel).parents('div:first').find('select:first');
        return selectBox;
    };
    
    var getSelectValue = function() {
        var selectBox = findSelect();
        var val = selectBox.find(':selected').text();
        if( 'Yes' == val.substring( 0, 3 ) )
        {
            jQuery( '.paintOptions' ).show();
        }
        else
        {
            jQuery( '.paintOptions' ).hide();
        }
    }
    
    jQuery('select').change( getSelectValue );
    
});


/***
Attribute based toggling, attributes dont work
with import but will add this as a feature later

jQuery( '#attribute').change( function() {
    if( jQuery(this).val() == 4 ) {
        jQuery( '.paintOptions' ).show();
    } else {
        jQuery( '.paintOptions' ).hide();
    }
});
****/