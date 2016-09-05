<div class="recovery">
    <h2>Востановление пароля</h2>
    <form action="/login/newpass/<?=$hash?>" method="POST" class="form-half">
        <input type="password" name="pass" placeholder="Новый пароль" required id="p1">
        <input type="password" name="passchek" placeholder="Пароль еще раз" required id="p2">
        <input type="submit" value="Сохранить изменения" class="change_recov_pass">
        <div class="errors_changepass"></div>
    </form>
</div>
