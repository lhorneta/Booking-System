<?php

class IndexController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'login' => array(
            'users' => array('guest'),
        ),        
        'rewritepackageprices' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        )
    );
    //Главная страница админ панели
    public function actionIndex() {        
//        $flag = PackageFlag::modelWhere('id');
        $this->render('index');
    }
    
    //Метод отслеживания флага для снижения цен пакетов включающих акционные товары
    public function actionRewritePackagePrices() {
        $flag = PackageFlag::modelWhere('id');
        
        if((int)$flag->value === 0){
            $flag->value = 1;
        }else{
            $flag->value = 0;            
        }
        
        $flag->save();
    }
}

