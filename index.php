<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Nutri\Page;
use \Nutri\PageAdmin;
use \Nutri\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {		//Referenciando o caminho do index
    
	$page = new Page();

	$page->setTpl("index");

});

$app->get('/admin', function() {  //Referenciando o caminho da Page Admin
	
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function() {  //Referenciando o caminho da Pagina Login
    
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login',function(){

	User::login($_POST["login"], $_POST["password"]);

	header("Location: /admin");
	exit;

});

$app->get('/admin/logout', function(){

	User::logout();

	header("Location: /admin/login");
	exit;

});

$app->run();

 ?>