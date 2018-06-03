<?php

namespace vendor\core\routing;

class AutoRoute extends RouteBase
{
	public const  DEFAULT_PATTERN = "^\/(?P<controller>[a-z-_]+)(\/?(?P<action>[a-z-_]+))?.*$";
	
	private $route_priority;
	private $uriPattern = "";
	
	public function __construct( string $uriPattern = self::DEFAULT_PATTERN, int $routePriority = RoutePriority::LOW )
	{
		parent::__construct( "__UNDEFINED__", "__UNDEFINED__", $routePriority );
		
		$this->uriPattern = $uriPattern;
	}
	
	public function matchURI( string $uri ) : bool
	{
		$match = [];
		
		$pattern = "/{$this->uriPattern}/i";
		
		if( preg_match( $pattern, $uri, $match ) == true )
		{
			$this->controller = $match["controller"];
			$this->action = $match["action"] ?: "Index";
			
			return true;
		}
		
		return false;
	}
}