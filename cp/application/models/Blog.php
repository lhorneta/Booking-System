<?php

class Blog extends ModelTable {

    const STATUS = 1;
    
    static $table = 'blog';
    public $safe = array(
     'id', 'url', 'meta_t', 'meta_k', 'meta_d', 'rubric', 'interesting',
     'best','title', 'mini_description', 'description', 'img', 'tags', 'date_add', 'status', 'views');
    
    public $commentsCount = 0;
	public $commentsAnswer = 0;
    public $comments = array();
    
    public function calculateComments(){
        $this->commentsCount = Comment::countRowWhere('id_blog = ?', array($this->id));
    }
	    
    public function calculateAnswers(){
        $this->commentsAnswer = Comment::countRowWhere('parent = ?', array($this->id));
    }

    public function takeComments(){
        $this->comments = Comment::modelsWhere('id_blog = ?', array($this->id));
    }
}
