<?php
class Constants {
    const WAIT_STATUS = 0;
    const CONFIRMED_STATUS = 1;
    const DENIED_STATUS = 2;
    
    const ZERO = 0;
    const MESSAGE = 0;
	
    const REVIEW_LOT = 1;
    const REVIEW_USER = 2;
    const VOTE_LOT = 3;
    const VOTE_USER = 4;
    const BOOKING_LOT = 5;
	const UMESSAGE = 6;
	const PASSWORD = 7;
	const BOOKING = 8;
	
    const ADMIN_EMAIL = 'stuffexua@gmail.com';
    const INDEX_PAGE_COUNT_LOTS = 15;
	const INDEX_SHOW_LOTS_STEP = 30;
    const RECIVE_MESSAGE_TYPE = 1;
    const SEND_MESSAGE_TYPE = 2;
    
    
    const LOT_DEACTIVE = 1;
    const LOT_ACTIVE = 0;
    
    public static function sendEmail($id, $title, $flag){
    	$user = User::model((int)$id);
		if ($user) {
			$to = $user->email;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=65001' . "\r\n";
			$headers .= "From: Stuffex <info@stuffex.com.ua>\r\n";
			$subject = 'Оповещение от сайта '.App::gi()->config->sitename;
			
			
			switch ($flag) {
				case 0:
					$message = gethtmlmail('Вам было оставленно сообщение на лот '.$title);
					break;
				case 1:
					$message = gethtmlmail('Вам был оставленн отзыв на лот '.$title);
					break;
				case 2:
					$message = gethtmlmail('Вам был оставлен отзыв');
					break;
				case 3:
					$message = gethtmlmail('На ваш лот '.$title.' была оставлена оценка');
					break;
				case 4:
					$message = gethtmlmail('Вам поставили оценку');
					break;
				case 5:
					$message = gethtmlmail('Вам пришло запрос на бронирование лота: '.$title);
					break;
				case 6:
					$message = gethtmlmail('У вас новое сообщение: <a href="http://'.$_SERVER['HTTP_HOST'].'/myprofile?tab3">ссылка</a>');
					break;
				case 7:
					$message = gethtmlmail($title);
					break;
				case 8:
					$message = gethtmlmail($title);
					break;
				default:
					
					break;
			}
			
			return mail($to, $subject, $message,$headers);
			
		}
    	
    }

	public static function sendregemail($u) {
		$user = User::model((int)$u);
		if ($user) {
			$to = $user->email;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=65001' . "\r\n";
			$headers .= "From: Stuffex <info@stuffex.com.ua>\r\n";
			$subject = 'Оповещение от сайта '.App::gi()->config->sitename;
			
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
						<p style="margin-bottom: 20px;">Поздравляем, вы успешно зарегистрировались на <a href="http://'.$_SERVER['HTTP_HOST'].'" style="color: #4667ea;">'.App::gi()->config->sitename.'</a>!</p>
						<p style="margin-bottom: 20px;">Ваш личный кабинет доступен по ссылке: <a href="http://'.$_SERVER['HTTP_HOST'].'/myprofile" style="color: #4667ea;">ссылка</a></p>
						<p style="margin-bottom: 10%;">Чтобы создать новое объявление перейдите по ссылке: <a href="http://'.$_SERVER['HTTP_HOST'].'/lot/add" style="color: #4667ea;">ссылка</a></p>
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
			
			return mail($to, $subject, $message,$headers);
			
		} else {
			return false;
		}
		
		
		
		
		
	}


}
