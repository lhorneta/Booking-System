<?php

class RegisterController extends Controller {

    static $rules = array(
        'index' => array(
            'users' => array('guest'),
            'redirect' => '/'
        ),
        'social' => array(
            'users' => array('guest'),
            'redirect' => '/'
        ),
        'sendconfirmationmail' => array(
            'users' => array('guest'),
            'redirect' => '/'
        ),        
        'confirmation' => array(
            'users' => array('guest'),
            'redirect' => '/'
        ),
        'success' => array(
            'users' => array('guest'),
            'redirect' => '/'
        )
    );
    //Метод регистрации нового пользователя
    function actionIndex() {
        $user = new User();
        if (isset($_POST['form'])) {
			$this->layout = 'clear';
        	$this->mainTemplate = 'clear';
			
            $user->__attributes = $_POST['form'];
            if (!User::isUnique('email', $_POST['form']['email'])) {
                $user->errors[] = 'Введеный вами имейл уже зарегестрирован';
            }elseif ($user->password !== $_POST['form']['passcheck']) {
                $user->errors[] = 'Введенные вами пароли не совпадают';
            }
            $user->confirmed = User::DEACTIVE;
            $user->id_role = User::USER;
            $user->register_time = time();

            if ($user->save()) {
                $userSettings = new Setting();
                $userSettings->id_user = $user->id;
                $userSettings->show_deactive = Setting::HIDE;
                $userSettings->hide_address = Setting::HIDE;
                $userSettings->save();
                if ($this->sendConfirmationMail($user)) {
                    $this->render('success');
                } else {
                    $this->render('fail');
                }
                return;
            }
        }
        $this->render('register', array('user' => $user));
    }
	
	public function actionSuccess() {
		$this->render('success');
	}

    //Подтвержение регистрации
    public function actionConfirmation($hash) {
        $messages = array();
        $user = User::modelWhere('hash = ?', array($hash));
        if ($user) {
            if ($user->hash_time > time()) {
                $user->confirmed = User::ACTIVE;
                $user->hash_time = 0;
                if ($user->save()) {
                    $messages[] = 'Аккаунт успешно активирован';
					Constants::sendregemail($user->id);
                } else {
                    $messages[] = 'В ходе активации аккаунта произошла ошибка';
                }
            } else {
                $messages[] = 'Время отведенное на подтверждение регистрации истекло';
                $messages[] = $this->sendConfirmationMail($user) ? 'Вам отправлено новое письмо для активации аккаунта' : '';
            }
        } else {
            $messages[] = 'Не правильная ссылка';
        }
        $this->render('confirmation', ['messages'=>$messages]);
    }
        
    //Отправка почты с хэш ссылкой для активации аакаунта
    public function actionSendConfirmationMail($user_id) {
    	$user = User::modelWhere('id = ?', array($user_id));
        $user->hash = generateToken();
        $user->hash_time = time() + 60 * 60 * 24;
        if ($user->save()) {
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=65001' . "\r\n";
			$headers .= "From: Stuffex <info@stuffex.com.ua>\r\n";
			$un = ($user->name)?', '.$user->name:'';
			
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
						<h2 style="font-size: 22px; color: #333; margin-bottom: 20px;">Здравствуйте'.$un.'!</h2>
						<p style="margin-bottom: 10%;">Для того чтобы подтвердить Ваш e­mail адрес перейдите по ссылке: <a href="http://'.$_SERVER['HTTP_HOST'].'/register/confirmation/'.$user->hash.' style="color: #4667ea;">ссылка</a></p>
						<span style="font-size: 16px; color: #fa5400;">С наилучшими пожеланиями, команда Stuffex.</span>
					</div>
					<footer style="background: #ffffff; padding: 0 15px; border-bottom: 1px solid #e5e5e5; border-top: 1px solid #e5e5e5; overflow: hidden;">
						<div style="max-width: 630px; margin: 0 auto; padding: 20px 0;">
							<div style="float: left; margin-right: 10px;">Полезные ссылки:</div>
							<ul style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; list-style: none; padding: 0; margin: 0;">
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab1" style="color: #4667ea; display: inline-block; text-decoration: none;">Блог</a></li>
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab3" style="color: #4667ea; display: inline-block; text-decoration: none;">О нас</a></li>
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab4" style="color: #4667ea; display: inline-block; text-decoration: none;">FAQ</a></li>
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab6" style="color: #4667ea; display: inline-block; text-decoration: none;">Как это работает</a></li>
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab5" style="color: #4667ea; display: inline-block; text-decoration: none;">Условия использования</a></li>
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab2" style="color: #4667ea; display: inline-block; text-decoration: none;">Контакты</a></li>
							</ul>
						</div>
					</footer>
					<div style="padding: 20px 0; text-align: center;">Это сообщение было отправлено автоматически. Пожалуйста, не отвечайте на него.</div>
				</div>
			</body>
			</html>';
			
			
            mail($user->email, 'Подтверждение регистрации', $message,$headers);
			
			//$this->render('success');
			$errors/*[]*/ = 'Пожалуйста, перейдите по ссылке отправленной на Ваш Email.';
			$this->render('success', array('errors' => $errors));
        }
        return false;
    }
	
    //Отправка почты с хэш ссылкой для активации аакаунта
    private function sendConfirmationMail(User $user) {
        $user->hash = generateToken();
        $user->hash_time = time() + 60 * 60 * 24;
        if ($user->save()) {
        	$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=65001' . "\r\n";
			$headers .= "From: Stuffex <info@stuffex.com.ua>\r\n";
            $mailMessage = "Уважаемый(ая) ". $user->name  .". Вы были зарегестрированы на " . App::gi()->config->sitename . ". \n";
            $mailMessage .= "Пройдите по ссылке для активации аккаунта : http://" . $_SERVER['HTTP_HOST'] . "/register/confirmation/" . $user->hash;
			$un = ($user->name)?', '.$user->name:'';
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
						<h2 style="font-size: 22px; color: #333; margin-bottom: 20px;">Здравствуйте'.$un.'!</h2>
						<p style="margin-bottom: 10%;">Для того чтобы подтвердить Ваш e­mail адрес перейдите по ссылке: <a href="http://'.$_SERVER['HTTP_HOST'].'/register/confirmation/'.$user->hash.' style="color: #4667ea;">ссылка</a></p>
						<span style="font-size: 16px; color: #fa5400;">С наилучшими пожеланиями, команда Stuffex.</span>
					</div>
					<footer style="background: #ffffff; padding: 0 15px; border-bottom: 1px solid #e5e5e5; border-top: 1px solid #e5e5e5; overflow: hidden;">
						<div style="max-width: 630px; margin: 0 auto; padding: 20px 0;">
							<div style="float: left; margin-right: 10px;">Полезные ссылки:</div>
							<ul style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; list-style: none; padding: 0; margin: 0;">
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab1" style="color: #4667ea; display: inline-block; text-decoration: none;">Блог</a></li>
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab3" style="color: #4667ea; display: inline-block; text-decoration: none;">О нас</a></li>
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab4" style="color: #4667ea; display: inline-block; text-decoration: none;">FAQ</a></li>
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab6" style="color: #4667ea; display: inline-block; text-decoration: none;">Как это работает</a></li>
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab5" style="color: #4667ea; display: inline-block; text-decoration: none;">Условия использования</a></li>
								<li style="margin: 0 5px;"><a href="http://'.$_SERVER['HTTP_HOST'].'/info/index?tab2" style="color: #4667ea; display: inline-block; text-decoration: none;">Контакты</a></li>
							</ul>
						</div>
					</footer>
					<div style="padding: 20px 0; text-align: center;">Это сообщение было отправлено автоматически. Пожалуйста, не отвечайте на него.</div>
				</div>
			</body>
			</html>';
			//, '.$user->name.'
            return mail($user->email, 'Подтверждении регистрации', $message,$headers);
        }
        return false;
    }
    //Проверка на существующего пользователя который логинится через соц.сеть
    public function actionSocial() {
    	
		
    	$json = (isset($_REQUEST['user']))?$_REQUEST['user']:'';
        if($json!=''){
        	//echo "string";
        	$userInfo = base64_decode($json);
			//echo $userInfo;
			$userInfo = json_decode($userInfo);
			if (!$userInfo) {
				$this->redirect('/login');
			}
            $social = $userInfo->social;
            $errors = '';
            $user = null;
//debug($userInfo);
            switch($social){
                case 'facebook':
					
                    $user = User::modelWhere('email = ?', array($userInfo->email));
                    if($user){
                        if($user->bane == USER::ACTIVE){
                            $this->layout = 'clear';
                            $user->auth_token = generateToken();
                            if($user->save()){
                                loginUser($user->auth_token);//Ставим куку
    //                            $errors = "Вы успешно вошли в систему.<br>";
                                $this->redirect('/');
                            } else {
                                $this->redirect('/error/autorize');
                            } 
                        } else {
                            $this->redirect('/error/autorize');
                        }
//                        $this->render('social' , array('error'=>$errors);
                    }else{
//                        $fields = (array) $userInfo;
//                        unset($fields['id']);
//                        debug($field); die();
                        $user = new User();
//                        $user->__attributes = $fields;
                        $user->name = $userInfo->first_name;
                        $user->surname = $userInfo->last_name;
                        $user->email = $userInfo->email;
                        $user->gender = $userInfo->gender;
						// if ($userInfo->pic) {
							// $user->avatar = $userInfo->pic;
						// }
                        $user->bane = User::ACTIVE;
                        $user->id_role = User::USER;
                        $user->register_time = time();
						$user->auth_token = generateToken();
						loginUser($user->auth_token);
                        if ($user->save()) {
                        	Constants::sendregemail($user->id);
							if ($userInfo->pic) {
								
								$upload_dir = $_SERVER['DOCUMENT_ROOT'] . User::UPLOAD_DIR . $user->id . '/';
						        if (!file_exists($upload_dir)) {
						            if (!mkdir($upload_dir, 0777, true)) {
						                die('Не удалось создать: ' . $upload_dir);
						            }
						        }
								file_put_contents($upload_dir.'/avatar.jpg', file_get_contents($userInfo->pic));
								$user->avatar = '/uploads/user/'.$user->id.'/avatar.jpg';
								$user->save();
							}
							
                            $userSettings = new Setting();
                            $userSettings->id_user = $user->id;
                            $userSettings->show_deactive = Setting::HIDE;
                            $userSettings->hide_address = Setting::HIDE;
                            if($userSettings->save()){
//                                debug($json); die();
								$this->redirect('/');
                                $this->redirect('/register/social/'.$json);
                            }else{
                                $this->redirect('/error/register');
                            }
							$this->redirect('/');
                        }
                    }
                    break;
                case 'vk':
                    break;
                case 'google':
					//echo "string";
					$user = User::modelWhere('email = ?', array($userInfo->email));

                    if($user){
                        if($user->bane == USER::ACTIVE){
                            $this->layout = 'clear';
                            $user->auth_token = generateToken();
                            if($user->save()){
                                loginUser($user->auth_token);//Ставим куку
    //                            $errors = "Вы успешно вошли в систему.<br>";
                                $this->redirect('/');
                            } else {
                                $this->redirect('/error/autorize');
                            } 
                        } else {
                            $this->redirect('/error/autorize');
                        }

                    }else{

                        $user = new User();
                        $user->name = $userInfo->given_name;
                        $user->surname = $userInfo->family_name;
                        $user->email = $userInfo->email;
                        $user->gender = 0;
                        $user->bane = User::ACTIVE;
                        $user->id_role = User::USER;
                        $user->register_time = time();
						$user->auth_token = generateToken();
						loginUser($user->auth_token);
                        if ($user->save()) {
                        	Constants::sendregemail($user->id);

							if ($userInfo->picture) {
								
								$upload_dir = $_SERVER['DOCUMENT_ROOT'] . User::UPLOAD_DIR . $user->id . '/';
						        if (!file_exists($upload_dir)) {
						            if (!mkdir($upload_dir, 0777, true)) {
						                die('Не удалось создать: ' . $upload_dir);
						            }
						        }
								file_put_contents($upload_dir.'/avatar.jpg', file_get_contents($userInfo->picture));
								$user->avatar = '/uploads/user/'.$user->id.'/avatar.jpg';
								$user->save();
							}
							
                            $userSettings = new Setting();
                            $userSettings->id_user = $user->id;
                            $userSettings->show_deactive = Setting::HIDE;
                            $userSettings->hide_address = Setting::HIDE;
                            if($userSettings->save()){
                            	//echo $json;
								$this->redirect('/');
                                //$this->redirect('/register/social/'.$json);
                            }else{
                                $this->redirect('/error/register');
                            }
							$this->redirect('/');
                        }
                    }

                    break;
                default:
                    $errors = 'Нет такой соц сети.<br>';
                    break;
            }
//            debug($user);
//            debug($errors);
//            die();
        }else{
            //$this->redirect('/error/404');
        }
    }

}
