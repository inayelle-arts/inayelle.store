<?php

use vendor\auxiliary\ErrorPagesSender;
use vendor\auxiliary\Logger;
use vendor\auxiliary\Maintenance;
use vendor\auxiliary\SessionManager;
use vendor\core\routing\Router;
use vendor\exception\ErrorPageSignal;

if( !defined( "ROOT__" ) )
	die( "[CRITICAL] - <b>ROOT__</b> CONSTANT HAVE NOT BEEN DEFINED" );

error_reporting( E_ERROR | E_PARSE );

define( "APP__", ROOT__ . "/app" );
define( "ROUTE__", APP__ . "/route" );
define( "PUBLIC__", ROOT__ . "/public" );
define( "ERROR_PAGES__", PUBLIC__ . "/error_pages" );
define( "VENDOR__", ROOT__ . "/vendor" );
define( "CORE__", VENDOR__ . "/core" );
define( "CONTROLLER__", APP__ . "/controller" );
define( "MODEL__", APP__ . "/model" );
define( "VIEW__", APP__ . "/view" );
define( "LAYOUT__", APP__ . "/layout" );
define( "CONFIG__", ROOT__ . "/config" );

final class Application
{
	private function __construct() { }
	
	public static function initialize()
	{
		self::loadClasses();
		self::loadConfig();
		self::loadRoutes();
		self::loadLogger();
	}
	
	public static function start()
	{
		try
		{
			$maintenance = new Maintenance();
			$ip          = $_SERVER["REMOTE_ADDR"];
			
			if( $maintenance->enabled() && !$maintenance->validateDeveloper( $ip ) )
				throw new ErrorPageSignal( 503 );
			
			SessionManager::start();
			
			$uri = $_SERVER["REQUEST_URI"];
			Router::dispatch( $uri );
			
			SessionManager::end();
		}
		catch( ErrorPageSignal $errorPageState )
		{
			ErrorPagesSender::sendErrorPage( $errorPageState->getCode(), $errorPageState->getMessage() );
		}
	}
	
	private static function loadClass( string $className ) : void
	{
		$file = ROOT__ . "/" . str_replace( "\\", "/", $className ) . ".php";
		
		if( file_exists( $file ) )
			require_once $file;
	}
	
	private static function loadClasses() : void
	{
		spl_autoload_extensions( ".php" );
		spl_autoload_register( [ "Application", "loadClass" ], false );
	}
	
	private static function loadConfig() : void
	{
		$configFilePath = ROOT__ . "/config.json";
		
		if( !file_exists( $configFilePath ) )
			die( "[CRITICAL] - <b>CONFIG FILE</b> WAS NOT FOUND AT <b>${configFilePath}</b>" );
		
		$configJSON = file_get_contents( $configFilePath );
		
		$configs = json_decode( $configJSON, true );
		define( "APP_CONFIG__", $configs );
	}
	
	private static function loadRoutes() : void
	{
		if( !dir( ROUTE__ ) )
			die( "[CRITICAL] - <b>ROUTE__</b> DIR NOT FOUND, GIVEN PATH: " . ROUTE__ );
		
		$routePathPattern = ROUTE__ . "/*";
		$routeFiles       = glob( $routePathPattern, GLOB_NOSORT );
		
		foreach( $routeFiles as &$routeFile )
		{
			$route = require_once $routeFile;
			Router::addRoute( $route );
		}
	}
	
	private static function loadLogger() : void
	{
		Logger::initialize();
	}
}