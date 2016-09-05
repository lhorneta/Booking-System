<div id="main-catalog">
<h1>Выберите категорию в которую будет размещен лот:</h1>
<?php


foreach($categories as $category){ ?>
	<p>
	<?php if ($category->haveChilds()) {
	$childs = $category->categoryAllChilds($category->id);
	debug($childs);
	?>
    <a href='/lot/selectcategory/<?=$category->url?>'><?=$category->title?> -></a>
    <?php } else { ?>
    <a href='/lot/add/<?=$category->url?>'><?=$category->title?></a>
    <?php } ?>
    </p>
<?php } ?>
</div>
    