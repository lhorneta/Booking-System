<div class="col-md-12 search-in-database">
    <?php
    if(count($parents)){ ?>
    <h3>Поиск по всем лотам в базе данных:</h3>
    <div class="row">
        <div class="col-md-6">
            <form method="POST" action='/cp/lot/search'>
                <input type="text" name="search[lot]" placeholder="Введите название лота" class="form-control" required>
                <select name="search[category]" class="form-control"> 
                    <?php foreach($parents as $category){ ?>
                        <option value="<?=$category->id; ?>"><?=$category->title; ?></option>
                    <?php } ?>
                </select>
                <input type="submit" value="Найти" class="btn btn-default search">
            </form>
        </div>
    </div>
    <?php }
    if(count($lots)){ ?>
        <div class="lot_list row">
            <h1>Добавленные в течении суток:</h1>
        <?php foreach($lots as $lot){ ?>
            <div class="lot_item">
                <?php if (count($lot->images)) { ?>
                <div class="img-holder" style="background-image: url(<?= Lot::UPLOAD_DIR . $lot->url . '/' . $lot->images[0]; ?>)"><a href="/lot/view/<?= $lot->url; ?>"></a></div>
                <?php } else { ?>
                <div class="img-holder" style="background-image: url('/assets/images/no-img.png')"><a href="/lot/view/<?= $lot->url; ?>"></a></div>
                <?php } ?>
                <div class="lotinfo">
                    <div class="clear_fix">
                      <div class="lab fl_l">Название лота:</div>
                      <div class="labed fl_l"><span class="title"><?=$lot->title?></span></div>
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
                <section>
<!--
                    <a href="/cp/lot/edit/<?= $lot->url; ?>" class="btn btn-default edit">
                        <i class="fa fa-pencil-square-o"></i> 
                        <span class="text">Редактировать</span>
                    </a>
-->
                    <a href="#" class="btn btn-default del-btn del-lot" data-id="<?=$lot->id?>" onclick="return false"><i class="fa fa-ban"></i> <span class="text"> Удалить</span></a>
                </section>
                <div style="clear: both"></div>
            </div>
        <?php } ?>
        </div>
        <?php }else{ ?>
        <p><strong>За последние сутки не добавлено ни одного лота</strong></p>
    <?php
    }
    ?>

    <a href="/cp/lot/selectcategory" class="btn btn-default add-lot">Добавить шикарный лот</a>
    
    <div class="modal-del-holder delete-lot">
        <div class="modal-del">
            <button type="button" class="closer">×</button>
            <div class="question">
                <p><i class="fa fa-trash-o"></i> Вы действительно хотите удалить данный лот насовсем?</p>
                <a href="#" class="ok">ОК</a>
                <a href="#" onclick="return false" class="cancel">ОТМЕНА</a>
            </div>
        </div>
        <div class="overlay"></div>
    </div>
</div>
<script>
    //Extract info from data-id attributes into attributes 'href'
    $('.del-lot').click(function () {
        var id = $(this).data('id');
        var modal = $('.delete-lot');
        if(id != '') {
            modal.find('a.ok').attr('href', '/cp/lot/delete/' + id);
        };
    });
</script>
