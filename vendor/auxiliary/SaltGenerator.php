<?php

namespace vendor\auxiliary;

final class SaltGenerator
{
	private function __construct() { }
	
	public static function generate() : string
	{
		return uniqid( (string)rand(), true );
	}
}