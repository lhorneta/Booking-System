<?php

class ErrorController extends Controller {
    static $rules = array(
        'index' => array(
                'users' => array('*'),
                'redirect' => '/'),
        'register' => array(
                'users' => array('*'),
                'redirect' => '/'),
        'autorize' => array(
                'users' => array('*'),
                'redirect' => '/'),
        'younotloggin' => array(
                'users' => array('*'),
                'redirect' => '/'),
        'pleaseregister' => array(
                'users' => array('*'),
                'redirect' => '/'),
        'selfaction' => array(
                'users' => array('*'),
                'redirect' => '/'),
        '404' => array(
                'users' => array('*'),
                'redirect' => '/')        
        );
    
    function actionIndex() {
        $this->redirect('/error/404');
    }

    function action404() {
        $this->meta_title = '404';
        header("HTTP/1.x 404 Not Found");
        $this->render('404');
    }
    function actionRegister() {
        echo 'Произошла ошибка при регистрации';
    }
    function actionYouNotLoggin() {
        $this->render('younotloggin');
    }
    
    function actionAutorize() {
        echo 'Ошибка авторизации. Попробуйте еще раз. Возможно ваш аккаунт заблокирован';
    }
    function actionPleaseRegister() {
        echo 'Пожалуйста сначала зарегистрируйтесь';
    }
    function actionSelfAction() {
        echo 'Вы пытаетесь произвести запрещенное действие относящееся к вашему лоту';
    }
}
