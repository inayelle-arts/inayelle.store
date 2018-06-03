namespace SignUp
{
	class Form
	{
		private formDOM: JQuery<HTMLFormElement>;
		private loginDOM: JQuery<HTMLInputElement>;
		private passwordDOM: JQuery<HTMLInputElement>;
		private submitButton: JQuery<HTMLElement>;
		private errorField: JQuery<HTMLElement>;
		
		constructor()
		{
			this.formDOM = <JQuery<HTMLFormElement>>$( "#form" );
			this.loginDOM = <JQuery<HTMLInputElement>>$( "#login" );
			this.passwordDOM = <JQuery<HTMLInputElement>>$( "#password" );
			this.submitButton = $( "#sign-up-button" );
			
			this.errorField = $( "#password-error" );
			
			this.setEventHandlers();
		}
		
		protected setEventHandlers()
		{
			this.loginDOM.on( "paste keyup change", () =>
			{
				this.loginDOM.valid();
			} );
			
			this.passwordDOM.on( "paste keyup change", () =>
			{
				this.passwordDOM.valid();
			} );
			
			
			this.submitButton.on( "click", () =>
			{
				if( !this.formDOM.valid() )
					return;
				
				let login = this.loginDOM.val();
				
				let password: string = <string>this.passwordDOM.val();
				
				let passHash = password.hashCode();
				
				let data = `{"login": "${login}", "password_hash": "${passHash}"}`;
				
				$.ajax(
					{
						url: "/sign/signup",
						method: "post",
						data: {data},
						success: ( response ) =>
						{
							if( response === "success" )
								window.location.href = "/sign/verify";
							else
								this.errorField.text( response );
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