<?php

namespace app\controller;

use app\model\Arrivals;
use vendor\core\routing\RouteBase;

class ArrivalsController extends AppController
{
	/** @var Arrivals $model */
	protected $model;
	
	public function __construct( RouteBase $route )
	{
		parent::__construct( $route );
	}
	
	public function indexAction() : void
	{
		$arrivals = $this->model->getLatestArrivals();
		$this->setAttribute("arrivals", $arrivals);
	}
}