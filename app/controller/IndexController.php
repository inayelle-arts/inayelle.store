<?php

namespace app\controller;

use vendor\core\routing\RouteBase;

class IndexController extends AppController
{
	public function __construct( RouteBase $route )
	{
		parent::__construct( $route );
	}
	
	public function indexAction() : void
	{
		$this->setTitle( "inayelle.store" );
	}
}