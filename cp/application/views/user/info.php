<div class="info-about-user">
    <h3>Информация о пользователе</h3>
    <table class="table detail-info">
        <tr>
            <td><strong>Тип пользователя:</strong></td>
            <td><?= ($user->id_role == 2) ? 'обычный' : 'бизнес'; ?></td>
        </tr>
        <tr>
            <td><strong>Имя:</strong></td>
            <td><?= ($user->name) ? $user->name : 'не указано'; ?></td>
        </tr>
        <tr>
            <td><strong>Фамилия:</strong></td>
            <td><?= ($user->surname) ? $user->surname : 'не указана'; ?></td>
        </tr>
        <tr>
            <td><strong>Пол:</strong></td>
            <td><?= ($user->gender) ? $user->gender : 'не выбран'; ?></td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td><?= ($user->email); ?></td>
        </tr>
        <tr>
            <td><strong>Забанен:</strong></td>
            <td><?= ($user->bane == 1) ? 'да' : 'нет'; ?></td>
        </tr>
        <tr>
            <td><strong>Информация о пользователе:</strong></td>
            <td><?= ($user->description) ? $user->description : 'нет'; ?></td>
        </tr>
        <tr>
            <td><strong>Количество жалоб:</strong></td>
            <td><?= ($user->appeal) ? $user->appeal : 'Нет жалоб'; ?></td>
        </tr>
        <tr>
            <td><strong>Рейтинг пользователя:</strong></td>
            <td><?= ($user->mark > 0) ? $user->mark : 'Нет рейтинга'; ?></td>
        </tr>
        <tr>
            <td><strong>Дата регистрации:</strong></td>
            <td><?= date('Y/m/d', $user->register_time); ?></td>
        </tr>
    </table>

    <?php if(count($user->lots)){ ?>
    <h3>Все лоты данного пользователя</h3>
    <?php foreach($user->lots as $lot){ ?>
    <table class="table detail-info">
        <tr>
            <td><strong>Название лота:</strong></td>
            <td class="title-lot"><?= $lot->title; ?></td>
        </tr>
        <tr>
            <td><strong>Описание лота:</strong></td>
            <td><p><?= $lot->description ? $lot->description : 'не указано'; ?></p></td>
        </tr>
        <tr>
            <td><strong>Депозит:</strong></td>
            <td><?= $lot->deposit ? $lot->deposit : 'не указан'; ?></td>
        </tr>
        <tr>
            <td><strong>Цена аренды на день:</strong></td>
            <td><?= $lot->day_payment; ?></td>
        </tr>
        <tr>
            <td><strong>Цена аренды на неделю:</strong></td>
            <td><?= $lot->week_payment ? $lot->week_payment : 'не указана'; ?></td>
        </tr>
        <tr>
            <td><strong>Цена аренды на месяц:</strong></td>
            <td><?= $lot->month_payment ? $lot->month_payment : 'не указана'; ?></td>
        </tr>
        <tr>
            <td><strong>Рейтинг лота:</strong></td>
            <td><?= $lot->mark > 0 ? $lot->mark : 'нет рейтинга'; ?></td>
        </tr>
        <tr>
            <td><strong>Условия проката:</strong></td>
            <td><?= $lot->rental_terms ? $lot->rental_terms : 'отсутствуют'; ?></td>
        </tr>
    </table>
    <?php
    }
    }

    if(count($user->reviewsToUser)){
    ?>
    <h3>Все отзывы на данного пользователя</h3>
    <?php foreach($user->reviewsToUser as $review){ ?>
    <table class="table detail-info reviews-of-user">
        <thead>
            <tr>
                <th class="date"><strong>Дата отзыва</strong></th>
                <th><strong>Текс отзыва</strong></th>
                <th class="delete">
                    <a href="javascript: void(0)" class="del-rev" title="Удалить отзыв" data-id="1"><i class="fa fa-trash-o"></i></a>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="date"><?= date('Y/m/d H:i:s', $review->time); ?></td>
                <td>
                    <p><?= $review->text; ?></p>
                    <?= $review->id_lot ? "Отзыв на лот: ".Lot::outputTitle($review->id_lot) : "Отзыв от пользователя: ".UserFront::outputEmail($review->id_reviewer); ?>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table> 
    <?php
    }
    }

    if(count($user->reviews)){
    ?>
    <h3>Все отзывы от данного пользователя</h3>
    <?php foreach($user->reviews as $rev){ ?>
    <table class="table detail-info reviews-of-user">
        <thead>
            <tr>
                <th class="date"><strong>Дата отзыва</strong></th>
                <th><strong>Текс отзыва</strong></th>
                <th class="delete">
                    <a href="javascript: void(0)" class="del-rev" title="Удалить отзыв" data-id="1"><i class="fa fa-trash-o"></i></a>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="date"><?= date('Y/m/d H:i:s', $rev->time); ?></td>
                <td>
                    <p><?= $rev->text; ?></p>
                    <?= $rev->id_lot ? "Отзыв на лот: ".Lot::outputTitle($rev->id_lot) : "Отзыв на пользователя: ".UserFront::outputEmail($rev->id_user); ?>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <?php
    }
    }
    ?>

    <div class="modal-del-holder delete-review">
        <div class="modal-del">
            <button type="button" class="closer">×</button>
            <div class="question">
                <p><i class="fa fa-trash-o"></i> Удалить данный отзыв насовсем?</p>
                <a href="#" class="ok">ОК</a>
                <a href="#" onclick="return false" class="cancel">ОТМЕНА</a>
            </div>
        </div>
        <div class="overlay"></div>
    </div>
</div>
<script>
    //Extract info from data-id attributes into attributes 'href'
    $('.del-rev').click( function () {
        var id = $(this).data('id');
        var modal = $('.delete-review');
        modal.find('a.ok').attr('href', '/cp/.../delete/' + id);
    });
</script>
