<h2>Лоты которые добавлены в избранное пользователем: <?=$user->email; ?></h2>
<?php
if(count($user->favoriteLots)){
    foreach($user->favoriteLots as $lot){ ?>
        Название лота: <p><?=$lot->title; ?></p>
        Описание лота: <p><?=$lot->description ? $lot->description : 'не указано'; ?></p>
        Депозит: <p><?=$lot->deposit ? $lot->deposit : 'не указан'; ?></p>
        Цена аренды на день: <p><?=$lot->day_payment; ?></p>
        Цена аренды на неделю: <p><?=$lot->week_payment ? $lot->week_payment : 'не указана'; ?></p>
        Цена аренды на месяц: <p><?=$lot->month_payment ? $lot->month_payment : 'не указана'; ?></p>
        Рейтинг лота: <p><?=$lot->mark > 0 ? $lot->mark : 'нет рейтинга'; ?></p>
        Условия проката: <p><?=$lot->rental_terms ? $lot->rental_terms : 'отсутствуют'; ?></p> 
        <hr>
    <?php
    }
}