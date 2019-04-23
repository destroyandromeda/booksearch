<?php

Class Model_Genres Extends Model_Base {

    public $id;
    public $genre;

    public function fieldsTable(){
        return array(
            'id' => 'id',
            'genre' => 'genre',
        );
    }

}