<?php

namespace vendor\core\routing;

class Route extends RouteBase
{
	private $uri;
	
	public function __construct( string $uri, string $controller, string $action, int $routePriority = RoutePriority::HIGH )
	{
		parent::__construct( $controller, $action, $routePriority );
		$this->uri = $uri;
	}
	
	public function matchURI( string $uri ) : bool
	{
		return $this->uri === $uri;
	}
}