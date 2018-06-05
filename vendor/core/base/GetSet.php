<?php

namespace vendor\core\base;

use vendor\auxiliary\Logger;
use vendor\exception\FieldNotFoundException;
use vendor\exception\TypeMismatchException;

trait GetSet
{
	public function __get( string $fieldName )
	{
		if( !property_exists( static::class, $fieldName ) )
			throw new FieldNotFoundException( $fieldName, static::class );
		
		return $this->$fieldName;
	}
	
	public function __set( string $fieldName, $value ) : void
	{
		if( !property_exists( static::class, $fieldName ) )
			throw new FieldNotFoundException( $fieldName, static::class );
		
//		$valueClass = get_class( $value );
//		$fieldClass = get_class( $this->$fieldName );
//
//		Logger::message( $fieldName );
//		Logger::message( $fieldClass );
//
//		if( $valueClass !== $fieldClass )
//			throw new TypeMismatchException( $fieldName, $valueClass );
		
		$this->$fieldName = $value;
	}
}