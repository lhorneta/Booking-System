<div class="col-md-8 row add-parents-category">	
	<h3>Добавление родительской категории</h3>
	<form method="POST">
	    <input type="text" name="form[title]" placeholder="Название категории" class="form-control" required value="<?=$category->title?>" />
		<textarea name="form[description]" placeholder="Описание категории" class="form-control" required><?=$category->description?></textarea>	    
		<input type="text" name="form[meta_title]" placeholder="Мета заголовок" class="form-control" value="<?=$category->meta_title?>" />
	    <input type="text" name="form[meta_keywords]" placeholder="Мета ключевые слова" class="form-control" value="<?=$category->meta_keywords?>" />
	    <input type="text" name="form[meta_description]" placeholder="Мета описание" class="form-control" value="<?=$category->meta_description?>"  />
	    <input type="submit" value="Сохранить" class="btn btn-defoult add"/> <?=($saved)?'<span style="float: right;" class="success">Сохранено</span>':''?>
	</form>
</div>