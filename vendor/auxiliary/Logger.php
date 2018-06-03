<?php

namespace vendor\auxiliary;

use Throwable;

final class Logger
{
	private function __construct() { }
	
	private const SEPERATOR       = "------------------------------------------------------------------------------------------------------------------------------";
	private const SMALL_SEPERATOR = "----";
	private const ENDLINE         = PHP_EOL;
	
	private static $enabled;
	private static $append;
	private static $logPath;
	
	public static function initialize()
	{
		$params = require_once CONFIG__ . "/logging.php";
		
		self::$enabled = $params["enabled"];
		self::$logPath = ROOT__ . "/" . $params["log_name"];
	}
	
	private static function writeException( Throwable $throwable, int $tabCount = 0 ) : string
	{
		$result = "";
		
		$result .= self::tabLine( "Exception", $tabCount );
		$result .= self::tabLine( "Type: " . get_class( $throwable ), $tabCount );
		$result .= self::tabLine( "Message: " . $throwable->getMessage(), $tabCount );
		$result .= self::tabLine( "File: " . $throwable->getFile(), $tabCount );
		$result .= self::tabLine( "Line: " . $throwable->getLine(), $tabCount );
		$result .= self::tabLine( "Code: " . $throwable->getCode(), $tabCount );
		if( $throwable->getPrevious() !== null )
		{
			$result .= self::tabLine( "Inner exception: ", $tabCount );
			$result .= self::writeException( $throwable->getPrevious(), $tabCount + 1 );
		}
		else
			$result .= self::tabLine( "Inner exception: null", $tabCount );
		
		for( $i = 0; $i < $tabCount; $i++ )
			$result .= self::SMALL_SEPERATOR;
		
		return $result;
	}
	
	private static function tabLine( string $string, int $tabCount = 0 ) : string
	{
		$result = "";
		
		while( $tabCount )
		{
			$result .= "    ";
			--$tabCount;
		}
		
		return $result . "|" . $string . self::ENDLINE;
	}
	
	public static function log( $message, Throwable $throwable = null ) : void
	{
		if( !self::$enabled )
			return;
		
		$log = "Date: " . date( DATE_RFC822 ) . self::ENDLINE;
		$log .= self::writeException( $throwable );
		$log .= self::SEPERATOR;
		file_put_contents( self::$logPath, $log, FILE_APPEND );
	}
}