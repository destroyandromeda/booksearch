<?php

Class Model_Authors Extends Model_Base {

    public $id;
    public $full_name;

    public function fieldsTable(){
        return array(
            'id' => 'id',
            'full_name' => 'full_name',
        );
    }

}