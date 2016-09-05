<?php
class Calendar extends ModelTable{
    static $table = 'calendar';
    public $safe = array('id', 'id_to', 'id_from', 'id_lot', 'start_rent', 'end_rent', 'start', 'end');
}