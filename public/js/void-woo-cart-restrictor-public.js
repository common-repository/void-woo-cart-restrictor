(function( $ ) {
	'use strict';

	jQuery(document).on('ready', function(){	
		//set cookie to be used for redirecting user to the product page
		var flag = false;
	    jQuery('.voidcoders-woo-account-link').on('click', function(e) {
	         var cookievalue,
	             cookieexpire,
	             cookiepath,
	             date;

	         cookievalue = document.location;
	         date = new Date();
	         date.setTime(date.getTime() + 360000 ); // will last 
	         cookieexpire = date.toGMTString();

	         cookiepath = "/"; // accessible from every web page of the domain

	         document.cookie = "voidcodersWooReferrer=" + cookievalue + "; expires=" + cookieexpire + "; path=" + cookiepath;

	     }); //.voidcoders-woo-account-link click ends here
	});// on ready ends here

})( jQuery );
