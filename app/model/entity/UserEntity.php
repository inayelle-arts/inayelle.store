<?php

namespace app\model\entity;

use vendor\auxiliary\SaltGenerator;
use vendor\core\base\EntityBase;

/**
 * Class UserEntity
 * @package app\model\entity
 * @property string $login
 * @property string $password_hash
 * @property int    $verified
 * @property string $verify_code
 */
class UserEntity extends EntityBase
{
	/** @var string $login */
	private $login;
	
	/** @var string $password_hash */
	private $password_hash;
	
	/** @var int $verified */
	private $verified;
	
	/** @var string $verify_code */
	private $verify_code;
	
	protected const TABLE  = "users";
	protected const FIELDS =
		[
			"login",
			"password_hash",
			"verified",
			"verify_code"
		];
	
	public function __construct( string $login = "", string $passwordHash = "" )
	{
		$this->login         = $login;
		$this->password_hash = $passwordHash;
		$this->verified      = 0;
		$this->verify_code   = SaltGenerator::generate();
	}
	
	public function __toString() : string
	{
		return
			"User : {" .
			"id: {$this->id}, " .
			"login: {$this->login}, " .
			"password: {$this->password_hash}}, " .
			"verified: {$this->verified}, " .
			"verify_code: {$this->verify_code} }";
	}
	
	public function __get( string $name )
	{
		return $this->$name;
	}
	
	public function __set( string $name, $value )
	{
		$this->$name = $value;
	}
}