<div class="col-md-12 white nopadding administrators">
    <div class="row">
        <div class="col-md-12">
            <div class="modal fade" id="createAdmin" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Создать администратора</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="/cp/admin/add">
                                <div class="form-group">
                                    <label>ФИО</label>
                                    <input name="form[fio]" type="text" class="form-control admin-fio" placeholder="ФИО" required>
                                </div>
                                <div class="form-group">
                                    <label>Логин</label>
                                    <input name="form[login]" type="text" class="form-control admin-login" placeholder="Логин" required>
                                </div>
                                <div class="form-group">
                                    <label>E-Mail</label>
                                    <input name="form[email]" type="email" class="form-control admin-email" placeholder="E-Mail" required>
                                </div>
                                <div class="form-group">
                                    <label>Телефон</label>
                                    <input name="form[phone]" type="text" class="form-control admin-phone" placeholder="Телефон" required>
                                </div>
                                <div class="form-group">
                                    <label>Пароль</label>
                                    <input name="form[password]" type="password" class="form-control admin-pass" placeholder="Пароль" required>
                                </div>
                                <div class="form-group">
                                    <label>Секретный вопрос</label>
                                    <select name="form[question]" class="form-control">
                                           <option disabled selected>Выберите секретный вопрос</option>
                                        <?php foreach($questions as $question){ ?>
                                            <option value="<?=$question; ?>"><?=$question; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ответ на секретный вопрос</label>
                                    <input name="form[answer]" type="text" class="form-control" placeholder="Ответ на секретный вопрос" required>
                                </div>
                                <button type="submit" class="btn btn-default">Создать</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editAdmin" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Редактировать администратора</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="/cp/admin/add">
                                <div class="form-group">
                                    <label>ФИО</label>
                                    <input name="form[name]" type="text" class="form-control admin-name" placeholder="ФИО" required>
                                </div>
                                <div class="form-group">
                                    <label>Логин</label>
                                    <input name="form[login]" type="text" class="form-control admin-login" placeholder="Логин" required>
                                </div>
                                <div class="form-group">
                                    <label>E-Mail</label>
                                    <input name="form[email]" type="email" class="form-control admin-email" placeholder="E-Mail" required>
                                </div>
                                <div class="form-group">
                                    <label>Телефон</label>
                                    <input name="form[phone]" type="email" class="form-control admin-phone" placeholder="Телефон" required>
                                </div>
                                <div class="form-group">
                                    <label>Пароль</label>
                                    <input name="form[password]" type="password" class="form-control admin-pass" placeholder="Пароль" required>
                                </div>
                                <div class="form-group">
                                    <label>Секретный вопрос</label>
                                    <select name="form[question]" class="form-control">
                                           <option disabled selected>Выберите секретный вопрос</option>
                                        <?php foreach($questions as $question){ ?>
                                            <option value="<?=$question; ?>"><?=$question; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ответ на секретный вопрос</label>
                                    <input name="form[answer]" type="text" class="form-control" placeholder="Ответ на секретный вопрос" required>
                                </div>
                                <button type="submit" class="btn btn-default">Сохранить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs nomargin" role="tablist">
                <li role="presentation" class="active"><a href="#activeadmins" aria-controls="home" role="tab" data-toggle="tab">Активные администраторы <span class="label label-primary count-active-label"><?=count($active); ?></span></a></li>
                <li role="presentation"><a href="#blockedadmins" aria-controls="profile" role="tab" data-toggle="tab">Неактивные администраторы <span class="label label-primary count-deactive-label"><?=count($deactive); ?></span></a></li>
                <li><a href="#" data-toggle="modal" data-target="#createAdmin">Создать администратора</a></li>
            </ul>

          <div class="tab-content nomargin">
            <div role="tabpanel" class="tab-pane active" id="activeadmins">

                    <div class="col-md-12 span_3 count-active-elements">
            <div class="bs-example1" data-example-id="contextual-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ФИО</th>
                            <th>Логин</th>
                            <th>E-Mail</th>
                            <th>Телефон</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php if (count($active)): $i = 1; ?>

                        <tbody>
                            <?php foreach ($active as $aadmin): ?>
                                <tr class="counted-element">
                                    <td class="admin-name">
                                        <?= $aadmin->fio; ?>
                                    </td>
                                    <td class="admin-name">
                                        <?= $aadmin->fio; ?>
                                    </td>
                                    <td class="admin-email">
                                        <?= $aadmin->email; ?>
                                    </td>
                                    <td class="admin-email">
                                        <?= $aadmin->phone; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-default deactivate admintoggler" type="submit" data-id="<?= $aadmin->id; ?>" data-inactive="<?= $aadmin->active; ?>"><i class="fa fa-power-off"></i> <span class="text"> Деактивировать</span></button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default edit" type="submit" data-toggle="modal" data-target="#editAdmin" data-id="<?= $aadmin->id; ?>" data-name="<?= $aadmin->fio; ?>" data-login="<?= $aadmin->fio; ?>" data-email="<?= $aadmin->email; ?>" data-phone="<?= $aadmin->phone; ?>" data-pass="12345">
                                            <i class="fa fa-pencil-square-o"></i> 
                                            <span class="text"> Редактировать</span>
                                        </button>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-default del-btn del-admin" type="submit" data-id="<?= $aadmin->id; ?>" data-inactive="<?= $aadmin->active; ?>" onclick="return false"><i class="fa fa-ban"></i> <span class="text"> Удалить</span></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>


                        </tbody>

                        <?php endif; ?>
                </table>
            </div>
        </div>


            </div>
            <div role="tabpanel" class="tab-pane" id="blockedadmins">

            <div class="col-md-12 span_3 count-deactive-elements">
            <div class="bs-example1" data-example-id="contextual-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ФИО</th>
                            <th>Логин</th>
                            <th>E-Mail</th>
                            <th>Телефон</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php if (count($deactive)): $i = 1; ?>

                        <tbody>
                            <?php foreach ($deactive as $dadmin): ?>
                                <tr class="counted-element">
                                    <td class="admin-name">
                                        <?= $dadmin->fio; ?>
                                    </td>
                                    <td class="admin-name">
                                        <?= $dadmin->fio; ?>
                                    </td>
                                    <td class="admin-email">
                                        <?= $dadmin->email; ?>
                                    </td>
                                    <td class="admin-email">
                                        <?= $dadmin->phone; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-default deactivate admintoggler" type="submit" data-id="<?= $dadmin->id; ?>" data-inactive="<?= $dadmin->active; ?>"><i class="fa fa-power-off"></i> <span class="text"> Активировать</span></button>
                                    </td>
                                    <td>
                                        <button class="btn btn-default edit" type="submit" data-toggle="modal" data-target="#editAdmin" data-id="<?= $aadmin->id; ?>" data-name="<?= $aadmin->fio; ?>" data-login="<?= $aadmin->fio; ?>" data-email="<?= $aadmin->email; ?>" data-phone="<?= $aadmin->phone; ?>" data-pass="12345">
                                            <i class="fa fa-pencil-square-o"></i> 
                                            <span class="text"> Редактировать</span>
                                        </button>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-default del-btn del-admin" type="submit" data-id="<?= $dadmin->id; ?>" data-inactive="<?= $dadmin->active; ?>" onclick="return false"><i class="fa fa-power-off"></i> <span class="text"> Удалить</span></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>


                        </tbody>

                        <?php endif; ?>
                </table>
            </div>
        </div>

            </div>

        </div>

        </div>
    </div>

    <div class="modal-del-holder delete-admin">
        <div class="modal-del">
            <button type="button" class="closer">×</button>
            <div class="question">
                <p><i class="fa fa-trash-o"></i> Вы действительно хотите удалить данного администратора насовсем?</p>
                <a href="/cp/admin/delete/" class="ok">ОК</a>
                <a href="#" onclick="return false" class="cancel">ОТМЕНА</a>
            </div>
        </div>
        <div class="overlay"></div>
    </div>
</div>

<script>
    function countSmth(){
        if($(".count-active-elements .counted-element").length != 0) $(".count-active-label").text($(".count-active-elements .counted-element").length); else $(".count-active-label").text("");
        if($(".count-deactive-elements .counted-element").length != 0) $(".count-deactive-label").text($(".count-deactive-elements .counted-element").length); else $(".count-deactive-label").text("");
    }
    $('#editAdmin').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var name = button.data('name'); // Extract info from data-* attributes
        var login = button.data('login'); // Extract info from data-* attributes
        var email = button.data('email'); // Extract info from data-* attributes
        var phone = button.data('phone'); // Extract info from data-* attributes
        var pass = button.data('pass'); // Extract info from data-* attributes
        var id = button.data('id'); // Extract info from data-* attributes
        var active = button.data('active'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body input.admin-active').val(active);
        modal.find('.modal-body input.admin-id').val(id);
        modal.find('.modal-body input.admin-name').val(name);
        modal.find('.modal-body input.admin-login').val(login);
        modal.find('.modal-body input.admin-email').val(email);
        modal.find('.modal-body input.admin-phone').val(phone);
        modal.find('.modal-body input.admin-pass').val(pass);
    })

    $(".admintoggler").click(function(){
        var id = $(this).data("id");
        var inactive = $(this).data("inactive");
        var currentObj = $(this);

        $.ajax({
          url: '/cp/admin/status/'+id,
          success: function(){
              if(inactive == 1) {
                $(currentObj).data("inactive", 0).children(".text").text("Активировать");
                $("#blockedadmins .table").append($(currentObj).parents("tr").addClass("success"));
                alertify.success("Администратор заблокирован");
              } else {
                $(currentObj).data("inactive", 1).children(".text").text("Деактивировать");
                $("#activeadmins .table").append($(currentObj).parents("tr").addClass("success"));
                alertify.success("Администратор разблокирован");
              }
              countSmth();    
          }
        });

    });

    //Extract info from data-id attributes into attributes 'href'
    $('.del-admin').click(function () {
        var id = $(this).data('id');
        var modal = $('.delete-admin');
        modal.find('a.ok').attr('href', '/cp/admin/delete/' + id);
    });

    $(window).ready(function(){
        countSmth();
    });
</script>
