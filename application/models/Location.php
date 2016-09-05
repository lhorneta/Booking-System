<?php 
class Location extends ModelTable {
    
    static $table = 'location';
    public $safe = array('id', 'longitude', 'latitude', 'address');
       
    public function create(User $user, $longitude, $latitude, $address){
//        parent::__construct();
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->address = $address;
        $this->save();
        $user->location = $this->id;
//        $user->save();
        
//        debug($this);
//        debug($user);
//        die();
    }
}