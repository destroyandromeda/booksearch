<?php
// контролер
Class Controller_Books Extends Controller_Base {

    // шаблон
    public $layouts = "first_layouts";

    // экшен
    function index() {

        //если убрать, то берет название контроллера
        function getTableName() {
            return 'books';
        }
        $table=getTableName();
        //до сюда

        /*
         * $select = array(
            'where' => 'id >= 1', // условие
        );
        */

        $select_from_books = "SELECT * FROM $table "; //sql запрос к бд
        $model = new Model_Books($select_from_books); // создаем объект модели
        $books = $model->getAllRows(); // получаем все строки



        $this->template->vars('books', $books);
        $this->template->view('index');
    }

}