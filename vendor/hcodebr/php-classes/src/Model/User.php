<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model {

	const SESSION = "User";

	public static function login($login, $password){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			":LOGIN"=>$login
		));

		if(count($results) === 0){

			throw new \Exception("Usuarios e senha noa existe");
			
		}

		$data = $results[0];

		if (password_verify($password, $data["despassword"]) === true){

			$user = new User();

			$user->setData($data); // função pertensente a classe Model.php

			$_SESSION[User::SESSION] = $user->getValues();

			return $user;

		}else{
			
			throw new \Exception("Error senha ou usuario incorretos");	
		}
	}
	public static function verifyLogin($inadmin = true){
		if(
			!isset($_SESSION[User::SESSION]) // Se a sessão nao for definida
			||
			!$_SESSION[User::SESSION] // Se a sessão estiver vazia
			||
			!(int)$_SESSION[User::SESSION]["iduser"] > 0 // verificadr se a consuta for vazia
			||
			(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin  // Verifica se o usuario é um administrador
		){
			header("Location: /admin/login"); //redimensiona se nao estiver logado...

			exit;
		}
	}
	public static function logOut(){

		session_destroy();

		header("Location: /admin/login");
	}
}

?>