<?php
class Socials{
     //Facebook sign in
    const FACEBOOK_ID = '204684066578302';
    const FACEBOOK_SECRET = '584e5152697e621547de6d25dc7f8e0d';
    const FACEBOOK_REDIRECT = 'http://stuffex.com.ua/social/facebook';
    const LINK_FACEBOOK_GROUP = 'https://www.facebook.com/stuffexua/';
    //Fields for request url
    const FIELDS = 'id,first_name,last_name,email,gender,picture';
    
    //VK sign in
    const VK_ID = 0;
    const VK_SECRET = 1;
    const VK_REDIRECT = 2;
	const LINK_VK_GROUP = 'https://vk.com/stuffexua';
    //Google plus sign in
    const GOOGLE_ID = '352360794477-b59tkqpmshgu2cvk9j7ubki7tkparm72.apps.googleusercontent.com';
    const GOOGLE_SECRET = 'kxHtbk5sCCqhogLgvKGEqvtQ';
    const GOOGLE_REDIRECT = "http://stuffex.com.ua/social/google";
    //Maps key
    const GOOGLE_MAP_KEY = 'AIzaSyCbY0GC9oACKXfvL8Zl5nNIYHp6PxS0ddY';
    const GOOGLE_MAP_URL = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
    const LINK_GOOGLE_GROUP = 'https://plus.google.com/u/2/b/103584389785907501679/103584389785907501679/about/p/pub';
	
	
    public static function googleMapsLocation($search){
        $url = sprintf("%s%s&key=%s&oe=utf-8&language=ru", self::GOOGLE_MAP_URL, urlencode($search), self::GOOGLE_MAP_KEY);
//        debug($url); die();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
    
    public static function linkFacebook(){
        $url = 'https://www.facebook.com/dialog/oauth';

        $params = array(
            'client_id'     => self::FACEBOOK_ID,
            'redirect_uri'  => self::FACEBOOK_REDIRECT,
            'response_type' => 'code',
            'scope'         => 'email,public_profile'
        );
        $link = $url.'?'.urldecode(http_build_query($params));
        
        return $link;
    }
    public static function linkVK(){
        $url = 'https://www.facebook.com/dialog/oauth';

        $params = array(
            'client_id'     => self::VK_ID,
            'redirect_uri'  => self::VK_REDIRECT,
            'response_type' => 'code',
            'scope'         => 'email,user_birthday,user_location'
        );
        $link = "' . $url . '?' . urldecode(http_build_query($params)) . '";
        
        return $link;
    }
    public static function linkGoogle(){
        $url = 'https://accounts.google.com/o/oauth2/auth';

        $params = array(
            'client_id'     => self::GOOGLE_ID,
            'state' 		=> 'profile',
            'response_type' => 'code',
            'redirect_uri'	=> self::GOOGLE_REDIRECT,
            'scope'         => 'https://www.googleapis.com/auth/userinfo.profile+https://www.googleapis.com/auth/userinfo.email', // 'email,user_birthday,user_location'
        );
        $link = $url . '?' . urldecode(http_build_query($params));

        return $link;
    }
}
