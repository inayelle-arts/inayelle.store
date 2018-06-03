<?php

use vendor\core\routing\AutoRoute;
use vendor\core\routing\RoutePriority;
use vendor\exception\ErrorPageSignal;

$pattern = "^\/(?P<controller>admin)(\/?(?P<action>[a-z-_]+))?(\?(?P<params>[a-z0-9-_=&]{3,}))?$";

$route = new AutoRoute( $pattern, RoutePriority::MIDDLE );

$route->addRule( function()
{
	throw new ErrorPageSignal( 403 );
} );

return $route;