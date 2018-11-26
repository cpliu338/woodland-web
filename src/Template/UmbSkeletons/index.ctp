<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UmbSkeleton[]|\Cake\Collection\CollectionInterface $umbSkeletons
 */
?>
<div class="umbSkeletons index large-9 medium-8 columns content">
    <h3 class="glyphicon glyphicon-home"><?= __('Skeletons') ?></h3>
    <div id="tags"><?= $this->element('tag_buttons', ['ids'=>$ids]) ?>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"><?= __('name') ?></th>
                <th scope="col"><?= __('tags') ?></th>
                <th scope="col"><?= __('description') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody id="results">
        	<?= $this->element('skeletons', ['skeletons'=>$umbSkeletons,'selected_tag_ids'=>$ids])?>
        </tbody>
<?php if ($total_count > count($umbSkeletons)): ?>
        <tfoot>               
        <tr><td>And <?= $total_count-count($umbSkeletons)?> more</td><td></td></tr>
        </tfoot>
<?php endif;?>
    </table>
</div>
<div id="add-form">
    <?= $this->Form->create($umbSkeleton, ['url'=>'/umb-skeletons/add']) ?>
    <fieldset>
        <legend><?= __('Add Umb Skeleton') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>  
</div>
<div id="dlg-view">
	<textarea id="dlg-text" rows="10" cols="20"></textarea>
	<br>
</div>
<button id="add" class="btn btn-success glyphicon glyphicon-plus" style="margin-right: 4em"></button>
<?php
	$v = "<i class='glyphicon glyphicon-tags btn btn-warning'></i>";
	echo $this->Html->link($v, ['controller' => 'UmbTags', 'action' => 'index'], ['escape'=>false]) 
?>
<form id="login-form" method="POST" action="/umb-skeletons/login" >
Secret: <input name="website"><input type="submit" id="login" class="btn btn-danger" value="login" />
</form>
<script>
$(function() {
	$("#dlg-view").dialog({
		modal:true, 
		autoOpen:false,
		buttons: [{
			text: "OK",
			click: function() { $(this).dialog("close");},
			icons: {primary: "ui-icon-locked"}
		}]
	});
	$("#add-form").dialog({
		modal:true, 
		autoOpen:false,
		buttons: [{
			text: "Cancel",
			click: function() { $(this).dialog("close");},
			icons: {primary: "ui-icon-locked"}
		}]                       
	});
	$(document).on("click", ".view", function() {
		$.ajax({
			url: "/umb-skeletons/view/"+$(this).data("tagid"),
			headers: {Accept: "application/json"},
			type: "GET"
		}).done(function(data) {
			$("#dlg-text").html(data.umbSkeleton.description);
			$("#dlg-view").dialog({title: data.umbSkeleton.name});
			$("#dlg-view").dialog("open");
		});
	});                              
	$("#add").click(function() {
		$("#add-form").dialog("open");
	});
	$(".filter").click(function() {
		var checked = $(this).data("checked");
		var opacity = checked ? 0.5 : 1.0; 
		$(this).css("opacity", opacity);
		$(this).data("checked", !checked);
		var ar = [];
		$("button.btn").each(function () {
			if ($(this).data("checked")) ar.push($(this).data("tagid"));
		});
		$.ajax({
			data: {ids:ar},
			url: "/umb-skeletons/filter",                                              
			type: "POST"
		}).done(function(data) {
			$("#results").empty();
			$("#results").append(data);
		});
	});
});
</script>