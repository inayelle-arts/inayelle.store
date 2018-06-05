<?php

use app\model\entity\ProductEntity;
use vendor\core\database\SQLBuilder;

define( "ROOT__", dirname( __DIR__ ) );

require_once ROOT__ . "/vendor/core/Application.php";

Application::initialize();
//Application::start();


function getProductsByFilter( array $allowedCategories = null, int $offset = 0, int $fromCost = null, int $toCost = null ) : array
{

}
