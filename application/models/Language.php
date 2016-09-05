<?php
class Language extends ModelTable {
	static $table = 'language';
	public $safe = array('id', 'title', 'url');
}