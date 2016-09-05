<div class="text">
    <p><?=$article->text; ?></p>
</div>
<?php if(count($comments)){ ?>
    <h2>Комментарии</h2>
    <?php foreach ($comments as $comment) { ?>
        <?php if ($comment->img) { ?>
            <img src="/uploads/user/<?= $comment->img; ?>">
        <?php } else { ?>
            <img src="/assets/images/user.png" alt="Foto">
        <?php } ?>
        <p><?= $comment->user; ?></p>
        <h5><?= $comment->date; ?></h5>
        <p><?= $comment->text; ?></p>
        <a href="">Ответить</a><br>
        <?php
        if (count($comment->replies)) {
            foreach ($comment->replies as $comm) {

            }
        }
    }
}
?>
    Оставьте свой комментрарий: <br>
    <?php if($user){ 
        $user->name ? "<p>Имя<input value='<?=$user->name; ?>' type='text' /><br></p>" : ''; ?>
        <p>E-mail<input value="<?=$user->email; ?>" type="text" /><br></p>
    <?php } ?>
<form action="/blog/articlecomment/<?=$article->id; ?>" method="post">
    <p>Комментарий<textarea name="comment[text]"></textarea></p><br>
    <input name="submit" type="submit" value="Отправить комментарий">
</form>