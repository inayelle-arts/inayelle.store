<?php

namespace vendor\auxiliary;

final class SaltGenerator
{
	private function __construct() { }
	
	public static function generate(int $symbolCount = null) : string
	{
		$result = uniqid( (string)rand(), true );
		if ($symbolCount !== null)
			$result = substr($result, strlen($result) - $symbolCount - 1);
		
		return $result;
	}
}