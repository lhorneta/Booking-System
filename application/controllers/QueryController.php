<?php

class QueryController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('*')
        ),
        'bookingdenied' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'bookingconfirm' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'getregions' => array(
            'users' => array('*')
        ),
        'getcitiesbyregionid' => array(
            'users' => array('*')
        ),
        'getattrbycatId' => array(
            'users' => array('*')
        ),
        'getattrbycatIdInputs' => array(
            'users' => array('*')
        ),
        'messagestolot' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'messagestoauthor' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'showmorelots' => array(
            'users' => array('*'),
            'redirect' => '/'
        ),
        'complain' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'getsubcat' => array(
            'users' => array('*')
        ),
        'getbreadcrumbs' => array(
            'users' => array('*')
        ),
        'getbreadcrumbsonlyone' => array(
            'users' => array('*')
        ),
        'reg' => array(
            'users' => array('*')
        ),
        'sendconfirmationmail' => array(
            'users' => array('*'),
        )
		 
    );

    function __construct() {
        parent::__construct();
        $this->layout = 'clear';
        $this->mainTemplate = 'clear';
    }

    function actionIndex() {
        
    }
    //Метод отображения переписки между пользователями по конкретному лоту
    public function actionMessagesToLot($lot = 0, $user = 0){
 		$u = App::gi()->user;
        $lot = Lot::model((int)$lot);
        if(!$lot){
            echo 'В базе данных отсутствует такой лот';
            return;
        }
        
        $owner = User::model((int)$lot->id_user);
        if(!$owner){
            echo 'В базе данных отсутствует такой пользователь';
            return;
        }

		$user_id = $user;
		//echo $owner->id, $user;
		if ($owner->id==$user) {
			$user=$u;
		} else {
			$user = User::model((int)$user);
		}
		$user->takeReciveLotTextFirstMessage($lot->id);

		if(isset($user->reciveMessages) && (array)$user->reciveMessages && !isset($user->reciveMessages['error'])){
			$firstMessage = $user->reciveMessages[0];
		}else{$firstMessage = null;}
		
		$text = Message::modelsWhere('id_from = ? AND id_lot = ? AND text!=\'\'', array($user->id, $lot->id));
		$messages = Message::modelsWhere('((id_to=? AND id_from = ? AND id_lot = ?) OR (id_to=? AND id_from = ? AND id_lot = ?)) AND booked !=0 AND text!=\'\'', array($owner->id, $user->id, $lot->id, $user->id, $owner->id, $lot->id));
		foreach ($text as $key => $message) {
			$message->new = 0;
			$message->save();
		}

		$lot->getUserName($user->id);
		$lot->messagesDialog($owner, $user);
        $lot->takeOneImage();
        $lot->owner = &$owner;
		$user = App::gi()->user;
        $lot->user = &$user;

        $this->render('dialog', array('lot'=>$lot,'text'=>$text,'user_id'=>$user_id, 'firstMessage'=>$firstMessage));
    }
	//Метод отображения переписки между пользователями (сообщение автору)
    public function actionMessagesToAuthor($user_id = 0){
        
		$user = User::model((int)$user_id);
		$owner = App::gi()->user;
		$ownername = getUserName($owner->id);
		$username = getUserName($user->id);
		
		$messages = Message::modelsWhere('(id_to=? AND id_from = ? OR id_to=? AND id_from = ?) AND booked =0 AND text!=\'\' GROUP BY id', array($owner->id, $user_id, $user_id, $owner->id));
		foreach ($messages as $key => $message) {
			$message->new = 0;
			$message->save();
		}
		
		if($owner && $user){
			$messagesToAuthor = $this->messagesDialog($owner, $user);
		}
		
        $this->render('dialog', array('messagesToAuthor'=>$messagesToAuthor,'user'=>$user, 'owner' => $owner,"ownername" => $ownername, "username" =>$username));
    }
	//Метод выборки всех сообщений пользователей
    public function messagesDialog(User $owner, User $user){
		
		if($owner && $user){
	        $messages = Message::modelsWhere('(id_to = ? AND id_from = ?) OR (id_to = ? AND id_from = ?) AND text!=\'\' ORDER BY time', array($owner->id, $user->id, $user->id, $owner->id));
	        
	        if(count($messages)){
	        	
	            foreach($messages as $key=>$message){
		            if(isset($message->id_from)){
		               $user = User::model($message->id_from);
		               if($user){
		                   $messages[] = array($user->name, $message);
		               }
		            }
				}
	        }
	
			return $messages;
		}
        
    }		
    //Мотод автоматической подгрузки картинки в личном кабинете
    function LoadAvatar($user_id = 0, $serializedFile = '') {
        $user = User::model($user_id);
        debug($serializedFile);
        $picture = unserialize($serializedFile);
        debug($picture);
        die();
        if($user and $picture){
            if(User::saveImage($user, $picture)){
                echo 'Все прошло прекрасно';
            }else{
                echo 'При сохранении произошла ошипочка какая-то';                
            }
        }else{
            echo 'Произошла катастрофа';
        }
    }
    //Метод подтверждения бронирования лота
    public function actionBookingConfirm($id_booking = 0){
    	$this->layout = 'clear';
        $this->mainTemplate = 'clear';
        $booking = Booking::model($id_booking);
        if($booking){
            $booking->confirmed = Booking::CONFIRMED;
            $booking->save();
			
			$mess = 'Поздравляем, ваше бронирование подтверждено: <a href="'.$_SERVER['HTTP_HOST'].'/page/orderview/'.$id_booking.'">ссылка на просмотр бронирования</a>';
			Constants::sendEmail($booking->id_from, $mess, Constants::BOOKING);
			echo json_encode(true);
        }
    }
    //Метод отклонения запроса на бронирование лота
    public function actionBookingDenied($id_booking = 0){
    	$this->layout = 'clear';
        $this->mainTemplate = 'clear';
        $booking = Booking::model($id_booking);
        if($booking){
            $booking->confirmed = Booking::DENIED;
            $booking->save();
			$lot = Lot::model($booking->id_lot);
			$mess = '<p style="margin-bottom: 10px;">К сожалению, ваше бронирование отклонено: <a href="'.$_SERVER['HTTP_HOST'].'/lot/view/'.$lot->url.'">ссылка</a></p>
			<p style="margin-bottom: 10%;">Но, вы не расстраивайтесь. Попробуйте еще раз найти то, что вам нужно: <a href="'.$_SERVER['HTTP_HOST'].'/search">в поиске</a></p>';
			Constants::sendEmail($booking->id_from, $mess, Constants::BOOKING);
			echo json_encode(true);
        }
        
    }
    //Метод отклонения запроса на бронирование лота
    public function actionComplain($id_user = 0){
        $user = User::model($id_user);
        if(!$user){
            $this->redirect('/error/404');
        }
        $complainer = App::gi()->user;
        if(!$complainer){
            $this->redirect('/error/404');            
        }
        
        $complain = Complain::modelWhere('id_user = ? AND id_complainer = ?', array($user->id, $complainer->id));
        if($complain){
            $this->mainTemplate = 'clear';
            echo 'Вы уже подавали жалобу на этого пользователя';
            return;
        }
        $complain = new Complain();
        $complain->id_user = $user->id;
        $complain->id_complainer = $complainer->id;
        $complain->save();
        $user->appeal += 1;
        $user->save();        
    }

    function actionGetRegions() {
        $regions = Region::models();
        $data = array();
        foreach ($regions as $region) {
            $data[] = array('id' => $region->id, 'name' => $region->outputTitle());
        }

        echo json_encode($data);
    }

    /**
     * Выборка городов под id региона
     * @param integer $id_country
     * @return json
     * */
    function actionGetCitiesByRegionId($id_region) {
        $cities = City::modelsWhere('id_region = ?', array($id_region));
        $data = array();
        foreach ($cities as $city) {
            $data[] = array('id' => $city->id, 'id_region' => $city->id_region, 'name' => $city->outputTitle(), 'center'=> $city->center);
        }
        echo json_encode($data);
    }
    
    function actionGetMessagesByLotId($id_lot, $messageType) {
        $user = App::gi()->user;
        if($user){
            switch($messageType){
                case Constants::RECIVE_MESSAGE_TYPE:
                    $user->takeReciveLotMessages($id_lot);
                    break;
                case Constants::SEND_MESSAGE_TYPE:
                    $user->takeSendLotMessages($id_lot);
                    break;
                default :
                    $user->takeArchiveLotMessages($id_lot);
                    break;
            }
//            $messages = Message::modelsWhere('id_lot = ? AND id_to = ? AND archive = ?', array($id_lot, $user->id, Message::NOT_ARCHIVE));
//            $data = array();
//            foreach ($messages as $message) {
//                $message->lotInfo();
//                $message->fromInfo();
//                $data[] = array('id' => $city->id, 'id_region' => $city->id_region, 'name' => $city->outputTitle());
//            }
//            echo json_encode($data);
        }
    }

    function actionGetSubCat($id_parent = 0) {
        if ($id_parent !== 0) {
            $sub_cats = Category::modelsWhere('id_parent = ?', array($id_parent));
            $data = array();
            foreach ($sub_cats as $cat) {
                $data[] = $cat->__attributes;
            }
            echo json_encode($data);
        }
    }

    function actionCookieSaved() {
        if (isset($_COOKIE['region']) && !empty($_COOKIE['region'])) {
            $regions = array();
            $selected_region = Region::model($_COOKIE['region']);
            if ($region) {
                $regions = Region::modelsWhere('id_country = ?', array($selected_region->id_country));
                $data = array();
                foreach ($regions as $region) {
                    $data = array('id' => $region->id, 'name' => $region->outputTitle(), 'id_country' => $region->id_country);
                }
                echo json_encode($data);
            }
        }
        echo 'error';
    }
	
	
	public function actionGetAttrByCatId($cat, $lot_id=0) {

        $attributes = Attribute::modelsWhere('id_category = ?', array($cat));
        $data = array();
		
		
        foreach ($attributes as $attr) {
        	
			$val = array();
			
        	if($attr->type=='static'){
				$values = SelectedAttributeValue::modelsWhere('id_lot=? AND id_attribute = ? AND dynamic_attribute_value =0', array($lot_id, $attr->id));
				if ($values) {
					foreach ($values as $k => $v) {
						$val[] = array(
							'id_static_attribute_value' => $v->id_static_attribute_value
						);
					}
				}	
				
	        	$values = StaticAttributeValue::modelsWhere('id_attribute = ?', array($attr->id));
	
				foreach ($values as $k => $v) {
					$val[] = array(
						'id' => $v->id,
						'id_attribute' => $v->id_attribute,
						'value' => $v->value,
						'url' => $v->url
					);
				}
				//debug($val);
				$type = ($attr->type=='static')? $attr->title:$attr->title;

	            $data[] = array(
					'id' => $attr->id,
					'id_category' => $attr->id_category,
					'title' => $type,
					'url' => $attr->url,
					'units' => $attr->units,
					'type' => $attr->type,
					'head' => $attr->head,
					'category' => $attr->category,
					'values' => $val
				);
			}
        }
		
        echo json_encode($data);
    }

	public function actionGetAttrByCatIdInputs($cat, $lot_id=0) {

        $attributes = Attribute::modelsWhere('id_category = ?', array($cat));
        $data = array();
		//debug($cat);
        foreach ($attributes as $attr) {
        	
			$val = array();
			if ($lot_id>0) {
				$values = SelectedAttributeValue::modelsWhere('id_lot=? AND id_attribute = ?', array($lot_id, $attr->id));
				
				foreach ($values as $k => $v) {
					$val[] = array(
						'id' => $v->id,
						'id_lot' => $v->id_lot,
						'id_attribute' => $v->id_attribute,
						'dynamic_attribute_value' => $v->dynamic_attribute_value,
						'id_static_attribute_value' => $v->id_static_attribute_value
					);
				}
				
				$values = StaticAttributeValue::modelsWhere('id_attribute = ?', array($attr->id));

				foreach ($values as $k => $v) {
					$val[] = array(
						'id' => $v->id,
						'value' => $v->value,
						'id_lot' => 0,
						'id_attribute' => $v->id_attribute,
						'dynamic_attribute_value' => 0,
						'id_static_attribute_value' => 0
					);
				}
			//	debug($val);
			} else {
				$values = StaticAttributeValue::modelsWhere('id_attribute = ?', array($attr->id));

				foreach ($values as $k => $v) {
					$val[] = array(
						'id' => $v->id,
						'value' => $v->value,
						'id_lot' => 0,
						'id_attribute' => $v->id_attribute,
						'dynamic_attribute_value' => 0,
						'id_static_attribute_value' => 0
					);
				}
			}
        	//echo json_encode($val);
			
			if($attr->type=='dynamic'){
	            $data[] = array(
					'id' => $attr->id,
					'id_category' => $attr->id_category,
					'title' => $attr->title,
					'url' => $attr->url,
					'units' => $attr->units,
					'type' => $attr->type,
					'head' => $attr->head,
					'category' => $attr->category,
					'values' => $val
				);
			}
        }

        echo json_encode($data);
    }

	// Показать все лоты на главной
	public function actionShowMoreLots($start=0,$step=30) {
		$this->layout = 'clear';
        $this->mainTemplate = 'clear';
		
        $lots = Lot::modelsWhere('post_type = 0 ORDER BY time DESC LIMIT ?, ?', array($start, $step));
        if(count($lots)){
            foreach($lots as $lot){
                $lot->takeImages();
				$lot->getVotes($lot->id);
            }
        }
		
		$all = Lot::countRowWhere('post_type = 0', array());
		$this->render('load', array('lots'=>$lots, 'all'=>$all));
    }
	
	public static function actionGetBreadcrumbs($id=0) {
		$res = '';
		if ($id>0) {
			$categories = Category::modelWhere('id = ?', array($id));
			if (isset($categories)&&$categories) {
				$c1 = $categories->title;
			}
			if (isset($categories)&&$categories) {
				$categories = Category::modelWhere('id = ?', array($categories->id_parent));
				if ($categories) {
					$c2 = $categories->title;
				}
			}
			if (isset($categories)&&$categories) {
				$categories = Category::modelWhere('id = ?', array($categories->id_parent));
				if ($categories) {
					$c3 = $categories->title;
				}
			}
			if (isset($c3)) {
				$res .= $c3;
			}
			
			if (isset($c2)) {
				$i = (isset($c3))?' <i>&gt;</i> ':'';
				$res .= $i.$c2;
			}
			
			if (isset($c1)) {
				$i = (isset($c2))?' <i>&gt;</i> ':'';
				$res .= $i.$c1;
			}
		}
		echo json_encode($res);
	}
	
	public static function actionGetBreadcrumbsOnlyOne($id=0) {
		$res = '';
		if ($id>0) {
			$categories = Category::modelWhere('id = ?', array($id));
			if (isset($categories)&&$categories) {
				$res = $categories->title;
			}
		}
		echo json_encode($res);
	}
	
	public function actionReg()	{
		$res = array('res'=>false, 'text'=>'Ошибка');
		$error = '';
		if (isset($_POST['form'])) {
			$user = new User();
			$user->__attributes = $_POST['form'];
            if (!User::isUnique('email', $_POST['form']['email'])) {
                $error = 'Введеный вами имейл уже зарегестрирован';
            }elseif ($_POST['form']['password'] !== $_POST['form']['passcheck']) {
                $error = 'Введенные вами пароли не совпадают';
            }
			
			if (!$error) {
				$user->confirmed = User::DEACTIVE;
	            $user->id_role = User::USER;
	            $user->register_time = time();
				
				if ($user->save()) {
	                $userSettings = new Setting();
	                $userSettings->id_user = $user->id;
	                $userSettings->show_deactive = Setting::HIDE;
	                $userSettings->hide_address = Setting::HIDE;
	                $userSettings->save();
					SendConfirmationMail($user->id);
	                $res = array('res'=>true, 'text'=>'');
	            }
			} else {
				$res = array('res'=>false, 'text'=>$error);
			}
			
		}
		
		echo json_encode($res);
	}

}
