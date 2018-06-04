<?php

namespace app\controller;

use app\model\entity\UserEntity;
use vendor\auxiliary\SessionManager;
use vendor\core\base\ControllerBase;
use vendor\core\routing\RouteBase;

abstract class AppController extends ControllerBase
{
	public function __construct( RouteBase $route )
	{
		$this->title = "inayelle.store";
		parent::__construct( $route );
	}
	
	public function render()
	{
		/** @var UserEntity $user */
		$user = SessionManager::getSessionProperty( "user" );
		$isUser    = ( $user !== null );
		
		if( $isUser )
			$this->args["__user__"] = $user;
		
		$this->args["__isUser__"] = $isUser;
		$this->args["__title__"]  = $this->title;
		
		parent::render();
	}
}