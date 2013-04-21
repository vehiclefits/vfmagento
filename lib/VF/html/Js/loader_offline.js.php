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
foreach( $levels as $level )
{
    ?>
    var <?=$level?> = new Array();
    <?php
}
function vafDoLevel( $level, $parent_id = 0 )
{    
    $schema = new VF_Schema();
    $finder = new VF_Level( $level );
    $parentLevel = $schema->getPrevLevel( $level );
    if( $parentLevel )
    {
        $entities = $finder->listInUse( array( $parentLevel => $parent_id ) );
    }
    else
    {
        $entities = $finder->listInUse();
    }
    echo $level . '["' . $parent_id . '"] = new Array();';
    foreach( $entities as $entity )
    {
        ?>
        var obj = new Array();
        obj["title"] = "<?=$entity->getTitle()?>";
        obj["id"] = "<?=$entity->getId()?>";
        <?=$level?>["<?=$parent_id?>"].push( obj );
        <?php
        if( $level != $schema->getLeafLevel() )
        {
            vafDoLevel( $schema->getNextLevel($level), $entity->getId() );
        }
        echo "\n";
    }
    
}

vafDoLevel( $schema->getRootLevel() );


/** Iterate each level ( except the "leaf" level ) and create a function to load it's children */
for( $i = 0; $i < $c - 1; $i++ )
{
    $level = $levels[ $i ];
    echo "\n";
    ?>
    
    var load<?=ucfirst( $levels[ $i + 1 ] )?>s = function() {
        
        var parentId = jQuery('.<?=$level?>Select').val();
        
        jQuery('.<?=$levels[$i+1]?>Select').html( '<option value="0"><?=Elite_Vaf_Helper_Data::getInstance()->getDefaultSearchOptionText()?></option>' );
        
        var newValues = <?=$levels[$i+1]?>[parentId];
        
        
        $.each( newValues, function() {
            var id = this["id"];
            var title = this["title"];
            if( id != undefined && title != undefined )
            {
                jQuery('.<?=$levels[$i+1]?>Select').append( '<option value="' + id + '">' + title + '</option>' );    
            }
        });
        
        decorateUnavailableSelections();
        jQuery(this).trigger('vafLevelLoaded');

    }
    <?php
}