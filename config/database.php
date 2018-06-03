<?php

$host = null;
$db_type = null;
$db_name = null;
$user = null;
$password = null;
$charset = null;

$config = APP_CONFIG__["database"];

extract($config, EXTR_OVERWRITE);

$options =
		[
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_EMULATE_PREPARES => false
		];

return
		[
				"dsn" => "{$db_type}:host={$host};dbname={$db_name};charset={$charset}",
				"user" => $user,
				"password" => $password,
				"options" => $options
		];