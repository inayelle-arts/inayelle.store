<?php

namespace app\controller;

use app\model\exception\AlreadyVerifiedException;
use app\model\exception\BadVerificationCodeException;
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
		
		$success = $this->model->validateSignIn( $login, $password );
		
		if( $success )
		{
			SessionManager::setSessionProperty( "user", $login );
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
		
		if (!$this->model->validateSignUp($login))
		{
			echo "Login already taken";
			return;
		}
		
		if (!$this->model->registerUser($login, $password))
		{
			echo "Login already taken";
			return;
		}
		
		SessionManager::setSessionProperty("user", $login);
		
		echo "success";
	}
	
	public function logoutAction()
	{
		$this->setViewable( false );
		SessionManager::unsetSessionProperty( "user" );
		header( 'Location: /' );
	}
	
	public function verifyAction() : void {}
	
	public function verifiedAction() : void
	{
		$code = $this->route->getParameter("code");
		$message = "";
		
		try
		{
			$this->model->verifyUser( $code );
			$message = "User was successfully verified!";
		}
		catch(AlreadyVerifiedException $exception)
		{
			$message = "Activation code was already used.";
		}
		catch(BadVerificationCodeException $exception)
		{
			$message = "Verification code is not valid.";
		}
		
		$this->setAttribute("message", $message);
	}
}