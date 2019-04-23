<?php

Class Model_Comments Extends Model_Base {
	
	public $id;
	public $user_name;
	public $text;
	public $date_create;
	public $is_active;
	
	public function fieldsTable(){
		return array(
			
			'id' => 'Id',
			'user_name' => 'User Name',
			'text' => 'Text',
			'date_create' => 'Date Create',
			'is_active' => 'Is Active',

		);
	}
	
}