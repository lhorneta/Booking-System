<div class="forgot">
    <?php if ($error!== ''){ ?>
        <?=$error; ?>
    <?php } ?>
    <form action="" method="POST" class="form-half">
            Введите ваш имейл: <input type="text" name="femail" placeholder="Ваш email" required>
        <input type="submit" value="Отправить запрос">
    </form>
</div>
