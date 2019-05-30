<?php 

namespace Hcode;

class PageAdmin extends Page { //vira uma extensão da class Page, herando todos os atributos

	public function __construct($opts = array(), $tpl_dir = "/views/admin/"){ //metodo construtor com as variações para esse classe

		parent::__construct($opts, $tpl_dir); //usando o metodo construtor da classe Page, passando comente os paramentros.
	}
}

?>