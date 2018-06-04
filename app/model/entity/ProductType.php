<?php

namespace app\model\entity;

/**
 * Class ProductType
 * @package app\model\entity
 */
final class ProductType
{
	private function __construct() { }
	
	public const TUXEDO    = 1;
	public const SHOES     = 2;
	public const SWEATER   = 3;
	public const WATCH     = 4;
	public const TSHIRT    = 5;
	public const GLASSES   = 6;
	public const UNDERWEAR = 7;
}