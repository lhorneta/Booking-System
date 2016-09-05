<div class="col-md-12 row lots-holder clearfix">
    <div class="title-block">
        <strong>Название родительской категории:</strong>
        <h2><?=$category->title; ?></h2>
        <strong>Описание:</strong> 
        <p><?=($category->description) ? $category->description : 'нет описания'; ?></p>
    </div>

    <?php
    if(count($category->lots)){
        foreach($category->lots as $categoryTitle=>$categoryLots){ ?>
            <h4>Все лоты в категории <strong><?=$categoryTitle; ?></strong></h4>    
            <?php 
            if(count($categoryLots)){
                foreach($categoryLots as $lot){ ?>
                <div class="lot">
                			<?php $img = ($lot->img0)?'/uploads/lot/'.$lot->url.'/'.$lot->img0:'/assets/images/no-img.png'; ?>
                            <div class="img-holder" style="background-image: url('<?=$img?>')"></div>
                            <div class="rating">
                                <span>Рейтинг лота: </span>
                                <strong><?=$lot->mark > 0 ? $lot->mark : 'нет рейтинга'; ?></strong>
                            </div>
                            <div class="title">
                                <span>Название лота:</span> 
                                <strong><?=$lot->title; ?></strong>
                            </div>
                            <div class="description">
                                <span>Описание лота:</span> 
                                <strong><?=$lot->description ? $lot->description : 'не указано'; ?></strong>
                            </div>
                            <div class="deposit">
                                <span>Депозит:</span><br>
                                <strong><?=$lot->deposit ? $lot->deposit : 'не указан'; ?></strong>
                            </div>
                            <div class="prices">
                                <span>Цена аренды на день:</span> <br>
                                <strong><?=$lot->day_payment; ?></strong><br>
                                <span>Цена аренды на неделю:</span> <br>
                                <strong><?=$lot->week_payment ? $lot->week_payment : 'не указана'; ?></strong><br>
                                <span>Цена аренды на месяц:</span> <br>
                                <strong><?=$lot->month_payment ? $lot->month_payment : 'не указана'; ?></strong>
                            </div>
                            <div class="conditions">
                                <span>Условия проката:</span> 
                                <strong><?=$lot->rental_terms ? $lot->rental_terms : 'отсутствуют'; ?></strong>
                            </div>
                            <div class="lnk-holder">
                                <a href="/cp/user/tofavorite/<?=$lot->url; ?>" class="btn btn-default add-lot">Добавить лот в избранное</a>
                            </div>
                            <form action="/cp/user/addreview" method="POST" class="review-form-lot">
                                <textarea name="review[text]" class="form-control" required></textarea>
                                <input type="hidden" name="review[id_lot]" value="<?=$lot->id; ?>" />
                                <button type="sumbit" class="btn btn-default">Добавить отзыв на лот</button>
                            </form>
                            <form action="/cp/user/addreview" method="POST" class="review-form-user">
                                <textarea name="review[text]" class="form-control" required></textarea>
                                <input type="hidden" name="review[id_user]" value="<?=$lot->id_user; ?>" />   
                                <button type="sumbit" class="btn btn-default">Добавить отзыв на пользователя</button>
                            </form>
                        </div>
            <?php
                }
            }else{ ?>
                <h5>В данной категории пока что нет лотов</h5>
            <?php
            }
        }
    }
// </div>