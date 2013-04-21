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
$CONFIG = $main->getConfig();
$schema = $main->getSchema();
$front = $main->isFront();
    
$levels = $schema->getLevels();
$c = count( $levels );

$leafLevel = $this->leafLevel();

?>

var chained = function() {
    <?php
     
    if( Elite_Vaf_Helper_Data::getInstance()->getConfig()->mygarage->collapseAfterSelection )
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