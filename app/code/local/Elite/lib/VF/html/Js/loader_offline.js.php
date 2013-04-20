<?php
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