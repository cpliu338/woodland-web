<div class='form-group'>
<?php foreach ($tags as $tag):?>
<?php 
	$opac = in_array($tag->id, $ids) ? 1.0 : 0.5;
	$checked = in_array($tag->id, $ids) ? "true" : 'false';
?>
<button title="type <?=$tag->type?>" data-checked="<?=$checked?>" data-tagid="<?=$tag->id?>" style="opacity: <?=$opac?>" class="filter btn tag-<?=$tag->type?>"><?=$tag->name?></button>
<?php endforeach; ?>    
</div>