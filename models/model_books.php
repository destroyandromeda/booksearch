<?php

Class Model_Books Extends Model_Base {
	
	public $id;
	public $name;
	public $description;
	public $cover;



	public function fieldsTable(){
		return array(
			'id' => 'id',
			'name' => 'name',
			'description' => 'description',
			'cover' => 'cover',

		);
	}
	
}