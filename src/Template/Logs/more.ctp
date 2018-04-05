<?php $date1 = ''; ?>
	<?php foreach ($logs as $log): ?>
	<?php if ($log->incurred->i18nFormat('yyyy-MM-dd HH') != $date1): ?>
		<?php $date1 = $log->incurred->i18nFormat('yyyy-MM-dd HH'); ?>
		<?php if (!array_key_exists($date1, $count) || $count[$date1]==1) break; ?>
	<tr>
		<th style="vertical-align: middle" rowspan="<?= $count[$date1] ?>">
			<?= $log->incurred->i18nFormat('MM-dd') ?><br>
			<?= $log->incurred->i18nFormat('h a') ?><br>
			<?= $log->incurred->i18nFormat('EEE') ?>
			<?php $earlier = $log->incurred->i18nFormat('yyyy-MM-dd');
			$meal = $log->incurred->i18nFormat('HH') ?>
		</th>
	<?php endif;?>
		<td><?= $log->has('person') ? $this->Html->link($log->person->name, ['controller' => 'Persons', 'action' => 'view', $log->person->id]) : '' ?></td>
		<td>
                <?= $this->Number->format($log->accum - $log->score) ?>
<?php if ($this->Number->format($log->score)>0): ?>                
                + <?= $this->Number->format($log->score) ?> -> <?= $this->Number->format($log->accum) ?>
<?php elseif ($this->Number->format($log->score)<0): ?>
                - <?= $this->Number->format(0 - $log->score) ?> -> <?= $this->Number->format($log->accum) ?>
<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; ?>
###{"earlier":"<?= $earlier?>", "meal":"<?= $meal?>"}