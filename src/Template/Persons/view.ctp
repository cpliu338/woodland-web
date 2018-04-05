<table class="table">
<thead><tr>
    <th>Record for <?= h($person->name) ?></th>
    <td><?= $this->Html->link('Home', ['controller'=>'Logs', 'action'=>'index'],
    	['class'=>'btn btn-primary'])?></td>
</tr></thead>
<?php foreach ($logs as $log): ?>
<tr>
	<td><?= $log->incurred->i18nFormat('MM-dd hh a')?></td>
	<td><?= $log->accum - $log->score ?> +
	<?= $log->score ?> -> <?= $log->accum ?></td>
</tr>
<?php endforeach; ?>
</table>
