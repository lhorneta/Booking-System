<div class="category-list clearfix">
    <!-- <div class="add-catagory">
        <a href="/cp/category/add">
            <i class="fa fa-plus-circle"></i>
            <span>Добавить категорию</span>
        </a>
    </div> -->
    <h1>Все родительские категории</h1>
    <?php foreach($categories as $category){ ?>
        <div class="col-md-4">
            <div class="category">
                <div class="title">
                    <!-- <strong>Название категории: </strong> -->
                    <a href="/cp/category/view/<?=$category->id; ?>"><?=$category->title; ?></a>
                </div>
                <div class="description">
                    <span>Описание:</span>
                    <strong><?=($category->description) ? $category->description : 'нет описания'; ?></strong>
                </div>
                <div class="links-holder">
                    <a href="/cp/category/info/<?=$category->id; ?>" class="btn btn-default lots">Лоты</a>
                    <a href="/cp/category/children/<?=$category->id; ?>" class="btn btn-default lots">Рубрики</a>
                    <a href="/cp/category/addchild/<?=$category->id; ?>" class="btn btn-default add-cat">Добавить подкатегорию</a>
                    <a href="/cp/category/add/<?=$category->id; ?>" class="btn btn-default edit">Редактировать</a>
                </div>
            </div>
        </div>
    <?php 
    } ?>
</div>

