<?php
class User extends ModelTable {
    
    const ACTIVE = 0;
    const DEACTIVE = 1;
    const SUBSCRIBER = 1;
    const USER = 2;
    const BUSINESS = 3;
    const UPLOAD_DIR = '/uploads/user/';
    
    public static $table = 'user';
    public $safe = array('id', 'id_role', 'auth_token', 'name','company_name', 'id_region',
                        'surname', 'password', 'gender', 'email','company_email', 'id_city',
                        'register_time', 'birthday', 'description','description_comp', 'avatar',
                        'location', 'mark', 'vote_count', 'appeal', 'hash_time', 'hash',
                        'phone0', 'phone1', 'phone2', 'phone3', 'phone4', 'bane', 'confirmed','show_all_adresses');
    public $newBooked = array();
    public $oldBooked = array();
    public $lots = array();
    public $archiveMessages;
    public $reciveMessages = array();
    public $sendMessages = array();
    public $reviewsToUser = array();
    public $reviews = array();
    public $favoriteLots = array();
//    public $sendMessages = array();
//    public $reciveMessages = array();
    public $reviewsCount = 0;
    public $position = null;
    public $role = '';
    
    public function takeRole(){
        $this->role = Role::model($this->id_role)->title_ru;
    }
    
    public function takePosition(){
        $this->position = Location::model($this->location);
    }
    public function countReviews(){
        $this->reviewsCount = Review::countRowWhere('id_user = ?', array($this->id));
    }
    public function userNewBooking() {
        $this->newBooked = Booking::modelsWhere('id_to = ? AND start_rent > ?', array($this->id, time()));
    }
    
    public function userOldBooking() {
        $this->oldBooked = Booking::modelsWhere('id_to = ? AND start_rent < ?', array($this->id, time()));
    }
    
    public function userLots(){
        $this->lots = Lot::modelsWhere('id_user = ?', array($this->id));
        if(count($this->lots)){
            foreach($this->lots as $lot){
                $lot->countLotMessages();
                $lot->takeOneImage();
            }
        }
    }
    
    public function userReviews(){
        $this->reviews = Review::modelsWhere('id_reviewer = ?', array($this->id));
    }
    
    public function toUserReviews(){
        $this->reviewsToUser = Review::modelsWhere('id_user = ?', array($this->id));
    }
//    Все входящие сообщения для конкретного лота
    public function takeReciveLotMessages($lot_id){
        $lot = Lot::model($lot_id);
        if($lot){
            $this->reciveMessages = Message::modelsWhere('id_to = ? AND id_lot = ? AND archive = ? ORDER BY time ', array($this->id, $lot->id, Message::NOT_ARCHIVE));
            if(count($this->reciveMessages)){
                foreach($this->reciveMessages as $recive){
                    $recive->lotInfo();
                    $recive->fromInfo();
                    if($recive->booked != Message::NOT_BOOKED){
    //                    debug($recive);
                        $recive->text = Booking::model($recive->booked)->text;
    //                    debug($recive);
                    }
                }
            }else{
                $this->reciveMessages['error'] = 'Нет полученных сообщений для данного лота';
            }
        }
    }
	//    Все входящие только текстовые сообщения для конкретного лота
    public function takeReciveLotTextFirstMessage($lot_id){
        $lot = Lot::model($lot_id);
        if($lot){
            $this->reciveMessages = Message::modelsWhere('id_to = ? AND id_lot = ? AND archive = ? AND booked=0 ORDER BY time ', array($this->id, $lot->id, Message::NOT_ARCHIVE));
            if(count($this->reciveMessages)){
                foreach($this->reciveMessages as $recive){
                    $recive->lotInfo();
                    $recive->fromInfo();
                    if($recive->booked != Message::NOT_BOOKED){
    //                    debug($recive);
                        $recive->text = Booking::model($recive->booked)->text;
    //                    debug($recive);
                    }
                }
            }else{
                $this->reciveMessages['error'] = 'Нет полученных сообщений для данного лота';
            }
        }
    }
//    Все исходящие сообщения для конкретного лота
    public function takeSendLotMessages($lot_id){
        $lot = Lot::model($id_lot);
        if($lot){
            $this->sendMessages = Message::modelsWhere('id_from = ? AND id_lot = ? AND archive = ? ORDER BY time', array($this->id, $lot->id, Message::NOT_ARCHIVE));
            if(count($this->sendMessages)){
                foreach($this->sendMessages as $send){
                    $send->lotInfo();
                    $send->fromInfo();
                }
            }else{
                $this->sendMessages['error'] = 'Нет отправленных сообщений для данного лота';
            }
        }
    }
//    Все зархивированные сообщения для конкретного лота
    public function takeArchiveLotMessages($lot_id){
        $lot = Lot::model($id_lot);
        if($lot){
            $this->archiveMessages = Message::modelsWhere('(id_to = ? OR id_from = ?) AND id_lot = ? AND archive = ? ORDER BY time', array($this->id, $this->id, $lot->id, Message::ARCHIVE));
            if(count($this->archiveMessages)){
                foreach($this->archiveMessages as $archive){
                    $archive->lotInfo();
                    $archive->toInfo();
                    $archive->fromInfo();
                }
            }else{
                $this->archiveMessages['error'] = 'Нет архивных сообщений для данного лота';
            }
        }
    }
    //Метод выборки всех сообщений для всех лотов конкретного пользователя
    public function messages(){
//        $this->reciveMessages = Message::modelsWhere('id_to = ? AND booked = ?', array($this->id, Message::NOT_BOOKED));
        $this->reciveMessages = Message::modelsWhere('id_to = ? AND archive = ?', array($this->id, Message::NOT_ARCHIVE));
        if(count($this->reciveMessages)){
            foreach($this->reciveMessages as $recive){
                $recive->lotInfo();
                $recive->fromInfo();
                if($recive->booked != Message::NOT_BOOKED){
                    //debug($recive);
		
                    //$recive->text = Booking::model($recive->booked)->text;
//                    debug($recive);
                }
            }
//                    die();
        }
        $this->sendMessages = Message::modelsWhere('id_from = ? AND booked = ? AND archive = ? ', array($this->id, Message::NOT_BOOKED, Message::NOT_ARCHIVE));
		//debug($this->sendMessages);
        //        $this->sendMessages = Message::modelsWhere('id_from = ?', array($this->id));
        if(count($this->sendMessages)){
            foreach($this->sendMessages as $send){
                $send->lotInfo();
                $send->toInfo();
            }
        }
        
        $this->archiveMessages = Message::modelsWhere('(id_from = ? OR id_to = ?) AND archive = ?', array($this->id, $this->id, Message::ARCHIVE));
//        $this->sendMessages = Message::modelsWhere('id_from = ?', array($this->id));
        if(count($this->archiveMessages)){
            foreach($this->archiveMessages as $archive){
                $archive->lotInfo();
                $archive->toInfo();
                $archive->fromInfo();
            }
        }
    }
    
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
    	if ($id) {
    		$res = self::model((int)$id);
			if (isset($res->email)) return $res->email;
			//debug($res);
    	} else {
    		return false;
   		}
    }
    
    public function takeImage() {
        $image = '';
        if(is_file($_SERVER['DOCUMENT_ROOT'] . self::UPLOAD_DIR . $this->id . $this->avatar) && $this->avatar != '') {
            $image = $this->avatar;
        }
        return $image;
    }
 
    public static function saveImage(User $user, $file) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . User::UPLOAD_DIR . $user->email . '/';
        if (!file_exists($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                die('Не удалось создать: ' . $upload_dir);
            }
        }
        
        die();
        if(!empty($file['name'])){
            $fileName = 'avatar';
            $type = explode('/', $file['type']);
            $fileName .= '.'.$type[1];
            move_uploaded_file($file['tmp_name'], $upload_dir . $fileName);
            $user->avatar = $fileName;

//            $image = new Image();
//            $image->load($upload_dir.$fileName);
//            $image->resize(135,135);
//            $image->resizeToWidth(175);
            
//            switch($type[1]){
//                case 'jpg':
//                    $image->keep($upload_dir . 'resized.'.$type[1]);
//                    break;
//                case 'png':
//                    $image->keep($upload_dir . 'resized.'.$type[1], IMAGETYPE_PNG);
//                    break;
//                case 'gif':
//                    $image->keep($upload_dir . 'resized.'.$type[1], IMAGETYPE_GIF);
//                    break;
//            }
        }
        return $user->save();
//        return;
    }
}
