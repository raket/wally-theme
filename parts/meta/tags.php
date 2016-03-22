<?php
$tags = get_the_tags();
if(!empty($tags)):
	?>
	<h2><?php  _e('Innehållet är taggat med', 'wally') ?>:</h2>
	<ul class="pills">
		<?php foreach($tags as $tag): ?>
			<li class="pills__item"><a href="<?php echo get_tag_link($tag); ?>" class="pills__link"><span><?php echo $tag->name; ?></span></a></li>
		<?php endforeach; ?>
	</ul>
<?php endif ?>