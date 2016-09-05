<?php

class TranslitController extends Controller {

    static $rules = array(
        'torussian' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        )
    );
    
    public function actionToRussian($string){
        return strtr($string,self::english);
    }
    
}