<?php

class AdminController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'add' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'subscribers' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'newpass' => array(
            'users' => array('guest'),
            'redirect' => '/cp/login'
        ),
        'checkquestion' => array(
            'users' => array('guest'),
            'redirect' => '/cp/login'
        ),
        'forgot' => array(
            'users' => array('guest'),
            'redirect' => '/cp/login'
        ),
        'status' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        ),
        'delete' => array(
            'users' => array('admin'),
            'redirect' => '/cp/login'
        )
    );
    //Отображение активных и не активных администраторов
    public function actionIndex($id = 0) {
        $active = User::modelsWhere('active = ? ORDER BY fio', array(User::ACTIVE));
        $deactive = User::modelsWhere('active = ? ORDER BY fio', array(User::DEACTIVE));

        $questions = User::questions();
        $this->render('index', array('active' => $active, 'deactive' => $deactive, 'questions'=>$questions));
    }
    //Добавление нового администратора
    public function actionAdd($id = 0) {
        $admin = User::model((int) $id);
        if (!$admin) {
            $admin = new User();
        }
        if (isset($_POST['form'])) {
            $admin->__attributes = $_POST['form'];
            $admin->active = User::DEACTIVE;
            $admin->id_role = User::ADMIN;
            $admin->time = time();
            $admin->save();
            $this->redirect('/cp/admin');
        }
    }
    //Смена статуса администратора активирован\деактивирован
    public function actionStatus($id = 0) {
        $admin = User::model((int) $id);
        if($admin){
            if ($admin->active == User::DEACTIVE) {
                $admin->active = User::ACTIVE;
            } else {
                $admin->active = User::DEACTIVE;
            }
            $admin->save();
            $this->redirect('/cp/admin');
        }else{
            $this->redirect('/cp/error/404');
        }
    }
    //Удаление администратора
    public function actionDelete($id = 0) {
        $admin = User::model((int)$id);
        if($admin){
            User::delete((int) $id);            
            $this->redirect('/cp/admin');
        }else{
            $this->redirect('/cp/error/404');
        }
    }
    //Метод рассылки новостей всем подписчикам
    public function actionSubscribers() {
        if(isset($_POST['form'])){
            $to = '';
            $subject = '';
            $subscribers = UserFront::modelsWhere('subscriber = ?', array(UserFront::SUBSCRIBER));
            if(count($subscribers)){
                foreach($subscribers as $subscriber){
                    $to .= $subscriber->email.',';
                }
            }
            $message = trim(strip_tags($_POST['form']['message']));
            $subject = trim(strip_tags($_POST['form']['title'])).' от '. App::gi()->config->sitename;
            if(mail($to, $subject, $message)){
                $message .= 'сообщение для: '.$to;
                $this->render('ok', array('message'=>$message));
            }
        }else{
            $this->render('subscribers');
        }
    }
    //Метод определения существования такого пользователя
    function actionForgot() {
        $this->layout = 'empty';
        if (isset($_POST['femail'])) {
            $error = '';
            $userForgot = User::modelWhere('email = ?', array(trim(strip_tags($_POST['femail']))));
            if ($userForgot) {
                $error = 'Пользователь найден, ответьте на котнрольный вопрос и введите новый пароль';
                $this->render('forgot', array('admin'=>$userForgot, 'message'=>$error));
            }else{             
                echo '<p class="errmsg">Введеный вами имейл не найден, проверте правильность данных</p>';
            }
        }else{
            $this->redirect('/cp/error/404');
        }
    }
    //Метод проверки контрольного вопроса и ответа на него
    function actionCheckQuestion($id = 0) {
        $this->layout = 'empty';
        $userRecovery = User::model((int)$id);
        if ($userRecovery) {
            if (isset($_POST['answer'])){
                if($userRecovery->answer == trim(strip_tags($_POST['answer']))){
                    echo 'ok';
                }else{
                    echo '<p class="errmsg">Неправильный ответ на контрольный вопрос</p>';
                }
            }else{
                $this->redirect('/cp/error/404');
            }
        }else{
                $this->redirect('/cp/error/404');
        }
    }
    //Метод установки нового пароля
    function actionNewPass($id = 0) {
        $userRecovery = User::model((int)$id);
        if ($userRecovery) {
            if (isset($_POST['pass']) and ( $_POST['pass'] === $_POST['passcheck'])) {
                $userRecovery->password = trim(strip_tags($_POST['pass']));
                if($userRecovery->save()){
                    echo 'Пароль успешно изменен';
                    $this->redirect('/cp/login');
                }
            }else{
                echo 'Пароли различаются, проверте правильность написания';
            }
        }
    }

}
