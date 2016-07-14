<?php do_action("wally_before-post-related-item") ?>
	<a <?php post_class('related-posts__post') ?> href="<?php the_permalink() ?>" data-match="height">

		<article role="article">
			<?php if(has_post_thumbnail()): ?>
				<div class="related-posts__post-image">
					<?php get_template_part('parts/media/thumbnail') ?>
				</div>
			<?php endif ?>
			<div class="related-posts__post-header" data-mh="related">
				<h3 class="related-posts__post-title" id="post-<?php echo $post->ID ?>"><span><?php the_title() ?></span></h3>
				<p class="related-posts__post-meta">Publicerad <time><?php echo get_the_date($post->id) ?></time></p>
			</div>
			<div class="related-posts__post-footer">
				<i class="material-icons" aria-label="<?php _e('Information', 'wally-theme') ?>" aria-hidden="true">info_outline</i>

				<?php if($relation == 'category'): ?>
					<?php _e('Den här artikeln är skriven i samma kategori.', 'wally-theme') ?>
				<?php elseif($relation == 'tag'): ?>
					<?php _e('Den här artikeln innehåller liknande taggar.', 'wally-theme') ?>
				<?php endif ?>

			</div>
		</article>

	</a>
<?php do_action("wally_after-post-related-item") ?>