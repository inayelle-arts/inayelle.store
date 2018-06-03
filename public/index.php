<?php

define( "ROOT__", dirname( __DIR__ ) );

require_once ROOT__ . "/vendor/core/Application.php";

Application::initialize();
Application::start();