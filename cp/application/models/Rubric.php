<?php
class Rubric extends ModelTable{
    static $table = 'rubrics';
    public $safe = array('id', 'url', 'meta_t', 'meta_k', 'meta_d', 'title','description','date_add');
}