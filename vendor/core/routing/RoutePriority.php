<?php

namespace vendor\core\routing;

final class RoutePriority
{
	private function __construct() { }
	
	public const LOW    = -2;
	public const MIDDLE = -1;
	public const HIGH   = 0;
}