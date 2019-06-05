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

	header("Location: /admin");

	exit;
});

$app->get('/admin/logOut', function(){

	User::logOut();

	header("Location: /admin/login");

	exit;

});

$app->get("/admin/users", function() {

	User::verifyLogin();

	$users = User::listAll();  //listar todos os 

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
		));
});

$app->get("/admin/users/:iduser/delete", function($iduser) {

	User::verifyLogin();
});

$app->get("/admin/users/:iduser", function($iduser) {

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$page = new PageAdmin();

	$page->setTpl("users-update", array(
		"user"=>$user->getValues();
	));
});

$app->get("/admin/users/create", function() {

	User::verifyLogin();
	
	$page = new PageAdmin();

	$page->setTpl("users-update");
});

$app->post("/admin/users/create", function() {

	User::verifyLogin();
	
	$user = new User();
	
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->setData($_POST);
	
	$user->save();

	header("Location: /admin/users");
	exit;

});

$app->post("/admin/users/:iduser", function($iduser) {

	User::verifyLogin();
});

$app->run(); //roda todo o codigo depois de ter carregado tudo

 ?>
