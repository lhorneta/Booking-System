<?php if (count($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <div class="error-message"><p><?= $error; ?></p></div>
    <?php endforeach; ?>
<?php endif; ?>

<form action="<?=$this->link('/login'); ?>" method="post" class="loginBlock">
    <label>Email<input type="text" name="form[email]" value="" required=""></label>
    <label><?=lang('password');?><input type="password" name="form[password]" value="" required=""></label>
    <input type="submit" value="<?=lang('button_enter'); ?>"><br>
</form>
<form action="<?=$this->link('/login/forgot'); ?>" method="post" class="loginBlock">
    <input type="submit" value="<?=lang('button_forgot_pass'); ?>"><br>
</form>

