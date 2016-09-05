<?php
class UserFront extends ModelTable {
    const ACTIVE = 0;
    const DEACTIVE = 1;
    const SUBSCRIBER = 1;
    
    public static $table = 'user';
    public $safe = array('id', 'id_role', 'auth_token', 'name', 'id_region',
                        'surname', 'password', 'gender', 'email', 'id_city',
                        'register_time', 'birthday', 'description', 'avatar',
                        'location', 'mark', 'vote_count', 'appeal',
                        'phone0', 'phone1', 'phone2', 'phone3', 'phone4', 'bane', 'confirmed');
    public $lots = array();
    public $reviewsToUser = array();
    public $reviews = array();
    public $favoriteLots = array();
     
    public function userLots(){
        $this->lots = Lot::modelsWhere('id_user = ?', array($this->id));
    }
    
    public function userReviews(){
        $this->reviews = Review::modelsWhere('id_reviewer = ?', array($this->id));
    }
    
    public function toUserReviews(){
        $this->reviewsToUser = Review::modelsWhere('id_user = ?', array($this->id));
    }
    
//    public function userInformation(){
//        $this->lots = Lot::modelsWhere('id_user = ?', array($this->id));
//    }
    
    
    function role(){
        return UserRole::model($this->_data->id_role);
    }
        
    public function favorites(){
        $favorites = Favorite::modelsWhere('id_user = ?', array($this->id));
        if($favorites){
            foreach($favorites as $favorite){
                $this->favoriteLots[] = Lot::modelWhere('id = ?', array($favorite->id_lot));                
            }
        }        
    }
    
    public static function outputEmail($id){
        return self::model((int)$id)->email;
    }
}
