<?php

use vendor\core\routing\AutoRoute;
use vendor\core\routing\RoutePriority;
use vendor\exception\ErrorPageSignal;

$pattern = "^\/(?P<controller>admin)(\/?(?P<action>[a-z-_]+))?(\?(?P<params>[a-z0-9-_=&]{3,}))?$";

$route = new AutoRoute( $pattern, RoutePriority::MIDDLE );

$route->addRule( function()
{
	/** @var \app\model\entity\UserEntity $user */
	$user = \vendor\auxiliary\SessionManager::getSessionProperty( "user" );
	if( $user === null || $user->permission_id !== \app\model\entity\UserPermission::ADMINISTRATOR )
		throw new ErrorPageSignal( 403 );
	return false;
} );

return $route;