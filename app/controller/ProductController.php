<?php

namespace app\controller;

use app\model\Product;
use vendor\core\routing\RouteBase;

class ProductController extends AppController
{
	/** @var Product */
	protected $model;
	
	public function __construct( RouteBase $route ) { parent::__construct( $route ); }
	
	public function indexAction()
	{
		$this->setTitle( "inayelle.store | Products" );
	
		$filters = $this->route->decodeJSON("filters");
		
		$count = $filters["count"];
		$offset = $filters["offset"];
		$allowedCategories = $filters["categories"];
		$lowerCost = $filters["lowerCost"];
		$upperCost = $filters["upperCost"];
		
		
	}
	
	public function seeAction() : void
	{
		$id = $this->route->getParameter( "id" );
		
		$product = $this->model->getProduct( $id );
		
		$this->setAttribute( "product", $product );
		$this->setAttribute( "productFound", $product !== null );
	}
}