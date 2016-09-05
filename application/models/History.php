<?php
class History extends ModelTable{
    
    const FRESH = 1;
    
    static $table = 'history';
    public $safe = array('id', 'id_to', 'id_message', 'id_from', 'time', 'id_previous', 'display_to', 'display_from', 'new');
    
    //Метод поиска предидущего сообщения в истори между пользователями и возврата айди в случае успеха
    public function previousId(){
        $previous = self::modelsWhere('id_to = ? AND id_from = ? OR id_from = ? AND id_to = ? ORDER BY id', array($this->id_to, $this->id_from, $this->id_to, $this->id_from));
        $count = count($previous);
        return $count ? $previous[$count-1]->id : 0 ;        
    }
}
