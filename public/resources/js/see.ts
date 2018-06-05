namespace See
{
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
		
		let addButton = $("#add-to-card-button");
		   
		   addButton.on( "click", () =>
		   {
			   let id: number = +$( "#primary-image" ).attr( "data-id" );
			   globalCart.put( id );
			   
			   addButton.fadeOut("0.7s", () =>
			   {
			   	addButton.text("added");
			   	addButton.fadeIn("0.7s", () =>
			    {
			    	setTimeout(() =>
				               {
				               	addButton.fadeOut("0.7s", () =>
				                {
				                	addButton.text("add to cart");
				                	addButton.fadeIn("0.7s");
				                });
					               
				               }, 1500);
			    })
			   });
		   } );
	   } );
}