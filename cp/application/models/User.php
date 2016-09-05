<?php
class User extends ModelTable {
    const ACTIVE = 1;
    const DEACTIVE = 0;
    const ADMIN = 1;
    
    private static $questions = array('Любимый мульт. персонаж', 'Кличка домашнего животного', 'Памятное событие', 'Любимый супер герой', 'Кодовое слово');

    static $table = 'admin';
    public $safe = array('id', 'id_role', 'fio', 'password', 'time', 'email',
                        'active', 'auth_token', 'question', 'answer');

    public $favoriteLots = array();
    
    function role(){
        return UserRole::model($this->_data->id_role);
    }
    
    public static function questions(){
        return self::$questions;
    }
    
    public function favorites(){
        $favorites = Favorite::modelsWhere('id_user = ?', array($this->id));
        if($favorites){
            foreach($favorites as $favorite){
                $this->favoriteLots[] = Lot::modelWhere('id = ?', array($favorite->id_lot));                
            }
        }        
    }
    
}
