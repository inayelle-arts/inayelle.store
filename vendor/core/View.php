<?php

namespace vendor\core;

use vendor\core\routing\RouteBase;
use vendor\exception\FileNotFoundException;

class View
{
	private $layout;
	private $view;
	private $args;
	
	public function __construct( RouteBase $route, array $args = [], string $customLayout = null )
	{
		$customLayout = $customLayout ?? "default";
		
		$this->view = VIEW__ . "/{$route->getControllerName()}/{$route->getActionName()}.php";
		$this->layout = LAYOUT__ . "/{$customLayout}.php";
		$this->args = $args;
	}
	
	public function render()
	{
		extract($this->args);
		
		if( !file_exists( $this->view ) )
			throw new FileNotFoundException( $this->view );
		if( !file_exists( $this->layout ) )
			throw new FileNotFoundException( $this->layout );
		
		ob_start();
		require_once $this->view;
		/** @noinspection PhpUnusedLocalVariableInspection */
		$__content__ = ob_get_clean();
		
		require_once $this->layout;
	}
}