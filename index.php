<?php 

session_start();

require_once("vendor/autoload.php"); //carrega todas as dependencias do site

use \Slim\Slim; //chama a classe Slim 
use \Hcode\Page; //chama da classe Page
use \Hcode\PageAdmin; //chama da classe PageAdmin
use \Hcode\Model\User;

$app = new Slim(); //instanciando a classe slim

$app->config('debug', true);

$app->get('/', function() {

	$page = new Page();

	$page->setTpl("index"); //chamando o conteudo da pagina
});

$app->get('/admin', function() {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("index"); //chamando o conteudo da pagina
});

$app->get('/admin/login', function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function() {

	User::login($_POST["login"], $_POST["password"]);
	
	header("location: /admin");

	exit;
});

$app->get('/admin/logout', function(){

	User::logout();

	header("Location: /admin/login");

	exit;

});

$app->run(); //roda todo o codigo depois de ter carregado tudo

 ?>
