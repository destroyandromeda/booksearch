<?php

Class Model_Book_Author Extends Model_Base {

    public $id;
    public $book;
    public $author;

    public function fieldsTable(){
        return array(
            'id' => 'id',
            'book' => 'book',
            'author' => 'author',
        );
    }

}