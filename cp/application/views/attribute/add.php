<div class="col-md-8 row add-parents-category">	
    <h3>Добавление атрибутов в группу</h3>
    <form method="POST" action="">
        <input type="text" name="attribute[title]" placeholder="Название атрибута" class="form-control" required />
            <input name="attribute[url]" placeholder="URL атрибута" class="form-control" required />	    
            <input name="attribute[units]" placeholder="Единицы измерения" class="form-control" />
            <select name="attribute[type]" class="form-control">
                <option value="static">Статическое</option>
                <option value="dynamic">Динамическое</option>
            </select>
            <br>
            Отображать в шапке: <input type="checkbox" name="attribute[head]" class="form-control" />
            <!-- Отображать как категорию: <input type="checkbox" name="attribute[category]" class="form-control"  /> -->
        <input type="submit" value="Добавить" class="btn btn-defoult add"/>
        <a href="javascript:history.go(-1)" class="btn btn-default pull-right">Назад</a>
    </form>
</div>
<table class="table">
    <tr>
        <td>URL</td>
        <td>Название</td>
        <td>Действие</td>
    </tr>
    <?php
    if(count($category->attributes)){
        foreach($category->attributes as $attr){ ?>
                <tr id="row_<?=$attr->id?>">
                    <td><?=$attr->url?></td>
                    <td>
                        <?php if ($attr->type == 'static') { ?>
                            <a href="/cp/attribute/addstaticvalue/<?=$attr->id?>"><?=$attr->title?></a>
                        <?php } else { ?>
                            <p><?=$attr->title?></p>
                        <?php } ?>
                    </td>
                    <td><a href="/cp/attribute/delete/<?=$attr->id?>" class="delete_attr">Удалить</a></td>
                </tr>
        <?php } 
    } ?>
</table>