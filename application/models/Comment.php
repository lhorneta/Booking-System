<?php
class Comment extends ModelTable{
    
    const WAIT = 1;
    const PUBLISHED = 0;
    
    static $table = 'comment';
    public $safe = array('id', 'id_blog', 'parent', 'status', 'id_user', 'text', 'dateadd');
    
    public $user = '';
    public $img = '';
    public $date = '';
    public $replies = array();
    
    public function takeUserInfo(){
        $owner = User::model($this->id_user);
        if($owner){
            $this->user = $owner->name;
            $this->img = $owner->avatar;
        }
    }
    
    public function takeDate(){
        $this->date = date('Y/m/d в H:i',$this->time);
    }
    
    public function takeReplies(){
        $this->replies = Comment::modelsWhere('id_reply = ?', array($this->id));
        if(count($this->replies)){
            foreach ($this->replies as $reply){
                $reply->takeReplies();
            }
        }else{
            return;
        }
    }
    
    public function outputReplies(){
        if(count($this->replies)){
            foreach ($this->replies as $reply){
                $reply->takeReplies();
            }
        }
    }
    
}
