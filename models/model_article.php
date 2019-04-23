<?php

Class Model_Article Extends Model_Base {

    public $id;
    public $id_category;
    public $title;
    public $small_text;
    public $text;
    public $date_create;
    public $is_active;

    public function fieldsTable(){
        return array(

            'id' => 'Id',
            'id_category' => 'Id Category',
            'title' => 'Title',
            'small_text' => 'Small Text',
            'text' => 'Text',
            'date_create' => 'Date Create',
            'is_active' => 'Is Active',

        );
    }

}