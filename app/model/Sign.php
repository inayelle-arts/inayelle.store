<?php

namespace app\model;

use app\model\entity\UserEntity;
use app\model\entity\UserPermission;
use app\model\exception\AlreadyVerifiedException;
use app\model\exception\BadVerificationCodeException;
use app\model\exception\UserNotFoundException;
use vendor\auxiliary\Email;
use vendor\auxiliary\SaltGenerator;
use vendor\auxiliary\StringExt;
use vendor\core\database\exception\DatabaseCommonException;

class Sign extends App
{
	public function __construct()
	{
	}
	
	public function validateSignIn( ?string $email, ?string $password ) : ?UserEntity
	{
		if( $email === null || $password == null )
			return null;
		
		/** @var UserEntity $user */
		$user = UserEntity::getByField( "email", $email )[0];
		
		if( $user === null || $user->email != $email || $user->password_hash != $password )
			return null;
		
		return $user;
	}
	
	public function validateSignUp( ?string $email ) : bool
	{
		if( $email === null )
			return false;
		
		/** @var UserEntity $user */
		$user = UserEntity::getByUniqueField( "email", $email );
		
		return ( $user === null );
	}
	
	public function registerUser( string $email, string $password ) : ?UserEntity
	{
		$user                = new UserEntity();
		$user->email         = $email;
		$user->password_hash = $password;
		$user->verify_code   = SaltGenerator::generate();
		
		try
		{
			$user->create();
		}
		catch( DatabaseCommonException $exception )
		{
			return null;
		}
		
		$message = "Hello! You received this message because you signed up on inayelle.store internet shop.\r\n";
		$message .= "Click on reference below to confirm your email.\r\n";
		$message .= "http://93.72.27.149:1338/sign/verified?code={$user->verify_code} \r\n";
		$message .= "If you receive this message and have no account on our site, please ignore this message.\r\n";
		$message .= "Best wishes,\r\ninayelle.store\r\n";
		
		$mail = new Email( $user->email, "inayelle.store | Verification code", $message );
		$mail->send();
		return $user;
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
		
		if( $user->permission_id === UserPermission::VERIFIED )
			throw new AlreadyVerifiedException();
		
		$user->permission_id = UserPermission::VERIFIED;
		$user->update();
	}
	
	public function sendResetConfirmation( ?string $email ) : void
	{
		if( $email === null )
			throw new UserNotFoundException();
		
		/** @var UserEntity $user */
		$user = UserEntity::getByField( "email", $email )[0];
		
		if( $user === null )
			throw new UserNotFoundException();
		
		$user->reset_code = SaltGenerator::generate() . StringExt::hashCodeToString( $_SERVER["REMOTE_ADDR"] );
		$user->update();
		
		$message =
			"Dear User,\r\n" .
			"We receieved a request to reset your password. Click a link below to reset your password.\r\n" .
			"http://93.72.27.149:1338/sign/resetconfirm?code={$user->reset_code} \r\n" .
			"If you did not request password reset, please, change your password immediately.\r\n" .
			"Best wishes,\r\ninayelle.store";
		
		$email = new Email( $user->email, "inayelle.store | Password reset", $message );
		$email->send();
	}
	
	public function resetConfirm( ?string $code, ?string $password ) : bool
	{
		if( $code === null )
			return false;
		
		/** @var UserEntity $user */
		$user = UserEntity::getByField( "reset_code", $code )[0];
		if( $user === null )
			return false;
		
		if( $user->reset_code === $code )
		{
			$user->password_hash = $password;
			$user->reset_code    = null;
			$user->update();
			return true;
		}
		
		return false;
	}
}