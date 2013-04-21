var getUrl = function( form, requestLevel ) {
    var requestLevel = requestLevel.replace(' ','_');
    if( form.find('.' + requestLevel + 'Select').size() ) {
        var select = form.find('.' + requestLevel + 'Select');
    } else {
        var select = form.find('.' + requestLevel + '_startSelect');
    }
    var value = select.val();
    
    var product = jQuery('#vafProduct').val();
    var url = '<?=Elite_Vaf_Helper_Data::getInstance()->processUrl()?>';
    
    var levels = select.metadata().prevLevelsIncluding.split(',');
    
    url = url + '&product=' + product;
    url = url + '&front=<?=$main->isFront() ? 1 : 0?>';
    url = url + '&requestLevel=' + requestLevel;
    
    $.each(levels, function(index,level){
        var level = level.replace(' ','_');
        if(level==requestLevel) {
            return;
        }
        url = url + '&' + level + '=' + form.find('.' + level + 'Select').val();
    });
    
    return url;
}

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
function isLastLevel( $i, $c ) {
    return $i == $c - 2;
}

/** Iterate each level ( except the "leaf" level ) and create a function to load it's children */
for( $i = 0; $i < $c - 1; $i++ )
{
    $level = $levels[ $i ];
    echo "\n";
    ?>
    
    var load<?=str_replace(' ','_',ucfirst( $levels[ $i + 1 ] ))?>s = function() {
        
        var callbackFunc = function(){
        
            showSelect(this);
            <?php
            if( isset( $levels[ $i + 2 ] ) )
            {
                ?>
                loadNextSelectIfOneOption( '<?=str_replace(' ','_',$levels[ $i + 1 ])?>', '<?=str_replace(' ','_',$levels[ $i + 2 ])?>' );
                <?php
            } 
            if( shouldAutoSubmit() && isLastLevel( $i, $c ) )
            {
                ?>
                autoSubmit();
                <?php
            }
            ?>
            decorateUnavailableSelections();
            jQuery(this).trigger('vafLevelLoaded');
        };
        
        decorateUnavailableSelections();
        
        var loadingText = '<option value="0"><?=htmlentities( addslashes( $this->loadingText() ) )?></option>';
        
        if(jQuery('.<?=str_replace(' ','_',$levels[ $i + 1 ])?>_startSelect').size()) {
            var url = getUrl( jQuery(this).parent('form'), '<?=str_replace(' ','_',$levels[ $i + 1 ])?>' );
            jQuery(this).nextAll('.<?=str_replace(' ','_',$levels[ $i + 1 ])?>_startSelect').html( loadingText );
            jQuery(this).nextAll('.<?=str_replace(' ','_',$levels[ $i + 1 ])?>_endSelect').html( loadingText );
            jQuery(this).nextAll('.<?=str_replace(' ','_',$levels[ $i + 1 ])?>_startSelect').load( url, {}, function(responseText) {
                jQuery(this).html(responseText);
                callbackFunc.apply( this );
            });  
            jQuery(this).nextAll('.<?=str_replace(' ','_',$levels[ $i + 1 ])?>_endSelect').load( url, {}, function(responseText) {
                jQuery(this).html(responseText);
                callbackFunc.apply( this );
            });  
        } else {
            var url = getUrl( jQuery(this).parent('form'), '<?=str_replace(' ','_',$levels[ $i + 1 ])?>' );
            jQuery(this).nextAll('.<?=str_replace(' ','_',$levels[ $i + 1 ])?>Select').html( loadingText );
            jQuery(this).nextAll('.<?=str_replace(' ','_',$levels[ $i + 1 ])?>Select').load( url, {}, function(responseText) {
                jQuery(this).html(responseText);
                callbackFunc.apply( this );
            });  
        }
        
        <?php
        for( $j = $i + 2; $j < $c; $j++ )
        {
            ?>
            jQuery('.<?=str_replace(' ','_',$levels[ $j ])?>Select').html('<option></option>');
            <?php
        } 
        ?>
    }
    <?php
}