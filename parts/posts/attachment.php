<?php do_action("wally_before-post-loop-item"); if(isset($post)): ?>

	<article <?php post_class('article-box'); ?> aria-labelledby="page-title-<?php echo $post->ID ?>">

		<a name="artikel" class="anchor"></a>
		<?php  get_template_part('parts/media/thumbnail'); ?>

		<header class="article-box__header below-figure">
			<h1 id="page-title-<?php echo $post->ID ?>"><?php the_title(); ?></h1>
			<time datetime="<?php echo get_the_date('Y-m-d\TH:i:s'); ?>"><?php the_date('j F, Y H:i') ?></time>
			<?php //Show Edit in Backend button for logged in Editors and Admins
			if(is_user_logged_in() && current_user_can('edit_posts')):
				$url = get_bloginfo('url').'/wp-admin/post.php?post='.$post->ID.'&action=edit';
				?>
				<a href="<?= $url; ?>" class="edit-btn">
					<span>
						<?php echo __('Redigera media', 'wally') ?>
					</span>
				</a>
			<?php endif; ?>
		</header>

		<div class="article-box__content" style="padding-left: 0; padding-right: 0">
			<?php echo wp_get_attachment_image($post->ID, 'original') ?>
			<?php the_content() ?>
		</div>
		<div class="article-box__tags">
			<a name="taggar" class="anchor"></a>
			<?php get_template_part('parts/meta/tags'); ?>
		</div>
		<footer class="article-box__footer">
			<div class="article-box__footer__col article-box__footer__col--meta">
				<time datetime="<?php echo get_the_date('Y-m-d\TH:i:s'); ?>"><?php echo get_the_date('j F, Y H:i') ?></time>
			</div>
			<div class="article-box__footer__col article-box__footer__col--meta">
				<?php _e('Uppladdad av', 'wally') ?>:
				<?php echo get_the_author_posts_link(); ?>
			</div>
		</footer>
	</article>
	<?php do_action("wally_after-post-loop-item"); endif ?>