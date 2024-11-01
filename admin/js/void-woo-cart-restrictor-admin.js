(function( $ ) {
	'use strict';

	jQuery(document).on('ready', function(){
		//set value to category page checkbox	
		jQuery('#VoidCodersProductCatVisibility').on('click', function(){
			if(jQuery(this).prop('checked')){
				jQuery(this).val('yes');
			}else{
				jQuery(this).val('no');
			}
		});

	});// on ready ends here

})( jQuery );
