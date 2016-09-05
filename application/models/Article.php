<?php

class Article extends ModelTable {

    const WAIT = 1;
    const PUBLISHED = 0;
    
    static $table = 'article';
    public $safe = array('id', 'img', 'title', 'text', 'url', 'meta_title',
                         'meta_keywords', 'meta_description', 'wait', 'time');
    
    public $commentsCount = 0;
    
    public function calculateComments(){
        $this->commentsCount = Comment::countRowWhere('id_article = ? AND wait = ?', array($this->id, self::PUBLISHED));
    }

}
