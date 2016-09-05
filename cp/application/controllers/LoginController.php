<?php
class LoginController extends Controller{
    static $rules = array(
        'index' => array(
                'users' => array('guest'),
                'redirect' => '/cp/index'),
        'logout' => array(
                'users' => array('admin'),
                'redirect' => '/cp/login')
    );
    //Метод проверки корректности введенных данных и входа в админ панель
    function actionIndex(){
        $this->layout = 'empty';
        $error = '';
        if (isset($_POST['form'])) {
            $login = $_POST['form']['login'];
            $password = $_POST['form']['password'];
            $user = User::modelWhere('fio = ? AND password = ? AND active = ?', array($login, $password,User::ACTIVE));
                        
            if ($user) {                
                $token = Auth::generateToken();
                $user->auth_token = $token;
                
                if ($user->save()) {
                    loginUser($token);
                    $this->redirect('/cp');
                }
            } else {
                $error = 'Указанная пара логин \ пароль не найдена, либо данный аккаунт заблокирован';
            }
        }
        $this->render('login', array('error' => $error));
    }
    //Метод снятия доступа к админской части
    function actionLogOut(){ 
        logoutUser();
        $this->redirect('/cp/login');
    }
}