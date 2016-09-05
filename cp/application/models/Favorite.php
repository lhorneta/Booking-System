<?php
class Favorite extends ModelTable{
    static $table = 'favorite';
    public $safe = array('id', 'id_user', 'id_owner', 'id_lot');
    
    public $userEmails = array();
    public $lotUrls = array();
    
    public function users(Lot $lot){
        $favorites = self::modelsWhere('id_lot = ?', array($lot->id));
        if($favorites){
            foreach($favorites as $favorite){
                $this->userEmails[] = UserFront::modelWhere('id = ?', array($favorite->id_user))->email;                
            }
        }
    }
    
    public function lots(User $user){
        $favorites = self::modelsWhere('id_user = ?', array($user->id));
        if($favorites){
            foreach($favorites as $favorite){
                $this->lotUrls[] = Lot::modelWhere('id = ?', array($favorite->id_lot))->url;                
            }
        }        
    }
}
