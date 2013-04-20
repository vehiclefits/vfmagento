function click( level, value ) {
    jQuery( '#vafForm .' + level + "Select").val( value ); 
    jQuery( '#vafForm .' + level + "Select").change();    
};

function chooserClick( level, value ) {
    jQuery( '#vafChooserForm .' + level + "Select").val( value ); 
    jQuery( '#vafChooserForm .' + level + "Select").change();    
};

function multiTreeClick( level, value ) {
    jQuery( '.multiTree .' + level + "Select").val( value ); 
    jQuery( '.multiTree .' + level + "Select").click();    
};

function selectionTextEquals( select, expectedText ) {
    var actual = select.find(":selected").text();
    equals( actual, expectedText );
}

function firstOptionTextEquals( select, expectedText ) {
    var actual = select.find("option:first").text();
    equals( actual, expectedText );
}
