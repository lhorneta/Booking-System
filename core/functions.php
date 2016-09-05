<?php

function debug($data, $stop = false) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($stop) {
        exit();
    }
}

//генерация токена для авторизации
function generateToken() {
    return md5(uniqid(rand(), true));
}
//Функция установки куки юзера
function loginUser($token, $path = '/') {
    setcookie('auth_token', $token, time() + app::gi()->config->cookietime, $path);
}
//Функция удаления куки юзера
function logoutUser($path = '/') {
    setcookie('auth_token', '', time() - 1, $path);
}

/**
 * Уставнавливает куки для выбраного региона
 *
 * строка вида id_country:id_region:id_city
 * например 43:657:67
 * @return boolean
 * */
function setCookieLocation($id_city = 0, $id_region = 0) {
    $string = $id_city . ':' . $id_region;
    setcookie('region', $string, time() + app::gi()->config->cookietime, '/');
    return isset($_COOKIE['region']) ? true : false;
}

function getAllCookie(){
    $array = array();
    if (isset($_COOKIE['region']) && !empty($_COOKIE['region'])) {
        $region = explode(':', $_COOKIE['region']);
        if (count($region) == 2) {
            $array['id_city'] = (int) $region[0];
            $array['id_region'] = (int) $region[1];
            $array['id_category'] == 0;
            
            if (isset($_COOKIE['category']) && !empty($_COOKIE['category'])) {
                $array['id_category'] == $_COOKIE['category'];
            }            
            return $array;
        }
    }
    return false;
}
/**
 * Парсит куку хранящую информацию о регионе
 * @return array
 * */
function getCookieLocation() {
    if (isset($_COOKIE['region']) && !empty($_COOKIE['region'])) {
        $region = explode(':', $_COOKIE['region']);
        if (count($region) == 2) {
            return array('id_city' => (int) $region[0], 'id_region' => (int) $region[1]);
        }
    }
    return false;
}

function getCookieCategory() {
    if (isset($_COOKIE['category']) && !empty($_COOKIE['category'])) {
        return array('id_category' => (int) $_COOKIE['category']);
    }
    return false;
}


//Функция для записи текущей категории в куки
function categoryOnCookie($catId){
    setcookie('category', $catId, time() + app::gi()->config->cookietime, '/');    
}

//Функция для удаления текущей категории из куки
function categoryOffCookie(){
    setcookie('category', '', time() - 1, '/');    
}

/**
 * Возвращает полное название региона в зависимости от данных записанных в куки
 * @return string
 */
function getLocationString() {
    $string = '';
    extract(getRegionOjects());
    if ($region) {
        $string = $region->getName();
        
        if ($city) {
            $string .= ', ' . $city->getName();
        }
        return $string;
    } else {
        return lang('all_regions');
    }
}

/**
 * Возвращает обьекты регионов по id записаным в куки
 * @return array массив объктов 'country' => Country, 'region' => Region, 'city' => City
 */
function getRegionOjects() {
    $cookieData = getCookieLocation();
//    debug(getCookieLocation());
//    die();
    $city = null;
    $region = null;
    if ($cookieData) {
        if ($cookieData['id_city'] > 0) {
            $city = City::model($cookieData['id_city']);
            if ($city) {
                $region = Region::model($city->id_region);
            }
        } elseif ($cookieData['id_region'] > 0) {
            $region = Region::model($cookieData['id_region']);
        }
    }
    return array('region' => $region, 'city' => $city);
}
function getCategoryOjects() {
    $cookieData = getCookieCategory();
//    debug(getCookieLocation());
//    die();
    $sub_child = null;
    $children = null;
    $parent = null;
    if ($cookieData) {
        if ($cookieData['id_category'] > 0) {
            $sub_child = Category::model($cookieData['id_category']);
            if ($sub_child) {
                $child = Category::model($sub_child->id_parent);
                if($child){
                    $parent = Category::model($child->id_parent);
                }
            }
        } 
    }
    return array('parent' => $parent, 'children' => $children, 'sub_child'=>$sub_child);
}

//Возвращает перевод по ключу из массива
function lang($key) {
    return array_key_exists($key, app::gi()->translate) ? app::gi()->translate[$key] : '';
}

//Функция для вывода первого символа строки в верхнем регистре
function mb_ucfirst($string) {
    $string = explode(' ', $string);
    if (count($string)) {
        $string[0] = mb_convert_case($string[0], MB_CASE_TITLE, 'UTF-8');
    }
    $string = implode(' ', $string);
    return $string;
}
//Функция отделения "тысячи"
function thousandPrice($price){
    return substr_replace($price, ' ', -3,0);
}

//Функция вывода названия месяца на русском
function echoRussianDate($time){
    $month = '';
    $day = date('j',$time);
    $year = date('Y',$time);
    $flag = date('m',$time);
	
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
	
    $output = $day.' '.$month.' '.$year;

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
////Функция получения данных о текущем пользователе
//function CustomUser(){
//    if(!isset($_COOKIE['auth_token'])){                
//        $user = $_COOKIE['temp'];
//    }else{
//        $user = $_COOKIE['auth_token'];
//    } 
//    return $user;
//}
////Функция для подстановки значения в ЮРЛ видеозаписи у статьи
//function urlRepair($string=''){
//    if($string != ''){
//        return str_replace('watch?v=', 'embed/', $string);
//    }
//}
////Функция удаления из массива объектов объекта категории у которой нет ни одного пакета
//function clearCategories(array $categories){
//    $categs = count($categories);
//        for ($i = 0; $i < $categs; $i++) {
//            if (count($categories[$i]->packs) < 1) {
//                unset($categories[$i]);
//                $categs--;
//                $i--;
//                sort($categories);
//            }
//        }
//    return $categories;
//}
////Функция проверки наличия товара в корзине
//function checkBacket(){
//    $count = 0;
//    if(isset($_COOKIE['customs'])){
//        $count += strlen($_COOKIE['customs']);        
//    }
//    if(isset($_COOKIE['packs'])){
//        $count += strlen($_COOKIE['packs']);
//    }
//    if(isset($_COOKIE['shares'])){
//        $count += strlen($_COOKIE['shares']);
//    }
//    if(isset($_COOKIE['products'])){
//        $count += strlen($_COOKIE['products']);
//    }
//    if($count){
//        echo 'active';
//    }else{
//        echo '';
//    }
//}

function byIds($region=0, $city=0) {
	$res = '';
	if ($region>0||$city>0) {
		if ($region>0) {
			$r = Region::modelWhere('id = ?', array($region));
			$res .= $r->title_ru;
			if ($city>0) {
				$res .= ", ";
			}
		}
		if ($city>0) {
			$c = City::modelWhere('id = ?', array($city)); 
			$res .= $c->title_ru;
		}
	}
	return $res;
}


function filter($cat=0, $s=array(), $a=array(), $cats=array()) {
	$res = array();
	$sql = "SELECT * FROM `lot` `l`";
	$attributes = array();
	$attrarr = array();
	if ($a) {
		
		$attrsql = "SELECT * FROM `attribute` `a`
				LEFT JOIN `static_attribute_value` `sav` ON `a`.`id`=`sav`.`id_attribute`
				LEFT JOIN  `selected_attribute_value` `sav2` ON `sav`.`id_attribute`=`sav2`.`id_attribute`
				WHERE 1 AND (";
		foreach ($a as $k => $v) {
			$attrarr[] = "(a.url='".$k."' AND sav.url='".$v."')";
		}
		$attrsql .= implode(' OR ', $attrarr);
		
		$attrsql .=  ") GROUP BY sav2.id_lot";
		//echo $attrsql;
		$attrs = DB::instance()->query($attrsql)->result();
		//debug($attrs);
		if ($attrs) {
			
			foreach ($attrs as $a) {
				$attributes[] = $a['id_lot'];
			}
		}
		
		//$sql .= " LEFT JOIN `selected_attribute_value` `sav` ON `l`.`id`=`sav`.`id_lot`";
		
		//$sql .= " LEFT JOIN `static_attribute_value` `sattrv` ON `sattrv`.`id_attribute`=`sav`.`id_attribute`";
		
		
	}
	$sql .= " WHERE `l`.`post_type`='0'";
	if ($attributes) {
		//debug($attributes);
		$attributes = array_diff($attributes, array(''));
		$pr = implode(",", $attributes);
		//echo $pr;
		if ($pr) {
			$sql .= " AND `l`.`id` IN (".$pr.")";
		} else {
			$sql .= " AND `l`.`id` IN (0)";
		}
		
	}
	//$sql .= " AND `l`.`id_category`='".$cat."'";
	if ($cat||$cats) {
		$cats[] = $cat;
		//debug($cats);
		$sql .= " AND `l`.`id_category` IN (".implode(",", $cats).")";
	}
	
	if ($s) {
		
		if ($s['type']) {
			$sql .= " AND `l`.`type`='".$s['type']."'";
		}
		
		if ($s['title_desc']) {
			if ($s['q']) {
				$sql .= " AND (`l`.`title` LIKE '%".$s['q']."%' OR `l`.`description` LIKE '%".$s['q']."%')";
			}
		} else {
			if ($s['q']) {
				$sql .= " AND `l`.`title` LIKE '%".$s['q']."%'";
			}
		}
		$pp = $s['price-period'];
		if ($s['from']||$s['to']) {
			if ($s['from']&&$s['to']) {
				$sql .= " AND `l`.`".$pp."_payment` BETWEEN '".$s['from']."' AND '".$s['to']."'";
			} else {
				if ($s['from']) {
					$sql .= " AND `l`.`".$pp."_payment`>='".$s['from']."'";
				}
				if ($s['to']) {
					$sql .= " AND `l`.`".$pp."_payment`<='".$s['to']."'";
				}
			}
		}
		
		if ((isset($s['region'])&&$s['region'])||(isset($s['city'])&&$s['city'])) {
			if ($s['region']) {
				$sql .= " AND `l`.`id_region`='".$s['region']."'";
			}
			if ($s['city']) {
				$sql .= " AND `l`.`id_city`='".$s['city']."'";
			}
		}
		
		
		
		// if (isset($s['location'])&&$s['location']) {
			// $sql .= " AND `l`.`address`='".$s['location']."'";
		// }
		
		if ($s['photo']) {
			$sql .= " AND `l`.`img0` IS NOT NULL";
		}
		
		if (isset($s['sort'])&&$s['sort']) {
			if ($s['sort'] =='new_search') {
				$sql .= " ORDER BY `l`.`id` DESC";
			} elseif ($s['sort'] =='expensive_search') {
				$sql .= " ORDER BY `l`.`day_payment` DESC";
			} else {
				$sql .= " ORDER BY `l`.`id` DESC";
			}
		}
		
	}
	
	//echo $sql;
	
	$items = DB::instance()->query($sql)->result();
	
	if ($items) {
		foreach ($items as $item) {
			$model = new Lot();
			$model->__attributes = $item;
			$res[] = $model;
		}
	}

	return $res;
}


	function getVotes($lot_id){
		$r = 0;
        $sql = "SELECT avg(rating) as vote FROM (SELECT `vote` as rating FROM `review` WHERE `id_lot` = '".$lot_id."') as rating";
		$rating = Review::modelsQuery($sql,array());
		if ($rating) {
			$r = round($rating[0]->vote/2,1, PHP_ROUND_HALF_DOWN);
		}
		return $r;
    }
		
	function getUserRating($user_id){
		$ur = 0;
        $sql = "SELECT avg(rating) as vote FROM (SELECT `vote` as rating FROM `review` WHERE `id_user` = '".$user_id."') as rating";
		$user_rating = Review::modelsQuery($sql,array());
		if ($user_rating) {
			$ur = round($user_rating[0]->vote/2,1, PHP_ROUND_HALF_DOWN);
		}
		return $ur;
    }

	function getUserName($user_id){

		$name = '';
        $sql = "SELECT * FROM user WHERE `id` = '".$user_id."' ";

		$username = User::modelsQuery($sql,array());
		if ($username) {
			if ($username[0]->id_role ==2) {
				$name = $username[0]->name;
			}else if($username[0]->id_role ==3){
				$name = $username[0]->company_name;
			}
		}

		return $name;
    }
	
	
	function myvote($id=0) {
		$res = 0;
		
		$user = App::gi()->user;
		if ($user) {
			$vote = Vote::modelWhere('id_review = ? AND id_user = ?', array($id, $user->id));
			if ($vote) {
				if ($vote->vote==1) {
					$res=1;
				} else {
					$res=2;
				}
			}
		}
		return $res;
	}
	
	function votes($id=0)	{
		$res = (object) array('all'=>0, 'quantity'=>0, 'percent'=>0);
		$votes = Vote::modelsWhere('id_review = ?', array($id));
		$all = count($votes);
		if ($all>0) {
			$val1=0; $val2=0;
			foreach ($votes as $k => $v) {
				if ($v->vote==1) {
					$val1++;
				} else {
					$val2++;
				}
			}
			
			$s = ($val1*100)/$all;
			$value1 = round($s);
			$value2 =round(100-$s);
			
			$res = (object) array(
				'all' => $all,
				'quantity' => array(1=>$val1, 2=>$val2),
				'percent' => array(1=>$value1, 2=>$value2)
			);
		} else {
			$res = (object) array(
				'all' => $all,
				'quantity' => array(1=>0, 2=>0),
				'percent' => array(1=>50, 2=>50)
			);
		}
		
		return $res;
	}
	
	
	function gethtmlmail($data='') {
		if ($data) {
			$mess = '<!DOCTYPE html>
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
						<p style="margin-bottom: 10%;">'.$data.'</p>
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
			return $mess;
		} else {
			return false;
		}
	}
	
	
	function GetBreadcrumbs($id=0) {
		$res = '';
		if ($id>0) {
			$categories = Category::modelWhere('id = ?', array($id));
			if (isset($categories)&&$categories) {
				$c1 = $categories->title;
			}
			if (isset($categories)&&$categories) {
				$categories = Category::modelWhere('id = ?', array($categories->id_parent));
				if ($categories) {
					$c2 = $categories->title;
				}
			}
			if (isset($categories)&&$categories) {
				$categories = Category::modelWhere('id = ?', array($categories->id_parent));
				if ($categories) {
					$c3 = $categories->title;
				}
			}
			if (isset($c3)) {
				$res .= $c3;
			}
			
			if (isset($c2)) {
				$i = (isset($c3))?' <i>&gt;</i> ':'';
				$res .= $i.$c2;
			}
			
			// if (isset($c1)) {
				// $res .= (isset($c2))?' <i>&gt;</i> '.$c1:'';
			// }
			
			
		}
		return $res;
	}
	
	function GetBreadcrumbsOnlyOne($id='') {
		$res = '';
		if ($id>0) {
			$categories = Category::modelWhere('id = ?', array($id));
			if (isset($categories)&&$categories) {
				$res = $categories->title;
			}
		}
		return $res;
	}
	
	function Getsiblings($cat=0) {
		$res = array();
		if ($cat>0) {
			$category = Category::modelWhere('id = ?', array($cat));
			if ($category) {
				$res = Category::modelsWhere('id_parent = ?', array($category->id_parent));
			}
		}
		return $res;
	}
	
	
	function SendConfirmationMail($user_id) {
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
			//$this->render('success', array('errors' => $errors));
        }
        return false;
    }

