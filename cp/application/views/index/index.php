<div class="graphs">
    <div class="col_3">
        <h3>Статистика</h3>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <a href="/cp/user">
                    <i class="pull-left fa fa-user user1 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong><?= UserFront::countRow(); ?></strong></h5>
                        <span>Пользователей всего</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <a href="/cp/lot">
                    <i class="pull-left fa fa-file-text-o icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>1000</strong></h5>
                        <span>Объявлений на сайте</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <a href="/cp/admin">
                    <i class="pull-left fa fa-laptop dollar1 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong><?= User::countRow(); ?></strong></h5>
                        <span>Администраторов</span>
                    </div>
                </a>
            </div>
        </div> 
        <div class="clearfix"></div>
        <br>
    </div>
</div>

<script>
    $('.btn').click(function () {
        $.ajax({
            url: '/cp/index/rewritepackageprices',
            type: 'GET',
            success: function (data) {
                $.ajax({
                    url: '/cp/index',
                    type: 'GET',
                    success: function (data) {
                        $('.btn').text($(data).find('.btn').text())
                    }
                });
            }
        });
    });
</script>    
