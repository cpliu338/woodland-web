<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Log[]|\Cake\Collection\CollectionInterface $logs
 */
 $this->start('css');
?>
<style>
button, #submit {
	padding: 1em; margin: 1em;
}
#incurred, #meal {
	font-size: x-large;
}
</style>
<?php
	$this->end();
	echo $this->Form->create($log, ['type'=>'get', 'id'=>'change-date']);
?>
<div class="row">
	<div class='col-sm-3 col-xs-3 col-md-2'>
		<?= $this->Form->input('incurred', ['value'=>$log->incurred->format('Y-m-d'),
			'type'=>'text']) ?>
	</div>
	<div class='col-sm-3 col-xs-3 col-md-2'>
		<?= $this->Form->input('meal', ['type'=>'select', 'options'=>$meals]) ?>
	</div>
	<!--
	<div class='col-sm-3 col-xs-3 col-md-2'>
		<?= $this->Form->submit('Change') ?>
	</div>
	-->
</div>
<?php
		echo $this->Form->end();
	echo $this->Form->create($log);
?>
<div class="row">
<?php
	foreach ($people as $person) {
		echo $this->Form->button($person->name . ' : ' . $person->score, 
			['class'=>'col-sm-4 col-xs-4 col-md-3',
			'data-pid'=>$person->id,
			'type'=>'button']),
		$this->Form->input("id_{$person->id}", ['type'=>'hidden', 'value'=>$person->score]);
	}
?>
<?php
	echo $this->Form->submit('Submit', ['class'=>'col-sm-4 col-xs-4 col-md-3 btn-primary', 'id'=>'submit']);
?>
</div>
<?= $this->Form->end() ?>
    <table class="table">
        <tbody>
        <?php $date1 = ''; ?>
            <?php foreach ($logs as $log): ?>
            <?php if ($log->incurred->i18nFormat('yyyy-MM-dd HH') != $date1): ?>
				<?php $date1 = $log->incurred->i18nFormat('yyyy-MM-dd HH'); ?>
            	<?php if (!array_key_exists($date1, $count) || $count[$date1]==1) break; ?>
			<tr>
                <th style="vertical-align: middle" rowspan="<?= $count[$date1] ?>">
                	<?= $log->incurred->i18nFormat('MM-dd') ?><br>
                	<?= $log->incurred->i18nFormat('HH') ?><br>
                	<?= $log->incurred->i18nFormat('EEE') ?>
				</th>
			<?php endif;?>
                <td><?= $log->has('person') ? $this->Html->link($log->person->name, ['controller' => 'Persons', 'action' => 'view', $log->person->id]) : '' ?></td>
                <td><?= $this->Number->format($log->score) ?>
                ->
                <?= $this->Number->format($log->accum) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<script>

var btn_classes = ['btn-default','btn-success'];

function updateBtnClass(btn) {
	var value = $('#id-' + btn.data('pid')).val();
	btn.removeClass (function (index, className) {
		cl = (className.match(/(^|\s)btn-\S+/) || []).join(' ');
		//console.log("Classes to remove: "+cl);
		return cl;
	});
	if (value == 0 || value == 1) {
		cl = btn_classes[value];
		//console.log("Class to add: "+cl);
		btn.addClass(cl);
	}
	else {
		//console.log("Class to add: btn-warning");
		btn.addClass('btn-warning');
	}
}

// change submit button disable status
function updateSubmit() {
	var nEat = 0;
	var nWash = 0;
	$("input[name^='id_']").each(function (i, btn) {
		v = parseInt($(btn).val());
		if (v < 0)
			nWash ++;
		else if (v==1)
			nEat++;
	});
	if (nWash == 1 && nEat > 0) {
		$("#submit").show();
	}
	else
		$("#submit").hide();
}

// Find the pid of the washing guy
function findWash() {
	var pid = 0;
	$("input[name^='id_']").each(function (i, btn) {
		if (parseInt($(btn).val()) < 0) 
			pid = parseInt($(btn).attr('name').substr(3));
	});
	console.log("Washing guy "+pid);
	return pid;
}

// On load function
$(function() {
	/* update all button classes */
	$("button").each(function (i, btn) {
		updateBtnClass($(btn));
	});
	updateSubmit();
	$("#incurred").datepicker({ dateFormat: "yy-mm-dd",
		onClose: function() { $("#change-date").submit() 
	}});
	$("#meal").change(function() {
		$("#change-date").submit();
	});
	$("button").click(function (event) {
<?php
		/* each button has data-pid = person_id 
		input_v hidden field related to this button
		old_v current value of input_v
		new_v value to be set to input_v
		*/
?>
		var input_v = $('#id-' + $(this).data('pid'));
		var new_v;
		var old_v = input_v.val();
		if (old_v == 0) {
			new_v = 1;
		}
		else if (old_v < 0)
			new_v = 0;
		else { // old_v==1
			new_v = (0 == findWash()) ? -1 : 0;
		}
		input_v.val(new_v);
		/* update all button classes */
		$("button").each(function (i, btn) {
			updateBtnClass($(btn));
		});
		updateSubmit();
		var name = $(this).html().substr(0, $(this).html().indexOf(':'));
		$(this).html(name + " :"+ (new_v < 0 ? 'W' : new_v));
	});
});
</script>