<div class="sidebar relative">
    <div class="logo">
        <p class="hello">Вы вошли как: <a href="/cp/admin"><?= app::gi()->user->login; ?></a></p>
    </div>
    <div class="menu">
        <h3>Автопостинг</h3>
        <ul class="sidebar_menu">
            <li><a href="/cp/blog">Все посты</a></li>
            <li><a href="/cp/blog/add">Добавить посты</a></li>
            <li><a href="/cp/blog/config">Редактировать конфигурацию автопостинга</a></li>
        </ul>
        <h3>Контент</h3>
        <ul class="sidebar_menu">
            <li><a href="/cp">Главная</a></li>
            <li><a href="/cp/admin">Администраторы</a></li>
            <li><a href="/cp/user">Пользователи</a></li>
            <li><a href="/cp/category">Категории</a></li>
            <li><a href="/cp/product">Товары</a></li>
            <li><a href="/cp/package">Пакеты</a></li>
            <li><a href="/cp/share">Акции</a></li>
            <li><a href="/cp/article">Статьи</a></li>
        </ul>
        <h3>Страницы сайта</h3>
        <ul class="sidebar_menu">
<!--            <li><a href="/cp/page/main">Главная</a></li>
            <li><a href="/cp/page/about">О компании</a></li>
            <li><a href="/cp/page/stati">Добавить страницу статьи</a></li>
            <li><a href="/cp/page/editstati">Редактировать страницу статьи</a></li>
            <li><a href="/cp/page/pay">Оплата</a></li>
            <li><a href="/cp/page/contactsanddelivery">Контакты и доставка</a></li>
            <li><a href="/cp/page/review">Отзывы</a></li>
            <li><a href="/cp/page/faq">Вопрос - Ответ</a></li>
            <li><a href="/cp/page/rule">Правила заполнения</a></li>-->
        </ul>
    </div>
</div>
<div class="content">
    <div class="smallrow">
        <a href="#"></a>
        <div class="linkgroup">
            <a href="#"></a>
            <a href="#"></a>
            <a href="#"></a>
            <a href="#"></a>
        </div>
    </div>
    <div class="main">
        <?= $content; ?>
    </div>
    <div class="smallrow">
        <div class="linkgroup">
            <a href="#" class="large">Hello, admin!</a>
            <a href="#"></a>
            <a href="#"></a>
        </div>
    </div>
</div>