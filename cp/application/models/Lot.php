<?php
class Lot extends ModelTable{
    
    const REGULAR = 0;
    
    public static $table = 'lot';
    public $safe = array('id', 'id_user', 'id_category', 'title', 'url', 'type', 'location',
                        'description', 'user_type', 'post_type', 'special_provisio', 'rental_terms',
                        'status', 'state', 'deposit', 'day_payment', 'week_payment', 'month_payment',
                        'mark', 'vote_count', 'img0', 'img1', 'img2', 'img3', 'img4', 'img5', 'img6', 'img7', 'time');
    
    public $userName = '';
    public $userEmail = '';
    public $category = '';
    public $favoriteEmails = array();
    
    public function userInfo(){
        $user = UserFront::modelWhere('id = ?', array($this->id_user));
        if($user){
            $this->userName = $user->name.' '.$user->surname;
            $this->userEmail = $user->email;
        }else{
            $this->userName = 'No user on this lot';
            $this->userEmail = 'No user on this lot';            
        }
    }
    
    public function categoryInfo(){
        $category = Category::modelWhere('id = ?', array($this->id_category));
        if($category){
            $this->category = $category->title;
        }else{
            $this->category = 'No category on this lot';    
        }
    }
    
    public function favorites(){
        $favorites = Favorite::modelsWhere('id_lot = ?', array($this->id));
        if($favorites){
            foreach($favorites as $favorite){
                $this->favoriteEmails[] = UserFront::modelWhere('id = ?', array($favorite->id_user))->email;                
            }
        }
    }
    
    public static function outputTitle($id){
        return self::model((int)$id)->title;
    }
}