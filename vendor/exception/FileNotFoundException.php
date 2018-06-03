<?php

namespace vendor\exception;

use Exception;

class FileNotFoundException extends Exception
{
	private $filePath;
	
	public function __construct( string $filePath )
	{
		$this->filePath = $filePath;
		
		$message = "[CRITICAL] File <{$filePath}> not found";
		
		parent::__construct( $message );
	}
	
	public function getFilePath() : string
	{
		return $this->filePath;
	}
}