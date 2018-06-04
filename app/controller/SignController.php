<?php

namespace app\controller;

use app\model\entity\UserEntity;
use app\model\exception\AlreadyVerifiedException;
use app\model\exception\BadVerificationCodeException;
use app\model\exception\UserNotFoundException;
use app\model\Sign;
use vendor\auxiliary\Email;
use vendor\auxiliary\SessionManager;
use vendor\core\routing\RouteBase;

class SignController extends AppController
{
	/** @var Sign $model */
	protected $model;
	
	public function __construct( RouteBase $route )
	{
		parent::__construct( $route );
	}
	
	public function inAction() : void
	{
		$this->setTitle( "inayelle.store | sign in" );
	}
	
	public function upAction() : void
	{
		$this->setTitle( "inayelle.store | sign up" );
	}
	
	public function signInAction() : void
	{
		$this->setViewable( false );
		
		$data = $this->route->decodeJSON();
		
		$login    = $data["login"];
		$password = $data["password_hash"];
		
		$user = $this->model->validateSignIn( $login, $password );
		
		if( $user !== null )
		{
			SessionManager::setSessionProperty( "user", $user );
			echo "success";
		}
		else
			echo "Login or/and password are not valid";
	}
	
	public function signUpAction() : void
	{
		$this->setViewable( false );
		
		$data = $this->route->decodeJSON();
		
		$login    = $data["login"];
		$password = $data["password_hash"];
		
		if( !$this->model->validateSignUp( $login ) )
		{
			echo "Login already taken";
			return;
		}
		
		$user = $this->model->registerUser( $login, $password );
		
		SessionManager::setSessionProperty( "user", $user );
		
		echo "success";
	}
	
	public function logoutAction()
	{
		$this->setViewable( false );
		SessionManager::unsetSessionProperty( "user" );
		header( 'Location: /' );
	}
	
	public function verifyAction() : void { }
	
	public function verifiedAction() : void
	{
		$code    = $this->route->getParameter( "code" );
		$message = "";
		
		try
		{
			$this->model->verifyUser( $code );
			$message = "User was successfully verified!";
		}
		catch( AlreadyVerifiedException $exception )
		{
			$message = "Activation code was already used.";
		}
		catch( BadVerificationCodeException $exception )
		{
			$message = "Verification code is not valid.";
		}
		
		$this->setAttribute( "message", $message );
	}
	
	public function resetAction() : void
	{
		if( $this->route->getMethodType() === "GET" )
			return;
		
		$this->setViewable( false );
		
		$data = $this->route->decodeJSON();
		
		$login = $data["email"];
		
		try
		{
			$this->model->sendResetConfirmation( $login );
		}
		catch( UserNotFoundException $exception )
		{
			echo "No user with such email found.";
		}
		
		echo "The mail was sent to you. Checkout your email and confirm password reset.";
	}
	
	public function resetConfirmAction() : void
	{
		if( $this->route->getMethodType() == "GET" )
		{
			$code = $this->route->getParameter( "code" );
			$this->setAttribute( "code", $code );
			return;
		}
		
		$this->setViewable( false );
		
		$data     = $this->route->decodeJSON();
		$code     = $data["code"];
		$password = $data["password"];
		
		$result = $this->model->resetConfirm( $code, $password );
		
		if( $result )
			echo "success";
		else
			echo "Invalid confirmation code. Contact an administrator at `Contact` panel";
	}
}