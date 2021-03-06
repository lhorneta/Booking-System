<div class="lot_reviews">
	<?php if ($reviews) { ?>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<td>Лот</td>
					<td>Отзыв</td>
					<td>Автор</td>
					<td>Оценка</td>
					<td>Дата</td>
					<td>Действия</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($reviews as $k => $r) {
				$lot = Lot::modelWhere('id = ?', array($r->id_lot));
				$user = UserFront::modelWhere('id = ?', array($r->id_reviewer));
				if ($lot&&$user) {
				?>
				<tr class="rev <?=(!$r->status)?'blocked':''?>" id="<?=$r->id?>">
					<td>
						<div class="img"><img src="<?=($lot->img0)?'/uploads/lot/'.$lot->url.'/'.$lot->img0:'/assets/images/no-img.jpg'?>" alt="<?=$lot->title?>" /></div>
						<div class="name"><a href="/lot/view/<?=$lot->url?>"><?=$lot->title?></a></div>
					</td>
					<td class="revtext">
						<div title="Редактировать" class="review_edit" id="ed_<?=$r->id?>" rel="<?=$r->id?>"><?=$r->text?></div>
					</td>
					<td>
						<div class="img"><img src="<?=($user->avatar)?$user->avatar:'/assets/images/photo.jpg'?>" alt="<?=$user->name?> <?=$user->surname?>" /></div>
						<div class="name"><a href="/page/publicprofile/<?=$user->id?>"><?=$user->name?> <?=$user->surname?></a></div>
					</td>
					<td><?=$r->vote/2?>/5</td>
					<td><?=echoRussianDate($r->time)?></td>
					<td class="action">
						<!-- <button class="btn btn-small btn-primary">Одобрить</button> -->
						<?php if ($r->status) { ?>
						<div class="glyphicon glyphicon-ban-circle block" rel="/cp/reviews/block/<?=$r->id?>" title="Заблокировать"></div>
						<?php } else { ?>
						<div class="glyphicon glyphicon-ok-circle block" rel="/cp/reviews/block/<?=$r->id?>" title="Разблокировать"></div>
						<?php } ?>
						<div class="glyphicon glyphicon-trash delete" rel="/cp/reviews/delete/<?=$r->id?>" title="Удалить"></div>
					</td>
				</tr>
				<?php } } ?>
			</tbody>
			<tfoot>
				
			</tfoot>
		</table>
	</div>
	<?php } ?>
</div>