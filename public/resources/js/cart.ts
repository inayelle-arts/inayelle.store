class Product
{
	public brand_id: number;
	public color: string;
	public total_cost: number;
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
		this.dom = $( document.createElement( "a" ) );
		this.dom.attr( "href", `/product/see?id=${this.id}` );
		this.dom.attr( "target", "_blank" );
		this.dom.addClass( "cart-item" );
		this.dom.attr( "data-cart-item-id", "" + this.id );
		
		let html =
			`<div class=\"cart-item-img\">` +
			`<img src=\"/resources/img/product_repo/${this.primaryImage}\" alt=\"alt\">` +
			"</div>" +
			"<div class=\"cart-item-title\">" +
			`${this.name}` +
			"</div>" +
			"<div class=\"cart-item-cost\">" +
			`${this.total_cost / 100.0}$` +
			"</div>" +
			`<div onclick='remove(${this.id})' style="cursor: pointer;">X</div>`;
		
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
	private counterDOM: JQuery<HTMLElement>;
	private containerDOM: JQuery<HTMLElement>;
	
	private idCount: number;
	private ids: Array<number>;
	
	private openCartDOM: JQuery<HTMLElement>;
	private submitCartDOM: JQuery<HTMLElement>;
	
	private isCached: boolean = false;
	private isClosed: boolean = true;
	
	private static increment: number = 0;
	
	constructor()
	{
		this.dom = $( "#cart" );
		this.openCartDOM = $( "#open-cart-button" );
		this.counterDOM = $( "#cart-emptyness" );
		this.containerDOM = $( "#cart-item-holder" );
		
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
		
		if( this.idCount !== 0 )
			this.counterDOM.text( `${this.idCount} items` );
		
		this.openCartDOM.on( "click", () =>
		{
			this.isClosed = !this.isClosed;
			this.load();
		} );
	}
	
	public load()
	{
		if( this.ids.length !== 0 && !this.isCached )
		{
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
						
						console.log( response );
						let data: Array<[string]> = JSON.parse( response );
						let products: Array<Product> = new Array<Product>( 0 );
						
						data.forEach( ( value ) =>
						              {
							              products.push( new Product( value ) );
						              } );
						
						
						products.forEach( ( product: Product ) =>
						                  {
							                  console.log( product );
							                  product.createDOM();
							                  this.containerDOM.append( product.getDOM() );
						                  } );
						this.isCached = true;
					}
				}
			);
		}
	}
	
	public put( id: number )
	{
		this.isCached = false;
		if( this.ids.indexOf( id ) !== -1 )
			return;
		this.ids.push( id );
		let storageString = JSON.stringify( this.ids );
		localStorage.setItem( "CART-ID-ARRAY", storageString );
		this.load();
	}
	
	public remove( id: number )
	{
		$( `div[data-cart-item-id="${id}"]` ).remove();
		
		let filter = new Array<number>( 0 );
		let found: boolean = false;
		
		this.ids.forEach( ( value: number ) =>
		                  {
			                  if( !found && value !== id )
			                  {
				                  filter.push( value );
				                  found = true;
			                  }
			                  else if( found )
				                  filter.push( value );
		                  } );
		
		this.ids = filter;
		let storageString = JSON.stringify( this.ids );
		this.counterDOM.text( this.ids.length + " items" );
		localStorage.setItem( "CART-ID-ARRAY", storageString );
	}
}


let globalCart: Cart = null;

$( () =>
   {
	   globalCart = new Cart();
	   console.log( "CART CREATED" );
   } );

function remove( id: number )
{
	globalCart.remove( id );
}