<div class="modal fade" id="newpassword" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Введите новый пароль</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="/cp/admin/newpass/<?=$admin->id; ?>" class="restore-password">
                    <div class="form-group">
                        <label>Новый пароль</label>
                        <input name="pass" type="text" class="form-control" placeholder="Новый пароль" required>
                    </div>
                    <div class="form-group">
                        <label>Повторите новый пароль</label>
                        <input name="passcheck" type="text" class="form-control" placeholder="Повторите новый пароль" required>
                    </div>
                    <button type="submit" class="btn btn-default">Восстановить</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="login">
<div class="login-logo">
<a href="index.html"><img src="/assets/images/logo.png" alt=""/></a>
</div>
<div class="forgot">
<div class="app-cam">
    <?php if ($message!== ''){ ?>
    <p style="color:#fff"><?=$message; ?></p>
<?php } ?>
<p style="color:#fff"><?=$admin->question; ?></p>
<form action="/cp/admin/checkquestion/<?=$admin->id; ?>" method="POST" class="form-half secret-question">
   <div class="form-group">
       <input type="text" class="form-control" name="answer" required>
   </div>
    <div class="form-group">
        <input type="submit" class="btn btn-default" value="Отправить запрос">
    </div>

</form>
</div>
</div>
</div>
<script>
    $('.secret-question').submit(function(e){
        e.preventDefault();
            var loginData = $(this).serialize();
            var isAnswerCorrect = false;
            $.ajax({
                url: '/cp/admin/checkquestion/<?=$admin->id; ?>',
                type: 'POST',
                async: false,
                data: loginData,
                success: function(data){
                    if($(data).find(".errmsg").text().length != 0){
                        console.log($(data).find(".errmsg").text());
                        alertify.success($(data).find(".errmsg").text());

                    } else isAnswerCorrect = true;

                }
            });
        console.log(isAnswerCorrect);
            if(isAnswerCorrect == true){
                $('#newpassword').modal('show');
            }
    });
</script>
