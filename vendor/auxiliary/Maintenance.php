<?php

namespace vendor\auxiliary;

final class Maintenance
{
	private $enabled   = false;
	private $allowedIP = [];
	
	public function __construct()
	{
		$config = APP_CONFIG__["application"]["maintenance"];
		
		$this->enabled   = $config["enabled"];
		$this->allowedIP = $config["allowedIP"];
	}
	
	public function enabled() : bool
	{
		return $this->enabled;
	}
	
	public function validateDeveloper( string $ip ) : bool
	{
		return in_array( $ip, $this->allowedIP );
	}
}