<?php
// контролер
Class Controller_Authors Extends Controller_Base {

    // шаблон
    public $layouts = "first_layouts";

    // экшен
    function index() {

        //если убрать, то берет название контроллера
        function getTableName() {
            return 'authors';
        }
        $table=getTableName();
        //до сюда

        /*
         * $select = array(
            'where' => 'id >= 1', // условие
        );
        */

        $select_from_authors = "SELECT * FROM $table "; //sql запрос к бд
        $model1 = new Model_Authors($select_from_authors);
        $authors = $model1->getAllRows();

        $this->template->vars('authors', $authors);
        $this->template->view('index');
    }

}