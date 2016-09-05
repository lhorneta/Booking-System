<div class="col-md-12 inbox_right">
    <div class="Compose-Message">               
        <div class="panel panel-default">
            <div class="panel-heading">
                Новая рассылка
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    Это сообщение будет разослано всем пользователям, подписанным на рассылки
                </div>
                <form method="POST" action="/cp/admin/subscribers">
                    <hr>
                        <label>Введите тему :  </label>
                        <input name="form[title]" type="text" class="form-control1 control3">
                        <label>Введите сообщение : </label>
                        <textarea name="form[message]" class="form-control" placeholder="Текст рассылки"></textarea>
                    <hr>
                    <input type="submit" value="Разослать">
                </form>
             </div>
         </div>
    </div>
</div>
