namespace Default
{
	abstract class PageComponentBase
	{
		protected dom: JQuery<HTMLElement>;
		protected window: JQuery<HTMLElement>;
		
		protected constructor( dom: JQuery<HTMLElement> )
		{
			this.dom = dom;
			this.window = $( window );
		}
		
		public getDOM(): JQuery<HTMLElement>
		{
			return this.dom;
		}
		
		protected abstract setEventHandlers();
		
		public addClass( className: string )
		{
			this.dom.addClass( className );
		}
		
		public removeClass( className: string )
		{
			this.dom.removeClass( className );
		}
	}
	
	class Header extends PageComponentBase
	{
		private mobileMenu: MobileMenu;
		private cart: Cart;
		
		constructor()
		{
			super( $( "#header" ) );
			
			this.mobileMenu = new MobileMenu();
			this.cart = new Cart();
			
			this.setEventHandlers();
		}
		
		protected setEventHandlers()
		{
			this.window.on( "scroll", () =>
			{
				let scrolled = this.window.scrollTop();
				let headerHeight = this.dom.height();
				
				if( scrolled > 0 )
					this.dom.addClass( "bottom-bordered" );
				else if( scrolled < headerHeight )
					this.dom.removeClass( "bottom-bordered" );
			} );
		}
	}
	
	class MobileMenu extends PageComponentBase
	{
		private scrolled: number;
		private button: JQuery<HTMLElement>;
		private isOpened: boolean;
		
		private content: JQuery<HTMLElement>;
		
		constructor()
		{
			super( $( "#mobile-menu" ) );
			this.button = $( "#mobile-menu-button" );
			this.content = $( "#content-footer" );
			this.isOpened = false;
			this.setEventHandlers();
		}
		
		public hide()
		{
			this.dom.fadeOut( "0.5s", () =>
			{
				this.content.fadeIn( "0.5s" );
				this.window.scrollTop( this.scrolled );
			} );
			this.isOpened = false;
		}
		
		public show()
		{
			this.scrolled = this.window.scrollTop();
			this.content.fadeOut( "1s", () =>
			{
				this.dom.fadeIn( "1s" );
			} );
			this.isOpened = true;
		}
		
		protected setEventHandlers()
		{
			this.button.on( "click", () =>
			{
				this.button.css( "::focus", "false" );
				if( this.isOpened )
					this.hide();
				else
					this.show();
			} );
			
			MediaQuery.addOnMD( () =>
			                    {
				                    this.hide();
			                    } );
			
			MediaQuery.addOnLG( () =>
			                    {
				                    this.hide();
			                    } );
			
			MediaQuery.addOnXL( () =>
			                    {
				                    this.hide();
			                    } );
		}
	}
	
	class Cart extends PageComponentBase
	{
		private isOpened: boolean;
		private isEmpty: boolean;
		private cartButton: JQuery<HTMLElement>;
		private cartButtonImage: JQuery<HTMLElement>;
		private emptynessMessage: JQuery<HTMLElement>;
		private width: number;
		
		
		private static CART_BUTTON_OPENED = "fa-times";
		private static CART_BUTTON_CLOSED = "fa-shopping-cart";
		
		constructor()
		{
			super( $( "#cart" ) );
			this.cartButton = $( "#open-cart-button" );
			this.cartButtonImage = $( "#cart-button-image" );
			this.emptynessMessage = $( "#cart-emptyness" );
			this.isOpened = false;
			this.isEmpty = true;
			
			if( this.isEmpty )
				this.showEmptynessMessage();
			
			this.setEventHandlers();
		}
		
		private showEmptynessMessage()
		{
			this.emptynessMessage.show();
		}
		
		private hideEmptynessMessage()
		{
			this.emptynessMessage.hide();
		}
		
		protected setEventHandlers()
		{
			this.cartButton.on( "click", () =>
			{
				this.isOpened = !this.isOpened;
				
				this.width = this.dom.width();
				
				this.dom.on( "transitionend webkitTransitionEnd oTransitionEnd", () =>
				{
					if( !this.isOpened )
					{
						this.dom.css( "display", "none" );
						this.dom.removeClass( "left-bordered" );
						this.dom.removeClass( "top-bordered" );
					}
				} );
				
				if( this.isOpened )
				{
					this.cartButtonImage.removeClass( Cart.CART_BUTTON_CLOSED );
					this.cartButtonImage.addClass( Cart.CART_BUTTON_OPENED );
					
					this.dom.css( "display", "block" );
					this.dom.addClass( "left-bordered" );
					this.dom.addClass( "top-bordered" );
					this.dom.css( "right", 0 );
				}
				else
				{
					this.cartButtonImage.removeClass( Cart.CART_BUTTON_OPENED );
					this.cartButtonImage.addClass( Cart.CART_BUTTON_CLOSED );
					
					this.dom.css( "right", -2 * this.width );
				}
			} );
		}
	}
	
	class Core extends PageComponentBase
	{
		private header: Header;
		
		private readonly debug: boolean;
		private info: JQuery<HTMLElement>;
		
		constructor( debug: boolean = false )
		{
			super( null );
			this.header = new Header();
			this.debug = debug;
			
			this.info = $( "#debug" );
			if( this.debug )
				this.info.show();
			else
				this.info.hide();
			
			let width = $( window ).width();
			this.info.text( `XS | Width: ${width}px` );
			
			this.setEventHandlers();
		}
		
		protected setEventHandlers()
		{
			let jWindow = $( window );
			
			if( this.debug )
			{
				MediaQuery.addOnXS( () =>
				                    {
					                    let width = jWindow.width();
					                    this.info.text( `XS | Width: ${width}px` );
				                    } );
				MediaQuery.addOnSM( () =>
				                    {
					                    let width = jWindow.width();
					                    this.info.text( `SM | Width: ${width}px` );
				                    } );
				MediaQuery.addOnMD( () =>
				                    {
					                    let width = jWindow.width();
					                    this.info.text( `MD | Width: ${width}px` );
				                    } );
				MediaQuery.addOnLG( () =>
				                    {
					                    let width = jWindow.width();
					                    this.info.text( `LG | Width: ${width}px` );
				                    } );
				MediaQuery.addOnXL( () =>
				                    {
					                    let width = jWindow.width();
					                    this.info.text( `XL | Width: ${width}px` );
				                    } );
			}
		}
	}
	
	type MediaQueryHandler = () => void;
	
	class MediaQuery
	{
		private static XS: number = 0;
		private static SM: number = 576;
		private static MD: number = 768;
		private static LG: number = 992;
		private static XL: number = 1200;
		
		private static _onXS: Array<MediaQueryHandler> = new Array<MediaQueryHandler>( 0 );
		private static _onSM: Array<MediaQueryHandler> = new Array<MediaQueryHandler>( 0 );
		private static _onMD: Array<MediaQueryHandler> = new Array<MediaQueryHandler>( 0 );
		private static _onLG: Array<MediaQueryHandler> = new Array<MediaQueryHandler>( 0 );
		private static _onXL: Array<MediaQueryHandler> = new Array<MediaQueryHandler>( 0 );
		
		public static init()
		{
			let jWindow = $( window );
			
			jWindow.on( "resize", () =>
			{
				let windowWidth = jWindow.width();
				
				if( windowWidth >= MediaQuery.XS && windowWidth < MediaQuery.SM )
				{
					MediaQuery._onXS.forEach( ( handler: MediaQueryHandler ) =>
					                          {
						                          handler();
					                          } );
					return;
				}
				
				if( windowWidth >= MediaQuery.SM && windowWidth < MediaQuery.MD )
				{
					MediaQuery._onSM.forEach( ( handler: MediaQueryHandler ) =>
					                          {
						                          handler();
					                          } );
					return;
				}
				
				if( windowWidth >= MediaQuery.MD && windowWidth < MediaQuery.LG )
				{
					MediaQuery._onMD.forEach( ( handler: MediaQueryHandler ) =>
					                          {
						                          handler();
					                          } );
					return;
				}
				
				if( windowWidth >= MediaQuery.LG && windowWidth < MediaQuery.XL )
				{
					MediaQuery._onLG.forEach( ( handler: MediaQueryHandler ) =>
					                          {
						                          handler();
					                          } );
					return;
				}
				
				if( windowWidth >= MediaQuery.XL )
				{
					MediaQuery._onXL.forEach( ( handler: MediaQueryHandler ) =>
					                          {
						                          handler();
					                          } );
					return;
				}
			} );
		}
		
		public static addOnXS( handler: MediaQueryHandler )
		{
			MediaQuery._onXS.push( handler );
		}
		
		public static addOnSM( handler: MediaQueryHandler )
		{
			MediaQuery._onSM.push( handler );
		}
		
		public static addOnMD( handler: MediaQueryHandler )
		{
			MediaQuery._onMD.push( handler );
		}
		
		public static addOnLG( handler: MediaQueryHandler )
		{
			MediaQuery._onLG.push( handler );
		}
		
		public static addOnXL( handler: MediaQueryHandler )
		{
			MediaQuery._onXL.push( handler );
		}
	}
	
	let core: Core = null;
	const DEBUG: boolean = false;
	
	$( () =>
	   {
		   MediaQuery.init();
		   core = new Core( DEBUG );
	   } );
}

interface String
{
	hashCode(): number;
}

String.prototype.hashCode = function (): number
{
	let result, char, length: number;
	result = char = 0;
	length = this.length;
	
	if( length === 0 )
		return result;
	
	for( let i = 0; i < length; i++ )
	{
		char = this.charCodeAt( i );
		result = result * 31 + char;
		result |= 0;
	}
	
	return result;
};
