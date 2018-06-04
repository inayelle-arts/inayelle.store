<?php

define( "ROOT__", dirname( __DIR__ ) );

require_once ROOT__ . "/vendor/core/Application.php";

Application::initialize();
Application::start();

/** @var \app\model\entity\ProductEntity $product */
//$product = \app\model\entity\ProductEntity::getById(1);

//echo $product->toJSON();