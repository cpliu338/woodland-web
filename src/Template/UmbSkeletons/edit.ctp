<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UmbSkeleton $umbSkeleton
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $umbSkeleton->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $umbSkeleton->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Umb Skeletons'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Umb Tags'), ['controller' => 'UmbTags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Umb Tag'), ['controller' => 'UmbTags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="umbSkeletons form large-9 medium-8 columns content">
    <?= $this->Form->create($umbSkeleton) ?>
    <fieldset>
        <legend><?= __('Edit Umb Skeleton') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('umb_tags._ids', ['options' => $umbTags]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
