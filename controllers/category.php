<?php
// контролер
Class Controller_Category Extends Controller_Base {
	
	// шаблон
	public $layouts = "first_layouts";
	
	// экшен
	function index() {
		$idCategory = (isset($_GET['id'])) ? (int)$_GET['id'] : false;
		if($idCategory){
			$select = array(
				'where' => "is_active = 1 AND id_category = $idCategory", // условие
				'order' => 'date_create DESC' // сортируем
			);
			$model = new Model_Article($select); // создаем объект модели
			$articles = $model->getAllRows(); // получаем все строки
		}else{
			$articles = false;
		}
		
		$this->template->vars('articles', $articles);
		$this->template->view('index');
	}
	
}