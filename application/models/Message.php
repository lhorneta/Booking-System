<?php
class Message extends ModelTable{
        
    const NOT_BOOKED = 0;
    const FRESH = 1;
    const NOT_ARCHIVE = 0;
    const ARCHIVE = 1;
    const OLD = 0;
    
    static $table = 'message';
    public $safe = array('id', 'id_to', 'id_lot', 'id_from', 'booked', 'text', 'archive',
                        'file', 'time', 'id_previous', 'display_to', 'display_from', 'new');
    
//    public $categoryTitle = '';
    public $lot = null;
    public $to = null;
    public $from = null;
	public $username = '';
    public $bookingConfirmed = 0;
    
    //Метод поиска предидущего сообщения в истори между пользователями и возврата айди в случае успеха
    public function previousId(){
        $previous = self::modelsWhere('id_to = ? AND id_from = ? OR id_from = ? AND id_to = ? ORDER BY id', array($this->id_to, $this->id_from, $this->id_to, $this->id_from));
        $count = count($previous);
        return $count ? $previous[$count-1]->id : 0 ;        
    }
     
	 
	 // запрос для выборки диалогов:
	// SELECT `message`.*, `user`, `user`.`name`, `user`.`surname`, `user`.`avatar`
	// FROM `message`
	// JOIN
	// (SELECT if(`id_to`='36',`id_from`,`id_to`) AS `user`, MAX(`time`) as `datemax`
	 // FROM `message`
	 // WHERE `id_to`='36' OR `id_from`='36'
	 // GROUP BY IF(`id_to`='36',`id_from`,`id_to`) ) as `message`
	// on if(`id_to`='36',`id_from`,`id_to`)=`user` AND `time`=`datemax`
	// JOIN `user` ON `user`.`id`=`user`
	// WHERE `id_to`='36' OR `id_from`='36'
	 
	 
	 
//    public function categoryInfo(){
//        $this->category
//    }
    public function getUserName($user_id){
       $user = User::modelWhere('id = ?', array($user_id));
	   $this->username = $user->name;
    }
    public function lotInfo(){
        $this->lot = Lot::model($this->id_lot);
    }
    public function toInfo(){
        $this->to = User::model($this->id_to);
    }
    public function fromInfo(){
        $this->from = User::model($this->id_from);
    }
    public function bookingInfo(){
        //debug($this->booked);
		if (Booking::model($this->booked)) {
			$this->bookingConfirmed = ($this->booked != 0) ? Booking::model($this->booked)->confirmed : 0;
		} else {
			$this->bookingConfirmed = 0;
		}

        
    }
    //Метод выборки данных необходимых для страницы переписки между пользователями
//    public function dialogInfo(){
//        $this->lot = Lot::model($this->id_lot);
//        $this->to = User::model($this->id_to);
//        $this->from = User::model($this->id_from);
//    }
}
