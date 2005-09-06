function selectHasValue( select ) {
    var hasValue = false;
    select.find('option').each( function() {
        if( '' != jQuery(this).val() && 0 != jQuery(this).val() ) {
            hasValue = true;
        }
    });
    return hasValue;
}

var decorateUnavailableSelections = function() {
    
    if( 1 != <?=$main->isFront() ? 1 : 0?>)
    {
    	return;
    }
    var mode = '<?=$mode?>';
    
    <?php
    foreach( $levelsExceptRoot as $level )
    {
        ?>
        var select = jQuery('.<?=$level?>Select');
        if( !selectHasValue( select ) ) {
            switch( mode ) {
                case 'hide':
                    select.hide();
                    select.prev('label').hide();
                break;
                case 'disable':
                    select.attr('disabled','disabled');
                break;
            }
        }
        <?php
    }
    ?>
}

<?=$content?>

decorateUnavailableSelections(); 