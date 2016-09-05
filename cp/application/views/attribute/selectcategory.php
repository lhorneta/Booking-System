<div class="selectcategory">
    <h2>Выберите категорию в которую будет добавлен атрибут:</h2>
    <?php
    foreach($categories as $category){ ?>
        <p><?=$category->hadChilds ? "<a href='/cp/attribute/selectcategory/$category->url'>$category->title -></a>" : "<a href='/cp/attribute/add/$category->id'>$category->title</a>"; ?></p>
    <?php
    } ?>
</div>

