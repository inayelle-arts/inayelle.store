<?php

namespace app\controller;

use app\model\Product;
use vendor\core\routing\RouteBase;

class ProductController extends AppController
{
	/** @var Product */
	protected $model;
	
	public function __construct( RouteBase $route ) { parent::__construct( $route ); }
	
	public function seeAction() : void
	{
		$id = $this->route->getParameter("id");
		
		$product = $this->model->getProduct($id);
		
		$this->setAttribute("product", $product);
		$this->setAttribute("productFound", $product !== null);
	}
}