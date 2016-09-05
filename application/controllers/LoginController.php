<?php

class LoginController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('guest'),
            'redirect' => '/'),
        'forgot' => array(
            'users' => array('guest'),
            'redirect' => '/'),
        'recovery' => array(
            'users' => array('guest'),
            'redirect' => '/'),
        'newpass' => array(
            'users' => array('guest'),
            'redirect' => '/'),
        'logout' => array(
            'users' => array('user', 'business'),
            'redirect' => '/')
    );
    //Метод проверки на правельность введенных пользователем данных и предоставления прав зарегестрированого пользователя
    function actionIndex() {
        $errors = '';
        $user = null;
        if (isset($_POST['form'])) {
            $email = $_POST['form']['email'];
            $password = $_POST['form']['password'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors = 'Email указан неверно.';
            } else {
                $user = User::modelWhere('email = ? AND password = ? AND bane = ?', array($email, $password, User::ACTIVE));
                if ($user) {

                    switch ($user->confirmed) {
                        case User::ACTIVE: {
                                $user->auth_token = generateToken();
                                if($user->save()){
                                    loginUser($user->auth_token);//Ставим куку
//                                    $errors = "Вы успешно вошли в систему";

							
                                    //$this->redirect('/');

                                    $this->redirect('/');

                                } else {
                                    $errors/*[]*/ = 'Ошибка авторизации. Попробуйте еще раз.';
                                }
                            } break;
                        case User::DEACTIVE: {
                        		$errors/*[]*/ = "Пользователь зарегистрирован, но аккаунт не активирован. Пожалуйста, перейдите по ссылке отправленной на указанный Email. <a href='http://". $_SERVER['HTTP_HOST'] . "/register/sendconfirmationmail/" . $user->id. "' >Отправить ссылку повторно</а>";
                            } break;
                        default : {
                                $errors/*[]*/ = 'Ошибка авторизации. Попробуйте еще раз.';
                            }
                    }
                } else {
                    $errors/*[]*/ = 'Не верно введен логин или пароль / либо аккаунт заблокирован';
                }
            }
        }
	//	$this->render('login', array('errors' => $errors));
        echo "<div class='error-message'>".$errors."</div>";
//        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    //Метод восстановления пароля
    function actionForgot() {
        $error = '';
        if (isset($_POST['femail'])) {
            $userForgot = User::modelWhere('email = ?', array(trim(strip_tags($_POST['femail']))));
            if ($userForgot) {
//                debug($_POST);
//                debug($userForgot);
//                die();
                $message = md5(uniqid());
                $userForgot->hash = $message;//Хэш для ссылки
                $userForgot->hash_time = time() + 3600;//Время действи хэша
                if($userForgot->save()){                    
                    $link = "http://" . $_SERVER['HTTP_HOST'] . "/login/recovery/$message";
                    $to = $userForgot->email;
                    $subject = App::gi()->config->sitename;
					
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=65001' . "\r\n";
					$headers .= "From: Stuffex <info@stuffex.com.ua>\r\n";
                    $query = "Вы получили это письмо, потому что нам был отправлен запрос\r\n"
                            . "на изменение вашего пароля для входа в систему,\r\n"
                            . "если вы этого не делали то проигнорируйте это сообщение.\r\n"
                            . "Для того что бы изменить пароль пройдите по этой ссылке:\r\n";
                    $query .= $link;
                    
					
					$message = '<!DOCTYPE html>
					<html lang="en">
					<head>
						<meta charset="UTF-8">
						<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
						<title>Message</title>
						<link href="https://fonts.googleapis.com/css?family=Architects+Daughter" rel="stylesheet" type="text/css">
					</head>
					<body style="font: 14px/20px Arian, sans-serif; color: #999999;">
						<div style="background: #f1f1f1;">
							<div style="background: #ffffff url(http://neolx.ntcn1.xyz/assets/images/nav-after.jpg) 0 0 no-repeat; background-size: 100% 4px; padding: 0 15px; margin-bottom: 30px; border-bottom: 1px solid #e5e5e5">
								<header style="max-width: 630px; margin: 0 auto; padding: 20px 0;">
									<img src="http://neolx.ntcn1.xyz/assets/images/logo.png" alt="Logo" style="width: 144px;">
								</header>
							</div>
							<div style="max-width: 570px; background: #ffffff; padding: 50px 30px 30px 30px; border: 1px solid #e5e5e5; margin:0 auto 25px auto;">
								<h2 style="font-size: 22px; color: #333; margin-bottom: 20px;">Здравствуйте!</h2>
								<p style="margin-bottom: 20px;">Для восстановления пароля перейдите по ссылке: <a href="'.$link.'" style="color: #4667ea;">ссылка</a>.</p>
								<p style="margin-bottom: 10%;">Если вы не подавали заявку на восстановление пароля, то просто проигнорируйте это письмо.</p>
								<span style="font-size: 16px; color: #fa5400;">С наилучшими пожеланиями, команда Stuffex.</span>
							</div>
							<footer style="background: #ffffff; padding: 0 15px; border-bottom: 1px solid #e5e5e5; border-top: 1px solid #e5e5e5; overflow: hidden;">
								<div style="max-width: 630px; margin: 0 auto; padding: 20px 0;">
									<div style="float: left; margin-right: 10px;">Полезные ссылки:</div>
									<ul style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; list-style: none; padding: 0; margin: 0;">
										<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab1" style="color: #4667ea; display: inline-block; text-decoration: none;">Блог</a></li>
										<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab3" style="color: #4667ea; display: inline-block; text-decoration: none;">О нас</a></li>
										<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab4" style="color: #4667ea; display: inline-block; text-decoration: none;">FAQ</a></li>
										<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab6" style="color: #4667ea; display: inline-block; text-decoration: none;">Как это работает</a></li>
										<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab5" style="color: #4667ea; display: inline-block; text-decoration: none;">Условия использования</a></li>
										<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab2" style="color: #4667ea; display: inline-block; text-decoration: none;">Контакты</a></li>
									</ul>
								</div>
							</footer>
							<div style="padding: 20px 0; text-align: center;">Это сообщение было отправлено автоматически. Пожалуйста, не отвечайте на него.</div>
						</div>
					</body>
					</html>';
					
					
					
                    //$headers = "Content-Type: text/html; charset=utf8\r\n";
                    
                    mail($to, $subject, $message, $headers);//Письмо на почту пользователя с ссылкой на необходимую страницу для восстановления пароля
//                    $this->render('silka', array('query'=>$link));
                    $this->redirect('/');
                }
            } else {
                $error = 'Введеный вами имейл не найден, проверте правильность написания';
            }
        }
        $this->render('forgot', ['error' => $error]);
    }
    //Метод установки нового пароля
    function actionNewPass($hash) {
        $userRecovery = User::modelWhere('hash = ?', array(trim(strip_tags($hash))));
        if ($userRecovery) {
            if ($userRecovery->hash === $hash and $userRecovery->hash_time > time()) {
                if (isset($_POST['pass'])and ( $_POST['pass'] === $_POST['passchek'])) {
                    $userRecovery->password = trim(strip_tags($_POST['pass']));
                    if($userRecovery->save()){
                    	
						$to = $userRecovery->email;
		                $subject = App::gi()->config->sitename;
						
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=65001' . "\r\n";
						$headers .= "From: Stuffex <info@stuffex.com.ua>\r\n";
						
						$message = '<!DOCTYPE html>
						<html lang="en">
						<head>
							<meta charset="UTF-8">
							<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
							<title>Message</title>
							<link href="https://fonts.googleapis.com/css?family=Architects+Daughter" rel="stylesheet" type="text/css">
						</head>
						<body style="font: 14px/20px Arian, sans-serif; color: #999999;">
							<div style="background: #f1f1f1;">
								<div style="background: #ffffff url(http://neolx.ntcn1.xyz/assets/images/nav-after.jpg) 0 0 no-repeat; background-size: 100% 4px; padding: 0 15px; margin-bottom: 30px; border-bottom: 1px solid #e5e5e5">
									<header style="max-width: 630px; margin: 0 auto; padding: 20px 0;">
										<img src="http://neolx.ntcn1.xyz/assets/images/logo.png" alt="Logo" style="width: 144px;">
									</header>
								</div>
								<div style="max-width: 570px; background: #ffffff; padding: 50px 30px 30px 30px; border: 1px solid #e5e5e5; margin:0 auto 25px auto;">
									<h2 style="font-size: 22px; color: #333; margin-bottom: 20px;">Здравствуйте!</h2>
									<p style="margin-bottom: 20px;">Поздравляем, теперь у вас новый пароль!</p>
									<p style="margin-bottom: 20px;">Ваш личный кабинет доступен по ссылке: <a href="http://neolx.ntcn1.xyz/myprofile">ссылка</a></p>
									<p style="margin-bottom: 10%;">Чтобы создать новое объявление перейдите по ссылке: <a href="http://neolx.ntcn1.xyz/lot/add/">ссылка</a></p>
									<span style="font-size: 16px; color: #fa5400;">С наилучшими пожеланиями, команда Stuffex.</span>
								</div>
								<footer style="background: #ffffff; padding: 0 15px; border-bottom: 1px solid #e5e5e5; border-top: 1px solid #e5e5e5; overflow: hidden;">
									<div style="max-width: 630px; margin: 0 auto; padding: 20px 0;">
										<div style="float: left; margin-right: 10px;">Полезные ссылки:</div>
										<ul style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; list-style: none; padding: 0; margin: 0;">
											<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab1" style="color: #4667ea; display: inline-block; text-decoration: none;">Блог</a></li>
											<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab3" style="color: #4667ea; display: inline-block; text-decoration: none;">О нас</a></li>
											<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab4" style="color: #4667ea; display: inline-block; text-decoration: none;">FAQ</a></li>
											<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab6" style="color: #4667ea; display: inline-block; text-decoration: none;">Как это работает</a></li>
											<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab5" style="color: #4667ea; display: inline-block; text-decoration: none;">Условия использования</a></li>
											<li style="margin: 0 5px;"><a href="http://stuffex.com.ua/info/index?tab2" style="color: #4667ea; display: inline-block; text-decoration: none;">Контакты</a></li>
										</ul>
									</div>
								</footer>
								<div style="padding: 20px 0; text-align: center;">Это сообщение было отправлено автоматически. Пожалуйста, не отвечайте на него.</div>
							</div>
						</body>
						</html>';
						
						mail($to, $subject, $message, $headers);
						
                        $this->render('passwordChanged');
                    }
                }
            }
        }
    }
    //Метод проверки соответсвия ссылки и данных из базы (хэш и время действия хэша)
    function actionRecovery($hash) {
        $recoveryHash = trim(strip_tags($hash));
        $user = User::modelWhere('hash = ?', array($hash));
        if($user){
//            debug($user);
//            die();
            if ($user->hash === $recoveryHash and $user->hash_time > time()) {
                $this->render('recovery', array('hash' => $recoveryHash));
            }
        }
    }
    //Метод снятия прав зарегестрированного пользователя и выход из системы
    function actionLogOut(){        
        logoutUser();
        $this->redirect('/');
    }

}
