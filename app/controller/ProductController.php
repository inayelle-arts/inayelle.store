<?php

namespace app\controller;

use app\model\Product;
use vendor\core\routing\RouteBase;

class ProductController extends AppController
{
	/** @var Product */
	protected $model;
	
	public function __construct( RouteBase $route ) { parent::__construct( $route ); }
	
	public function indexAction() : void
	{
		$this->setTitle( "inayelle.store | Products" );
	}
	
	public function filterAction() : void
	{
		$this->setViewable( false );
		
		$filters = $this->route->decodeJSON( "filters" );
		
		if( $filters["categories"] === "all" )
			$allowedCategories = [ 1, 2, 3, 4, 5, 6 ];
		else
			$allowedCategories = $filters["categories"];
		
		$count     = $filters["count"];
		$offset    = $filters["offset"];
		$lowerCost = $filters["lowerCost"];
		$upperCost = $filters["upperCost"];
		
		$products = $this->model->getProductsByFilter( $count, $offset, $allowedCategories, $lowerCost, $upperCost );
		
		if( count( $products ) === 0 )
		{
			echo "noitems";
			return;
		}
		
		$result = "[";
		
		foreach( $products as $product )
			$result .= $product->toJSON() . ",";
		
		$result[strlen( $result ) - 1] = "]";
		
		echo $result;
	}
	
	public function seeAction() : void
	{
		$id = $this->route->getParameter( "id" );
		
		$product = $this->model->getProduct( $id );
		
		$this->setAttribute( "product", $product );
		$this->setAttribute( "productFound", $product !== null );
	}
	
	public function getEntitiesByIdAction() : void
	{
		$this->setViewable( false );
		
		$data = $this->route->decodeJSON();
		
		$products = [];
		
		foreach( $data as $datum )
			$products[] = $this->model->getProduct($datum);
		
		$result = "[";
		
		foreach( $products as $product )
			$result .= $product->toJSON() . ",";
		
		$result[strlen( $result ) - 1] = "]";
		
		echo $result;
	}
}