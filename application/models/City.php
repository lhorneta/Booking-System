<?php
class City extends ModelTable {
	static $table = 'city';
	
	public $safe = array('id', 'id_region', 'title_ru', 'title_ua', 'phone_code', 'center');

	public function outputTitle(){
		if(strtolower(App::gi()->uri->lang) !== 'ru'){
			return $this->title_en;
		} else {
			return $this->title_ru;
		}
	}

}