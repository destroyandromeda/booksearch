<?php
// контролер
Class Controller_Article  Extends Controller_Base {
	
	// шаблон
	public $layouts = "first_layouts";

	// экшен
	function index() {
		$idArticle = (isset($_GET['id'])) ? (int)$_GET['id'] : false;
		if($idArticle){
			$select = array(
				'where' => "id = $idArticle" // условие
			);
			$model = new Model_Article($select); // создаем объект модели
			$article = $model->getOneRow(); // получаем статью
		}else{
			$article = false;
		}
		
		$this->template->vars('article', $article);
		$this->template->view('index');
	}
	
}