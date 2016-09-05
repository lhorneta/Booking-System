<?php

function debug($data, $stop = false) {
    echo '<pre>';
    print_r($data);
    echo '<pre>';
    if ($stop) {
        exit();
    }
}

//генерация временного пароля
function generatePassword($length = 8) {
    $password = "";
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
    $maxlength = strlen($possible);
    if ($length > $maxlength) {
        $length = $maxlength;
    }
    $i = 0;
    while ($i < $length) {
        $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
        if (!strstr($password, $char)) {
            $password .= $char;
            $i++;
        }
    }
    return $password;
}

//генерация токена для авторизации
function generateToken() {
    return md5(uniqid(rand(), true));
}

function loginUser($token, $path = '/cp') {
    setcookie('auth_token', $token, time() + app::gi()->config->cookietime, $path);
}

function logoutUser($path = '/cp') {
    setcookie('auth_token', '', time() - 1, $path);
}

/**
 * Уставнавливает куки для выбраного региона
 * 
 * строка вида id_country:id_region:id_city
 * например 43:657:67
 * @return boolean
 * */
//function setCookieLocation($id_city = 0, $id_region = 0, $id_country = 0) {
//    $string = $id_city . ':' . $id_region . ':' . $id_country;
//    setcookie('region', $string, time() + app::gi()->config->cookietime, '/');
//    return isset($_COOKIE['region']) ? true : false;
//}

/**
 * Парсит куку хранящую информацию о регионе
 * @return array
 * */
function getCookieLocation() {
    if (isset($_COOKIE['region']) && !empty($_COOKIE['region'])) {
        $region = explode(':', $_COOKIE['region']);
        if (count($region) == 3) {
            return array('id_city' => (int) $region[0], 'id_region' => (int) $region[1], 'id_country' => (int) $region[2]);
        }
    }
    return false;
}

//возвращает переод по ключу из массива
function lang($key) {
    return array_key_exists($key, app::gi()->translate) ? app::gi()->translate[$key] : '';
}
//Метод который вставляет пробел в строку отделяя "тысячи"
function thousandPrice($price) {
    $strprice = "$price";
    return substr_replace($strprice, ' ', -3, 0);
}
//Функция отмены действия всех акций время которых истекло
//function discardShares() {
//    $shares = Share::modelsWhere('end < ?', array(time()));
//    if (count($shares)) {
//        foreach ($shares as $share) {
//            $packages = Package::modelsWhere('id_share = ?', array($share->id));
//            $products = Product::modelsWhere('id_share = ?', array($share->id));
//            if(count($packages)){
//                foreach ($packages as $pack) {
//                    $pack->discount_price = 0;
//                    $pack->id_share = 0;
//                    $pack->save();
//                }
//            }
//            
//            if(count($products)){
//                foreach ($products as $prod) {
//                    $prod->discount_price = 0;
//                    $prod->id_share = 0;
//                    $prod->save();
//                }
//            }
//            Share::delete($share->id);
//        }
//        return true;
//    }
//    return false;
//}
//
////Функция привязки акции к товару и изменение цены товара
//function attachShareToProducts(){
//    $shares = Share::modelsWhere('end > ? AND connectable = ?', array(time(), Share::CONNECTABLE));
//    if (count($shares)) {
//        foreach ($shares as $share) {     
//            $products = Product::modelsWhere('id_share = ?', array($share->id));
//            if(count($products)){
//                foreach ($products as $prod) {
//                    $percent_price = 100-$share->discount; 
//                    $prod->discount_price = ($prod->price/100) * $percent_price;
//                    $prod->save();
//                }
//            }
//        }
//    }        
//    return $shares;
//}
////Функция привязки акции к пакету и изменение цены пакета
//function attachShareToPackages(array $shares = array()){    
////    $shares = Share::modelsWhere('end > ? AND connectable = ?', array(time(), Share::CONNECTABLE));
//    if (count($shares)) {
//        foreach ($shares as $share) {     
//            $packages = Package::modelsWhere('id_share = ?', array($share->id));
//            if(count($packages)){
//                foreach ($packages as $pack) {
//                    $percent_price = 100-$share->discount; 
//                    $pack->discount_price = $pack->price/100 * $percent_price;
//                    $pack->save();
//                }
//            }
//        }
//    }        
//}
////Функция перезаписи цен пакетов
//function rewritePackagePrices() {
//    $packages = Package::modelsWhere('id_share <> ?', array(Package::NO_SHARE));
////    $packages = Package::models();
//    if (count($packages)) {
//        foreach ($packages as $pack) {
//            $pack->price = $pack->cost();
//            $pack->save();
//        }
//    }    
//}
////Функиция проверки на существование недавно привязаных акций к продуктам
//function countNoShareProducts(){
//    return Product::countRowWhere('id_share <> ? AND discount_price = ?', array(Product::NO_SHARE, Product::NO_SHARE));
//}
////Функиция проверки на существование недавно привязаных акций к пакетам
//function countNoSharePackages(){
//    return Package::countRowWhere('id_share <> ? AND discount_price = ?', array(Package::NO_SHARE, Package::NO_SHARE));
//}

function urlRepair($string=''){
    if($string != ''){
        return str_replace('watch?v=', 'embed/', $string);
    }
}

//Функция вывода названия месяца на русском
function echoRussianDate($time){
    $month = '';
    $day = date('j',$time);
    $year = date('Y',$time);
    $flag = date('m',$time);
	
	$time = date('H:i',$time);
	
    switch($flag){
        case '01' : 
            $month = 'января';
            break;
        case '02' : 
            $month = 'февраля';
            break;
        case '03' : 
            $month = 'марта';
            break;
        case '04' : 
            $month = 'апреля';
            break;
        case '05' : 
            $month = 'мая';
            break;
        case '06' : 
            $month = 'июня';
            break;
        case '07' : 
            $month = 'июля';
            break;
        case '08' : 
            $month = 'августа';
            break;
        case '09' : 
            $month = 'сентября';
            break;
        case '10' : 
            $month = 'октября';
            break;
        case '11' : 
            $month = 'ноября';
            break;
        case '12' : 
            $month = 'декабря';
            break;
        default :
            $month = 'No way';
            break;
    }
	
    $output = $day.' '.$month.' '.$year.' в '.$time;

    return $output;
}

function translit($string){
    $alphabet = array(
        "А"=>"A","а"=>"a",
	"Б"=>"B","б"=>"b",
	"В"=>"V","в"=>"v",
	"Г"=>"G","г"=>"g",
	"Д"=>"D","д"=>"d",
	"Е"=>"Ye","е"=>"e",
	"Ё"=>"Ye","ё"=>"e",
	"Ж"=>"Zh","ж"=>"zh",
	"З"=>"Z","з"=>"z",
	"И"=>"I","и"=>"i",
	"Й"=>"I","й"=>"i",
	"К"=>"K","к"=>"k",
	"Л"=>"L","л"=>"l",
	"М"=>"M","м"=>"m",
	"Н"=>"N","н"=>"n",
	"О"=>"O","о"=>"o",
	"П"=>"P","п"=>"p",
	"Р"=>"R","р"=>"r",
	"С"=>"S","с"=>"s",
	"Т"=>"T","т"=>"t",
	"У"=>"U","у"=>"u",
	"Ф"=>"F","ф"=>"f",
	"Х"=>"Kh","х"=>"kh",
	"Ц"=>"Ts","ц"=>"ts",
	"Ч"=>"Ch","ч"=>"ch",
	"Ш"=>"Sh","ш"=>"sh",
	"Щ"=>"Shch","щ"=>"shch",
	"Ы"=>"Y","ы"=>"y",
	"Э"=>"E","э"=>"e",
	"Ю"=>"Yu","ю"=>"yu",
	"Я"=>"Ya","я"=>"ya",
	"ъ"=>"","ь"=>"",
        " "=>"-",","=>""
        );
    
    return strtr($string,$alphabet);
    
}