<div class="col-md-8 row add-parents-category">	
    <h3>Добавление значений для статического атрибута: <?=$group->title; ?></h3>
    <form method="POST" action="">
        <input type="text" name="value[value]" placeholder="Название атрибута" class="form-control" required />
            <input name="value[url]" placeholder="URL атрибута" class="form-control" required />	    
<!--            <input name="value[units]" placeholder="Единицы измерения" class="form-control" />
            <select name="value[type]" class="form-control">
                <option value="static">Статическое</option>
                <option value="dynamic">Динамическое</option>
            </select>
            <br>
            Отображать в шапке: <input type="checkbox" name="value[head]" class="form-control" />
            Отображать как категорию: <input type="checkbox" name="value[category]" class="form-control"  />-->
        <input type="submit" value="Добавить" class="btn btn-default add"/>
        <a href="javascript:history.go(-1)" class="btn btn-default pull-right">Назад</a>
    </form>
</div>

        <table class="table">
            <tr>
                <td>Название</td>
                <td>URL</td>
                <td>Действия</td>
            </tr>
<?php
if(count($group->staticValues)){
    foreach($group->staticValues as $value){ ?>
            <tr id="row_<?=$value->id?>">
                <td><?=$value->value; ?></a></td>
                <td><?=$value->url; ?></td>
                <td><a class="delete_val" href="/cp/attribute/deletevalue/<?=$value->id?>">Удалить</a></td>
            </tr>
    <?php } 
} ?>
        </table>
