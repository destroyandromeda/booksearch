<?php
// контролер
Class Controller_Genres Extends Controller_Base {

    // шаблон
    public $layouts = "first_layouts";

    // экшен
    function index() {

        //если убрать, то берет название контроллера
        function getTableName() {
            return 'genres';
        }
        $table=getTableName();
        //до сюда

        /*
         * $select = array(
            'where' => 'id >= 1', // условие
        );
        */

        $select_from_genres = "SELECT * FROM $table "; //sql запрос к бд
        $model = new Model_Books($select_from_genres); // создаем объект модели
        $genres = $model->getAllRows(); // получаем все строки

        $this->template->vars('genres', $genres);
        $this->template->view('index');
    }

}