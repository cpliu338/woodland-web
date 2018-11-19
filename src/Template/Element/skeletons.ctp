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
                <td class="actions">
                    <button data-tagid="<?=$umbSkeleton->id?>" class="view btn btn-default glyphicon glyphicon-search"></button>
                </td>
            </tr>
            <?php endforeach; ?>
