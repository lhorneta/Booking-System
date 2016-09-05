<?php

class MyprofileController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),        
        'favorite' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'tofavorite' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'addreview' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'addcomment' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'toarchiveauthor' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'alltoarchive' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'toarchive' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'toarchiveoutcoming' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'leavemessage' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'sortmessages' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ), 
        'refreshmessages' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'dialogmessage' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'dialogmessageanswer' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'messages' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'changepassword' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'changeemail' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'deleteavatar' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'deletefile' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'deletearchiveid' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'deletearchiveall' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'allouttoarchive' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),    
        'loadfilemessage' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),        
        'uploadphoto' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'editinfo' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'lotvote' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'updateorderscalendar' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'resolvebooking' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'rejectbooking' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'uservote' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'orderscalendar' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        )
    );
    
    //Метод отображения всех пользователей активированых и деактивированных
    public function actionIndex($flag = ''){
    	
        $user = App::gi()->user;

        if($user){
            $user->userLots();
//            $user->messagesToLots();
            $user->messages();
            $user->toUserReviews();
            $user->userReviews();
            $user->takePosition();
			//debug($user);
//            $avatar = $user->takeImage();
            $bookedPast = Booking::allPastBooking($user);
            $bookedFuture = Booking::allFutureBooking($user);
            $messagesArray = array_reverse($user->reciveMessages);
            $countNew = Message::countRowWhere('id_to = ? AND new = ?', array($user->id, Message::FRESH));
            $hold = 0;
            $showedr = array();
            $showeds = array();
            $showeda = array();
            $birthday = array();
            $birthArray = explode('/', $user->birthday);
            if($user->birthday != 0){
                $birthday = array('year'=>$birthArray[0], 'month'=>$birthArray[1], 'day'=>$birthArray[2]);
//                debug($birthday); die();
            }

            $this->render('index', array('user'=>$user, 'messagesArray'=>$messagesArray, 'new'=>$countNew, 'birthday'=>$birthday,
                                        'bookedPast'=>$bookedPast, 'bookedFuture'=>$bookedFuture,
                                        'showedr'=>$showedr, 'showeds'=>$showeds, 'hold'=>$hold,'flag'=>$flag));
        }else{
            $this->redirect('/error/404');
        }
    }

    //Метод удаления изображения пользователя(аватарки)
    public function actionDeleteAvatar(){
        $user = App::gi()->user;
		$this->mainTemplate = 'clear';
        if($user){
            // $user->avatar = '';
            // if($user->save()){
                // $this->redirect('/myprofile');
            // }
			@unlink($_SERVER['DOCUMENT_ROOT'] .$_POST['img']);
			echo json_encode($_SERVER['DOCUMENT_ROOT'] .$_POST['img']);
        }else{
            $this->redirect('/error/404');
        }
    }
    
    //Страница календарь заказов
    public function actionOrdersCalendar($url = ''){
    	
    	$user = App::gi()->user;
		
        if($user){
        	
	    	$lot = Lot::modelWhere('url = ?', array($url));
			$flag = null;

	        if($lot){
		    	$booking_arr = Booking::modelsWhere('id_to = ? AND id_lot = ?', array($user->id, $lot->id));
				
				if ($lot->id_user!=$user->id) {
					$this->redirect('/error/404');
				}
		
				if($booking_arr){
					
					$flag = true;
					$dates = array();
					$bookedPast = array();
					$bookedFuture = array();
					$authorBooking = array();
					
					$authorBooking = Booking::modelsWhere('id_to = ? AND id_from = ? AND id_lot = ? AND confirmed = 1', array($user->id, $user->id, $lot->id));
					
					foreach($booking_arr as $k => $item){

						if($item->id_from != $user->id){
							$item->takeInfoSend();
							$item->getUserName($item->id_from);

							if(date('Y-m-d',time()) > $item->start){
								$bookedPast[] = $item;
							}else if (date('Y-m-d',time()) <= $item->start){
								
								$bookedFuture[] = $item;
							}else{
								echo "error";
							}
							
						}
						
						$item->start = date('Y-m-d', strtotime($item->start));
						$item->end = date('Y-m-d', strtotime($item->end));
						
						if($item->confirmed ==1){
							$dates[] 	= array('from' => $item->start, 'to' => $item->end);
						}				
					}

					if(!$bookedFuture){$bookedFuture = null;}
					if(!$bookedPast){$bookedPast = null;}

					$booking = json_encode($dates);

					$this->render('orderscalendar', array('user'=>$user, 'authorBooking'=>$authorBooking, 'booking'=>$booking,'lot'=>$lot, 'bookedPast'=>$bookedPast,'flag'=>$flag, 'bookedFuture'=>$bookedFuture));

				}else{
					$dates = array();
					$flag = false;
					$booking = json_encode($dates);
					
					$this->render('orderscalendar', array('booking'=>$booking,'lot'=>$lot,'flag'=>$flag));
				}
				
			}else{
	             $this->redirect('/error/404');
	        }
			
		}else{
	        $this->redirect('/error/404');
	    }
    }
    
	public function actionUploadPhoto() {
		$user = App::gi()->user;
		$this->mainTemplate = 'clear';
		
		if ($_FILES) {
			if(isset($_FILES['userfile'])){
				$file = $_FILES['userfile'];
				$upload_dir = $_SERVER['DOCUMENT_ROOT'] . User::UPLOAD_DIR . $user->id . '/';
		        if (!file_exists($upload_dir)) {
		            if (!mkdir($upload_dir, 0777, true)) {
		                die('Не удалось создать: ' . $upload_dir);
		            }
		        }
				$fileName = 'avatar';
	            $type = explode('/', $file['type']);
	            $fileName .= '.'.$type[1];
	            move_uploaded_file($file['tmp_name'], $upload_dir . $fileName);
				
				echo User::UPLOAD_DIR.$user->id.'/'.$fileName;
				
            	//$res = User::saveImage($user, $_FILES['userfile']);
				//echo json_encode($res);
            } else {
            	echo "userfile none";
            }
		} else {
			echo "files none";
		}
	}
	
    //Метод редактирования информации о пользователе
    public function actionEditInfo(){
        $user = App::gi()->user;
		$this->mainTemplate = 'clear';
		$res = array();
        if($user){

					  
            if(isset($_POST['form'])){
                $user->__attributes = $_POST['form'];
                $user->gender = 'male';
                if(isset($_POST['form']['female'])){
                    $user->gender = 'female';
                }
				
                $user->show_all_adresses = 0;
				if(isset($_POST['form']['show_all_adresses']) && $_POST['form']['show_all_adresses'] == 'on'){
				  	$user->show_all_adresses = 1;$user->save();						
				}else{$user->show_all_adresses = 0;$user->save();}
				
                $date = $_POST['form']['year'].'/'.$_POST['form']['month'].'/'.$_POST['form']['day'];
                $user->birthday = $date;
				$res['user'] = $user->save();
                
                //$res['user'] = 'Saved';
            }
			
			if(isset($_POST['map'])){
				$map['latitude'] = round($_POST['map']['lat'], 7);
				$map['longitude'] = round($_POST['map']['long'], 7);
				$map['address'] = $_POST['map']['title'];
				$location = Location::model($user->location);
				//var_dump($location);
				if ($location) {
					
					$location->__attributes = $map;
					$res['map'] = $location->save();
					
				} else {
					$location = new Location();
					$location->__attributes = $map;

					$res['map'] = $location->save();
					$user->location = $location->id;
					$user->save();
				}
				//$res['map'] = 'Saved';
			}
			echo json_encode($res);

        }
    }
    //Метод добавления отзыва
    public function actionAddReview(){
        if(isset($_POST['review'])){
            $reviewer = App::gi()->user;
            if($reviewer){
                $review = new Review();
                $review->__attributes = $_POST['review'];
                $review->id_reviewer = $reviewer->id;
                $review->time = time();
                if($review->save()){
//                    debug($review);
                    if($review->id_user == 0){
                        $lot = Lot::model($review->id_lot);
                        if($lot){
                            Constants::sendEmail($lot->id_user, $lot->title, Constants::REVIEW_LOT); 
                        }                        
                    }else{
                        $user = User::model($review->id_user);
                        if($user){
                            Constants::sendEmail($review->id_user, 'title', Constants::REVIEW_USER);
                        }
                    }
                    $this->redirect($_SERVER['HTTP_REFERER']);
                }else{
                    $this->redirect('/error/404');            
                }
            }
        }else{
            $this->redirect('/error/404');            
        }        
    }
    //Метод выборки всех избранных товаров у данного пользователя
    public function actionFavorite(){
        $user = App::gi()->user;
        if($user){
            $user->favorites();
            
            $this->render('favorites', array('user'=>$user));
        }else{
            $this->redirect('/error/404');
        }        
    }
    //Метод добавления лота в избранное
    public function actionToFavorite($url = ''){
        $lot = Lot::modelWhere('url = ?', array($url));
        if($lot){
            $user = App::gi()->user;
            if($user){
                $id_from = $user->id;
                if($lot->id_user != $id_from){
                    $favo = new Favorite();
                    $favo->id_user = $id_from;
                    $favo->id_lot = $lot->id;
                    $favo->id_owner = $lot->id_user;
                    $favo->save();
                }else{
                    $this->redirect('/error/selfaction');
                }
            }else{
                $this->redirect('/error/404');
            }
        }else{
            $this->redirect('/error/404');
        }
    }
    //Метод отображения всех сообщений данного пользователя
    public function actionMessages(){
        $user = App::gi()->user;
        if($user){
            $user->messages();
                  
            $showedr = array();
            $showeds = array();
            $this->render('message', array('user'=>$user, 'showedr'=>$showedr, 'showeds'=>$showeds));
        }else{
            $this->redirect('/error/404');
        }
    }
    //Метод добавления комментария
    public function actionAddComment(){
        if(isset($_POST['comment'])){
            $from = App::gi()->user;
            if($from){
                $comment = new Comment();
                $comment->__attributes = $_POST['comment'];
                $comment->id_user = $from->id;
                $comment->time = time();
                $comment->save();
            }
        }else{
            $this->redirect('/error/404');
        }
    }
    //Метод отправки сообщений из диалога между пользователями
    public function actionDialogMessage($id_lot = 0){
    	$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		$from = App::gi()->user;
        if(!isset($_POST['dialog'])){
            $this->redirect('/error/404');
        }
        
        $lot = Lot::model((int)$_POST['dialog']['lot']);
        if(!$lot){
            $this->redirect('/error/404');
        }
        
        $user = User::model((int)$_POST['dialog']['user']);
        if(!$user){
            $this->redirect('/error/404');
        }
//        debug($lot);
//        debug($user);
//        debug($_POST); die();
        if($lot->id_user == $user->id){
            $this->redirect('/error/selfaction');
        }
		
        $message = new Message();
        $message->__attributes = $_POST['dialog'];
        $message->id_to = $user->id;
        $message->id_from = $from->id;
        $message->id_lot = $lot->id;
        $message->time = time();
        $message->id_previous = $message->previousId();
        if($message->save()){
        	if (isset($_POST['dialog']['filename'])) {
              	$message->file = $_POST['dialog']['filename'];
				$message->save();
            }
            Constants::sendEmail($message->id_to, $lot->title, Constants::MESSAGE);
        }
		echo json_encode(true);                
    }
	//Метод отправки сообщений из диалога между пользователями
    public function actionDialogMessageAnswer(){
    	$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
        if(!isset($_POST['dialog'])){
            $this->redirect('/error/404');
        }

        $user = User::model((int)$_POST['dialog']['user']);
		//debug($user);
        if(!$user){
            $this->redirect('/error/404');
        }
		$owner = App::gi()->user;
        $message = new Message();
        $message->__attributes = $_POST['dialog'];
        $message->id_to = $user->id;
        $message->id_from = $owner->id;

        $message->time = time();
        $message->id_previous = $message->previousId();
        if($message->save()){
        	if (isset($_POST['dialog']['filename'])) {
              	$message->file = $_POST['dialog']['filename'];
				$message->save();
            }
            Constants::sendEmail($message->id_to, 'Новое сообщение ', Constants::MESSAGE);
        }                
		echo json_encode(true);
    }
    //Метод отправки сообщений со страницы лота
    public function actionLeaveMessage($url = ''){
        if(isset($_POST['message'])){
            $lot = Lot::modelWhere('url = ?', array($url));
            if($lot){
                $user = App::gi()->user;
                if($user){
//                    debug($_POST); die();
                    $id_from = $user->id;
                    if($lot->id_user != $id_from){
                        $message = new Message();
                        $message->__attributes = $_POST['message'];
                        $message->id_to = $lot->id_user;
                        $message->id_lot = $lot->id;
                        $message->id_from = $id_from;
                        $message->time = time();
                        $message->id_previous = $message->previousId();
                        if($message->save()){
                            Constants::sendEmail($message->id_to, $lot->title, Constants::MESSAGE);
                        }

                        $this->redirect('/lot/view/'.$lot->url);
                    }else{
                        $this->redirect('/error/selfaction');
                    }
                }
            }else{
                $this->redirect('/error/404');
            }
        }
    }
    //Метод добавления исходящих сообщений в архив по лоту
    public function actionToArchiveOutcoming($id_message = 0){
    	
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		
        if($id_message){
        	
            $messages = Message::modelsWhere('id=?', array($id_message));

            if(count($messages)){
                foreach($messages as $message){
                    $message->archive = Message::ARCHIVE;
                    $message->save();
                }
            }
        }else{
            $this->redirect('/error/404');
        }
    }
	
    //Метод добавления сообщений в архив по лоту
    public function actionToArchive($id_lot = 0, $id_user = 0){
    	
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		
        $owner = App::gi()->user;
        if($owner){
            $user = User::model((int)$id_user);
            $lot = Lot::model((int)$id_lot);
            if($user and $lot){
            	
                $messages = Message::modelsWhere('id_to = ? AND id_from = ? AND id_lot = ?', array($owner->id, $user->id, $lot->id));

                if(count($messages)){
                    foreach($messages as $message){
                        $message->archive = Message::ARCHIVE;
                        $message->save();
                    }
                }
            }else{
                $this->redirect('/error/404');
            }
        }else{
            $this->redirect('/error/404');
        }
    }
	//Метод добавления сообщений в архив по user
    public function actionToArchiveAuthor($id_user = 0){
    	
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		
        $owner = App::gi()->user;
        if($owner){
            $user = User::model((int)$id_user);
             if($user){
                $messages = Message::modelsWhere('id_to = ? AND id_from = ?', array($owner->id, $user->id));
                if(count($messages)){
                    foreach($messages as $message){
                        $message->archive = Message::ARCHIVE;
                        $message->save();
                    }
                }
            }else{
                $this->redirect('/error/404');
            }
        }else{
            $this->redirect('/error/404');
        }
    }
	//Метод удаления сообщений из архива по id
    public function actionDeleteArchiveId($message_id = 0){
    	
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';

        if($message_id){
            Message::deleteWhere('id = ?', array($message_id));                
        }else{
            $this->redirect('/error/404');
        }
    }
    //Метод удаления сообщений в архиве по всем выбраным лотам
    public function actionDeleteArchiveAll(){
    	
    	$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
	
		if(isset($_POST['json'])){
			$json = $_POST['json'];
		}

        if($json != ''){
            $allToDeleteJson = json_decode($json);

            if(count($allToDeleteJson)){
                foreach($allToDeleteJson as $toDelete){
                    if($message_id){
			            Message::deleteWhere('id = ?', array($toDelete));                
			        }else{
                        $this->redirect('/error/404');
                    }                        
                }
            }
        }
    }
	//Метод добавления исходящих сообщений в архив по всем выбраным лотам
    public function actionAllOutToArchive(){
    	
    	$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
	
		if(isset($_POST['json'])){
			$json = $_POST['json'];
		}
		
        $owner = App::gi()->user;
        if($owner){
            if($json != ''){
                $allToDeleteJson = json_decode($json);

                if(count($allToDeleteJson)){
                    foreach($allToDeleteJson as $toDelete){
                        $data = explode('|', $toDelete);
                        $user = User::model($data[0]);
                        $lot = Lot::model($data[1]);
                        if($user and $lot and $lot !='0'){
                            $messages = Message::modelsWhere('id_to = ? AND id_from = ? AND id_lot = ?', array($user->id, $owner->id, $lot->id));
                            if(count($messages)){
                                foreach($messages as $message){
                                    $message->archive = Message::ARCHIVE;
                                    $message->save();
                                }
                            }
                        }else if($user){
                            $messages = Message::modelsWhere('id_to = ? AND id_from = ?', array($user->id, $owner->id));
                            if(count($messages)){
                                foreach($messages as $message){
                                    $message->archive = Message::ARCHIVE;
                                    $message->save();
                                }
                            }
                        }else{
                            $this->redirect('/error/404');
                        }                        
                    }
                }
            }
        }else{
            $this->redirect('/error/404');
        }
    }
    //Метод добавления сообщений в архив по всем выбраным лотам
    public function actionAllToArchive(){
    	
    	$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
	
		if(isset($_POST['json'])){
			$json = $_POST['json'];
		}
		
        $owner = App::gi()->user;
        if($owner){
            if($json != ''){
                $allToDeleteJson = json_decode($json);

                if(count($allToDeleteJson)){
                    foreach($allToDeleteJson as $toDelete){
                        $data = explode('|', $toDelete);
                        $user = User::model($data[0]);
                        $lot = Lot::model($data[1]);
                        if($user and $lot and $lot !='0'){
                            $messages = Message::modelsWhere('id_to = ? AND id_from = ? AND id_lot = ?', array($owner->id, $user->id, $lot->id));
                            if(count($messages)){
                                foreach($messages as $message){
                                    $message->archive = Message::ARCHIVE;
                                    $message->save();
                                }
                            }
                        }else if($user){
                            $messages = Message::modelsWhere('id_to = ? AND id_from = ?', array($owner->id, $user->id));
                            if(count($messages)){
                                foreach($messages as $message){
                                    $message->archive = Message::ARCHIVE;
                                    $message->save();
                                }
                            }
                        }else{
                            $this->redirect('/error/404');
                        }                        
                    }
                }
            }
        }else{
            $this->redirect('/error/404');
        }
    }
    //Метод изменения имейла пользователя
    public function actionChangeEmail(){
    	$this->layout = 'clear';
        $this->mainTemplate = 'clear';
        $user = App::gi()->user;
        if($user){
            if (isset($_POST['password'])&&$_POST['password']==$user->password) {
                $user->email = trim(strip_tags($_POST['email']));
                $user->save();
				$res = array('result'=>true, 'text'=>'E-mail сохранен');
            }else{
				$res = array('result'=>false, 'text'=>'Введенный вами пароль не верный');
            }
        }else{
        	$res = array('result'=>false, 'text'=>'При исполнении операции произошла внутренняя ошибка');
        }
		echo json_encode($res);
		
    }
    //Метод изменения пароля пользователя
    public function actionChangePassword(){
    	$this->layout = 'clear';
        $this->mainTemplate = 'clear';
        $user = App::gi()->user;
        if($user){
            if (isset($_POST['pass'])&&$_POST['pass']==$_POST['passcheck']) {
                $user->password = trim(strip_tags($_POST['pass']));
                $user->save();
				$res = array('result'=>true, 'text'=>'Пароль сохранен');
				$un = ($user->name)?', '.$user->name:'';
				
				$mess = '<p style="margin-bottom: 20px;">Ваш пароль изменен.</p>';
				$mess .= '<p>Если это были вы, то просто проигнорируйте это письмо.</p>';
				$mess .= '<p style="margin-bottom: 10%;">В противном случае обратитесь в <a href="'.$_SERVER['HTTP_HOST'].'/info/index">службу поддержки</a>.</p>';
				Constants::sendEmail($user->id, $mess, Constants::PASSWORD);				
				
            }else{
				$res = array('result'=>false, 'text'=>'Введенные вами пароли не совпадают');
            }
        }else{
			$res = array('result'=>false, 'text'=>'При исполнении операции произошла внутренняя ошибка');
        }
		echo json_encode($res);
    }
    
    public function actionLotVote() {
        if ($_POST['score'] != '') {
            $lot = Lot::modelWhere('url = ?', array($_POST['vote-id']) );
            $voter = App::gi()->user;
            if (!Vote::modelWhere('id_lot = ? AND id_voter = ?', array($lot->id, $voter->id))) {
                if ($lot) {
                    if ($lot->vote_count === 0) {
                        $lot->mark = (float) $_POST['score'];
                        $lot->vote_count = 1;
                    } else {
                        $lot->mark = ($lot->mark * $lot->vote_count + (float) $_POST['score']) / ($lot->vote_count + 1);
                        $lot->vote_count +=1;
                    }
                    if ($lot->save()) {
                        $vote = new Vote();
                        $vote->id_lot = $lot->id;
                        $vote->id_voter = $voter->id;
                        $vote->save();

                        $data['msg'] = 'Спасибо. Ваш голос учтен';
                        $data['status'] = 'OK';
                    }
                } else {
                    $data['msg'] = 'Произошла ошибка при голосовании';
                    $data['status'] = 'ERR';
                }
            } else {
                $data['msg'] = 'Вы уже голосовали за эту статью';
                $data['status'] = 'ERR';
            }
        } else {
            $data['msg'] = 'Вы не передали необходимые данные';
            $data['status'] = 'ERR';
        }
        if($data['status'] == 'OK'){
            $this->sendEmail($lot->id_user, $lot->title, Constants::VOTE_LOT);
        }
        echo json_encode($data);
    }
    
    public function actionUserVote() {
        if ($_POST['score'] != '') {
            $user = Review::modelWhere('url = ?', array($_POST['vote-id']) );
            $voter = App::gi()->user;
            if (!Vote::modelWhere('id_user = ? AND id_voter = ?', array($user->id, $voter->id))) {
                if ($user) {
                    if ($user->vote_count === 0) {
                        $user->mark = (float) $_POST['score'];
                        $user->vote_count = 1;
                    } else {
                        $user->mark = ($user->mark * $user->vote_count + (float) $_POST['score']) / ($user->vote_count + 1);
                        $user->vote_count +=1;
                    }
                    if ($user->save()) {
                        $vote = new Vote();
                        $vote->id_user = $user->id;
                        $vote->id_voter = $voter->id;
                        $vote->save();

                        $data['msg'] = 'Спасибо. Ваш голос учтен';
                        $data['status'] = 'OK';
                    }
                } else {
                    $data['msg'] = 'Произошла ошибка при голосовании';
                    $data['status'] = 'ERR';
                }
            } else {
                $data['msg'] = 'Вы уже отдавали голос за этого пользователя';
                $data['status'] = 'ERR';
            }
        } else {
            $data['msg'] = 'Вы не передали необходимые данные';
            $data['status'] = 'ERR';
        }
        if($data['status'] == 'OK'){
            $this->sendEmail($user->id, '', Constants::VOTE_LOT);
        }
        echo json_encode($data);
    }
    
    private function foundLocation(User $user, $address = 'Киев'){

            $json = Socials::googleMapsLocation($address);
            $result = json_decode($json);

            $long = $result->results[0]->geometry->location->lng;
            $lat = $result->results[0]->geometry->location->lat;
            $addr = $result->results[0]->formatted_address;

        
            $userLocation = new Location();
            $userLocation->create($user, $long, $lat, $addr);
            $this->redirect('/myprofile');
    }
	
	public function actionResolveBooking($booking_id=''){
		
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		
       if($booking_id !=''){
	       	$booking = Booking::modelWhere('id = ?', array($booking_id));
			$booking->confirmed = 1;
			$booking->save();
			
			$mess = 'Поздравляем, ваше бронирование подтверждено: <a href="'.$_SERVER['HTTP_HOST'].'/page/orderview/'.$booking_id.'">ссылка на просмотр бронирования</a>';
			Constants::sendEmail($booking->id_from, $mess, Constants::BOOKING);
			//подтвердить
       }
    }
		
	public function actionRejectBooking($booking_id=''){
		
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		
        if($booking_id !=''){
       		$booking = Booking::modelWhere('id = ?', array($booking_id));
			$booking->confirmed = 2;
			$booking->save();
			
			$mess = '<p style="margin-bottom: 10px;">К сожалению, ваше бронирование отклонено: <a href="'.$_SERVER['HTTP_HOST'].'/page/orderview/'.$booking_id.'">ссылка</a></p>
			<p style="margin-bottom: 10%;">Но, вы не расстраивайтесь. Попробуйте еще раз найти то, что вам нужно: <a href="'.$_SERVER['HTTP_HOST'].'/search">в поиске</a></p>';
			Constants::sendEmail($booking->id_from, $mess, Constants::BOOKING);
			//отклонить
			
        }
    }
	
	public function actionSortMessages($hold='',$flag =''){
		
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';

       if($hold !=''){
       		
			    $user = App::gi()->user;

		        if($user){
		            $user->userLots();
		            $user->messages();
		            $user->toUserReviews();
		            $user->userReviews();
		            $user->takePosition();
					$bookedPast = Booking::allPastBooking($user);
		            $bookedFuture = Booking::allFutureBooking($user);
		            $countNew = Message::countRowWhere('id_to = ? AND new = ?', array($user->id, Message::FRESH));
		
					if($hold == 0){$hold=1;$messagesArray = $user->reciveMessages;
					}else if ($hold == 1) {$hold=0;$messagesArray =  array_reverse($user->reciveMessages);
					}else{$messagesArray = array_reverse($user->reciveMessages);}
					
		            $showedr = array();
		            $showeds = array();
		            $showeda = array();
		            $birthday = array();
		            $birthArray = explode('/', $user->birthday);
					
		            if($user->birthday != 0){
		                $birthday = array('year'=>$birthArray[0], 'month'=>$birthArray[1], 'day'=>$birthArray[2]);
		            }
		            $this->render('index', array('user'=>$user, 'messagesArray'=>$messagesArray, 'new'=>$countNew, 'birthday'=>$birthday,
		                                        'bookedPast'=>$bookedPast, 'bookedFuture'=>$bookedFuture,
		                                        'showedr'=>$showedr, 'showeds'=>$showeds, 'hold'=>$hold,'flag'=>$flag));
		        }else{
		            $this->redirect('/error/404');
		        }
			
        }
    }

	public function actionRefreshMessages($flag = ''){
    			
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
        $user = App::gi()->user;

        if($user){
            $user->userLots();
            $user->messages();
            $user->toUserReviews();
            $user->userReviews();
            $user->takePosition();
            $bookedPast = Booking::allPastBooking($user);
            $bookedFuture = Booking::allFutureBooking($user);
            $messagesArray = array_reverse($user->reciveMessages);
            $countNew = Message::countRowWhere('id_to = ? AND new = ?', array($user->id, Message::FRESH));
            $hold = 0;
            $showedr = array();
            $showeds = array();
            $showeda = array();
            $birthday = array();
            $birthArray = explode('/', $user->birthday);
            if($user->birthday != 0){
                $birthday = array('year'=>$birthArray[0], 'month'=>$birthArray[1], 'day'=>$birthArray[2]);
            }
            $this->render('index', array('user'=>$user, 'messagesArray'=>$messagesArray, 'new'=>$countNew, 'birthday'=>$birthday,
                                        'bookedPast'=>$bookedPast, 'bookedFuture'=>$bookedFuture,
                                        'showedr'=>$showedr, 'showeds'=>$showeds, 'hold'=>$hold,'flag'=>$flag));
        }else{
            $this->redirect('/error/404');
        }
    }
	
	//Add file to message
	public function actionLoadFileMessage() {
		
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		
		$owner = App::gi()->user;
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/messages/';
        if (isset($owner)) {
            $uploaddir .= $owner->id . '/';
        }
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }
		$dir = '/uploads/messages/' .$owner->id . '/';
        if (!empty($_FILES['userfile']['name'])) {

            $name = $_FILES['userfile']['name'];
			$namef = explode('.', $name);
			$res = array('path'=> '', 'filename'=> '');
            $type = explode('/', $_FILES['userfile']['type']);
			$fileName = substr(md5($_SERVER['REMOTE_ADDR'].date('Y-m-d H-m-s').$namef[0]), 0, 15).'.';
            $fileName .= $type[1];
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $fileName)) {
                
				$res['path'] = $uploaddir.$fileName;
				$res['upload'] = $dir.$fileName;
	            $res['filename'] = $fileName;
				echo json_encode($res);
            }else{
                return false;
            }
        }
    }
	//Метод удаления файла с сервера
    public function actionDeleteFile(){
    	
        $this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		
		$path = $_POST['path'];
		
       	if(isset($path)){
			@unlink($path);
			echo json_encode(true);
        }else{
            $this->redirect('/error/404');
        }
    }
	
	//update calendar
    public function actionUpdateOrdersCalendar($url = ''){
    					
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		
    	$user = App::gi()->user;
		
        if($user){
        	
	    	$lot = Lot::modelWhere('url = ?', array($url));

	        if($lot){
		    	$booking_arr = Booking::modelsWhere('id_to = ? AND id_lot = ?', array($user->id, $lot->id));
		
				if($booking_arr){

					$dates = array();
					
					foreach($booking_arr as $k => $item){
						
						$item->start = date('Y-m-d', strtotime($item->start));
						$item->end = date('Y-m-d', strtotime($item->end));
						
						if($item->confirmed !=1){
							$dates[] 	= array('from' => $item->start, 'to' => $item->end);
						}				
					}
					echo json_encode($dates);
				}else{
					$dates = array();
					echo json_encode($dates);
				}
				
			}else{
	             $this->redirect('/error/404');
	        }
			
		}else{
	        $this->redirect('/error/404');
	    }
    }
}
