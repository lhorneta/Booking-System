<?php
class Vote extends ModelTable {
	static $table = 'vote';
	
	public $safe = array('id', 'id_review', 'id_user', 'vote');

}