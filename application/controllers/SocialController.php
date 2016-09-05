<?php
 
class SocialController extends Controller {
    static $rules = array(
        'facebook' => array(
            'users' => array('guest'),
            'redirect' => '/'
        ),
        'vk' => array(
            'users' => array('guest'),
            'redirect' => '/'
        ),
        'google' => array(
            'users' => array('guest'),
            'redirect' => '/'
        )
    );
    //facebook sig in
    public function actionFacebook() {
        if (isset($_GET['code'])) {
            $result = false;

            $params = array(
                'client_id'     => Socials::FACEBOOK_ID,
                'redirect_uri'  => Socials::FACEBOOK_REDIRECT,
                'client_secret' => Socials::FACEBOOK_SECRET,
                'code'          => $_GET['code']
            );

            $url = 'https://graph.facebook.com/oauth/access_token';

            $tokenInfo = null;
            parse_str(file_get_contents($url . '?' . http_build_query($params)), $tokenInfo);

            if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
                $params = array('access_token' => $tokenInfo['access_token']);

                $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me?fields='.Socials::FIELDS.'&' . urldecode(http_build_query($params))), true);
//debug($userInfo);
                if (isset($userInfo['id'])) {
                    $userInfo['social'] = 'facebook';
					unset($userInfo['picture']);
					$userpic = json_decode(file_get_contents('https://graph.facebook.com/me/picture?fields=redirect,height,url,width&type=large&redirect&access_token='.$tokenInfo['access_token']), true);
					$userInfo['pic'] = $userpic['data']['url'];
                    $info = json_encode($userInfo, JSON_UNESCAPED_UNICODE);
					$i=base64_encode($info);
                    $this->redirect('/register/social?user='.$i);
                }
            }
        }
    }
    //vk sig in
    public function actionVK() {
        
        $this->render('vk');
    }
    //google plus sig in
    public function actionGoogle() {
        if (isset($_GET['code'])) {
        	$result = false;

		    $params = array(
		        'client_id'     => Socials::GOOGLE_ID,
		        'client_secret' => Socials::GOOGLE_SECRET,
		        'redirect_uri'  => Socials::GOOGLE_REDIRECT,
		        'grant_type'    => 'authorization_code',
		        'code'          => $_GET['code']
		    );
			
			$url = 'https://accounts.google.com/o/oauth2/token';
			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($curl);
			curl_close($curl);

			$tokenInfo = json_decode($result, true);

			if (isset($tokenInfo['access_token'])) {
			    $params['access_token'] = $tokenInfo['access_token'];
				
			    $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
			    if (isset($userInfo['id'])) {
			        $userInfo = $userInfo;
			        $result = true;
					
					$userInfo['social'] = 'google';
                    $info = json_encode($userInfo, JSON_UNESCAPED_UNICODE);
					$i=base64_encode($info);
                    $this->redirect('/register/social?user='.$i);
					
			    }
			}
			
        }
        $this->render('google');
    }
}
