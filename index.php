<?php 

require_once("vendor/autoload.php");

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$sql = new Nutri\DB\Sql();

	$results = $sql->select("SELECT * FROM categoriaalimentos");

	echo json_encode($results);

});

$app->run();

 ?>