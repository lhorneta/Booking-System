<?php

class BookingController extends Controller {
    static $rules = array(
        'index' => array(
                'users' => array('*'),
                'redirect' => '/'),
        'newbooking' => array(
                'users' => array('*'),
                'redirect' => '/'),
        'savebooking' => array(
                'users' => array('user', 'business'),
                'redirect' => '/'),
        'deletebookingbyid' => array(
                'users' => array('user', 'business'),
                'redirect' => '/'),
        'saveautorbooking' => array(
                'users' => array('user', 'business'),
                'redirect' => '/'),       
        'userbooking' => array(
                'users' => array('user', 'business'),
                'redirect' => '/')
        );
    
    public function actionIndex() {
        $this->redirect('/error/404');
    }
    public function actionNewBooking() {
        $user = App::gi()->user;

        if($user){
            if(isset($_POST)){
            	if (isset($_POST['calendar'])) {
            		$lot = Lot::model((int)$_POST['calendar']['id_lot']);
					$lot->getVotes($lot->id);
					//debug($lot);
					$owner = User::model((int)$_POST['calendar']['id_to']);
					$lot->getUserRating($owner->id);
					$lot->countReviews();
					$user->takeRole();
					$lot->takeAllAttributeValues();
					
	                if($owner and $lot){
	                	
	                    if($owner->id != $user->id){
	                    	//debug($owner);
	                        $calendar = new Calendar();
	                        $calendar->__attributes = $_POST['calendar'];
	                        $calendar->id_from = $user->id;
							
							$days = $_POST['calendar']['count_days'];
							$price = $_POST['calendar']['total_sum'];
							$order_arr = $_POST['calendar']['order_arr'];

							$this->render('confirm', array('lot' => $lot, 'user'=>$user, 'calendar'=>$calendar, 'owner'=>$owner,'days'=> $days, 'price'=> $price,'order_arr'=>$order_arr));
		               
					    }else{
		                    $this->redirect('/error/selfaction');
		                }
		            }else{
		                $this->redirect('/error/404');
		            }
            } else {
            	$this->redirect('/error/pleaseregister');
            }
				
                
	        }else{
	            $this->redirect('/error/pleaseregister');
	        }
	    } else{
	            $this->redirect('/error/younotloggin');
	    }   
	}

	public function actionSaveBooking() {
		
		$this->layout = 'clear';
        $this->mainTemplate = 'clear';
		 
		$user = App::gi()->user;
		$res = '';
		
        if($user){
            if(isset($_POST)){
            	if (isset($_POST['calendar'])) {
            		$lot = Lot::model((int)$_POST['calendar']['id_lot']);
				
	                $owner = User::model((int)$_POST['calendar']['id_to']);
	                if($owner and $lot){
	                    if($owner->id != $user->id){
	                        $calendar = new Calendar();
							
	                        if(isset($_POST['message']['text']) && !empty($_POST['message']['text'])){
	                            $booking = new Booking();
	                            $booking->__attributes = $_POST['calendar'];
	                            $booking->id_from = $user->id;
	                            $booking->createText();
								if(isset($_POST['calendar']['order_arr'])){
									$booking->order_arr = $_POST['calendar']['order_arr'];
								}
								
	                            $booking->save();
	
	                            $message = new Message();
	                            $message->__attributes = $_POST['calendar'];
	                            $message->id_from = $user->id;
	                            $message->booked = $booking->id;
								$message->text = $_POST['message']['text'];
	                            $message->time = time();
	                            $message->save();
	
	                            Constants::sendEmail($owner->id, $lot->title, Constants::BOOKING_LOT);
								$res = 'success';
	                        }
							
		                }else{
		                	$res['error'] = 'error';
		                    $this->redirect('/error/selfaction');
		                }
		            }else{
		                $this->redirect('/error/404');
		            }
	            } else {
	            	$this->redirect('/error/pleaseregister');
	            }
					     
	        }else{
	            $this->redirect('/error/pleaseregister');
	        }
	    }

		$callback = json_encode($res, true);
        return $callback;
	}

	public function actionSaveAutorBooking() {
		
		$this->layout = 'clear';
        $this->mainTemplate = 'clear';
		$user = App::gi()->user;
		$res = '';
        
	    if(isset($_POST['booking']['start'], $_POST['booking']['end'])){
	    	$booking = new Booking();
	        $booking->start = $_POST['booking']['start'];
			$booking->end = $_POST['booking']['end'];
			$booking->id_to = $user->id;
			$booking->id_from = $user->id;
			$booking->id_lot = $_POST['booking']['id_lot'];
			$booking->confirmed = 1;
	        $booking->createText();
	
	        $booking->save();
		}else{
			$res['error'] = 'error';
		    $this->redirect('/error/selfaction');
		}

		echo $booking->id;
	}
	
	//Метод удаления booking по id
    public function actionDeleteBookingById(){
    	
		$this->layout = 'clear';
	    $this->mainTemplate = 'clear';
		$booking_id = $_POST['booking_id'];
        if($booking_id){
            Booking::deleteWhere('id = ?', array($booking_id));   
			$res = 'success';  
			$callback = json_encode($res, true);
        	return $callback;     
        }else{
            $this->redirect('/error/404');
        }
    }

	public function getDaysBetween($date1 , $date2){
	   $datetime1 = new DateTime($date1);
	   $datetime2 = new DateTime($date2);
	   $interval = $datetime1->diff($datetime2); 
	   return ($interval->format('%d')+1);
	 }
}