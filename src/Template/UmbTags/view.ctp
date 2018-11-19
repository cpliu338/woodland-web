<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UmbTag $umbTag
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Umb Tag'), ['action' => 'edit', $umbTag->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Umb Tag'), ['action' => 'delete', $umbTag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $umbTag->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Umb Tags'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Umb Tag'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Umb Skeletons'), ['controller' => 'UmbSkeletons', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Umb Skeleton'), ['controller' => 'UmbSkeletons', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="umbTags view large-9 medium-8 columns content">
    <h3><?= h($umbTag->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($umbTag->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($umbTag->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($umbTag->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($umbTag->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($umbTag->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Umb Skeletons') ?></h4>
        <?php if (!empty($umbTag->umb_skeletons)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($umbTag->umb_skeletons as $umbSkeletons): ?>
            <tr>
                <td><?= h($umbSkeletons->id) ?></td>
                <td><?= h($umbSkeletons->name) ?></td>
                <td><?= h($umbSkeletons->description) ?></td>
                <td><?= h($umbSkeletons->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UmbSkeletons', 'action' => 'view', $umbSkeletons->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'UmbSkeletons', 'action' => 'edit', $umbSkeletons->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UmbSkeletons', 'action' => 'delete', $umbSkeletons->id], ['confirm' => __('Are you sure you want to delete # {0}?', $umbSkeletons->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
