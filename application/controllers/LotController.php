<?php

class LotController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'add' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'view' => array(
            'users' => array('*'),
            'redirect' => '/login'
        ),
        'edit' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'posttype' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'addajaximages' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'saveajaxrating' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'delajaximages' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'leavemessage' => array(
            'users' => array('*'),
            'redirect' => '/login'
        ),
        'selectcategory' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'addreview' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'likereview' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'unlikereview' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        )
        
    );
    
    public function actionIndex(){
    	// заглушка
        $lots = Lot::modelsWhere('time > ?', array(time()-3600*24));
		if(count($lots)){
            foreach($lots as $lot){
				$lot->getVotes($lot->id);
            }
        }	
	
        $parents = Category::modelsWhere('id_parent = ?', array(Category::PARENT));
        $this->render('index', array('lots'=>$lots, 'parents'=>$parents));
    }

    //Активация\деактивация лота
    public function actionPostType($id_lot = 0){
        $lot = Lot::model($id_lot);
        $this->layout = 'clear';
        $this->mainTemplate = 'clear';
		$res = array('message'=> '', 'result'=> false, 'id'=>$id_lot);
        if($lot){
            if($lot->post_type == Constants::LOT_ACTIVE){
                $lot->post_type = Constants::LOT_DEACTIVE;
				if($lot->save()){
					$res['message'] = 'Лот деактивирован';
	                $res['result'] = true;
	            }
            }else{
                $lot->post_type = Constants::LOT_ACTIVE; 
				if($lot->save()){
					$res['message'] = 'Лот активирован';
	                $res['result'] = true;
	            }           
            }
            
        }else{
        	$res['message'] = 'Такого лота не существует';
        }
		echo json_encode($res);
    }
    
    public function actionView($url = ''){
        $lot = Lot::modelWhere('url = ?', array($url));
        if($lot){
            $lot->countReviews();
            $lot->takeImages();
            $lot->takeReviews();
			$lot->getVotes($lot->id);
			$owner = App::gi()->user;
            $lot->takeAllAttributeValues();
			//debug($lot);
            $user = User::model((int)$lot->id_user);

			$lot->getUserRating($user->id);
			
            $user->takeRole();
            $user->countReviews();
            $avatar = $user->takeImage();
			
			$category = Category::modelWhere('id = ?', array($lot->id_category));
			if($lot->id_category && $category){
				$category->checkOnParentsAndTakeIt();
			}

			if($owner){
				$booking_lots =Booking::modelsWhere('id_lot = ? AND confirmed=1 AND id_to=? AND id_from=?', array($lot->id,$user->id,$owner->id));

			}else{$booking_lots = null;}  

			 
			$booking_arr = Booking::modelsWhere('id_lot = ?', array($lot->id));
			$dates = array();
			foreach($booking_arr as $item){
				
				$item->start = date('Y-m-d', strtotime($item->start));
				$item->end = date('Y-m-d', strtotime($item->end));

				if($item->confirmed ==1){
					$dates[] 	= array('from' => $item->start, 'to' => $item->end);	
				}				
			}
			//debug(json_encode($dates));
			
			$booking = json_encode($dates);
			
            $this->render('view', array('user'=>$user, 'lot'=>$lot, 'avatar'=>$avatar, 'category'=>$category,'booking_lots'=>$booking_lots,'booking'=>$booking));
        }else{
            $this->redirect('/error/404');
        }
    }
    
    public function actionSelectCategory($url = ''){
        if($url==''){
            $categories = Category::modelsWhere('id_parent = ? ORDER BY title', array(Category::PARENT));            
        }else{
            $selected = Category::modelWhere('url = ?', array($url));
            if($selected){
                $categories = Category::modelsWhere('id_parent = ? ORDER BY title', array($selected->id));                
            }
        }
        
//        debug($categories);
        $this->render('selectcategory', array('categories'=>$categories));
    }
    
    public function actionAdd($url = ''){
        if(isset($_POST['form'])){
            $user = App::gi()->user;
            if($user){
                $lot = new Lot();
                $lot->__attributes = $_POST['form'];
                $lot->id_user = $user->id;
                $lot->user_type = $user->id_role;
				$loturl = translit($lot->title). uniqid();
				
				$loturl = str_replace('/', '-', $loturl);
				$loturl = str_replace('"', '', $loturl);
				$loturl = str_replace("'", '', $loturl);
				
                $lot->url = $loturl;
                $lot->state = Lot::FRESH;
                $lot->status = Lot::REGULAR;
                $lot->id_region = $user->id_region;
                $lot->id_city = $user->id_city;
                $lot->time = time();
				$user->takePosition();
								
//                debug($_POST); 
//                debug($_FILES); 
//                debug($lot); die();
                if($lot->save()){
                    // if (isset($_FILES['pic'])) {
                    //     Lot::saveImages($lot, $_FILES['pic']);
                    // }
                    
                    $address = $_POST['form']['address'];
					  if(isset($address)){
						$arr = explode(',',$address);
						foreach($arr as $key=>$item){
					  		$q = City::modelsWhere('title_ru LIKE ?', array("$item%"));
					  		if($q){
					  			$lot->id_region = $q[0]->id_region;
					  			$lot->id_city = $q[0]->id;
								$lot->save();
								break;
					  		}else{continue;}
					 	}						
					  }
					$lot->show_address = 0;
					  if(isset($_POST['form']['show_address']) && $_POST['form']['show_address'] == 'on'){
					  	$lot->show_address = 1;	$lot->save();					
					  }else{$lot->show_address = 0;$lot->save();}
					
                    $old_dir = $_SERVER['DOCUMENT_ROOT'] . Lot::UPLOAD_DIR . 'temp' . '/';
                    $new_dir = $_SERVER['DOCUMENT_ROOT'] . Lot::UPLOAD_DIR . $lot->url . '/';
					if (file_exists($old_dir) && is_writable($old_dir)) {
                    	rename($old_dir, $new_dir);
					}
					
					if (isset($_POST['form']['attr'])) {
						$attr = $_POST['form']['attr'];
						
						if(isset($_POST['form']['deposit']) && !empty($_POST['form']['deposit'])){
							$lot->deposit = $_POST['form']['deposit'];
							$lot->save();
	                      }else{
	                      	$lot->deposit = 'document';
							$lot->save();
	                    }
							
						if (isset($attr['static']) && $attr['static']) {
							foreach ($attr['static'] as $key => $stat) {
								$sav = new SelectedAttributeValue();
								$sav->id_lot = $lot->id;
								$sav->id_attribute = $key;
								$sav->dynamic_attribute_value = 0;
								$sav->id_static_attribute_value = $stat;
								$sav->save();
							}
							if (isset($attr['dynamic']) && $attr['dynamic']) {
								foreach ($attr['dynamic'] as $key => $dyn) {
									$sav = new SelectedAttributeValue();
									$sav->id_lot = $lot->id;
									$sav->id_attribute = $key;
									$sav->dynamic_attribute_value = $dyn;
									$sav->id_static_attribute_value = 0;
									$sav->save();
								}
							}
						}
						
					}
					
					if(isset($_POST['form']['phone0'])){$user->phone0 = $_POST['form']['phone0'];}
					if(isset($_POST['form']['phone1'])){$user->phone1 = $_POST['form']['phone1'];}
					if(isset($_POST['form']['phone2'])){$user->phone2 = $_POST['form']['phone2'];}
					if(isset($_POST['form']['phone3'])){$user->phone3 = $_POST['form']['phone3'];}
					if(isset($_POST['form']['phone4'])){$user->phone4 = $_POST['form']['phone4'];}

                }
                $user->save();
                
                $this->redirect('/myprofile?tab2');
            }
            
        }
        
        $categories = Category::modelsWhere('id_parent = ?', array(Category::PARENT)); //Category::modelWhere('url = ?', array($url));
        foreach ($categories as $key => $cat) {
            $categories[$key]->child = $cat->takeChilds();
        }
        $user = App::gi()->user;
		$user->takePosition();
       // debug($user);
        $this->render('add', array('category'=>$categories, 'user'=>$user));
    }

    public function actionEdit($url = ''){
    	$res = FALSE;
        $lot = Lot::modelWhere('url = ?', array($url));
  
        if($lot){
        	
			$user = App::gi()->user;
			if ($user->id!=$lot->id_user) {
				$this->redirect('/error/404');
			}

            if(isset($_POST['form'])){
                $user = App::gi()->user;
                if($user){

                    $lot->__attributes = $_POST['form'];
                    $lot->id_user = $user->id;
                    $lot->user_type = $user->id_role;
 
                    $lot->state = Lot::FRESH;
                    $lot->status = Lot::REGULAR;
                    $lot->id_region = $user->id_region;
                    $lot->id_city = $user->id_city;
                    //$lot->time = time();
					$lot->takeAllAttributeValues();
					
		            $user->takeRole();

                    if($lot->save()){
						
					  if(isset($_POST['form']['deposit']) && !empty($_POST['form']['deposit'])){
						$lot->deposit = $_POST['form']['deposit'];
						$lot->save();
                      }else{
                      	$lot->deposit = 'document';
						$lot->save();
                      }
					  
					  $lot->show_address = 0;
					  if(isset($_POST['form']['show_address']) && $_POST['form']['show_address'] == 'on'){
					  	$lot->show_address = 1;	$lot->save();					
					  }else{$lot->show_address = 0;$lot->save();}
					  
					  $address = $_POST['form']['address'];
					  if(isset($address)){
						$arr = explode(',',$address);
						foreach($arr as $key=>$item){
					  		$q = City::modelsWhere('title_ru LIKE ?', array("$item%"));
					  		if($q){
					  			$lot->id_region = $q[0]->id_region;
					  			$lot->id_city = $q[0]->id;
								$lot->save();
								break;
					  		}else{continue;}
					 	}						
					  }

					if (isset($_POST['form']['attr'])) {
						$attr = $_POST['form']['attr'];

						if (isset($attr['static']) || isset($attr['dynamic'])) {
							SelectedAttributeValue::deleteWhere('id_lot = ?', array($lot->id));
							
							if (isset($attr['static'])) {
								foreach ($attr['static'] as $key => $stat) {
									$sav = new SelectedAttributeValue();
									$sav->id_lot = $lot->id;
									$sav->id_attribute = $key;
									$sav->dynamic_attribute_value = 0;
									$sav->id_static_attribute_value = $stat;
									$sav->save();
								}
							}
							if (isset($attr['dynamic'])) {
								foreach ($attr['dynamic'] as $key => $dyn) {
									$sav = new SelectedAttributeValue();
									$sav->id_lot = $lot->id;
									$sav->id_attribute = $key;
									$sav->dynamic_attribute_value = $dyn;
									$sav->id_static_attribute_value = 0;
									$sav->save();
								}
							}
							
						}
						
					}
					
					$res = TRUE;
										
					if(isset($_POST['form']['phone0'])){$user->phone0 = $_POST['form']['phone0'];}
					if(isset($_POST['form']['phone1'])){$user->phone1 = $_POST['form']['phone1'];}
					if(isset($_POST['form']['phone2'])){$user->phone2 = $_POST['form']['phone2'];}
					if(isset($_POST['form']['phone3'])){$user->phone3 = $_POST['form']['phone3'];}
					if(isset($_POST['form']['phone4'])){$user->phone4 = $_POST['form']['phone4'];}
						
                    }

                    $user->save();

                    $this->redirect('/myprofile?tab2');
                }

            }
        
            $category = Category::modelsWhere('id_parent = ?', array(Category::PARENT));
			foreach ($category as $key => $cat) {
	            $category[$key]->child = $cat->takeChilds();
	        }
            $user = App::gi()->user;

            $this->render('edit', array('lot' => $lot, 'category'=>$category, 'user'=>$user, 'saved'=>$res));
        }else{
            $this->redirect('/error/404');
        }
    }
    
	public function actionAddReview(){
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear'; 
		if ($_POST) {
			$user = App::gi()->user;
			$review = new Review();
			//$_POST['review']['vote'] = ($_POST['review']['vote']*2);
			$review->__attributes = $_POST['review'];
			$review->vote = ($_POST['review']['vote'])?$_POST['review']['vote']*2:0;
			$review->time = time();
			$review->title = trim($_POST['review']['title']);
			$review->parent = (isset($_POST['review']['parent']))?$_POST['review']['parent']:0;
			$review->id_reviewer = $user->id;
			if($review->save()){
				if (isset($_POST['review']['id_lot'])) {
					$lot = Lot::modelsWhere('id = ?', array($_POST['review']['id_lot']));
					Constants::sendEmail($lot->id_user, $lot->title, Constants::REVIEW_LOT);
				}
				$res = (isset($_POST['review']['parent']))?$_POST['review']['parent']:0;
			} else {
				$res = false;
			}
			echo json_encode($review);
		} else {
			$this->redirect('/error/404');
		}
	}
	
	public function actionLikeReview() {
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		if ($_POST) {
			$user = App::gi()->user;
			$vote = new Vote();
			$vote->__attributes = $_POST;
			$vote->id_user = $user->id;
			$vote->vote = 1;
			$del = Vote::deleteWhere('id_user = ? AND id_review = ?', array($vote->id_user, $vote->id_review));
			if($vote->save()){
				$res = true;
				$rev = Review::modelWhere('id = ?', array($_POST['id_review']));
				$nr = new Review();
				
				$nr->id_user = $rev->id_user;
				$nr->id_lot = $rev->id_lot;
				$nr->vote = $rev->vote;
				$nr->time = time();
				$nr->title = $rev->title;
				$nr->text = $rev->text;
				$nr->parent = $rev->parent;
				$nr->id_reviewer = $rev->id_reviewer;
				$nr->reposted = 1; 
				
				$nr->save();
			} else {
				$res = false;
			}
			echo json_encode($res);
		} else {
			$this->redirect('/error/404');
		}
	}
	public function actionUnlikeReview() {
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		if ($_POST) {
			$user = App::gi()->user;
			$vote = new Vote();
			$vote->__attributes = $_POST;
			$vote->id_user = $user->id;
			$vote->vote = 0;
			$del = Vote::deleteWhere('id_user = ? AND id_review = ?', array($vote->id_user, $vote->id_review));
			if($vote->save()){
				$res = true;
			} else {
				$res = false;
			}
			echo json_encode($res);
		} else {
			$this->redirect('/error/404');
		}
	}
	
	
    /*
     * description: Recieves post data from ajax handler
     * author: lhornet
     * date: 27.04.2016
     * return: array
     */
    public function actionAddAjaxImages($lot_url=''){
            $this->layout = 'clear';
            $this->mainTemplate = 'clear'; 
            //debug($_FILES);
            $lot = Lot::modelWhere('url = ?', array($lot_url));
            if($lot){
                $res = Lot::saveimg($lot, $_FILES);
            }else{$res = Lot::saveimg(null,$_FILES);}

            print_r($res);
    }

    public function actionDelAjaxImages($lot_url=''){

            $this->layout = 'clear';
            $this->mainTemplate = 'clear'; 
            //debug($_FILES);
            $lot = Lot::modelWhere('url = ?', array($lot_url));

            if($lot){
                $res = Lot::deleteimg($lot, $_POST['filename']);
            }else{$res = Lot::deleteimg(null, $_POST['filename']);}

            print_r($res);
    }

    public function actionLeaveMessage($lot_url=''){
    	
    	 $this->layout = 'clear';
         $this->mainTemplate = 'clear'; 
			
    	if (isset($_POST['message'])) {

            if(isset($_POST['message']['text']) && !empty($_POST['message']['text'])){
   				$user = App::gi()->user;
                if($user){
                	if($lot_url){
	                	$lot = Lot::modelWhere('url = ?', array($lot_url));
		                $message = new Message();
		                $message->id_from = $user->id;
						$message->id_lot = $lot->id;
						$message->id_to = $_POST['message']['id_to'];
						$message->text = $_POST['message']['text'];
		                $message->time = time();
						$message->id_previous = $message->previousId();
						
						$message->save();
	                    if($message->save()){
	                        Constants::sendEmail($message->id_to, $lot->title, Constants::MESSAGE);
							
	                    }
	
	                    $this->redirect('/lot/view/'.$lot->url);
					}else{
						debug($_POST['message']);
		                $message = new Message();
		                $message->id_from = $user->id;
						$message->id_to = $_POST['message']['id_to'];
						$message->text = $_POST['message']['text'];
		                $message->time = time();
						$message->booked = 0;
						$message->id_previous = $message->previousId();
						$message->save();
						if($message->save()){
	                        Constants::sendEmail($message->id_to, '', Constants::UMESSAGE);
							
	                    }
					}
				}
            }
      
        } else {
        	$this->redirect('/error/pleaseregister');
        }
			
    }

    public function foundLocation($address = 'Киев'){

			$res = array();
            $json = Socials::googleMapsLocation($address);
			//debug($json);
            $result = json_decode($json);

            $long = $result->results[0]->geometry->location->lng;
            $lat = $result->results[0]->geometry->location->lat;
            $addr = $result->results[0]->formatted_address;
			
			$res = array('long'=>$long, 'lat'=>$lat, 'addr'=>$addr);
			
			return $res;
    }
}