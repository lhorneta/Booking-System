<?php
class Picture extends ModelTable{
    static $table = 'picture';
    public $safe = array('id', 'id_lot', 'pic');
}