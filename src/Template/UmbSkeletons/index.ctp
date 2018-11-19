<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UmbSkeleton[]|\Cake\Collection\CollectionInterface $umbSkeletons
 */
$this->start('css');
// see https://clrs.cc/ for colors below
?>
<style>
.tag-1, .tag-1:hover {
    background: #001f3f;
    color: hsla(210, 100%, 75%, 1.0);
}
.tag-2, .tag-2:hover {
    background: #0074d9;
    color: hsla(210, 100%, 85%, 1.0);
}
.tag-3, .tag-3:hover {
    background: #7fdbff;
    color: hsla(197, 100%, 20%, 1.0);
}
.tag-4, .tag-4:hover {
    background: #39cccc;
}
</style>
<?php
$this->end();
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Umb Tags'), ['controller' => 'UmbTags', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="umbSkeletons index large-9 medium-8 columns content">
    <h3><?= __('Umb Skeletons') ?></h3>
    <div id="tags">
<?php foreach ($tags as $tag):?>
<?php 
	$opac = in_array($tag->id, $ids) ? 1.0 : 0.5;
	$checked = in_array($tag->id, $ids) ? "true" : 'false';
?>
<button data-checked="<?=$checked?>" data-tagid="<?=$tag->id?>" style="opacity: <?=$opac?>" class="filter btn tag-<?=$tag->type?>"><?=$tag->name?></button>
<?php endforeach; ?>    
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"><?= __('name') ?></th>
                <th scope="col"><?= __('tags') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody id="results">
        	<?= $this->element('skeletons')?>
        </tbody>
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
<div id="debug"></div>
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
	var data = {ids:[1,3],val:"abc"};
	$.ajax({
		data: data,
		url: "/umb-skeletons/filter",
		type: "POST"
	});
});
</script>