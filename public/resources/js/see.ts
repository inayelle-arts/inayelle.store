let previousImg = null;

$( () =>
   {
	   $( "[id^='img-']" ).each( ( index, value ) =>
	                                   {
		                                   let jImage = $( value );
		                                   jImage.on( "click", () =>
		                                   {
			                                   if( previousImg !== null )
				                                   previousImg.removeClass( "bordered-image" );
			
			                                   $( "#primary-image" ).attr( "src", jImage.attr( "src" ) );
			                                   jImage.addClass( "bordered-image" );
			
			                                   previousImg = jImage;
		                                   } );
		
		                                   if( index === 0 )
			                                   jImage.trigger( "click" );
	                                   } );
   } );