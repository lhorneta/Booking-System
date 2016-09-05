<?php

class Settings extends ModelTable {
    static $table = 'config';
    public $safe = array('id', 'title', 'value');

    /**
     * @return string
     * */
    static function lang() {
        $conf = Settings::modelWhere('title = ?', array('language'));
        $lang = Language::model($conf->value);
        return $lang->url;
    }

}
