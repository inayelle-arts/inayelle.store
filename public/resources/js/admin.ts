namespace Admin
{
	class Admin
	{
		private tableSelectDOM: JQuery<HTMLSelectElement>;
		
		private tableDOM: JQuery<HTMLTableElement>;
		private tableHeadDOM: JQuery<HTMLElement>;
		private tableBodyDOM: JQuery<HTMLElement>;
		
		private fieldList: Array<string>;
		
		private rowList: Array<Row>;
		
		private saveChangesButtonDOM: JQuery<HTMLElement>;
		
		private addRowButtonDOM: JQuery<HTMLElement>;
		
		constructor()
		{
			this.tableSelectDOM = <JQuery<HTMLSelectElement>>$( "#table-select" );
			
			this.tableDOM = <JQuery<HTMLTableElement>>$( "#table" );
			this.tableHeadDOM = $( "#table-head" );
			this.tableBodyDOM = $( "#table-body" );
			
			this.saveChangesButtonDOM = $( "#save-changes-button" );
			this.addRowButtonDOM = $( "#add-row-button" );
			
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
				let success: boolean = true;
				let updated: boolean = false;
				
				this.rowList.forEach( ( value: Row ) =>
				                      {
					                      let url = "/admin/";
					
					                      if( value.pendingDelete === true )
						                      url += "delete";
					                      else if( value.pendingCreate === true )
						                      url += "create";
					                      else if( value.pendingUpdate === true )
						                      url += "update";
					                      else
						                      return;
					
					                      updated = true;
					
					                      let data = value.toJSON();
					
					                      $.ajax(
						                      {
							                      url: url,
							                      method: "POST",
							                      data: {data},
							                      success: ( response: string ) =>
							                      {
								                      if( response !== "success" )
								                      {
									                      alert( response );
									                      success = false;
								                      }
							                      }
						                      }
					                      );
				                      } );
				
				if( updated && success )
					this.loadTable();
			} );
			
			
			this.addRowButtonDOM.on( "click", () =>
			{
				let row = new Row( -1, <string>this.tableSelectDOM.val(), true );
				this.rowList.push( row );
				
				row.addPrimaryField( "generated", "id" );
				
				for( let i = 1; i < this.fieldList.length; i++ )
					row.addField( null, this.fieldList[i] );
				
				this.tableBodyDOM.append( row.getDOM() );
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
			this.fieldList = fields;
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
				
				                  let row = new Row( id, <string>this.tableSelectDOM.val() );
				
				                  row.addPrimaryField( id, "id" );
				
				                  for( let fieldKey in entity )
					                  row.addField( entity[`${fieldKey}`], fieldKey );
				
				                  this.rowList.push( row );
				
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
		
		protected deleteButtonDOM: JQuery<HTMLElement>;
		
		private static ON_HOVER_STYLE: string = "bg-primary";
		private static ON_HOVER_TEXT_STYLE: string = "text-light";
		
		protected readonly entityName: string;
		
		protected fieldList: Array<Field>;
		
		constructor( id: number, entityName: string, isNew: boolean = false )
		{
			this.needsCreate = isNew;
			this.entityName = entityName;
			
			this.dom = $( document.createElement( "tr" ) );
			this.id = id;
			this.active = false;
			this.fieldList = new Array<Field>( 0 );
			
			this.deleteButtonDOM = $( document.createElement( "div" ) );
			
			this.deleteButtonDOM.addClass( "hidden btn btn-danger" );
			
			this.deleteButtonDOM.text( "delete" );
			
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
				if( !( this.needsCreate || this.needsRemove ) )
					this.needsUpdate = true;
			} );
			
			this.deleteButtonDOM.on( "click", () =>
			{
				this.needsRemove = !this.needsRemove;
				
				if( this.needsCreate )
				{
					this.needsUpdate = false;
					this.needsCreate = false;
					this.needsRemove = false;
					this.dom.remove();
					return;
				}
				
				if( this.needsUpdate )
					this.needsUpdate = false;
				
				if( this.needsRemove )
				{
					this.dom.addClass( "bg-danger" );
					this.deleteButtonDOM.text( "keep" );
				}
				else
				{
					this.dom.removeClass( "bg-danger" );
					this.deleteButtonDOM.text( "delete" );
				}
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
		
		public get pendingDelete(): boolean
		{
			return this.needsRemove;
		}
		
		public addPrimaryField( value: any, fieldName: string )
		{
			let field = new Field( value, fieldName, true );
			
			let fieldDOM = field.getDOM();
			
			fieldDOM.append( this.deleteButtonDOM );
			
			fieldDOM.on( "mouseenter", () =>
			{
				field.getValueDOM().addClass( "hidden" );
				
				this.deleteButtonDOM.removeClass( "hidden" );
			} );
			
			fieldDOM.on( "mouseleave", () =>
			{
				this.deleteButtonDOM.addClass( "hidden" );
				
				field.getValueDOM().removeClass( "hidden" );
			} );
			
			this.fieldList.push( field );
			this.dom.append( field.getDOM() );
		}
		
		public addField( value: any, fieldName: string )
		{
			let field = new Field( value, fieldName );
			this.fieldList.push( field );
			this.dom.append( field.getDOM() );
		}
		
		public getDOM(): JQuery<HTMLElement>
		{
			return this.dom;
		}
		
		public toJSON(): string
		{
			let result = `{"entityName": ${JSON.stringify( this.entityName )}, `;
			
			this.fieldList.forEach( ( value: Field, index: number, array ) =>
			                        {
				                        result += value.toJSON();
				
				                        if( index < array.length - 1 )
					                        result += ",";
			                        } );
			
			result += "}";
			
			return result;
		}
	}
	
	class Field
	{
		protected dom: JQuery<HTMLElement>;
		protected valueDOM: JQuery<HTMLElement>;
		protected inputDOM: JQuery<HTMLElement>;
		
		protected value: any;
		
		protected isPrimary: boolean;
		
		protected isActive: boolean = false;
		
		protected readonly columnName: string;
		
		constructor( value: any, fieldName: string, primary: boolean = false )
		{
			this.columnName = fieldName;
			this.isPrimary = primary;
			
			this.value = value;
			
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
				this.value = this.valueDOM.text();
				this.inputDOM.width( this.valueDOM.width() );
				this.inputDOM.val( this.valueDOM.text() );
				this.valueDOM.addClass( "hidden" );
				this.inputDOM.removeClass( "hidden" );
				this.inputDOM.trigger( "focus" );
				this.inputDOM.trigger( "select" );
			} );
			
			this.inputDOM.on( "focusout", () =>
			{
				if( this.value !== this.inputDOM.val() )
				{
					this.value = this.inputDOM.val();
					this.dom.addClass( "bg-success" );
					this.dom.addClass( "text-light" );
					this.valueDOM.text( <string>this.inputDOM.val() );
				}
				this.inputDOM.addClass( "hidden" );
				this.valueDOM.removeClass( "hidden" );
			} );
			
			this.inputDOM.on( "keypress", ( keycode ) =>
			{
				if( keycode.keyCode === 13 )
				{
					if( this.value !== this.inputDOM.val() )
					{
						this.value = this.inputDOM.val();
						this.dom.addClass( "bg-success" );
						this.dom.addClass( "text-light" );
						this.valueDOM.text( <string>this.inputDOM.val() );
					}
					this.inputDOM.addClass( "hidden" );
					this.valueDOM.removeClass( "hidden" );
				}
			} );
		}
		
		public toJSON(): string
		{
			let result = "";
			
			let value = (<string>this.valueDOM.text() === "" ? null : <string>this.valueDOM.text());
			
			result += `"${this.columnName}": ${JSON.stringify( value )}`;
			
			return result;
		}
		
		public getDOM(): JQuery<HTMLElement>
		{
			return this.dom;
		}
		
		public getValueDOM(): JQuery<HTMLElement>
		{
			return this.valueDOM;
		}
		
		public getValue(): any
		{
			return this.value;
		}
	}
	
	
	let admin: Admin = null;
	
	$( () =>
	   {
		   admin = new Admin();
		   admin.loadTable();
	   } );
}