jQuery( document ).ready( function( $ ) {

	$( '.posts-slider-list-item' ).hover( function() {

		var item = $( this ).data( 'posts-slider' );

		$( '.posts-slider-main' ).removeClass( 'is-active' );
		$( '.posts-slider-main-' + item ).addClass( 'is-active' );

		$( '.posts-slider-list-item' ).removeClass( 'is-active' );
		$( '.posts-slider-list-item-' + item ).addClass( 'is-active' );

	});

});