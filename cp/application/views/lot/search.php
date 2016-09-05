<h4>Результат поиска по запросу: <?=$query; ?></h4>
<?php
if(count($result)){ ?>
<div class="lot_list">
<?php foreach ($result as $lot){ ?>
    <div class="lot_item">
        <?php if (count($lot->images)) { ?>
        <div class="img-holder" style="background-image: url(<?= Lot::UPLOAD_DIR . $lot->url . '/' . $lot->images[0]; ?>)"><a href="/lot/view/<?= $lot->url; ?>"></a></div>
        <?php } else { ?>
        <div class="img-holder" style="background-image: url('/assets/images/img-1.jpg')"><a href="/lot/view/<?= $lot->url; ?>"></a></div>
        <?php } ?>
        <div class="lotinfo">

            <div class="clear_fix">
              <div class="lab fl_l">Название лота:</div>
              <div class="labed fl_l"><a href="/cp/lot/edit/<?= $lot->url; ?>"><?=$lot->title?></a></div>
            </div>
            <div class="clear_fix">
              <div class="lab fl_l">Описание лота:</div>
              <div class="labed fl_l"><?=$lot->description ? $lot->description : 'не указано'?></div>
            </div>
            <div class="clear_fix">
              <div class="lab fl_l">Депозит:</div>
              <div class="labed fl_l"><?=$lot->deposit ? $lot->deposit : 'не указан'?></div>
            </div>
            <div class="clear_fix">
              <div class="lab fl_l">Цена аренды на день:</div>
              <div class="labed fl_l"><?=$lot->day_payment?></div>
            </div>
            <div class="clear_fix">
              <div class="lab fl_l">Цена аренды на неделю:</div>
              <div class="labed fl_l"><?=$lot->week_payment ? $lot->week_payment : 'не указана'?></div>
            </div>
            <div class="clear_fix">
              <div class="lab fl_l">Цена аренды на месяц:</div>
              <div class="labed fl_l"><?=$lot->month_payment ? $lot->month_payment : 'не указана'?></div>
            </div>
            <div class="clear_fix">
              <div class="lab fl_l">Рейтинг лота:</div>
              <div class="labed fl_l"><?=$lot->mark > 0 ? $lot->mark : 'нет рейтинга'?></div>
            </div>
            <div class="clear_fix">
              <div class="lab fl_l">Условия проката:</div>
              <div class="labed fl_l"><?=$lot->rental_terms ? $lot->rental_terms : 'отсутствуют'?></div>
            </div>

        </div>
        <div style="clear: both"></div>
    </div>
<?php } ?>
</div>
<?php } else { ?>
    <h5>Поиск не дал результатов</h5>
<?php } ?>
