<?php
class Lot extends ModelTable{
    
    const REGULAR = 0;
    const VIP = 1;
    const FRESH = 0;
    const USED = 1;
    const COUNT_IMG_FIELDS = 8;
    const UPLOAD_DIR = '/uploads/lot/';
    
    public static $table = 'lot';
    public $safe = array('id', 'id_user', 'id_category', 'title', 'url', 'type', 'location', 'id_region', 'id_city',
                        'description','condition_title','user_type', 'post_type', 'special_provisio', 'rental_terms',
                        'status', 'state', 'deposit', 'day_payment', 'week_payment', 'month_payment',
                        'mark', 'vote_count', 'img0', 'img1', 'img2', 'img3', 'img4', 'img5', 'img6', 'img7', 'time','name','last_name', 'email','phones','longitude','latitude','address','currency','show_address');
    
    public $owner = '';
    public $user = '';
    public $reviewsCount = 0;
	public $rating = 0;
	public $user_rating = 0;	
    public $reviews = 0;
    public $userName = '';
    public $userEmail = '';
    public $category = '';
    public $favoriteEmails = array();
    public $messages = array();
    public $images = array();
    public $mainImage = '';
    public $lotMessagesCount = 0;
    public $username = '';
    public $staticValues = array();
    public $dynamicValues = array();
    public $staticUrls = array();
    public $dynamicUrls = array(); 
    
    public function takeAllAttributeValues(){
        $staticAttributes = SelectedAttributeValue::modelsWhere('id_lot = ? AND id_static_attribute_value <> ?', array($this->id, Constants::ZERO));
        if(count($staticAttributes)){
            foreach($staticAttributes as $attrS){
                $attributeGroup = Attribute::model($attrS->id_attribute);
                if($attributeGroup){
                    $this->staticValues[$attributeGroup->title] = StaticAttributeValue::modelWhere('id_attribute = ? AND id = ?', array($attrS->id_attribute, $attrS->id_static_attribute_value))->value;
                } 
            }
        }
        $dynamicAttributes = SelectedAttributeValue::modelsWhere('id_lot = ? AND id_static_attribute_value = ?', array($this->id, Constants::ZERO));
        if(count($dynamicAttributes)){
            foreach($dynamicAttributes as $attrD){
                $attributeGroup = Attribute::model($attrD->id_attribute);
                if($attributeGroup){
                    $this->dynamicValues[$attributeGroup->title] = $attrD->dynamic_attribute_value.' '.$attributeGroup->units;
                }
            }
        }
    }
    /******************************************************************************/
    public function takeAllAttributeUrls(){
        $staticAttributes = SelectedAttributeValue::modelsWhere('id_lot = ? AND id_static_attribute_value <> ?', array($this->id, Constants::ZERO));
        if(count($staticAttributes)){
            foreach($staticAttributes as $attrS){
                $attributeGroup = Attribute::model($attrS->id_attribute);
                if($attributeGroup){
                    //$this->$staticUrls[$attributeGroup->url] = StaticAttributeValue::modelWhere('id_attribute = ? AND id = ?', array($attrS->id_attribute, $attrS->id_static_attribute_value))->url;
                } 
            }
        }
        $dynamicAttributes = SelectedAttributeValue::modelsWhere('id_lot = ? AND id_static_attribute_value = ?', array($this->id, Constants::ZERO));
        if(count($dynamicAttributes)){
            foreach($dynamicAttributes as $attrD){
                $attributeGroup = Attribute::model($attrD->id_attribute);
                if($attributeGroup){
                    //$this->$dynamicUrls[$attributeGroup->url] = $attrD->dynamic_attribute_value;
                }
            }
        }
    }
    /******************************************************************************/
    public function getUserName($user_id){
       $user = User::modelWhere('id = ?', array($user_id));
	   $this->username = $user->name;
    }
    public function countLotMessages(){
        $this->lotMessagesCount = Message::countRowWhere('id_lot = ?', array($this->id));
    }
	public function countLotNewMessages(){
        $this->lotMessagesCount = Message::countRowWhere('id_lot = ? AND new = ?', array($this->id, 1));
    }
    public function countReviews(){
        $this->reviewsCount = Review::countRowWhere('id_lot = ?', array($this->id));
    }
	
	public function getVotes($lot_id){
        $sql = "SELECT avg(rating) as vote FROM (SELECT `vote` as rating FROM `review` WHERE `id_lot` = '".$lot_id."') as rating";
		$rating = Review::modelsQuery($sql,array());
		$this->rating = round($rating[0]->vote/2,1, PHP_ROUND_HALF_DOWN);
    }
		
	public function getUserRating($user_id){
        $sql = "SELECT avg(rating) as vote FROM (SELECT `vote` as rating FROM `review` WHERE `id_user` = '".$user_id."') as rating";
		$user_rating = Review::modelsQuery($sql,array());
		$this->user_rating = round($user_rating[0]->vote/2,1, PHP_ROUND_HALF_DOWN);
    }
	
    public function takeReviews(){
        $this->reviews = Review::modelsWhere('id_lot = ?', array($this->id));
    }
    public function userInfo(){
        $user = User::modelWhere('id = ?', array($this->id_user));
        if($user){
            $this->userName = $user->name.' '.$user->surname;
            $this->userEmail = $user->email;
        }else{
            $this->userName = 'No user on this lot';
            $this->userEmail = 'No user on this lot';            
        }
    }
    //Метод выборки всех сообщений привязаных к данному лоту
    public function messages(){
        $messages = Message::modelsWhere('id_lot = ? ORDER BY time', array($this->id));
        if(count($messages)){
            foreach($messages as $message){
                $user = User::model($message->id_from);
                if($user){
                    $this->messages[] = array($user->name, $message);
                }
            }
        }
        
    }
    //Метод выборки всех сообщений привязаных к данному лоту с учетом пользователей
    public function messagesDialog(User $owner, User $user){

        $this->messages = Message::modelsWhere('id_lot = ? AND (id_to = ? AND id_from = ? OR id_to = ? AND id_from = ?) ORDER BY time', array($this->id, $owner->id, $user->id, $user->id, $owner->id));
        if(count($this->messages)){
            foreach($this->messages as $message){
                if($message->booked != Message::NOT_BOOKED){
                	//var_dump(Booking::model($message->booked));
					if (Booking::model($message->booked)) {
						$message->text = Booking::model($message->booked)->text;
					} else {
						$message->text  = '';
					}
                   
                }
                $message->lotInfo();
                $message->bookingInfo();
				if(isset($message->id_from)){
	               $user = User::model($message->id_from);
	               if($user){
	                   $this->messages[] = array($user->name, $message);
	               }
				}
            }
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
    	//return self::model((int)$id)->title;
		return self::model((int)$id['title']);
		
    }
    public function takeOneImage() {
        $image = 'img';        
        for($i = 0; $i < self::COUNT_IMG_FIELDS; $i++){
            $image .= $i;
            if(is_file($_SERVER['DOCUMENT_ROOT'] . self::UPLOAD_DIR . $this->url . '/' . $this->$image) && $this->$image != '') {
//                debug($this->images);
//                debug($this->$image);
                $this->mainImage = $this->$image;
                return ;
            }
        }
    }
    public function takeImages() {
        $image = 'img';
        $j=0;
        $pictures = Picture::modelsWhere('id_lot = ?', array($this->id));
//        foreach($pctures as $picture){
        for($i = 0; $i < self::COUNT_IMG_FIELDS; $i++){
            $image .= $i;
            
//            if(is_file($_SERVER['DOCUMENT_ROOT'] . self::UPLOAD_DIR . $this->url . '/' . $picture->pic) && $picture->pic != '') {
            if(is_file($_SERVER['DOCUMENT_ROOT'] . self::UPLOAD_DIR . $this->url . '/' . $this->$image) && $this->$image != '') {
               //debug($this->images);
//                debug($this->$image);
//                $this->images[] = $picture->pic;
                $this->images[] = $this->$image;
            }
        }
    }
    
    public static function saveImages(Lot $lot, $files) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . Lot::UPLOAD_DIR . $lot->url . '/';
        if (!file_exists($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                die('Не удалось создать: ' . $upload_dir);
            }
        }
        $key = '';

        for($i = 0; $i < self::COUNT_IMG_FIELDS; $i++){

            if(!empty($files['name'][$i])){

//                debug($files);
                $key = 'img';
                $key .= (string) $i;
                $fileName = (string)$i;
                $type = explode('/', $files['type'][$i]);

                $fileName .= '.'.$type[1];
                move_uploaded_file($files['tmp_name'][$i], $upload_dir . $fileName);
                
//                $picture = new Picture();
//                $picture->id_lot = $lot->id;
//                $picture->pic = $fileName;
//                $picture->save();
                
                $lot->$key = $fileName;

//                $image = new Image();
//                $image->load($upload_dir.$fileName);
//                $image->resize(135,135);
//                $image->resizeToWidth(250);
//                switch($type[1]){
//                    case 'jpg':
//                        $image->keep($upload_dir . 'resized.'.$type[1]);
//                        break;
//                    case 'png':
//                        $image->keep($upload_dir . 'resized.'.$type[1], IMAGETYPE_PNG);
//                        break;
//                    case 'gif':
//                        $image->keep($upload_dir . 'resized.'.$type[1], IMAGETYPE_GIF);
//                        break;
//                }
            }
        }
        return $lot->save();
//        return;
    }

    public static function saveimg(Lot $lot=null, $files) {

            $res = array();
            $link = '';
            if(isset($lot)){$link = $lot->url;}else{$link = 'temp';}

            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . Lot::UPLOAD_DIR . $link . '/';

            if (!file_exists($upload_dir)) {
                if (!mkdir($upload_dir, 0777, true)) {
                    die('Не удалось создать: ' . $upload_dir);
                }
            }
            
            $key = '';
            if ($files) {
                foreach ($files as $key => $f) {
                    $fileName = $key;
                    $type = explode('/', $f['type']);
            //debug($f);
                    $fileName .= '.'.$type[1];
                    move_uploaded_file($f['tmp_name'], $upload_dir . $fileName);
                    
                    $res['img'] = $fileName;
                    if(isset($lot)){$res['path'] = $lot->url;}else{$res['path']='temp';}

                }
                
            }

            $callback = json_encode($res, true);
            return $callback;
    }

    public static function deleteimg(Lot $lot=null, $filename) {
        
        $res = array();
        $link = '';
        if(isset($lot)){$link = $lot->url;}else{$link = 'temp';}
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . Lot::UPLOAD_DIR . $link . '/';

        if ($filename) {
            unlink($upload_dir . $filename);
            $res['result'] = $filename.' was deleted';
        }

        $callback = json_encode($res, true);
        return $callback;
        
    }
	
	
	public static function myvote($id=0) {
		$res = 0;
		
		$user = App::gi()->user;
		if ($user) {
			$vote = Vote::modelWhere('id_review = ? AND id_user = ?', array($id, $user->id));
			if ($vote) {
				if ($vote->vote==1) {
					$res=1;
				} else {
					$res=2;
				}
			}
		}
		return $res;
	}
	
	public static function votes($id=0)	{
		$res = (object) array('all'=>0, 'quantity'=>0, 'percent'=>0);
		$votes = Vote::modelsWhere('id_review = ?', array($id));
		$all = count($votes);
		if ($all>0) {
			$val1=0; $val2=0;
			foreach ($votes as $k => $v) {
				if ($v->vote==1) {
					$val1++;
				} else {
					$val2++;
				}
			}
			
			$s = ($val1*100)/$all;
			$value1 = round($s);
			$value2 =round(100-$s);
			
			$res = (object) array(
				'all' => $all,
				'quantity' => array(1=>$val1, 2=>$val2),
				'percent' => array(1=>$value1, 2=>$value2)
			);
		} else {
			$res = (object) array(
				'all' => $all,
				'quantity' => array(1=>0, 2=>0),
				'percent' => array(1=>50, 2=>50)
			);
		}
		
		return $res;
	}
	
	
}