<?php

namespace vendor\core\routing;

use Exception;
use vendor\auxiliary\ClassFactory;
use vendor\auxiliary\Logger;
use vendor\core\base\ControllerBase;
use vendor\exception\ErrorPageSignal;

final class Router
{
	/** @var RouteBase[] $routes */
	private static $routes = [];
	/** @var RouteBase $currentRoute */
	private static $currentRoute;
	
	private function __construct() { }
	
	public static function addRoute( RouteBase $route ) : void
	{
		self::$routes[] = $route;
	}
	
	private static function matchURI( string $uri ) : bool
	{
		self::sortRoutesByPriority();
		
		foreach( self::$routes as &$route )
			if( $route->matchURI( $uri ) )
			{
				self::$currentRoute = $route;
				return true;
			}
		
		return false;
	}
	
	public static function dispatch( string $uri ) : void
	{
		if( !self::matchURI( $uri ) )
			throw new ErrorPageSignal( 404, $uri );
		
		if( self::$currentRoute->checkRules() )
			exit();
		
		$controllerName = self::$currentRoute->getControllerFullName();
		$actionName     = self::$currentRoute->getActionFullName();
		
		if( !ClassFactory::isValid( $controllerName, $actionName ) )
			throw new ErrorPageSignal( 404, $uri );
		
		/** @var ControllerBase $controllerInstance */
		$controllerInstance = new $controllerName( self::$currentRoute );
		try
		{
			$controllerInstance->$actionName();
			$controllerInstance->render();
		}
			//todo: handle concrete exceptions...
		catch( Exception $exception )
		{
			$message = "Unhandled Exception was occured";
			Logger::log( $message, $exception );
			throw new ErrorPageSignal( 500 );
		}
	}
	
	private static function sortRoutesByPriority() : void
	{
		usort( self::$routes,
			function( RouteBase $route1, RouteBase $route2 ) : int
			{
				return $route2->getPriority() - $route1->getPriority();
			} );
	}
}