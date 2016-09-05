<h2>Редактирование лота "<?=$lot->title?>"</h2>
<form method="POST" action="/cp/lot/editsave/<?=$lot->id?>" class="lot_item">
    <?php if (count($lot->images)) { ?>
    <div class="img-holder" style="background-image: url(<?= Lot::UPLOAD_DIR . $lot->url . '/' . $lot->images[0]; ?>)"><a href="/lot/view/<?= $lot->url; ?>"></a></div>
    <?php } else { ?>
    <div class="img-holder" style="background-image: url('/assets/images/no-img.png')"><a href="/lot/view/<?= $lot->url; ?>"></a></div>
    <?php } ?>
    <div class="lotinfo">
    <input type="text" name="form[title]" class="form-control" placeholder="Название лота" required value="<?=$lot->title?>" />*<br>
    Описание*<br><textarea name="form[description]" placeholder="Описание лота" class="form-control" required><?=$lot->description?></textarea><br>
    Категория: <?=($category)?$category->title:''?><input type="hidden" name="form[id_category]" value="<?=($category)?$category->id:''?>" required /><hr>
    Пользователь: <select class="selectpicker form-control bs-select-hidden" name="form[id_user]" required><br>
        <?php foreach($users as $user){ ?>
            <option <?=($lot->id_user==$user->id)?'selected':''?> value="<?=$user->id; ?>"><?=$user->email; ?></option>
        <?php } ?>
    </select><br>
    <input type="text" class="form-control" name="form[special_provisio]" placeholder="Особые условия" value="<?=$lot->special_provisio?>" /><br>
    <input type="text" class="form-control" name="form[rental_terms]" placeholder="Условия проката" value="<?=$lot->rental_terms?>" /><br>
    <input type="text" class="form-control" name="form[deposit]" placeholder="Депозит" value="<?=$lot->deposit?>" /><br>
    <input type="text" class="form-control" name="form[day_payment]" placeholder="Стоимость 1-го дня аренды" value="<?=$lot->day_payment?>" required />*<br>
    <input type="text" class="form-control" name="form[week_payment]" placeholder="Стоимость недели аренды" value="<?=$lot->week_payment?>" /><br>
    <input type="text" class="form-control" name="form[month_payment]" placeholder="Стоимость месяца аренды" value="<?=$lot->month_payment?>" /><br>
<!--    <input type="text" name="form[meta_title]" placeholder="Мета тэг"  /><br>
    <input type="text" name="form[meta_keywords]" placeholder="Мета тэг"  /><br>
    <input type="text" name="form[meta_description]" placeholder="Мета тэг"  /><br>-->
    <input type="text" class="form-control" name="user[location]" placeholder="Местоположение" required value="<?=$user->location?>" />*<br>
    </div>
    <div style="clear: both"></div>

    <?php
        if(count($attributeGroup)){ ?>
            <hr>
            <h2>Атрибуты</h2>
            <h3>Статичные</h3>
            <?php foreach($attributeGroup as $group){
                if(count($group->staticValues)){ ?>
                <?=$group->title; ?><select class="selectpicker form-control bs-select-hidden" name="static[<?=$group->id?>]">
                    <?php foreach($group->staticValues as $staticValue){ ?>
                        <option  value="<?=$staticValue->id; ?>"><?=$staticValue->value; ?></option>
                    <?php } ?>
                </select><br><br>
                <?php } 
            } ?>
            <hr>
            <h3>Динамичные</h3>
            <?php foreach($attributeGroup as $group){ 
               if($group->type == 'dynamic'){ ?>
                <?=$group->title; ?><input class="form-control" name="dynamic[<?=$group->id?>]" value="" /><?=$group->units; ?><br><br>
               <?php }

               } ?>
        <?php }
    ?>
    <hr>
    <?php //debug($selecteds); ?>
    <input type="submit" class="btn btn-primary" value="Сохранить"/>
</form>
