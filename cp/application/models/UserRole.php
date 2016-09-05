<?php
class UserRole extends ModelTable {
    static $table = 'role';
    public $safe = array('id', 'title');
    
}

