<?php

namespace app\controller;

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
		$userLogin = SessionManager::getSessionProperty( "user" );
		$isUser    = ( $userLogin !== null );
		
		if( $isUser )
			$this->args["__userLogin__"] = $userLogin;
		
		$this->args["__isUser__"] = $isUser;
		$this->args["__title__"]  = $this->title;
		
		parent::render();
	}
}