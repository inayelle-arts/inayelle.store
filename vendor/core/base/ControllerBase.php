<?php

namespace vendor\core\base;

use vendor\core\routing\RouteBase;
use vendor\core\View;

abstract class ControllerBase
{
	protected $viewable = true;
	protected $layout   = "default";
	protected $title    = "Document title";
	
	protected $route;
	/** @var ModelBase $model */
	protected $model;
	protected $args;
	
	public function __construct( RouteBase $route )
	{
		$this->route = $route;
		$this->args  = [];
		
		$model_name = "app\\model\\".$route->getControllerName();
		$this->model = new $model_name();
	}
	
	public function render()
	{
		if( $this->viewable )
		{
			$view = new View( $this->route, $this->args, $this->layout );
			$view->render();
		}
	}
	
	public function setViewable(bool $viewable) : void
	{
		$this->viewable = $viewable;
	}
	
	public function setLayout(string $layout) : void
	{
		$this->layout = $layout;
	}
	
	public function setTitle(string $title) : void
	{
		$this->title = $title;
	}
	
	public function setAttribute( string $key, $value ) : void
	{
		$this->args[$key] = $value;
	}
}