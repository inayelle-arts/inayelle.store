<?php

namespace vendor\auxiliary;

final class StringExt
{
	private function __construct() { }
	
	public static function hashCodeToString( string $str ) : string
	{
		return (string)self::hashCodeToInt( $str );
	}
	
	public static function hashCodeToInt( string $str ) : int
	{
		$hash = 0;
		$len  = strlen( $str );
		
		if( $len === 0 )
			return $hash;
		
		for( $i = 0; $i < $len; $i++ )
		{
			$h    = $hash << 5;
			$h    -= $hash;
			$h    += ord( $str[$i] );
			$hash = $h;
			$hash &= 0xFFFFFFFF;
		}
		return $hash;
	}
}