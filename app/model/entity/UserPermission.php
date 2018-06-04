<?php

namespace app\model\entity;

/**
 * Class UserPermission
 * @package app\model\entity
 */
final class UserPermission
{
	private function __construct() { }
	
	public const COMMON        = 1;
	public const VERIFIED      = 2;
	public const MODERATOR     = 3;
	public const ADMINISTRATOR = 4;
}