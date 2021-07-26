/* Auxiliary function */
function debug( msg ) {
  if (msg) 
    window.console && console.log(msg);
}

/**
 * detect IEEdge
 * returns version of IE/Edge or false, if browser is not a Microsoft browser
 *
 * Source:
 * https://stackoverflow.com/questions/19999388/check-if-user-is-using-ie
 */
function detectIEEdge() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
       // Edge => return version number
       return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    // other browser
    return false;
}

/**
 * detect the code of the key pressed
 * @param e - the event object
 * @return {string} the key code as a string: "LEFT"|"UP"|"RIGHT"|"DOWN"
 * @return (nothing), if the key is not an arrow
 *
 * source for doc tags:
 * https://jsdoc.app/tags-param.html#names-types-and-descriptions
 *
 * Author: Yoel Monsalve
 * Date:   May-June, 2020.
 */
function _keyCode(e) {

  var arrowCode = { left: 37, up: 38, right: 39, down: 40 };

  /* IE */
  if (detectIEEdge()) {
    e = e || window.event; 
    code = e.which || e.keyCode;
  }
  else {
    /* is for modern browsers, which is deprecated */
    code = e.which || e.key;
  }

  //console.log( "e.which: " + e.which + ", e.code: ", e.code );
  switch (code) {
    case "ArrowLeft":    // method .key
    case arrowCode.left: // method .which
    debug( "LEFT pressed" );
    return "LEFT";
    break;

    case "ArrowUp":
    case arrowCode.up:
    debug( "UP pressed" );
    return "UP";
    break;

    case "ArrowRight":
    case arrowCode.right:
    debug( "RIGHT pressed" );
    return "RIGHT";
    break;

    case "ArrowDown":
    case arrowCode.down:
    debug( "DOWN pressed" );
    return "DOWN"
    break;

    default: return; // exit this handler for other keys
  }
};

$(document).ready(function() {

  /* I don't know what this is (?) */
  //tooltip
  $('[data-toggle="tooltip"]').tooltip();

  /* === debugging === */
  //console.log('IEEdge ' + detectIEEdge());
  //console.log( "document loaded" )

  $('.submenu-toggle').click(function () {
    $(this).parent().children('ul.submenu').toggle(200);
  });
  /*$('.submenu-toggle').mouseenter(function () {
    //console.log( "mouseenter ")
    //$(this).parent().children('ul.submenu').toggle(200);
  });
  $('.submenu-toggle ').mouseleave(function () {
    //console.log( "mouseleave")
    //$(this).parent().children('ul.submenu').toggle(200);
  });*/
})