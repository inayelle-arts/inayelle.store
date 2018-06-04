<?php

namespace app\model\entity;

use vendor\auxiliary\SaltGenerator;
use vendor\core\base\EntityBase;
use vendor\core\base\GetSet;

/**
 * Class UserEntity
 * @package app\model\entity
 * @property string $email
 * @property string $password_hash
 * @property string $verify_code
 * @property string $reset_code
 * @property int    $permission_id
 */
class UserEntity extends EntityBase
{
	use GetSet;
	
	/** @var string $login */
	private $email;
	
	/** @var string $password_hash */
	private $password_hash;
	
	/** @var string $verify_code */
	private $verify_code;
	
	/** @var string $verify_code */
	private $reset_code;
	
	/** @var int $permission_id */
	private $permission_id;
	
	protected const TABLE  = "users";
	protected const FIELDS =
		[
			"email",
			"password_hash",
			"verify_code",
			"reset_code",
			"permission_id"
		];
}