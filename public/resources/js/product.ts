namespace Producta
{
	class Product
	{
		public brand_id: number;
		public color: string;
		public cost: number;
		public description: string;
		public discount: number;
		public id: number;
		public in_stock: number;
		public name: string;
		public size_id: number;
		public type_id: number;
		public primaryImage: string;
		
		private dom: JQuery<HTMLElement>;
		
		constructor( json )
		{
			for( let field in json )
				this[`${field}`] = json[`${field}`];
		}
		
		public createDOM(): void
		{
			this.dom = $( document.createElement( "div" ) );
			this.dom.addClass( "col-12 col-md-6 col-lg-4" );
			
			let html =
				"<div class=\"product\">" +
				"" +
				`<img class=\"image\" src=\"/resources/img/product_repo${this.primaryImage}\">` +
				"" +
				"<div class=\"row\">" +
				"<div class=\"col-12 col-lg-6\">" +
				"<div class=\"name\">" +
				`${this.name}` +
				"</div>" +
				"</div>" +
				"" +
				"<div class=\"col-12 col-lg-6\">" +
				"<div class=\"cost\">" +
				`${this.cost / 100}$` +
				"</div>" +
				"</div>" +
				"</div>" +
				"" +
				"<div class=\"row align-items-center\">" +
				"<div class=\"col-12 col-lg-7\">" +
				"<div class=\"description\">" +
				`${this.description}` +
				"</div>" +
				"</div>" +
				"" +
				"<div class=\"col-12 col-lg-5\">" +
				`<a class=\"checkout\" href=\"/product/see?id=${this.id}\">` +
				"checkout" +
				"</a>" +
				"</div>" +
				"</div>" +
				"" +
				"</div>";
			
			this.dom.html( html );
		}
		
		public getDOM(): JQuery<HTMLElement>
		{
			return this.dom;
		}
	}
	
	class Filter
	{
		private container: JQuery<HTMLElement>;
		
		private productCount: number = 0;
		
		private updateButton: JQuery<HTMLElement>;
		
		private applyFiltersButton: JQuery<HTMLElement>;
		
		private isEmptyCategories: boolean = true;
		
		private categoriesList: Array<number>;
		
		private lowerPriceButton: JQuery<HTMLElement>;
		private upperPriceButton: JQuery<HTMLElement>;
		
		private lowerPrice: number | null;
		private upperPrice: number | null;
		
		constructor()
		{
			let urlParams = new URLSearchParams( window.location.search );
			
			let catId = urlParams.get( 'cat' );
			
			this.categoriesList = new Array<number>( 0 );
			
			let categoryPreparedId: number;
			
			if( catId !== null )
			{
				categoryPreparedId = +catId;
				if( categoryPreparedId !== Number.NaN )
				{
					this.categoriesList.push( categoryPreparedId );
					this.isEmptyCategories = false;
				}
			}
			
			
			this.container = $( "#products" );
			this.updateButton = $( "#update-button" );
			
			this.lowerPriceButton = $( "#lower-price" );
			this.upperPriceButton = $( "#upper-price" );
			
			this.applyFiltersButton = $( "#apply-filters" );
			
			
			this.lowerPriceButton.on( "change paste keyup", () =>
			{
				if( this.lowerPriceButton.val() === "" )
					this.lowerPrice = null;
				else
					this.lowerPrice = <number>this.lowerPriceButton.val();
			} );
			
			this.upperPriceButton.on( "change paste keyup", () =>
			{
				if( this.upperPriceButton.val() === "" )
					this.upperPrice = null;
				else
					this.upperPrice = <number>this.upperPriceButton.val();
			} );
			
			this.applyFiltersButton.on( "click", () =>
			{
				this.refresh();
			} );
			
			
			this.updateButton.on( "click", () =>
			{
				this.append();
			} );
			
			$( "#categories" ).find( "input" ).each( ( index, element ) =>
			                                         {
				                                         let jElem = $( element );
				                                         if( categoryPreparedId === index + 1 )
					                                         jElem.prop( "checked", true );
				
				                                         jElem.on( "click", () =>
				                                         {
					                                         if( jElem.is( ":checked" ) )
					                                         {
						                                         this.categoriesList.push( index + 1 );
						                                         this.isEmptyCategories = false;
					                                         }
					                                         else
					                                         {
						                                         delete this.categoriesList[this.categoriesList.indexOf( index + 1 )];
						                                         if( this.categoriesList.length == 0 )
							                                         this.isEmptyCategories = true;
					                                         }
				                                         } );
			                                         } );
		}
		
		public showNoMoreItems()
		{
			this.updateButton.text( "no more items" );
		}
		
		public hideNoMoreItems()
		{
			this.updateButton.text( "load more" );
		}
		
		public append()
		{
			let categoriesFlag = "";
			if( this.isEmptyCategories )
				categoriesFlag = `"all"`;
			else
				categoriesFlag = JSON.stringify( this.categoriesList );
			
			let lowerPrice = ( this.lowerPrice == null ? "null" : this.lowerPrice * 100 );
			let upperPrice = ( this.upperPrice == null ? "null" : this.upperPrice * 100 );
			
			let filters = "{" +
				`"count": 3,` +
				`"offset": ${this.productCount},` +
				`"categories" :` +
				categoriesFlag +
				`,"lowerCost": ${lowerPrice},` +
				`"upperCost": ${upperPrice}` +
				"}";
			
			
			$.ajax(
				{
					url: "/product/filter",
					method: "POST",
					data: {filters},
					success: ( response ) =>
					{
						if( response === "noitems" )
						{
							this.showNoMoreItems();
							return;
						}
						let data: Array<[string]> = JSON.parse( response );
						
						let products: Array<Product> = new Array<Product>( 0 );
						
						data.forEach( ( value ) =>
						              {
							              products.push( new Product( value ) );
						              } );
						
						
						products.forEach( ( product: Product ) =>
						                  {
							                  product.createDOM();
							                  this.container.append( product.getDOM() );
						                  } );
						
						this.productCount += 3;
					}
				}
			);
		}
		
		public refresh()
		{
			this.productCount = 0;
			this.hideNoMoreItems();
			this.container.find( ".product" ).each( ( index, element ) =>
			                                        {
				                                        $( element ).parent().remove();
			                                        } );
			this.append();
		}
	}
	
	let filter: Filter = null;
	
	$( () =>
	   {
		   filter = new Filter();
		   filter.append();
	   } );
}