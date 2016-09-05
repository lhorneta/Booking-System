<div id="main-not-logged">
    <h2>Вы не залогинены</h2>
    <div class="enter-registration for-not-logged">
        <div class="log-form-holder">
            <form method="POST" action="<?= $this->link('/login'); ?>" class="form-horizontal">
                <h5>Вход на stuffe<i>x</i>.ua</h5>
                <input name="form[email]" type="email" placeholder="Ваш E-mail" required>
                <input id="pass3" class="st-input" name="form[password]" type="password" alt="" placeholder="Пароль" required>
                <label class="checkbox">
                    <input onchange="if ($('#pass3').get(0).type == 'password')
                                $('#pass3').get(0).type = 'text';
                            else
                                $('#pass3').get(0).type = 'password';" name="fff" type="checkbox" value="false">
                    <span class="lbl padding-8">Показать пароль</span>
                </label>
                <a href="#" class="could-not-enter" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#notEnter">Не удалось войти</a>
                <label class="checkbox">
                    <input type="checkbox">
                    <span class="lbl padding-8">Запомнить меня</span>
                </label>
                <button type="submit" class="btn main-btn">Войти</button>
            </form>
        </div>
        <div class="registration-box">
            <h5>Создать учетную запись</h5>
            <p>Пароль нужен для входа в раздел <i>Мои объявления</i>, где вы сможете работать с объявлениями:</p>
            <ul>
                <li>редактировать, удалять и обновлять</li>
                <li>просматривать сообщения</li>
                <li>просматривать избранные объявления</li>
            </ul>
            <a href="/register" class="btn">Регистрация</a>
        </div>
    </div>
    <div class="other-enter">
        <h5>Войти с помощью</h5>
        <div class="facebook-holder">
            <a href="<?= Socials::linkFacebook(); ?>" class="facebook"><i class="fa fa-facebook"></i>Войти через Facebook</a>
        </div>
        <div class="gplus-holder">
            <a href="#" class="gplus"><i class="fa fa-google-plus"></i>Войти через Google</a>
        </div>
    </div>
    <div class="registration-box registration-box-640px">
        <h5>Создать учетную запись</h5>
        <a href="#" onclick="return false" class="btn reg-btn" data-toggle="modal" data-target="#registrationWindow" data-dismiss="modal" aria-label="Close">Регистрация</a>
    </div>
    
    <div class="modal fade" id="notEnter" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog create-admin" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <div class="modal-body">
                    <h5>Изменить пароль</h5>
                    <div class="forgot">
                        <form action="/login/forgot" method="POST" class="form-half">
                            <label>
                                <span>Введите ваш email:</span>
                                <input type="email" name="femail" class="form-control" placeholder="Ваш email" required>
                            </label>
                            <input type="submit" value="Отправить запрос" class="btn main-btn">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>