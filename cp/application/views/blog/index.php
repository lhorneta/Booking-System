<div id="articles-list">
    <div class="col-md-12 span_3">
        <div class="bs-example1" data-example-id="contextual-table">
            <h2>Добавленные статьи:</h2>
            <div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="#waiting" aria-controls="home" role="tab" data-toggle="tab">Отложенные <span class="label label-primary"><?= count($status); ?></span></a></li>
                    <li role="presentation" class="active"><a href="#published" aria-controls="profile" role="tab" data-toggle="tab">Опубликованные <span class="label label-primary"><?= count($published); ?></span></a></li>
                    <li><a href="#" data-toggle="modal" data-target="#createArticle">Написать статью</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane clearfix" id="waiting">
                            <?php $i = 0; ?>

                            <?php if (count($status)): ?>
                                <?php foreach ($status as $post): ?>
                                    <?php $i++; ?>
                                    <div class="col-md-4">
                                        <div class="product-tab well">
                                            <div class="dropdown right-up">
                                                <button type="button" class="btn btn-default" id="category-ops" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-cogs"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="category-ops">
                                                    <li>
                                                        <a href="#" 
                                                            data-toggle="modal" 
                                                            data-target="#editArticle" 
                                                            data-id="<?= $post->id; ?>" 
                                                            data-name="<?= $post->title; ?>" 
                                                            data-url="<?= $post->url; ?>" 
                                                            data-text="<?= $post->text; ?>" 
                                                            data-title="<?= $post->meta_t; ?>"
                                                            data-mini-description="<?= $post->mini_description; ?>" 
                                                            data-description="<?= $post->meta_d; ?>" 
                                                            data-keywords="<?= $post->meta_k; ?>" 
                                                            data-video="<?= $post->video; ?>"
                                                            data-rubric="<?= $post->rubric; ?>"
                                                            data-best="<?= $post->best; ?>"
                                                            data-interesting="<?= $post->interesting; ?>"
                                                            data-status="<?= $post->status; ?>"
                                                        >Редактировать</a></li>
                                                    <li><a href="/cp/blog/status/<?= $post->id; ?>">Опубликовать</a></li>
                                                    <li><a href="javascript: void(0)" class="del-article" data-id="<?= $post->id; ?>">Удалить</a></li>
                                                </ul>
                                            </div>
                                            <div class="blog-article-inner">
                                                <?php if ($post->img) { ?>
                                                    <div class="img-container" style="background-image: url(/uploads/blog/<?= $post->url; ?>/<?= $post->img; ?>)"></div>
                                                <?php } else { ?>
                                                    <div class="img-container" style="background-image: url(/cp/assets/images/product.jpg)"></div>
                                                <?php } ?>
                                                <h4><?= $post->title; ?></h4>
                                                <p><strong>URL:<?= $post->url; ?></strong></p>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                    <?php if ($i == 3) {
                                        echo "<div class='clearfix'></div>";
                                        $i = 0;
                                    } ?>
        <?php endforeach; ?>
    <?php else: ?>
                                <p>Пока еще не добавлено ни одной статьи</p>
                            <?php endif; ?>
                    </div>
                    <div role="tabpanel" class="tab-pane active clearfix" id="published">
                        <div class="row">
                            <?php $i = 0; ?>

    <?php if (count($published)): ?>

        <?php foreach ($published as $post): ?>
            <?php $i++; ?>
                                    <div class="col-md-4">
                                        <div class="product-tab well">
                                            <div class="dropdown right-up">
                                                <button type="button" class="btn btn-default" id="category-ops" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-cogs"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="category-ops">
                                                    <li><a href="#" 
                                                        data-toggle="modal" 
                                                        data-target="#editArticle" 
                                                        data-id="<?= $post->id; ?>" 
                                                        data-name="<?= $post->title; ?>"
                                                        data-url="<?= $post->url; ?>"
                                                        data-mini-description="<?= $post->mini_description; ?>" 
                                                        data-text="<?= $post->description; ?>" 
                                                        data-title="<?= $post->meta_t; ?>" 
                                                        data-description="<?= $post->meta_d; ?>" 
                                                        data-keywords="<?= $post->meta_k; ?>"
                                                        data-rubric="<?= $post->rubric; ?>"
                                                        data-best="<?= $post->best; ?>"
                                                        data-interesting="<?= $post->interesting; ?>"
                                                        data-status="<?= $post->status; ?>"
                                                        >Редактировать</a></li>
                                                    <li><a href="javascript: void(0)" class="del-article" data-id="<?= $post->id; ?>">Удалить</a></li>
                                                </ul>
                                            </div>
                                            <div class="blog-article-inner">
                                                <?php if ($post->img) { ?>
                                                    <div class="img-container" style="background-image: url(/uploads/blog/<?= $post->url; ?>/<?= $post->img; ?>)"></div>
                                                <?php } else { ?>
                                                    <div class="img-container" style="background-image: url(/cp/assets/images/product.jpg)"></div>
                                                <?php } ?>
                                                <h4><?= $post->title; ?></h4>
                                                <a href="/cp/comment/blog/<?=$post->id; ?>">Комментариев: <?= $post->commentsCount; ?></a><br>
                                                <a href="/cp/comment/blog/<?=$post->id; ?>"> Ответов: <?= $post->commentsAnswer; ?></a><br>
                                                <p><strong>URL:<?= $post->url; ?></strong></p>
                                            </div>


                                            <br>
                                        </div>
                                    </div>
            <?php if ($i == 3) {
                echo "<div class='clearfix'></div>";
                $i = 0;
            } ?>
        <?php endforeach; ?>
    <?php else: ?>
                                <p>Пока еще не добавлено ни одной статьи</p>
    <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editArticle" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Редактировать статью</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/cp/blog/edit/" data-action="/cp/blog/edit/" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Название</label>
                            <input name="form[title]" type="text" class="form-control article-name" placeholder="Название">
                        </div>
                        <div class="form-group">
                            <label>Мини описание</label>
                            <textarea name="form[mini_description]" class="form-control mini-description" placeholder="Описание"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Описание</label>
                            <textarea name="form[description]" class="form-control article-text" placeholder="Описание"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta - Title</label>
                            <input name="form[meta_t]" type="text" class="form-control meta-title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label>Meta - Description</label>
                            <input name="form[meta_d]" type="text" class="form-control meta-description" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <label>Meta - Keywords</label>
                            <input name="form[meta_k]" type="text" class="form-control meta-keywords" placeholder="Keywords">
                        </div>
                        <div class="form-group">
                            <label>Рубрики</label>
                            <select name="form[rubric]" class="form-control meta-rubric">
                                <?php
                                 foreach ($rubrics as $key => $value) {?>
                                     <option value="<?=$value->id?>"><?=$value->title?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Опубликовать</label>
                            <input name="form[status]" value="1" type="checkbox" class="form-control meta-status">
                        </div>
                        <div class="form-group">
                            <label>Лучшее</label>
                            <input name="form[best]" value="1" type="checkbox" class="form-control meta-best">
                        </div>
                        <div class="form-group">
                            <label>Интересное</label>
                            <input name="form[interesting]" value="1" type="checkbox" class="form-control meta-interesting">
                        </div>                                
                        <div class="form-group">
                            <label>Картинка</label>
                            <input name="userfile" type="file" class="form-control">
                        </div>                            
                        <button type="submit" class="btn btn-default">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createArticle" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Написать статью</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/cp/blog/add" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Название</label>
                            <input name="form[title]" type="text" class="form-control product-name" placeholder="Название">
                        </div>
                        <div class="form-group">
                            <label>Мини описание</label>
                            <textarea name="form[mini_description]" class="form-control mini-description" placeholder="Описание"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Описание</label>
                            <textarea name="form[description]" class="form-control product-description" placeholder="Описание"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Meta - Title</label>
                            <input name="form[meta_t]" type="text" class="form-control meta-title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label>Meta - Description</label>
                            <input name="form[meta_d]" type="text" class="form-control meta-description" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <label>Meta - Keywords</label>
                            <input name="form[meta_k]" type="text" class="form-control meta-keywords" placeholder="Keywords">
                        </div>
                        <div class="form-group">
                            <label>Рубрики</label>
                            <select name="form[rubric]" class="form-control meta-rubric">
                                <?php
                                 foreach ($rubrics as $key => $value) {?>
                                     <option value="<?=$value->id?>"><?=$value->title?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Опубликовать</label>
                            <input name="form[status]" value="1" type="checkbox" class="form-control meta-status">
                        </div>
                        <div class="form-group">
                            <label>Лучшее</label>
                            <input name="form[best]" value="1" type="checkbox" class="form-control meta-best">
                        </div>
                        <div class="form-group">
                            <label>Интересное</label>
                            <input name="form[interesting]" value="1" type="checkbox" class="form-control meta-interesting">
                        </div>
                        <div class="form-group">
                            <label>Картинка</label>
                            <input name="userfile" type="file" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-default">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-del-holder delete-article">
        <div class="modal-del">
            <button type="button" class="closer">×</button>
            <div class="question">
                <p><i class="fa fa-trash-o"></i> Вы действительно хотите удалить данную статью насовсем?</p>
                <a href="/cp/blog/delete/" class="ok">ОК</a>
                <a href="#" onclick="return false" class="cancel">ОТМЕНА</a>
            </div>
        </div>
        <div class="overlay"></div>
    </div>
</div>
<script>
    $('#editArticle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var name = button.data('name'); // Extract info from data-* attributes
        var url = button.data('url'); // Extract info from data-* attributes        
        var text = button.data('text'); // Extract info from data-* attributes        
        var id = button.data('id'); // Extract info from data-* attributes   
        var title = button.data('title'); // Extract info from data-* attributes   
        var mini_description = button.data('mini-description');
        var description = button.data('description'); // Extract info from data-* attributes   
        var keywords = button.data('keywords'); // Extract info from data-* attributes   
        var video = button.data('video'); // Extract info from data-* attributes   
        var status = button.data('status'); // Extract info from data-* attributes 
        var rubric = button.data('rubric'); // Extract info from data-* attributes 
        var interesting = button.data('interesting'); // Extract info from data-* attributes 
        var best = button.data('best'); // Extract info from data-* attributes 
        var curAct = $(this).find("form").data("action");

        console.log(status, interesting, best);
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body .article-name').val(name);
        modal.find('.modal-body .article-url').val(url);
        //        modal.find('.modal-body .article-text').val(text);
        tinyMCE.activeEditor.setContent('');
        tinyMCE.execCommand('mceInsertContent', false, text);

        modal.find('.modal-body .meta-title').val(title);
        modal.find('.modal-body .mini-description').val(mini_description);
        modal.find('.modal-body .meta-description').val(description);
        modal.find('.modal-body .meta-keywords').val(keywords);
        modal.find('.modal-body .article-video').val(video);
        modal.find('.modal-body .meta-rubric option[value='+rubric+']').attr('selected', 'selected');

        if(status ===1 ){modal.find('.modal-body .meta-status').attr('checked','checked');}else{modal.find('.modal-body .meta-status').removeAttr('checked');}
        if(interesting ===1 ){modal.find('.modal-body .meta-interesting').attr('checked','checked');}else{modal.find('.modal-body .meta-interesting').removeAttr('checked');}
        if(best ===1 ){modal.find('.modal-body .meta-best').attr('checked','checked');}else{modal.find('.modal-body .meta-best').removeAttr('checked');}
        $(this).find("form").attr("action", curAct + url);
    });

    //Extract info from data-id attributes into attributes 'href'
    $('.del-article').click( function () {
        var id = $(this).data('id');
        var modal = $('.delete-article');
        modal.find('a.ok').attr('href', '/cp/blog/delete/' + id);
    });

</script>
<script type="text/javascript">
    tinymce.init({
        selector: ".product-description",
        inline_styles: false,
        language: "ru",
        height: "100",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor  | forecolor backcolor  | print preview code ",
        image_advtab: true,
        external_filemanager_path: "/cp/core/libs/filemanager/",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "/cp/core/libs/filemanager/plugin.min.js"}
    });
    tinymce.init({
        selector: ".article-text",
        language: "ru",
        inline_styles: false,
        height: "100",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor  | forecolor backcolor  | print preview code ",
        image_advtab: true,
        external_filemanager_path: "/cp/core/libs/filemanager/",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "/cp/core/libs/filemanager/plugin.min.js"}
    });
</script>
