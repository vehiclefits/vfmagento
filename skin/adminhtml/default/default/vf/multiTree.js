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
(function($) {
    
    var methods = {};
    
    var MultiTree = function( element ) {    

        
        /**
        * Encapsulate CSS class literals
        */
        var classes = {
            multiTree: 'multiTree',
            ajaxUrl: 'multiTree-ajaxUrl',
            multiTreeAdd: 'multiTree-Add',
            multiTreeQuickAdd: 'vafQuickAddSubmit',
            selections: 'multiTree-selections',
            newSelections: 'multiTree-new-selections',
            deletedSelections: 'multiTree-deleted-selections',
            selection: 'multiTree-selection',
            selectContainer: 'multiTree-selectContainer',
            levelName: 'multiTree-levelName',
            closeLink: 'multiTree-closeLink',
            elementName: 'multiTree-elementName',
            more: 'more',
            noMore: 'noMore',
            seperator: 'multiTree-selection-seperator'
        };
        
        var data = $(element).metadata();
        
        var ajaxUrl = data.ajaxUrl;
        var quickAddUrl = data.quickAddUrl;
        var schema = data.schema;
        
        
        var treeName = data.elementName;

        /**
        * Get the name of the level for a select element
        *
        * @param select jquery select
        * @return string
        */
        var getLevelName = function( select ) {
            return select.nextAll( '.' + classes.levelName + ':first' ).text();
        };
        
        /**
        * Get the child ( dependant ) selects for a select element
        *
        * @param select - jquery select
        * @return jquery collection of select elements
        */
        var getNextSelects = function( select ) {
            return select.parent().nextAll( '.' + classes.selectContainer ).find( 'select' );
        };
        
        /**
        * Load into a select a collection of options
        *
        * @param select - jquery select to load into
        * @param data - jquery collection of options, to contain:
        *   id - the primary key id of this option within it's level
        *   title - the title of this option
        *   more - boolean, wether or not this option has child options in the descendant level
        */
        var loadInto = function( select, data ) {

            // add the option, if it has more children then apply the correct class name
            select.html( data );
            // show the select
            select.parent().css( 'display', '' );
            jQuery(select).trigger('vafLevelLoaded');
        };
        
        /**
        * Hide a select 
        */
        var hideSelect = function( select ) {
            select.find( 'option:selected' ).attr( 'selected', '' );  // make sure it registers as unselected for the value, clearing the html is not sufficient apparently.
            select.html('').parent().css( 'display', 'none' );
        };
        
        /**
        * Show a select 
        */
        var showSelect = function( select ) {
            select.parent().css( 'display', 'none' );
        };
        
        /**
        * Callback for when an option is changed, will load in children if appropriate,
        * if this is the last level in the current tree, will return false
        * If children may be present, initates an ajax request with
        * callback to loadInto() to load the child options
        *
        * @param select - jquery select object that has been changed
        * @return boolean wether or not a request to load children was initiated
        */
        var selectChange = function( select ) {
            if( select.find( 'option:selected' ).hasClass( '.' + classes.noMore ) ) {
                return false;
            }
            var parentId = select.val()[0];
            var selectContainer = select.parent();
            // clear out & hide the boxes we might need to load into
            
            $.each( getNextSelects( select ), function( i, select ) {
                hideSelect( $(select) );
            });
                
            // get the container & element for the child level
            var childContainer = selectContainer.next( '.' + classes.selectContainer );
            var childSelect = childContainer.find( 'select' );
            // if this is the final box, no need to do any further lazy loading
            if( childSelect.length === 0 ) {
                return false;
            }
            
            var parentLevels =  select.metadata().parents_including.split(',');
            
            var levelName =  getLevelName( select );
            var childLevelName =  getLevelName( childSelect );

            var url = ajaxUrl + '?';
            url = url + 'schema='+schema;
            $.each(parentLevels, function(index, level) {
                var value = $(element).find('.' + level + 'Select' ).val();
                url = url + '&' + level + '=' + value;
            });
            
            // request the data and load it into the child level's select
            $.get(
                url,
                {
                    'requestLevel' : childLevelName
                },
                function( data ) {
                    loadInto( childSelect, data );
                }
            );
            return true;
        };
        
        var remove = function( option ) {
            var value = option.find( '.multiTree-value' ).text();
            var tree = option.parents( '.multiTree' );
            
            var newDiv = tree.find( '.' + classes.newSelections );
            var newElem = newDiv.find( "input[value='" + value + "']" );
            newElem.remove();
            
            var deletedDiv = tree.find( '.' + classes.deletedSelections );
            deletedDiv.append( '<input type="hidden" value="' + value + '" name="' + getElementName( tree ) + '-delete[]" />' );
            option.remove();
        };
        
        /**
        * Callback for removing selections
        */
        var reBindRemoveEvents = function() {
            $( '.' + classes.closeLink ).click( function()  {
                remove( $( this ).parent() );
                return false; 
            });
        };
        
        /**
        * Get the right most select that has a value
        * @param selects jquery collection of selects
        */
        var getCurrentLevelSelect = function( selects ) {
            var selected;
            selects = $.makeArray( selects );
            $.each( selects.reverse(), function() {
                if( $(this).val() !== null ) {
                    selected = $(this);
                    return false;
                }
            });
            return selected;
        };
        
        /**
        * iterate in reverse order and find value and
        * level name of right most level that has a selection.
        */
        var getSelected = function( selects ) {

            var array = new Array();
            var selected = getCurrentLevelSelect( selects );
            var selectedOptions = selected.find( 'option:selected');
            
            selectedOptions.each( function() {
            
                var selectedOption = $(this);
                var obj = {}; 
                
                obj.id = selectedOption.val();
                obj.level = getLevelName( selected );
                
                // build up the path string            
                var path = [];
                $.each( selects, function() {
                    var level = getLevelName( $(this) );
                    var text = $(this).find( 'option:selected').text();
                    if( text.length ) {
                        path.push( text );
                    }
                    if( level == obj.level ){
                        return false;
                    }
                });
                obj.path = path;
                array.push( obj );
            });
            return array;
        };
          
        var collapseChildrenOf = function( select ) {
            var selects = $.makeArray( getNextSelects( select ) );
            $.each( selects, function( i, select ) {
                hideSelect( $( select ) );
                // null out last value so a subsequent click will load children
                element.last = null;
            });
        };
        
        var getElementName = function( tree ) {
            return treeName;
        };
          
        /**
        * Callback for when the add button is pressed
        * find the id of the selected option and the name of the level
        * the selected option belongs to
        *
        * Will iterate all the selects in the current tree to find the deepest level
        * that has a selection, aka it finds the selected option from the level closest
        * to the "leaf" level. aka rightermost select on the screen.
        *
        * @param jquery collection - the current tree
        * @param jquery selected - the node to add
        */
        var add = function( tree, selections ) {     

            $.each( selections, function( i ) {
                var selected = this;
                var selects = $.makeArray( tree.find( '.' + classes.selectContainer + ' select' ) ); // all the selects in the current tree 
                var value = '';
                var level = '';

                var parent = $( selects[0] ).parents( '.' + classes.multiTree );
                var selections = parent.find( '.' + classes.selections ); 
                var newSelections = parent.find( '.' + classes.newSelections ); 
                              
                var append = '';
                var hiddenVal = '';

                $.each(selects, function(number,select){
                    select = jQuery(select);
                    var level = select.metadata().level;
                    if( select.val()) {
                        hiddenVal += level + ':' + select.val()+ ';';
                    }
                });

                append += '<div class="' + classes.selection + '">';
                    append += '<input type="checkbox" name="vafcheck[]" class="vafcheck" value="' + hiddenVal + '" /> ';
                    append += '<div style="display:none" class="multiTree-value">' + hiddenVal + '</div>';
                    append += '<a href="#" class="' + classes.closeLink + '">[ x ]</a>';
                    append += selected.path.join( '<span class="' + classes.seperator + '">&raquo;</span>' );
                append += '</div>';
                
                newSelections.append( '<input type="hidden" name="' + getElementName( tree ) + '[]" class="selected" value="' + hiddenVal + '" />' );            
                selections.prepend( append );
            });
            reBindRemoveEvents();
        };
        
        /**
        * Select click event
        */
        $(element).find( 'select' ).click( function() {
            $(this).parents( '.' + classes.multiTree ).find( '.' + classes.multiTreeAdd ).removeAttr( 'disabled' );
            collapseChildrenOf( $( this ) );
            // if clicking on node already expanded
            if( element.last === $(this).val() )
            {   
                return;
            }
            element.last = $(this).val(); 
            return selectChange( $(this) );
        });
        
        /**
        * Add button event
        */
        $(element).find( '.' + classes.multiTreeAdd ).click( function() {
            $(this).attr( 'disabled', 'disabled' );
            var selects = $(element).find( 'select' );
            add(
                $(element),
                getSelected( $(element).find( 'select' ) ) 
            );
            jQuery('.multiTree').trigger('vafMultiTreeAdded');
        });
        
        /**
        * Quick add button event
        */
        $(element).find( '.' + classes.multiTreeQuickAdd ).click(function() {
            var data = $(this).metadata();
            var levelClicked = data.level;
            
            var select = $(element).find( '.' + levelClicked + 'Select' );
            var titleField = $(element).find( '.vafQuickAdd_' + levelClicked );
            var title = titleField.val();
            
            var selectClickedData = $(select).metadata();
            
            var parentLevels = selectClickedData.parents.split(',');

            var parentSelect = $(element).find( '.' + selectClickedData.parent + 'Select' );
            var parentId = parentSelect.find('option:selected').val();
            
            var url = quickAddUrl + '?';
            url = url + 'schema=' + schema;
            if( undefined != parentId )
            {
                url = url + '&id=' + parentId;
            }
            $.each(parentLevels, function(index, level) {
                var value = $(element).find('.' + level + 'Select' ).val();
                url = url + '&' + level + '=' + value;
            });
            url = url + '&entity=' + levelClicked;
            url = url + '&title=' + title;
            
            $.get(url, null, function(data) {
                select.append( '<option value="' + data + '">' + title + '</option>');
                titleField.val('');
                select.trigger('vafLevelQuickAdd');
            });
            
            
        });
        
        reBindRemoveEvents();

                  
    };    

    $.fn.multiTree = function() {
        this.each( function() {
            var multiTree = new MultiTree( this );
        });  
    };
    
    // apply the plugin to matching DOM elements
    $( document ).ready( function() {
        $( '.multiTree' ).multiTree();
    });
    
})(jQuery);