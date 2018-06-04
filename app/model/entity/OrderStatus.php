<?php


namespace app\model\entity;


final class OrderStatus
{
	private function __construct() { }
	
	public const DELIVERED = 1;
	public const ONWAY     = 2;
	public const PENDING   = 3;
}