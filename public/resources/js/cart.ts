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

class Cart
{
	private dom: JQuery<HTMLElement>;
	
	private idCount: number;
	private ids: Array<number>;
	
	private openCartDOM: JQuery<HTMLElement>;
	private submitCartDOM: JQuery<HTMLElement>;
	
	//	private isCached: boolean = false;
	private isClosed: boolean = true;
	
	constructor()
	{
		this.dom = $( "#cart" );
		this.openCartDOM = $( "#open-cart-button" );
		
		let storageString = localStorage.getItem( "CART-ID-ARRAY" );
		if( storageString === null )
		{
			this.ids = new Array<number>( 0 );
			storageString = JSON.stringify( this.ids );
			localStorage.setItem( "CART-ID-ARRAY", storageString );
		}
		else
			this.ids = JSON.parse( storageString );
		
		
		this.idCount = this.ids.length;
		
		this.openCartDOM.on( "click", () =>
		{
			this.isClosed = !this.isClosed;
			
			let data = JSON.stringify( this.ids );
			console.log( data );
			
			$.ajax(
				{
					url: "/product/getEntitiesById",
					method: "POST",
					data: {data},
					success: ( response: string ) =>
					{
						if( response === "noitems" )
						{
							console.log( response );
							return;
						}
						
						console.log(response);
						let data: Array<[string]> = JSON.parse( response );
						let products: Array<Product> = new Array<Product>( 0 );
						
						data.forEach( ( value ) =>
						              {
							              products.push( new Product( value ) );
						              } );
						
						
						products.forEach( ( product: Product ) =>
						                  {
							                  console.log(product);
//							                  product.createDOM();
							                  //this.container.append( product.getDOM() );
						                  } );
					}
				}
			);
		} );
	}
	
	public put( id: number )
	{
		this.ids.push( id );
		let storageString = JSON.stringify( this.ids );
		localStorage.setItem( "CART-ID-ARRAY", storageString );
		console.log( storageString );
	}
	
	public remove( id: number )
	{
		delete this.ids[this.ids.indexOf( id )];
		let storageString = JSON.stringify( this.ids );
		localStorage.setItem( "CART-ID-ARRAY", storageString );
	}
}


let globalCart: Cart = null;

$( () =>
   {
	   globalCart = new Cart();
	   console.log( "CART CREATED" );
   } );