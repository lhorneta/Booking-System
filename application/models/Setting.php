<?php
class Setting extends ModelTable{
    
    const HIDE = 0;
    
    static $table = 'settings';
    public $safe = array('id', 'id_user', 'show_deactive', 'hide_address');
}