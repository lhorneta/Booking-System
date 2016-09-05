<div id="users-list" class="col-md-12 white nopadding">
    <ul class="nav nav-tabs nomargin" role="tablist">
        <li role="presentation" class="active activeusers"><a href="#activeusers" aria-controls="home" role="tab" data-toggle="tab">Активные пользователи <span class="label label-primary count-active-label"><?= count($active); ?></span></a></li>
        <li role="presentation" class="blockedusers"><a href="#blockedusers" aria-controls="profile" role="tab" data-toggle="tab">Заблокированные пользователи  <span class="label label-primary count-deactive-label"><?= count($deactive); ?></span></a></li>
    </ul>

    <div class="tab-content nomargin">
        <div role="tabpanel" class="tab-pane active" id="activeusers">

            <div class="col-md-12 span_3 activeusers count-active-elements">
                <div class="bs-example1" data-example-id="contextual-table">
                    <!--       <h3>Активные</h3>-->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Фото</th>
                                <th>ФИО</th>
                                <th>E-Mail</th>
                                <th>Телефон</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <?php if (count($active)): $i = 1; ?>

                            <tbody>
                                <?php foreach ($active as $auser): ?>
                                    <tr class="counted-element">
                                        <td class="foto-box">
                                            <? if($auser->avatar){ ?>
								        		<div class="foto-holder" style="background-image: url('<?=$auser->avatar;?>')"></div>
								        	<?}else{?>
								        		<div class="foto-holder" style="background-image: url(assets/images/photo.jpg)"></div>
								        	<? }?>
                                        </td>
                                        <td>
                                            <?= $auser->fio; ?>
                                        </td>
                                        <td>
                                            <?= $auser->email; ?>
                                        </td>
                                        <td>
                                            <?= $auser->phone; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-default usertoggler" type="submit" data-id="<?= $auser->id; ?>" data-inactive="<?= $auser->bane; ?>"><i class="fa fa-power-off"></i> <span class="text"> Заблокировать</span></button>
                                        </td>
            <!--                            <td>
                                            <a href="/cp/user/delete/<?= $auser->id; ?>" class="btn btn-default del-btn usertoggler" type="submit" data-id="<?= $auser->id; ?>" data-inactive="<?= $auser->bane; ?>"><i class="fa fa-ban"></i> <span class="text">Удалить</span></a>
                                        </td>-->
                                        <td>
                                            <a href ="/cp/user/info/<?= $auser->id; ?>" class="btn btn-default usertoggler" ><span class="text"> Подробнее</span></button>
                                        </td>
                                        <td class="del-holder">
                                            <a href="javascript: void(0)" class="btn del-btn del-user" data-id="<?= $auser->id; ?>">Удалить</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>


                            </tbody>

                        <?php endif; ?>
                    </table>
                </div>
            </div>


        </div>
        <div role="tabpanel" class="tab-pane" id="blockedusers">

            <div class="col-md-12 span_3 blockedusers count-deactive-elements">
                <div class="bs-example1" data-example-id="contextual-table">
                    <!--       <h3>Заблокированные</h3>-->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Фото</th>
                                <th>ФИО</th>
                                <th>E-Mail</th>
                                <th>Телефон</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <?php if (count($deactive)): $i = 1; ?>

                            <tbody>
                                <?php foreach ($deactive as $deuser): ?>
                                    <tr class="counted-element">
                                        <td class="foto-box">
                                        	<? if($deuser->avatar){ ?>
								        		<div class="foto-holder" style="background-image: url('<?=$deuser->avatar;?>')"></div>
								        	<?}else{?>
								        		<div class="foto-holder" style="background-image: url(assets/images/photo.jpg)"></div>
								        	<? }?>
                                        </td>
                                        <td>
                                            <?= $deuser->fio; ?>
                                        </td>
                                        <td>
                                            <?= $deuser->email; ?>
                                        </td>
                                        <td>
                                            <?= $deuser->phone; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-default usertoggler" type="submit" data-id="<?= $deuser->id; ?>" data-inactive="<?= $deuser->bane; ?>"><i class="fa fa-power-off"></i> <span class="text"> Разблокировать</span></button>
                                        </td>
            <!--                            <td>
                                            <a href="/cp/user/delete/<?= $deuser->id; ?>" class="btn btn-default del-btn usertoggler" type="submit" data-id="<?= $deuser->id; ?>" data-inactive="<?= $deuser->bane; ?>"><i class="fa fa-ban"></i> <span class="text"> Удалить</span></a>
                                        </td>-->
                                        <td>
                                            <a href ="/cp/user/info/<?= $deuser->id; ?>" class="btn btn-default usertoggler" ><span class="text"> Подробнее</span></button>
                                        </td>
                                        <td class="del-holder">
                                            <a href="#" class="btn del-btn del-user" data-id="1">Удалить</a>
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
    <div class="modal-del-holder delete-user">
        <div class="modal-del">
            <button type="button" class="closer">×</button>
            <div class="question">
                <p><i class="fa fa-trash-o"></i> Вы действительно хотите удалить данного пользователя? Вместе с аккаунтом также удаляться все связанные с пользователем данные.</p>
                <a href="/cp/user/delete/" class="ok">ОК</a>
                <a href="#" onclick="return false" class="cancel">ОТМЕНА</a>
            </div>
        </div>
        <div class="overlay"></div>
    </div>
</div>

<br>

<script>
    function countSmth() {
        if ($(".count-active-elements .counted-element").length != 0)
            $(".count-active-label").text($(".count-active-elements .counted-element").length);
        else
            $(".count-active-label").text("");
        if ($(".count-deactive-elements .counted-element").length != 0)
            $(".count-deactive-label").text($(".count-deactive-elements .counted-element").length);
        else
            $(".count-deactive-label").text("");
    }
    $("body").on('click', '.usertoggler', function () {
        var id = $(this).data("id");
        var inactive = $(this).data("inactive");
        var currentObj = $(this);
        alertify.set({
            delay: 3000
        });
        $.ajax({
            url: '/cp/user/status/' + id,
            success: function () {
                console.log("status toggled");

                $.ajax({
                    url: window.location,
                    success: function (data) {
                        $('.activeusers').html($(data).find('.activeusers').html());
                        $('.blockedusers').html($(data).find('.blockedusers').html());
                        $('#activeusers').html($(data).find('#activeusers').html());
                        $('#blockedusers').html($(data).find('#blockedusers').html());
                        if (inactive == 1) {
                            alertify.success("Пользователь разблокирован");
                        } else {
                            alertify.success("Пользователь заблокирован");
                        }
                    }
                });
                countSmth();

            }
        });
    });

    //Extract info from data-id attributes insert attribute 'href'
    $('.del-user').click(function () {
        var id = $(this).data('id');
        var modal = $('.delete-user');
        modal.find('a.ok').attr('href', '/cp/user/delete/' + id);
    });

    $(window).ready(function () {
        countSmth();
    });
</script>
