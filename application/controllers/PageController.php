<?php
 
class PageController extends Controller {
    static $rules = array(
        'index' => array(
            'users' => array('*'),
            'redirect' => '/login'
        ),
        'publicprofile' => array(
            'users' => array('*'),
            'redirect' => '/error/younotloggin'
        ),
        'orderview' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'orderconfirm' => array(
            'users' => array('user', 'business'),
            'redirect' => '/error/younotloggin'
        ),
        'howitwork' => array(
            'users' => array('*'),
            'redirect' => '/login'
        ),
        'contacts' => array(
            'users' => array('*'),
            'redirect' => '/login'
        ),
        'abount' => array(
            'users' => array('*'),
            'redirect' => '/login'
        ),
        'termsofuse' => array(
            'users' => array('*'),
            'redirect' => '/login'
        ) 
    );

    //Главная страница сайта
    public function actionIndex() {
        
//        $this->render('index', array('parents'=>$parents));
        $this->render('index');
    }
    
    public function actionPublicProfile($id=0) {
		//echo $id;
		if ($id==0) {
			$this->redirect('/error/404');
		}
		$user = User::modelWhere('id=?', array($id));
		if (!$user) {
			$this->redirect('/error/404');
		}
		$map = Location::modelWhere('id=?', array($user->location));
		$reviews = Review::modelsWhere('id_user=? AND parent=?', array($user->id, 0));
		$lots = Lot::modelsWhere('id_user=? AND post_type=0', array($id));
		$lot = (object) array();
		//debug($lots);
		if(count($lots)){
            foreach($lots as $lot){
				$lot->getVotes($lot->id);
				$lot->getUserRating($user->id);
            }
        }

		$lot->rating = getUserRating($user->id);
        $this->render('publicprofile', array('user'=>$user, 'map'=>$map, 'lots'=>$lots, 'lot'=>$lot,'reviews'=>$reviews));
    }
	
    public function actionOrderView($id_order = 0) {
    	$user = App::gi()->user;
		$booking = Booking::model((int)$id_order);
	
		if($booking){
			if ($user->id==$booking->id_to||$user->id==$booking->id_from) {
				$booking->lotInfo();
	//            $booking->userInfo();
	            $booking->ownerInfo();
	            $booking->dateInfo();
				
				$booking_lots = Booking::modelsWhere('id_lot = ? AND confirmed=1 AND id_to=? AND id_from=?', array($booking->lot->id,$booking->lot->id_user,$user->id));

	            $this->render('order', array('booking'=>$booking,'booking_lots'=>$booking_lots));
			} else {
				$this->redirect('/error/404');
			}
        }else{
            $this->redirect('/error/404');
        }
		
    }
    public function actionOrderConfirm() {
		// $this->render('index', array('parents'=>$parents));
        $this->render('confirm', array());
    }
    public function actionAbout() {
        $this->render('about');
    }
    public function actionTermsOfUse() {
        $this->render('terms');
    }
    public function actionContacts() {
        $this->render('cont');
    }
    public function actionHowItWork() {
        $this->render('how');
    }
	
	public function actionAddReview(){
		
		$this->layout = 'clear';
        $this->mainTemplate = 'clear'; 
		
		if ($_POST) {
			$user = App::gi()->user;
			$review = new Review();
			$_POST['review']['vote'] = ($_POST['review']['vote']*2);
			$review->__attributes = $_POST['review'];
			$review->time = time();
			$review->id_reviewer = $user->id;
			if($review->save()){
				Constants::sendEmail($_POST['review']['id_user'], '', Constants::REVIEW_USER);
				$res = true;
			} else {
				$res = false;
			}

			echo json_encode($res);
		} else {
			$this->redirect('/error/404');
		}
	}
	
}
