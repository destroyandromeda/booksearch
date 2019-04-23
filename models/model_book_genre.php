<?php

Class Model_Book_Genre Extends Model_Base {

    public $id;
    public $book;
    public $genres;

    public function fieldsTable(){
        return array(
            'id' => 'id',
            'book' => 'book',
            'genres' => 'genres',
        );
    }

}