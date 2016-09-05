<?php
class Review extends ModelTable{
    static $table = 'review';
    public $safe = array('id', 'id_lot', 'id_user', 'vote', 'id_reviewer', 'text', 'time', 'status');
}