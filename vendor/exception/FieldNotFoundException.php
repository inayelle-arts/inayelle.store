<?php

namespace vendor\exception;

class FieldNotFoundException extends \Exception
{
	private $fieldName;
	private $className;
	
	public function __construct( string $fieldName, string $className )
	{
		$this->fieldName = $fieldName;
		$this->className = $className;
		
		parent::__construct( "Field <${fieldName}> in class <${className}> not found" );
	}
	
	public function getFieldName() : string
	{
		return $this->fieldName;
	}
	
	public function getClassName() : string
	{
		return $this->className;
	}
}