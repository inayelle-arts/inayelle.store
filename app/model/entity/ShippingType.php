<?php

namespace app\model\entity;

final class ShippingType
{
	private function __construct() { }
	
	public const PICKUP  = 1;
	public const COURIER = 2;
	public const POST    = 3;
}