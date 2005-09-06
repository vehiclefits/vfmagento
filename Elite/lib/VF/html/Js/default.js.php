<?php
$CONFIG = $main->getConfig();
$schema = $main->getSchema();
$front = $main->isFront();
    
$levels = $schema->getLevels();
$c = count( $levels );

$leafLevel = $this->leafLevel();

?>

var chained = function() {
    <?php
     
    if( Mage::helper('vaf')->getConfig()->mygarage->collapseAfterSelection )
    {
        ?>
        var myGarageActive = jQuery( '.vafMyGarageActive' );
        if( 0 < myGarageActive.length )
        {
            jQuery('#vafForm').hide();
        }
        jQuery('.vafMyGarageChange').click( function() {
            jQuery('#vafForm').toggle();
        });
        <?php
    }
    
    ?>
    
    var showSelect = function( select ) {
        jQuery(select)
            .show()
            .removeAttr('disabled')
            .prev('label').show();
    }
    
    
    var loadNextSelectIfOneOption = function( loadedSelect, selectAfterLoaded ) {
        
        if( jQuery('.' + loadedSelect + 'Select option' ).length == 1 ) {
            var myFuncName = 'load' + ucfirst(selectAfterLoaded) + 's';
            jQuery('.' + loadedSelect + 'Select option' ).change();
        }
    }

    
    
    function lastLevel() {
        return '<?=$schema->getLeafLevel()?>';
    }
    
    <?php
    
    if( 'offline' != $CONFIG['loadingStrategy'] )
    {
        $loader = new VafJs_Loader_Ajax();
    }
    else
    {
        $loader = new VafJs_Loader_Offline();
    }
    echo $loader->main('',$main);
    
    $submit = new VafJs_Submits();
    echo $submit->main('',$main);
    
    $callbacks = new VafJs_Callbacks();
    echo $callbacks->main('',$main);
    ?>  
    
} 

jQuery.fn.chained = function() {
    this.each( function() {
        var mychained = new chained( this );
    });  
};

jQuery('#vafForm').chained();
jQuery('#vafChooserForm').chained();