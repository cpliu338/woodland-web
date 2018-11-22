            <?php foreach ($umbSkeletons as $umbSkeleton): ?>
            <tr>
                <td><?= h($umbSkeleton->name) ?>
<?php /* $umbSkeleton->cnt*/ ?>
                </td>
                <td>
<?php foreach ($umbSkeleton->umb_tags as $tag): ?>
<span class="btn tag-<?=$tag->type?>"><?= $tag->name?></span>
<?php endforeach; ?>
                </td>
                <td>
<?= nl2br($this->Text->truncate($umbSkeleton->description, 50))?>
                </td>
                <td class="actions">
                    <button data-tagid="<?=$umbSkeleton->id?>" class="view btn btn-default glyphicon glyphicon-search"></button>
                    <?=  $this->Html->link('', ['action'=>'edit', $umbSkeleton->id], ['class'=>'view btn btn-danger glyphicon glyphicon-pencil', 'style'=>'margin-left:1em'])?> 
                </td>
            </tr>
            <?php endforeach; ?>
