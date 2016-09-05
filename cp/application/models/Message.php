<?php
class Message extends ModelTable{
    static $table = 'message';
    public $safe = array('id', 'id_to', 'id_lot', 'id_from', 'booked', 'text', 'file');
    
}
