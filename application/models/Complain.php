<?php

class Complain extends ModelTable {

    static $table = 'complain';
    public $safe = array('id_user', 'id_complainer');
    
}
