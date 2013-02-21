/**
 * Handles toggling the main navigation menu for small screens.
 */
jQuery( document ).ready( function( $ ) {
	var $masthead = $( '#masthead' ),
	    timeout = false;

	$.fn.smallMenu = function() {
		$masthead.find( '.site-navigation' ).removeClass( 'main-navigation' ).addClass( 'main-small-navigation' );
		$masthead.find( '.site-navigation h1' ).removeClass( 'assistive-text' ).addClass( 'menu-toggle' );

		$( '.menu-toggle' ).unbind( 'click' ).click( function() {
			$masthead.find( '.menu' ).toggle();
			$( this ).toggleClass( 'toggled-on' );
		} );
	};

	// Check viewport width on first load.
	// if ( $( window ).width() < 600 ) 
		// $.fn.smallMenu();

	// Check viewport width when user resizes the browser window.
	$( window ).resize( function() {
		var browserWidth = $( window ).width();

		if ( false !== timeout )
			clearTimeout( timeout );

		timeout = setTimeout( function() {
			if ( browserWidth < 600 ) {
				// $.fn.smallMenu();
				var navHeight = $('#wordup-banner nav').height();
				$('#wordup-banner .sticky-wrapper').css("height", navHeight);
			} else {
				// $masthead.find( '.site-navigation' ).removeClass( 'main-small-navigation' ).addClass( 'main-navigation' );
				// $masthead.find( '.site-navigation h1' ).removeClass( 'menu-toggle' ).addClass( 'assistive-text' );
				// $masthead.find( '.menu' ).removeAttr( 'style' );
				var navHeight = $('#wordup-banner nav').height();
				$('#wordup-banner .sticky-wrapper').css("height", navHeight);
			}
		}, 200 );
	} );



  init_navigation();

$('#wordup-banner nav').waypoint('sticky');

	
function init_navigation(){
	
	var browserHeight = $(window).height();
	var numberOfPages = $('.section').size() - 1;		
	
	for(var i=0; i<=numberOfPages; i++){
		$('#wordup-banner ul').append('<a href="#"></a>');
	}		
	$('#wordup-banner ul a:first').addClass('active');
	$('#wordup-banner ul a:last').addClass('last');
	
	$('#wordup-banner ul a').each(function(index) {
		var navTitleCount = $(this).index();
		var navTitleGet = $('.section:eq(' + $(this).index() + ')').attr('rel');
		var navIDGet = $('.section:eq(' + $(this).index() + ')').attr('id');
		$(this).text(navTitleGet);
		$(this).attr('href','#'+navIDGet);
	});
	
	$('#wordup-banner ul a').live("click", function(){
		$(window).scrollTo( $('.section:eq(' + $(this).index() + ')') , 500, {offset: { top: -115 }} );
		return false
	});


	$('.section').waypoint(function(direction) {

		if (direction === 'up') {

		var activePageIndex = $(this).index();
							
		$('#wordup-banner ul a.active').removeClass('active');
		$('#wordup-banner ul a:eq('+activePageIndex+')').addClass('active');
    		}

} , { offset: 110 });

	$('.section').waypoint(function(direction) {

		if (direction === 'down') {

		var activePageIndex = $(this).index();
							
		$('#wordup-banner ul .active').removeClass('active');
		$('#wordup-banner ul a:eq('+activePageIndex+')').addClass('active');
    		}

} , { offset: 120 });



}
} );