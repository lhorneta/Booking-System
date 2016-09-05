<div class="registration-holder">
    <?php if(count($user->errors)):?>
    <?php foreach($user->errors as $error):?>
        <div class="error-message"><p><?=$error;?></p></div>
    <?php endforeach;?>
    <?php endif;?>

    <div class="register-block">
        <h2>Регистрация</h2>
        <div class="registration-form" id="tab-1">
            <form action="/register" method="post" class="tab1_content validate">
<!--                    <label><span>Ф.И.О.</span><input type="text" name="form[name]" value="" required><br></label><br>
                <label><span>Ф.И.О.</span><input type="text" name="form[surname]" value="" required><br></label><br>
                <label><span>Телефон</span><input type="text" name="form[phone]" value="" required><br></label><br>-->
                <label>
                    <span>E-mail</span>
                    <input type="email" name="form[email]" class="emailfield" value="" required>
                </label>
                <label>
                    <span>Пароль</span>
                    <input type="password" name="form[password]" value="" required>
                </label>
                <label>
                    <span>Повторите пароль</span>
                    <input type="password" name="form[passcheck]" value="" required>
                </label>
                <input type="submit" value="Зарегистрироваться" class="btn">
            </form>
            <span>Все поля обязательны для заполнения!</span>
        </div>
    </div>
</div>