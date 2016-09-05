<?php

return array(
    'sitename' => 'Stuffex',
    'db' => include 'config.db.php',
    'layout' => 'base',
    'path_error_controller' => '/error', //урла контроллера ошибки
    'router' => array(        
        'category/([a-z0-9+_\-]+)' => 'category/index/$id',
        '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)/([a-z0-9+/_\-]+)' => '$controller/$action/$id',
        '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)' => '$controller/$action',
        '([a-z0-9+_\-]+)' => '$controller',
        '/uploads/messages/([0-9]+)/' => 'index/$id',

        // 'index' => '/uploads/messages/$id/',
//        'o-kompanii' => 'index/about',
//        'oplata' => 'index/pay',
//        'dostavka-i-kontakty' => 'index/contactsanddelivery',
//        'katalog' => 'index/catalog',
//        'register/social/([a-z0-9+_\-]+)' => 'register/social/$id',
        '([a-z]{2})/([a-z0-9+_\-]+)/([a-z0-9+_\-]+)' => '$lang/$controller/$action',
        '([a-z]{2})/?' => '$lang/$controller',
//        '([a-z]{2})/myprofile?action=' => '$lang/myprofile/index/$id',
    ),
);
