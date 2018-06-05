<?php

namespace app\controller;

use app\model\entity\OrderEntity;
use app\model\Purchase;
use vendor\auxiliary\Logger;
use vendor\auxiliary\SessionManager;
use vendor\core\routing\RouteBase;

class PurchaseController extends AppController
{
	/** @var Purchase $model */
	protected $model;
	
	public function __construct( RouteBase $route ) { parent::__construct( $route ); }
	
	public function indexAction() : void
	{
		$productIds = $this->route->decodeJSON( "purchase-data" );
		if( $productIds === null || count( $productIds ) === 0 )
			header( "Location: /" );
		
		$products = $this->model->getProductsById( $productIds );
		
		$sum = 0;
		
		foreach( $products as $product )
			$sum += $product->total_cost;
		
		$this->setAttribute( "products", $products );
		$this->setAttribute( "products_id", $this->route->getParameter( "purchase-data" ) );
		$this->setAttribute( "total", $sum );
	}
	
	public function submitAction() : void
	{
		$productIds = $this->route->decodeJSON( "products_id" );
		
		if( $productIds === null || count( $productIds ) === 0 )
			header( "Location: /" );
		
		$this->model->purchase( $productIds, SessionManager::getSessionProperty( "user" ) );
	}
}