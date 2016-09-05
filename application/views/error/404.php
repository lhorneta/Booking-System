<div id="error404">
    <div class="error-holder">
        <div class="text-block">
            <h2>Ой!</h2>
            <strong>Такой страницы<br> на нашем сайте нет :(</strong>
            <span>Ошибка 404</span>
        </div>
        <div class="img-block">
            <img src="/assets/images/404.png" alt='Img'>
        </div>
        <p>Не расстраивайтесь, выход есть!<br> Перейдите на <a href="/">главную страницу</a> или на <a href="/">страницу объявлений.</a></p>
    </div>
</div>
<script>
    //Height for #error404
    ;(function() {
        if(window.innerWidth >= 1024) {
            var error404 = document.getElementById('error404'),
                content = document.getElementById('content');
            error404.style.cssText = 'height:' + content.clientHeight + 'px';
        }
    })();
</script>