<div id="main">
			<div id="blog">
				<h2>Блог</h2>
				<div class="container">
					<div class="row">
                                            <?php if(count($articles)){ ?>
						<div class="left-col col-md-8 clearfix">
                                                    <?php foreach ($articles as $article){ ?>
							<div class="article-holder col-sm-6">
                                                            <h4><a href="/blog/article/<?=$article->url; ?>"><?=$article->title; ?></a></h4>
                                                            <p><?=echoRussianDate($article->time); ?></p>
                                                            <p><?=$article->commentsCount; ?></p>комментариев<br>
                                                            <?php if($article->img){ ?>
                                                                <a href="/blog/article/<?=$article->url; ?>"><img src="/uploads/blog/<?= $article->url; ?>/<?=$article->img; ?>" alt="Foto"></a>
                                                            <?php }else{ ?>
                                                                <img src="/assets/images/foto-4.jpg" alt="Foto">
                                                            <?php } ?>
                                                            <div class="text">
                                                                <a href="/blog/article/<?=$article->url; ?>"> <?=$article->text; ?></a>
                                                            </div>
                                                            <a href="/blog/article/<?=$article->url; ?>" class="more">!more more more!</a>
							</div>
                                                   <div class='clearfix'></div>
                                                    <?php }
                                                    if($all > count($articles)){ ?>							
							<div class="more-10">
                                                            <form action="/blog/index/<?=$start; ?>" method="POST">
                                                                <button type="submit" class="main-btn load-four" data-url="/blog/index/<?=$start; ?>">Загрузить еще 4</button>                                                                
                                                            </form>
							</div>
                                                    <?php } ?>
						</div>
                                            <?php }else{
                                                echo 'Пока что нет ни одной статьи';
                                            } ?>
					</div>
				</div>
			</div>
		</div>
<script>

</script>