// SLIDINGMENU.JS
//--------------------------------------------------------------------------------------------------------------------------------
//JS for operating the sliding menu*/
// -------------------------------------------------------------------------------------------------------------------------------
// Author: Designova.
// Website: http://www.designova.net 
// Copyright: (C) 2013 
// -------------------------------------------------------------------------------------------------------------------------------

/*global $:false */
/*global window: false */

(function(){
  "use strict";

$(function ($) {

    var status = false;

    function abre() {
        status = true;
        $('#sm-trigger').toggleClass('active');
        $('#mastwrap').toggleClass('sliding-toright');
        $('#sm').toggleClass('menu-open');
        $('#mastwrap').addClass('nav-opened');
    }

    function fecha() {
        status = false;
        $('#mastwrap').removeClass('sliding-toright');
        $('#sm').removeClass('menu-open');
    }

// Menu Action
$('#sm-trigger, #intro').on('click', function(){
    if(status === false)
        abre();
    else
        fecha();
});

});
// $(function ($)  : ends

})();
//  JSHint wrapper $(function ($)  : ends

