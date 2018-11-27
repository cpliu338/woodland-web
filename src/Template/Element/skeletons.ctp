<?php //array_intersect(
$perfect_match = true;
?>
<?php foreach ($skeletons as $skeleton): ?>
<?php 
	$buttons = ''; $tags = [];
	foreach ($skeleton->umb_tags as $tag) {
		$buttons = $buttons . '<span class="btn tag-' . $tag->type . '">' . $tag->name . '</span>';
		$tags[] = $tag->id;
	}
	if ($perfect_match) $perfect_match = count(array_intersect($tags, $selected_tag_ids)) == count($selected_tag_ids);
?>

            <tr>
                <td class="<?=$perfect_match?'perfect':'imperfect'?>-match">
                <?= h($skeleton->name) ?>
                </td>
                <td><?= $buttons?>
                </td>
                <td class="<?=$perfect_match?'perfect':'imperfect'?>-match">
<?= nl2br($this->Text->truncate($skeleton->description, 50))?>
                </td>
                <td class="actions">
                    <button data-tagid="<?=$skeleton->id?>" class="view btn btn-default glyphicon glyphicon-search"></button>
<?php 
	//if ($loggedIn)
		echo $this->Html->link('', ['action'=>'edit', $skeleton->id], 
			['class'=>'view btn btn-danger glyphicon glyphicon-pencil', 'style'=>'margin-left:1em']);
?>
                </td>
            </tr>
            <?php endforeach; ?>
