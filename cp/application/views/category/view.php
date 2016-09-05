<h1>Родительская категория: <?= $parent->title; ?></h1>
<h3>Категории которые входят в родительскую:</h3>
<?php foreach ($parent->firstChilds as $child) {
    $child->checkChilds(); ?>
    Название категории: <p><a href="/cp/category/view/<?= $child->id; ?>"><?= $child->title; ?></a><p>
        Описание: <p><?= ($child->description) ? $child->description : 'нет описания'; ?><p>
        <a href="/cp/category/info/<?= $child->id; ?>">Лоты</a>
        <a href="/cp/category/add/<?= $child->id; ?>">Редактировать</a>
        <a href="/cp/category/addchild/<?= $child->id; ?>">Добавить дочернюю категорию</a>
    <hr>
    <?php
} 