<?php 

require_once("vendor/autoload.php"); //carrega todas as dependencias do site

use \Slim\Slim; //chama a classe Slim 
use \Hcode\Page; //chama da classe Page

$app = new Slim(); //instanciando a classe slim

$app->config('debug', true);

$app->get('/', function() {

	$page = new Page();

	$page->setTpl("index"); //chamando o conteudo da pagina
});

$app->run(); //roda todo o codigo depois de ter carregado tudo

 ?>
