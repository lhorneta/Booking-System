<?php
class Review extends ModelTable{
    static $table = 'review';
    public $safe = array('id', 'parent', 'id_lot', 'id_user', 'id_reviewer', 'vote', 'title', 'text', 'time', 'reposted');
}