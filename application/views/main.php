<!DOCTYPE html>
<html lang="ru">
    <head>
 
        <!-- Will be the animations on the website??? -->

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        
        <meta property="og:type" content="site">
		<meta property="og:site_name" content="Stuffex">
		<meta property="og:url" content="http://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>">
		<meta property="og:title" content="<?= $this->meta_title; ?>">
		<meta property="og:description" content="Stuffex - Делитесь Вашими товарами с соседями и друзьями">
        
        
        <title><?= $this->meta_title; ?></title>
        <meta name="description" content="Stuffex - Делитесь Вашими товарами с соседями и друзьями" />
		<meta name="keywords" content="Stuffex, обновления" />
        <link media="all" rel="stylesheet" href="/assets/css/owl.carousel.css">
        <link media="all" rel="stylesheet" href="/assets/css/owl.transitions.css">
        <link media="all" rel="stylesheet" href="/assets/css/jquery-ui.theme.min.css">
        <link media="all" rel="stylesheet" href="/assets/css/jquery-ui.structure.min.css">
        <link media="all" rel="stylesheet" href="/assets/css/social-likes_classic.css">
        <link media="all" rel="stylesheet" href="/assets/css/bootstrap.css">
        <link media="all" rel="stylesheet" href="/assets/css/bootstrap-select.css">
        <link media="all" rel="stylesheet" href="/assets/css/jquery.fancybox.css">
        <link media="all" rel="stylesheet" href="/assets/css/style.css">
        <link href='https://fonts.googleapis.com/css?family=Roboto:300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <script src="/assets/js/jquery-1.11.2.min.js"></script>
    </head>
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                appId: '661145764024111',
                xfbml: true,
                version: 'v2.5'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!--        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.5";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>-->
    <body>
    	<div style="display: none"><p>Stuffex - Делитесь Вашими товарами с соседями и друзьями</p></div>
        <div id="wrapper">
        
        <?php include dirname(__FILE__) . '/layouts/' . $this->layout . '.php'; ?>

        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/bootstrap-select.min.js"></script>
        <script src="/assets/js/owl.carousel.min.js"></script>
        <script src="/assets/js/jquery.maskedinput.min.js"></script>
        <script src="/assets/js/jquery.rateit.js"></script>
        <script src="/assets/js/jquery-ui.min.js"></script>
        <script src="/assets/js/social-likes.min.js"></script>
        <script src="/assets/js/functions.js"></script>
        <script src="/assets/js/jquery.fancybox.pack.js"></script>
        <script src="/assets/js/jquery.fancybox-buttons.js"></script>
        <script src="/assets/js/jquery.fancybox-media.js"></script>
        <script src="/assets/js/jquery.fancybox-thumbs.js"></script>
        <script src="/assets/js/main.js"></script>

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
                (function (d, w, c) {
                    (w[c] = w[c] || []).push(function () {
                        try {
                            w.yaCounter35296685 = new Ya.Metrika({
                                id: 35296685,
                                clickmap: true,
                                trackLinks: true,
                                accurateTrackBounce: true,
                                webvisor: true,
                                trackHash: true
                            });
                        } catch (e) {
                        }
                    });

                    var n = d.getElementsByTagName("script")[0],
                            s = d.createElement("script"),
                            f = function () {
                                n.parentNode.insertBefore(s, n);
                            };
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = "https://mc.yandex.ru/metrika/watch.js";

                    if (w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f, false);
                    } else {
                        f();
                    }
                })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/35296685" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-69492045-29', 'auto');
            ga('send', 'pageview');            
        </script>
        <!-- Footer always below -->
        <script>
            var wrapheight = jQuery(window).outerHeight() - jQuery("#footer").outerHeight(true);
                jQuery("#content").css("min-height" , wrapheight + "px");    
        </script>
        </div>
    </body>
</html> 
