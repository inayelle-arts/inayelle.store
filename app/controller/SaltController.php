<?php

namespace app\controller;

use vendor\auxiliary\SaltGenerator;
use vendor\core\routing\RouteBase;

class SaltController extends AppController
{
	public function __construct( RouteBase $route ) { parent::__construct( $route ); }
	
	public function indexAction() : void
	{
		$this->setViewable(false);
		echo SaltGenerator::generate(10);
	}
}