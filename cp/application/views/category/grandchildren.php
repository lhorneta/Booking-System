<div class="category-list clearfix">
	
	<div class="add-catagory">
		<a href="/cp/category/addchild/<?=$cat->id?>">
	        <i class="fa fa-plus-circle"></i>
	        <span>Добавить подкатегорию</span>
	    </a>
    	<a style="float:left; background: #aaa" href="javascript:history.go(-1);">
            <span>Назад</span>
        </a>
    </div>
    <h1>Все подкатегории в рубрике "<?=$cat->title?>"</h1>
    <?php foreach($categories as $category){
	$lots = Lot::modelWhere('id_category = ?', array($category->id));
    ?>
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
                    <a href="/cp/category/add/<?=$category->id; ?>" class="btn btn-default edit">Редактировать</a>
                    <a href="#" class="btn <?=($lots)?' btn-default nodel':'btn-danger del-categ'?>" data-id="<?=$category->id; ?>" onclick="return false">Удалить</a>
                </div>
            </div>
        </div>
    <?php 
    } ?>
    
    <div class="modal-del-holder delete-categ">
        <div class="modal-del">
            <button type="button" class="closer">×</button>
            <div class="question">
                <p><i class="fa fa-trash-o"></i> Вы действительно хотите удалить данную категорию насовсем?</p>
                <a href="#" class="ok">ОК</a>
                <a href="#" onclick="return false" class="cancel">ОТМЕНА</a>
            </div>
        </div>
        <div class="overlay"></div>
    </div>
    <div class="modal-del-holder warning-categ">
        <div class="modal-del">
            <button type="button" class="closer">×</button>
            <div class="question">
                <p><i class="fa fa-trash-o"></i> Чтобы удалить выбранную категорию, сначала удалите все дочерние категории и/или лоты!</p>
                <a href="#" class="ok">ОК</a>
            </div>
        </div>
        <div class="overlay"></div>
    </div>
</div>
<script>
    //Extract info from data-id attributes into attributes 'href'
    $('.del-categ').click(function () {
        var id = $(this).data('id');
        var modal = $('.delete-categ');
        if(id != '') {
            modal.find('a.ok').attr('href', '/cp/category/delete/' + id);
        };
    });
</script>