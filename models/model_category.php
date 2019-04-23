<?php

Class Model_Category Extends Model_Base {
	
	public $id;
	public $name;
	public $is_active;
	
	public function fieldsTable(){
		return array(
			
			'id' => 'Id',
			'name' => 'Name',
			'is_active' => 'Is Active',

		);
	}
	
}