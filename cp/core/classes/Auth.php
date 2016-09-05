<?php

class Auth {

    static function isRegister() {
        
    }

    static function isLogged() {
        
    }

    static function authorize($token) {
        self::setCookie('auth_token', $token);
    }
    
    static function issetCookie($name){
        return (isset($_COOKIE[$name]) && !empty($_COOKIE[$name])) ? true : false;
    }

    static function setCookie($name, $value) {
        setcookie($name, $value, time() + app::gi()->config->cookietime);
    }
    static function unsetCookie($name){
        setcookie($name,'',-1);
    }
    static function generateToken(){
        return md5(uniqid(rand(), true));
    }

}
