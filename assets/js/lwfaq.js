jQuery(document).ready( function($) {
    /**
     * Throw errors, for "unsafe" actions, and bad code
     */
    "use strict";
	/**
	 * FAQs 
	 */
	$( ".lightweight-faq" ).find( ".lightweight-faq-toggle" ).on( "click", function(e) {
		e.preventDefault();

		$( this ).next().slideToggle( 200, callback );				
		$( ".lightweight-faq-content" ).not( $( this ).next() ).slideUp( 200, callback );
		
		function callback() 
		{
			var iconClass = $( this ).is( ":visible" ) ? "fa-minus" : "fa-plus";
			$( this ).prev().find( "i" ).removeClass( "fa-plus fa-minus" ).addClass(iconClass);
		}
    });
});
