<div class="selectcategory">
	<h2>Выберите категорию в которую будет размещен лот:</h2>
	<?php
	foreach($categories as $category){ ?>
	    <p><?=$category->hadChilds ? "<a href='/category/selectcategory/$category->url'>$category->title -></a>" : "<a href='/category/$category->url'>$category->title</a>"; ?></p>
	<?php
	} ?>
</div> 
    