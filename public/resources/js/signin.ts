namespace SignIn
{
	class Form
	{
		private loginFormDOM: JQuery<HTMLFormElement>;
		private loginDOM: JQuery<HTMLInputElement>;
		private passwordDOM: JQuery<HTMLInputElement>;
		private submitButton: JQuery<HTMLElement>;
		private errorField: JQuery<HTMLElement>;
		
		private titleDOM: JQuery<HTMLElement>;
		
		private resetLoginInputDOM: JQuery<HTMLInputElement>;
		private resetPasswordFormDOM: JQuery<HTMLFormElement>;
		private resetPassowordButtonDOM: JQuery<HTMLElement>;
		private backToSignInButtonDOM: JQuery<HTMLElement>;
		
		private resetFormSubmit: JQuery<HTMLElement>;
		
		constructor()
		{
			this.loginFormDOM = <JQuery<HTMLFormElement>>$( "#login-form" );
			this.loginDOM = <JQuery<HTMLInputElement>>$( "#login" );
			this.passwordDOM = <JQuery<HTMLInputElement>>$( "#password" );
			this.submitButton = $( "#login-form-submit" );
			this.titleDOM = $( "#sign-title" );
			
			this.resetPasswordFormDOM = <JQuery<HTMLFormElement>>$( "#reset-form" );
			this.resetPassowordButtonDOM = $( "#forgot-pass-button" );
			this.backToSignInButtonDOM = <JQuery<HTMLFormElement>>$( "#back-to-sign-in" );
			this.resetFormSubmit = $("#reset-form-submit");
			
			this.resetLoginInputDOM = <JQuery<HTMLInputElement>>$("#reset-login");
			
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
			
			this.backToSignInButtonDOM.on("click", () =>
			{
				this.titleDOM.fadeOut("0.5s", () =>
				{
					this.titleDOM.text("Sign in");
					this.titleDOM.fadeIn("0.5s");
				});
				
				this.resetPasswordFormDOM.fadeOut( "0.5s", () =>
				{
					this.loginFormDOM.fadeIn("0.5s");
					this.loginFormDOM.css("display", "flex");
				} );
			});
			
			this.resetPassowordButtonDOM.on( "click", () =>
			{
				this.titleDOM.fadeOut("0.5s", () =>
				{
					this.titleDOM.text("Reset password");
					this.titleDOM.fadeIn("0.5s");
				});
				
				this.loginFormDOM.fadeOut( "0.5s", () =>
				{
					this.resetPasswordFormDOM.fadeIn("0.5s");
					this.resetPasswordFormDOM.css("display", "flex");
				} );
			} );
			
			this.submitButton.on( "click", () =>
			{
				if( !this.loginFormDOM.valid() )
					return;
				
				let login = this.loginDOM.val();
				
				let password: string = <string>this.passwordDOM.val();
				
				let passHash = password.hashCode();
				
				let data = `{"login": "${login}", "password_hash": "${passHash}"}`;
				
				$.ajax(
					{
						url: "/sign/signin",
						method: "post",
						data: {data},
						success: ( response ) =>
						{
							if( response === "success" )
								window.location.href = "/";
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
		
			this.resetLoginInputDOM.on("change paste keyup", () =>
			{
				this.resetLoginInputDOM.valid();
			});
			
			this.resetFormSubmit.on("click", () =>
			{
				if (!this.resetLoginInputDOM.valid())
					return;
				
				let email:string = <string>this.resetLoginInputDOM.val();
				
				let data = `{"email": "${email}"}`;
				
				$.ajax(
					{
						url: "/sign/reset",
						method: "POST",
						data: {data},
						success: (response: string) =>
						{
							$("#email-error").text(response);
						},
						error: () =>
						{
							$("#email-error").text("Server does not respond.");
						},
						timeout: 5000
					}
				);
			});
		}
	}
	
	let form: Form = null;
	
	$( () =>
	   {
		   form = new Form();
	   } );
}