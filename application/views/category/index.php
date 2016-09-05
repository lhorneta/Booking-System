Название родительской категории: <p><?=$category->title; ?><p>
Описание: <p><?=($category->description) ? $category->description : 'нет описания'; ?><p>

<?php
if(count($category->lots)){
    foreach($category->lots as $categoryTitle=>$categoryLots){ ?>
        <p>Все лоты в категории <?=$categoryTitle; ?></p>    
        <?php 
        if(count($categoryLots)){
            foreach($categoryLots as $lot){ ?>
                Название лота: <a href="/lot/view/<?=$lot->url; ?>"><p><?=$lot->title; ?></p></a>
                Описание лота: <p><?=$lot->description ? $lot->description : 'не указано'; ?></p>
                Депозит: <p><?=$lot->deposit ? $lot->deposit : 'не указан'; ?></p>
                Цена аренды на день: <p><?=$lot->day_payment; ?></p>
                Цена аренды на неделю: <p><?=$lot->week_payment ? $lot->week_payment : 'не указана'; ?></p>
                Цена аренды на месяц: <p><?=$lot->month_payment ? $lot->month_payment : 'не указана'; ?></p>
                Рейтинг лота: <p><?=$lot->mark > 0 ? $lot->mark : 'нет рейтинга'; ?></p>
                Условия проката: <p><?=$lot->rental_terms ? $lot->rental_terms : 'отсутствуют'; ?></p>
                <a href="/myprofile/tofavorite/<?=$lot->url; ?>">Добавить лот в избранное</a>
                <form action="/myprofile/addreview" method="POST">
                    <textarea name="review[text]"></textarea><br>
                    <input type="hidden" name="review[id_lot]" value="<?=$lot->id; ?>" />
                    <input type="submit" value="Добавить отзыв на лот" />
                </form>
                <form action="/myprofile/addreview" method="POST">
                    <textarea name="review[text]"></textarea><br>
                    <input type="hidden" name="review[id_user]" value="<?=$lot->id_user; ?>" />
                    <input type="submit" value="Добавить отзыв на пользователя" />
                </form>
                <hr>
        <?php
            } 
        }else{ ?>
            <h5>В данной категории пока что нет лотов</h5>
        <?php
        }
    }
}