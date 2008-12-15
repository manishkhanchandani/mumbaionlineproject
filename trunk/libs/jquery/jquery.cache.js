/**
 * a jquery cache function
 * 
 * works by creating a bunch of hidden text areas for later retrieval
 * assumes, at this point, that value is a string which is properly encoded
 * 
 * many solutions are bogged down by having to encode and decode cache values in larger
 * from single large arrays stored in textareas, etc.
 * 
 * Tested only on Windows IE7 and FireFox 1.5.x
 * 
 * @todo do some checks of key and value
 * @todo alternative use cookies/iframes for better XP persistance
 * 
 * @author Jonathan Hendler (jonathan dot hendler at gmail dot com)
 * @license AGPL http://www.affero.org/oagpl.html
 * @version 0.1.2
 * 
 *  cacheCheck:
 *  cachePut:
 *  cacheGet:
 *  cacheRemove:
 *  
 */

jQuery.extend({ 
    cacheCheck: function (key){
        return jQuery('#'+key).size() > 0;
    },
    cachePut: function (key,value){
        if (!jQuery.cacheCheck(key)){
            jQuery('body').append('<textarea id="'+key+'" style="position: absolute; top: 0px; left: 0px; display: none; inline: none;"></textarea>');
        }
        //do some checks of key and value
        jQuery('#'+key).val(value);
    },
    cacheGet: function (key){
        if (jQuery.cacheCheck(key)){
            return jQuery('#'+key).val();
        }
        else {
            return null;
        }
    },
    cacheRemove: function (key){
        if (jQuery.cacheCheck(key)){
            jQuery('#'+key).remove();
            return true;
        }
        else {
            return false;
        }
    }
});