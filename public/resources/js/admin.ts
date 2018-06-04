namespace Admin
{
	class Admin
	{
		private tableSelectDOM: JQuery<HTMLSelectElement>;
		
		private tableDOM: JQuery<HTMLTableElement>;
		private tableHeadDOM: JQuery<HTMLElement>;
		private tableBodyDOM: JQuery<HTMLElement>;
		
		private rowList: Array<Row>;
		
		private saveChangesButtonDOM: JQuery<HTMLElement>;
		
		constructor()
		{
			this.tableSelectDOM = <JQuery<HTMLSelectElement>>$( "#table-select" );
			
			this.tableDOM = <JQuery<HTMLTableElement>>$( "#table" );
			this.tableHeadDOM = $( "#table-head" );
			this.tableBodyDOM = $( "#table-body" );
			
			this.saveChangesButtonDOM = $( "#save-changes-button" );
			
			this.rowList = new Array<Row>( 0 );
			
			this.setEventHandlers();
		}
		
		//todo: save changes
		protected setEventHandlers()
		{
			this.tableSelectDOM.on( "change", () =>
			{
				this.loadTable();
			} );
			
			
			this.saveChangesButtonDOM.on( "click", () =>
			{
				this.rowList.forEach( ( value: Row ) =>
				                      {
					                      //					                      if( value. )
				                      } );
			} );
		}
		
		public loadTable()
		{
			this.tableHeadDOM.html( "" );
			this.tableBodyDOM.html( "" );
			
			let selected = this.tableSelectDOM.val();
			
			let data = `{"table": "${selected}"}`;
			
			$.ajax(
				{
					url: "admin/table",
					method: "GET",
					data: {data},
					success: ( response: string ) =>
					{
						this.parseJSON( response );
					},
					error: () =>
					{
						console.log( "Server does not respond" );
					},
					timeout: 5000
				}
			);
		}
		
		protected parseJSON( json: string )
		{
			let decoded: Array<[string]> = JSON.parse( json );
			this.parseFieldList( decoded["fieldList"] );
			this.parseEntities( decoded["entities"] );
		}
		
		protected parseFieldList( fields: Array<string> )
		{
			fields.forEach( ( value: string ) =>
			                {
				                let columnNameDOM = $( document.createElement( "th" ) );
				
				                columnNameDOM.attr( "scope", "col" );
				                columnNameDOM.text( value );
				                this.tableHeadDOM.append( columnNameDOM );
			                } );
		}
		
		protected parseEntities( entities: Array<Array<[string]>> )
		{
			entities.forEach( ( entity: Array<[string]> ) =>
			                  {
				                  let id = entity["id"];
				                  delete entity["id"];
				
				                  let row = new Row( id );
				
				                  row.addPrimaryField( id );
				
				                  for( let fieldKey in entity )
					                  row.addField( entity[`${fieldKey}`] );
				
				                  this.tableBodyDOM.append( row.getDOM() );
			                  } );
		}
	}
	
	class Row
	{
		protected dom: JQuery<HTMLElement>;
		protected active: boolean;
		protected id: number;
		
		protected needsUpdate: boolean = false;
		protected needsCreate: boolean = false;
		protected needsRemove: boolean = false;
		
		private static ON_HOVER_STYLE: string = "bg-primary";
		private static ON_HOVER_TEXT_STYLE: string = "text-light";
		
		protected fieldList: Array<Field>;
		
		constructor( id: number, isNew: boolean = false )
		{
			this.needsCreate = isNew;
			
			this.dom = $( document.createElement( "tr" ) );
			this.id = id;
			this.active = false;
			this.fieldList = new Array<Field>( 0 );
			
			this.setEventHandlers();
		}
		
		protected setEventHandlers()
		{
			this.dom.on( "mouseenter", () =>
			{
				this.dom.addClass( Row.ON_HOVER_STYLE );
				this.dom.addClass( Row.ON_HOVER_TEXT_STYLE );
			} );
			
			this.dom.on( "mouseleave", () =>
			{
				this.dom.removeClass( Row.ON_HOVER_STYLE );
				this.dom.removeClass( Row.ON_HOVER_TEXT_STYLE );
			} );
			
			this.dom.on( "click", () =>
			{
				if( !this.needsCreate )
					this.needsUpdate = true;
			} );
		}
		
		public get pendingUpdate(): boolean
		{
			return this.needsUpdate;
		}
		
		public get pendingCreate(): boolean
		{
			return this.needsCreate;
		}
		
		public addPrimaryField( value: number )
		{
			let field = new Field( value, true );
			this.fieldList.push( field );
			this.dom.append( field.getDOM() );
		}
		
		public addField( value: any )
		{
			let field = new Field( value );
			this.fieldList.push( field );
			this.dom.append( field.getDOM() );
		}
		
		public getDOM(): JQuery<HTMLElement>
		{
			return this.dom;
		}
	}
	
	class Field
	{
		protected dom: JQuery<HTMLElement>;
		protected valueDOM: JQuery<HTMLElement>;
		protected inputDOM: JQuery<HTMLElement>;
		
		protected isPrimary: boolean;
		
		constructor( value: any, primary: boolean = false )
		{
			this.isPrimary = primary;
			
			let tagName: string = primary ? "th" : "td";
			
			this.dom = $( document.createElement( tagName ) );
			this.valueDOM = $( document.createElement( "div" ) );
			
			if( primary )
				this.dom.attr( "scope", "row" );
			
			this.valueDOM.text( value );
			
			if( !primary )
				this.dom.css( "cursor", "pointer" );
			
			this.inputDOM = $( document.createElement( "input" ) );
			
			this.inputDOM.css(
				{
					height: "100%"
				}
			);
			
			this.inputDOM.addClass( "hidden" );
			
			this.dom.append( this.valueDOM );
			this.dom.append( this.inputDOM );
			
			if( !primary )
				this.setEventHandlers();
		}
		
		protected setEventHandlers()
		{
			this.dom.on( "click", () =>
			{
				this.inputDOM.width( this.valueDOM.width() );
				this.inputDOM.val( this.valueDOM.text() );
				this.valueDOM.addClass( "hidden" );
				this.inputDOM.removeClass( "hidden" );
				this.inputDOM.trigger( "focus" );
				this.inputDOM.trigger( "select" );
			} );
			
			this.inputDOM.on( "mouseleave", () =>
			{
				this.dom.addClass( "bg-danger" );
				this.dom.addClass( "text-light" );
				this.valueDOM.text( <string>this.inputDOM.val() );
				this.inputDOM.addClass( "hidden" );
				this.valueDOM.removeClass( "hidden" );
			} );
			
			this.inputDOM.on( "keypress", ( keycode ) =>
			{
				if( keycode.keyCode === 13 )
				{
					this.dom.addClass( "bg-danger" );
					this.dom.addClass( "text-light" );
					this.valueDOM.text( <string>this.inputDOM.val() );
					this.inputDOM.addClass( "hidden" );
					this.valueDOM.removeClass( "hidden" );
				}
			} );
		}
		
		public getDOM(): JQuery<HTMLElement>
		{
			return this.dom;
		}
	}
	
	
	let admin: Admin = null;
	
	$( () =>
	   {
		   admin = new Admin();
		   admin.loadTable();
		
	   } );
}