// @author Kevin van Zonneveld (http://kevin.vanzonneveld.net), Onno Marsman, Brett Zamir (http://brett-zamir.me)  
function ucfirst (str) {
    str += '';
    var f = str.charAt(0).toUpperCase();
    return f + str.substr(1);
}