<?php

$dbname = getenv('MYSQL_DATABASE', false) ?: "kenshudb";
$dbhost = getenv('MYSQL_HOST', false) ?: "localhost";
$dbuser = getenv('MYSQL_USER', false) ?: "root";
$dbpassword = getenv('MYSQL_PASSWORD', false) ?: "root";

return
	[
		'paths' => [
			'migrations' => '%%PHINX_CONFIG_DIR%%/app/External/Database/migrations',
			'seeds' => '%%PHINX_CONFIG_DIR%%/app/External/Database/seeds'
		],
		'environments' => [
			'default_migration_table' => 'phinxlog',
			'default_environment' => 'development',
			'production' => [
				'adapter' => 'mysql',
				'host' => $dbhost,
				'name' => $dbname,
				'user' => $dbuser,
				'pass' => $dbpassword,
				'port' => '3306',
				'charset' => 'utf8',
			],
			'development' => [
				'adapter' => 'mysql',
				'host' => $dbhost,
				'name' => $dbname,
				'user' => $dbuser,
				'pass' => $dbpassword,
				'port' => '3306',
				'charset' => 'utf8',
			],
			'testing' => [
				'adapter' => 'mysql',
				'host' => $dbhost,
				'name' => $dbname,
				'user' => $dbuser,
				'pass' => $dbpassword,
				'port' => '3306',
				'charset' => 'utf8',
			]
		],
		'version_order' => 'creation'
	];
