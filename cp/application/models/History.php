<?php
class History extends ModelTable{
    static $table = 'history';
    public $safe = array('id', 'id_to', 'id_message', 'id_from', 'time', 'id_previous', 'display_to', 'display_from', 'new');
    
    //Метод поиска предидущего сообщения в истори между пользователями и возврата айди в случае успеха
    public function actionPreviousId(){
        $previous = self::modelsWhere('id_to = ? AND id_from = ? ORDER BY id', array($this->id_to, $this->id_from));
        return count($previous) ? $previous[0]->id : 0 ;        
    }
}
