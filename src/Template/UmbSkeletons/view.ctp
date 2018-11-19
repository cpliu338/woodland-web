<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UmbSkeleton $umbSkeleton
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Umb Skeleton'), ['action' => 'edit', $umbSkeleton->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Umb Skeleton'), ['action' => 'delete', $umbSkeleton->id], ['confirm' => __('Are you sure you want to delete # {0}?', $umbSkeleton->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Umb Skeletons'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Umb Skeleton'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Umb Tags'), ['controller' => 'UmbTags', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Umb Tag'), ['controller' => 'UmbTags', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="umbSkeletons view large-9 medium-8 columns content">
    <h3><?= h($umbSkeleton->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($umbSkeleton->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($umbSkeleton->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($umbSkeleton->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($umbSkeleton->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Umb Tags') ?></h4>
        <?php if (!empty($umbSkeleton->umb_tags)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($umbSkeleton->umb_tags as $umbTags): ?>
            <tr>
                <td><?= h($umbTags->id) ?></td>
                <td><?= h($umbTags->name) ?></td>
                <td><?= h($umbTags->description) ?></td>
                <td><?= h($umbTags->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UmbTags', 'action' => 'view', $umbTags->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'UmbTags', 'action' => 'edit', $umbTags->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UmbTags', 'action' => 'delete', $umbTags->id], ['confirm' => __('Are you sure you want to delete # {0}?', $umbTags->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
