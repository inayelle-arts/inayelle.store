<?php

namespace vendor\auxiliary;

use vendor\exception\ClassNotFoundException;

final class ClassFactory
{
	private function __construct() { }
	
	public static function create( string $className, ... $params ) : object
	{
		if( !class_exists( $className ) )
			throw new ClassNotFoundException( $className );
		
		return new $className( ... $params );
		
	}
	
	public static function isValid( string $className, string $methodName ) : bool
	{
		return class_exists( $className ) && method_exists( $className, $methodName );
	}
}