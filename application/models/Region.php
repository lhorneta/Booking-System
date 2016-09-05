<?php
class Region extends ModelTable {
	static $table = 'region';

	public $safe = array('id', 'title_ru', 'title_ua');

	public function outputTitle(){
		if(strtolower(App::gi()->uri->lang) !== 'ru'){
			return $this->title_en;
		} else {
			return $this->title_ru;
		}
	}
	

}