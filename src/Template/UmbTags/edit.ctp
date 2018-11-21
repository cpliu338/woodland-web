<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UmbTag $umbTag
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $umbTag->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $umbTag->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Umb Tags'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Umb Skeletons'), ['controller' => 'UmbSkeletons', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Umb Skeleton'), ['controller' => 'UmbSkeletons', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="umbTags form large-9 medium-8 columns content">
    <?= $this->Form->create($umbTag) ?>
    <fieldset>
        <legend><?= __('Edit Umb Tag') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('type', ['type'=>'select', 'options'=>$tags]);
        ?>
    <div id="hint" class="btn tag-<?=$umbTag->type?>"><?=$umbTag->name?></div>
    </fieldset>
    <?= $this->Form->button('', ['class'=>'glyphicon glyphicon-check btn btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
$(function() {
	$("input[name=name]").keyup(function() {
		$("#hint").text($(this).val());
	});
	$("select[name=type]").change(function() {
		$("#hint").attr('class', "btn tag-"+$(this).val());
	})
	
});
</script>