<?php

class Blog extends ModelTable {
    
    public static $table = 'blog';
    public $safe = array('id', 'url', 'meta_t', 'meta_k', 'meta_d', 'rubric', 'interesting', 'best', 'title', 'mini_description', 'description','img','tags','date_add','status','views');
    
}
