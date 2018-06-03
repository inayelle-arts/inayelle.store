<?php

namespace vendor\core\routing;

abstract class RouteBase
{
	protected $controller = "";
	protected $action     = "";
	protected $rules      = [];
	
	private $routePriority;
	
	private const CONTROLLER_NAMESPACE = "app\\controller\\";
	private const CONTROLLER_POSTFIX   = "Controller";
	private const ACTION_POSTFIX       = "Action";
	
	protected function __construct( string $controller, string $action, int $routePriority )
	{
		$this->controller = $controller;
		$this->action = $action;
		$this->routePriority = $routePriority;
	}
	
	public abstract function matchURI( string $uri ) : bool;
	
	public function getControllerName() : string
	{
		return $this->controller;
	}
	
	public function getControllerFullName() : string
	{
		return self::CONTROLLER_NAMESPACE . "{$this->controller}" . self::CONTROLLER_POSTFIX;
	}
	
	public function getActionName() : string
	{
		return $this->action;
	}
	
	public function getActionFullName() : string
	{
		return $this->action . self::ACTION_POSTFIX;
	}
	
	public function getMethodType() : string
	{
		return $_SERVER["REQUEST_METHOD"];
	}
	
	public function getParameter( string $key )
	{
		return $_REQUEST[$key];
	}
	
	public function decodeJSON(string $jsonParameterName = "data") : array
	{
		return json_decode($_REQUEST[$jsonParameterName], true);
	}
	
	public function addRule( callable $rule ) : void
	{
		$this->rules[] = $rule;
	}
	
	public function checkRules() : bool
	{
		foreach( $this->rules as &$rule )
			if( $rule() )
				return true;
		
		return false;
	}
	
	public function getPriority() : int
	{
		return $this->routePriority;
	}
	
	public function __toString()
	{
		return "ROUTE: <ul>" .
				"<li>[TYPE] = " . static::class . "</li>" .
				"<li>[PRIOPRITY] = " . $this->getPriority() . "</li>" .
				"<li>[RULE COUNT] = " . count( $this->rules ) . "</li>" .
				"<li>[CONTROLLER] = " . $this->getControllerName() . "</li>" .
				"<li>[CONTROLLER CLASS] = " . $this->getControllerFullName() . "</li>" .
				"<li>[ACTION] = " . $this->getActionName() . "</li>" .
				"<li>[USER ACTION] = " . $this->getActionFullName() . "</li>" .
				"</ul>";
	}
}