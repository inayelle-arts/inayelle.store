namespace ResetConfirm
{
	class Form
	{
		private passwordInputDOM: JQuery<HTMLInputElement>;
		private confirmButtonDOM: JQuery<HTMLElement>;
		
		private errorField: JQuery<HTMLElement>;
		
		private readonly code: string;
		
		constructor()
		{
			this.passwordInputDOM = <JQuery<HTMLInputElement>>$( "#password" );
			this.confirmButtonDOM = $( "#confirm-button" );
			
			this.errorField = $( "#password-error" );
			
			let codeField = $( "#code" );
			
			this.code = <string>codeField.val();
			codeField.remove();
			
			this.setEventHandlers();
		}
		
		protected setEventHandlers()
		{
			this.passwordInputDOM.on( "paste keyup change", () =>
			{
				this.passwordInputDOM.valid();
			} );
			
			this.confirmButtonDOM.on( "click", () =>
			{
				if( !this.passwordInputDOM.valid() )
					return;
				
				let password: string = <string>this.passwordInputDOM.val();
				
				let passHash = password.hashCode();
				
				console.log(passHash);
				
				let data = `{"password" : "${passHash}", "code" : "${this.code}"}`;
				
				$.ajax(
					{
						url: "/sign/resetconfirm",
						method: "POST",
						data: {data},
						success: ( response ) =>
						{
							this.errorField.text(response);
							if (response === "success")
							{
								this.passwordInputDOM.attr( "disabled" );
								this.errorField.text( "Password was renewed successfully. Please, enter with new password." );
							}
						},
						error: () =>
						{
							this.errorField.text( "Server does not respond" );
						},
						timeout: 5000
					}
				);
			} );
			
		}
	}
	
	let form: Form = null;
	
	$( () =>
	   {
		   form = new Form();
	   } );
}