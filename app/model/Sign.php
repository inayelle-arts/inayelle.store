<?php

namespace app\model;

use app\model\entity\UserEntity;
use app\model\exception\AlreadyVerifiedException;
use app\model\exception\BadVerificationCodeException;
use vendor\auxiliary\Email;
use vendor\core\database\exception\DatabaseCommonException;

class Sign extends App
{
	public function __construct()
	{
	}
	
	public function validateSignIn( ?string $login, ?string $password ) : bool
	{
		if( $login === null || $password == null )
			return false;
		
		/** @var UserEntity $user */
		$user = UserEntity::getByField( "login", $login )[0];
		
		if( $user === null )
			return false;
		
		return ( $user->login == $login && $user->password_hash == $password );
	}
	
	public function validateSignUp( ?string $login ) : bool
	{
		if( $login === null )
			return false;
		
		/** @var UserEntity $user */
		$user = UserEntity::getByField( "login", $login )[0];
		
		return ( $user === null );
	}
	
	public function registerUser( string $login, string $password ) : bool
	{
		$user = new UserEntity( $login, $password );
		try
		{
			$user->create();
		}
		catch( DatabaseCommonException $exception )
		{
			return false;
		}
		$message = "Hello! You received this message because you signed up on inayelle.store internet shop.\r\n";
		$message .= "Click on reference below to confirm your email.\r\n";
		$message .= "http://93.72.27.149:1338/sign/verified?code={$user->verify_code} \r\n";
		$message .= "If you receive this message and have no account on our site, please ignore this message.\r\n";
		$message .= "Best wishes,\r\ninayelle.store\r\n";
		
		$mail = new Email( $user->login, "inayelle.store | Verification code", $message );
		$mail->send();
		return true;
	}
	
	/**
	 * @param string $code
	 *
	 * @throws AlreadyVerifiedException
	 * @throws BadVerificationCodeException
	 * @throws DatabaseCommonException
	 * @throws \vendor\core\database\exception\ConnectionFailureException
	 */
	public function verifyUser( ?string $code ) : void
	{
		if( $code === null )
			throw new BadVerificationCodeException();
		
		/** @var UserEntity $user */
		$user = UserEntity::getByField( "verify_code", $code )[0];
		
		if( $user === null )
			throw new BadVerificationCodeException();
		
		if( $user->verified )
			throw new AlreadyVerifiedException();
		
		$user->verified = 1;
		$user->update();
	}
}