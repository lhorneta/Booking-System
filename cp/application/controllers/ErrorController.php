<?php

class ErrorController extends Controller {

    static $rules = array(
        '404' => array(
            'users' => array('*')),
        'notallowed' => array(
            'users' => array('*')),
        'urlallreadyexist' => array(
            'users' => array('*'))
    );

    function actionNotAllowed() {
        echo 'Недостаточно прав';
    }

    function action404() {
        header("HTTP/1.x 404 Not Found");
        echo 'Страница не найдена';
    }
    function actionUrlAllreadyExist() {
        echo 'Такой URL адрес уже существует';
        sleep(5);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    function actionDelete() {
        echo 'Произошла ошибка при удалении';
        sleep(5);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

}
