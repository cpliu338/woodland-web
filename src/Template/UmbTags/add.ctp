<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UmbTag $umbTag
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Umb Tags'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Umb Skeletons'), ['controller' => 'UmbSkeletons', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Umb Skeleton'), ['controller' => 'UmbSkeletons', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="umbTags form large-9 medium-8 columns content">
    <?= $this->Form->create($umbTag) ?>
    <fieldset>
        <legend><?= __('Add Umb Tag') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('type');
            echo $this->Form->control('umb_skeletons._ids', ['options' => $umbSkeletons]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
