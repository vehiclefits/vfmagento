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