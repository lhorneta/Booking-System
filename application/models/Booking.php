<?php
class Booking extends ModelTable{
    
    const WAIT = 0;
    const CONFIRMED = 1;
    const DENIED = 2;
    
    static $table = 'booking';
    public $safe = array('id', 'id_to', 'id_from', 'id_lot', 'start_rent', 'end_rent', 'status', 'confirmed', 'text', 'start', 'end','order_arr');
    
    public $startTime = 0;
    public $endTime = 0;
    public $recive = array();
    public $send = array();
    public $lot = null;
    public $owner = null;
    public $user = null;
    public $class = '';
    public $classText = '';
    public $username = '';
    
    public function createText(){
        $start = echoRussianDate(strtotime($this->start));
        $end = echoRussianDate(strtotime($this->end));
        $this->text = 'Запрос брони.С '.$start.' года по '.$end.' года.';
    }
    
    public static function allFutureBooking($user){
        $booking = new self;
        $booking->send = Booking::modelsWhere('id_to = ? AND start >= NOW()  ORDER BY id DESC', array($user->id));
        if(count($booking->send)){
            foreach ($booking->send as $send){
                $send->takeInfoSend();
            }
        }
        return $booking;
    }
    
    public static function allPastBooking($user){
        $booking = new self;
        $booking->send = Booking::modelsWhere('id_to = ? AND start < NOW() ORDER BY id DESC', array($user->id));

        if(count($booking->send)){
            foreach ($booking->send as $send){
                self::checkPastBooking($send);
                $send->takeInfoSend();
            }
        }
        return $booking;
    }

	public function getUserName($user_id){
       $user = User::modelWhere('id = ?', array($user_id));
	   if($user){
	   	$this->username = $user->name;
	   }
    }

    public function lotInfo(){
        $this->lot = Lot::model($this->id_lot);
    }
    public function dateInfo(){
        $this->startTime = strtotime($this->start);
        $this->endTime = strtotime($this->end);
    }
//    public function userInfo(){
//        $this->user = User::model($this->id_from);
//    }
    public function ownerInfo(){
        $this->owner = User::model($this->id_to);
    }
    
    public function takeInfoSend(){
        $this->lot = Lot::model($this->id_lot);
        $this->user = User::model($this->id_to);
        switch($this->confirmed){
            case  Constants::WAIT_STATUS :
                $this->class = 'wait';
                $this->classText = 'Ожидание подтверждения';
                break;
            case  Constants::CONFIRMED_STATUS :
                $this->class = 'confirm';
                $this->classText = 'Подтверждено';
                break;
            case  Constants::DENIED_STATUS :
                $this->class = 'cancel';
                $this->classText = 'Отменено';
                break;
            default:
                $this->class = 'other';
                $this->classText = 'Не известный статус';
                break;
        }
    }
    
    private static function checkPastBooking($book){
        if($book->status == Constants::WAIT_STATUS){
            $book->status = Constants::DENIED_STATUS;
        }
    }
}