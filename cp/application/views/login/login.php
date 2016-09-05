<!--
<div class="row">
    <div class="col-md-6 col-lg-4 col-xs-12">
        <div class="login-admin-block">
            <h3>Вход в админ панель</h3>
            <h4><?= $error; ?></h4>
            <form action="/cp/login" method="post">
                <div class="form-group">
                    <input type="text" name="form[login]" value="" class="form-control" placeholder="Логин" required>
                </div>
                <div class="form-group">
                    <input type="password" name="form[password]" value="" class="form-control" placeholder="Пароль" required>
                </div>
                
                <input type="submit" value="Вход" class="form-control btn btn-primary">
            </form>
        </div>
    </div>
</div>
-->


<div id="login">
  <div class="login-logo">
    <a href="index.html"><img src="/assets/images/logo.png" alt=""/></a>
  </div>
  <h2 class="form-heading">Вход в админпанель</h2>
  <h4 class="error-message"><?= $error; ?></h4>
  <div class="app-cam">
	  <form action="/cp/login" method="post">
		<div class="form-group">
                    <input type="text" name="form[login]" value="" class="form-control" placeholder="Логин" required>
                </div>
                <div class="form-group">
                    <input type="password" name="form[password]" value="" class="form-control" placeholder="Пароль" required>
                </div>
                <div class="submit"><input type="submit" value="Вход" class="form-control btn btn-warning"></div>		
	</form>
      <a href="#" class="fogot-password" data-toggle="modal" data-target="#forgot">Забыли пароль?</a>
      <div class="modal fade" id="forgot" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Восстановление пароля</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/cp/admin/forgot" class="restore-password">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="femail" type="text" class="form-control" placeholder="Email" required>
                            </div>
                            <button type="submit" class="btn btn-default">Восстановить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  </div>
</div>
<script>
        $('.restore-password').submit(function(){
                var loginData = $(this).serialize();
                var isEmailCorrect = true;
                $.ajax({
                    url: '/cp/admin/forgot',
                    type: 'POST',
                    async: false,
                    data: loginData,
                    success: function(data){
                        if($(data).find(".errmsg").text().length != 0){
                            console.log($(data).find(".errmsg").text());
                            alertify.success($(data).find(".errmsg").text());
                            isEmailCorrect = false;
                        }
                        
                    }
                });
            console.log(isEmailCorrect);
                if(isEmailCorrect == true)
                    return true;
            else 
                return false;
        });
    </script>