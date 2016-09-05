<h2>Добавление шикарного лота</h2>
<form method="POST" class="lot_item">

    <div class="img-holder" style="background-image: url('/assets/images/img-1.jpg')"></div>

    <div class="lotinfo">
    <input type="text" name="form[title]" placeholder="Название лота" required />*<br>
    Описание*<br><textarea name="form[description]" placeholder="Описание лота" required> </textarea><br>
    Категория: <?=$category->title; ?><input type="hidden" name="form[id_category]" value="<?=$category->id; ?>" required /><br>
    Пользователь: <select name="form[id_user]" required><br>
        <?php foreach($users as $user){ ?>
            <option value="<?=$user->id; ?>"><?=$user->email; ?></option>
        <?php } ?>
    </select><br>
    <input type="text" name="form[special_provisio]" placeholder="Особые условия" /><br>
    <input type="text" name="form[rental_terms]" placeholder="Условия проката" /><br>
    <input type="text" name="form[deposit]" placeholder="Депозит" /><br>
    <input type="text" name="form[day_payment]" placeholder="Стоимость 1-го дня аренды" required />*<br>
    <input type="text" name="form[week_payment]" placeholder="Стоимость недели аренды" /><br>
    <input type="text" name="form[month_payment]" placeholder="Стоимость месяца аренды" /><br>
<!--    <input type="text" name="form[meta_title]" placeholder="Мета тэг"  /><br>
    <input type="text" name="form[meta_keywords]" placeholder="Мета тэг"  /><br>
    <input type="text" name="form[meta_description]" placeholder="Мета тэг"  /><br>-->
    <input type="text" name="user[location]" placeholder="Местоположение" required />*<br>
    </div>
    <div style="clear: both"></div>


    <?php
        if(count($attributeGroup)){ ?>
            <hr>
            <h2>Атрибуты</h2>
            <h3>Статичные</h3>
            <?php foreach($attributeGroup as $group){
                if(count($group->staticValues)){ ?>
                <?=$group->title; ?><select name="static[<?=$group->url; ?>]">
                    <?php foreach($group->staticValues as $staticValue){ ?>
                        <option value="<?=$staticValue->id; ?>"><?=$staticValue->value; ?></option>
                    <?php } ?>
                </select><br><br>
                <?php } 
            } ?>
            <h3>Динамичные</h3>
            <?php foreach($attributeGroup as $group){ 
               if($group->type == 'dynamic'){ ?>
                <?=$group->title; ?><input name="dynamic[<?=$group->url; ?>]" /><?=$group->units; ?><br><br>
               <?php }

               } ?>
        <?php }
    ?>
    <hr>
    <input type="submit" value="Добавить" class="btn btn-primary"/>
</form>