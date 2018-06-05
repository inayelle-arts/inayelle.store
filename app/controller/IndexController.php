<?php

namespace app\controller;

use app\model\Index;
use vendor\core\routing\RouteBase;

class IndexController extends AppController
{
	/** @var Index $model */
	protected $model;
	
	public function __construct( RouteBase $route )
	{
		parent::__construct( $route );
	}
	
	public function indexAction() : void
	{
		$this->setTitle( "inayelle.store" );
		
		$discounted = $this->model->getProductsWithDiscount();
		
		$this->setAttribute( "discounted", $discounted );
	}
}