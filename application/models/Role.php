<?php
class Role extends ModelTable {
	static $table = 'role';	
	public $safe = array('id', 'title', 'title_ua', 'title_ru');


}