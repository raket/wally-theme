<?php do_action("wally_before-post-loop-item") ?>
<?php
$display_size = get_post_meta($post->ID, 'thumbnail_size', true);
$sticky = is_sticky($post->ID) ? ' sticky' : '';
?>

	<article <?php post_class('article-box') ?> role="article">

		<?php if(!is_search()): ?>
			<?php get_template_part('parts/media/thumbnail') ?>
		<?php endif ?>

		<div class="article-box__header--below-figure">
			<a href="<?php the_permalink() ?>"<?php echo $sticky ? ' data-mh="stickies"' : '' ?>>
				<h3 id="post-<?php echo $post->ID ?>"><span><?php the_title() ?></span></h3>
			</a>
			<?php //Show Edit in Backend button for logged in Editors and Admins
			if(is_user_logged_in() && current_user_can('edit_posts')):
				$url = esc_url( home_url() ).'/wp-admin/post.php?post='.$post->ID.'&action=edit';
				?>
				<a href="<?php echo $url ?>" class="edit-btn" title="<?php echo $post->post_type === 'post' ? __('Redigera inlägg', 'wally-theme') : __('Redigera sida', 'wally-theme') ?>">
					<span>
						<?php echo $post->post_type === 'post' ? __('Redigera inlägg', 'wally-theme') : __('Redigera sida', 'wally-theme') ?>
					</span>
				</a>
			<?php endif ?>
		</div>

		<div class="article-box__content--excerpt">
			<?php the_excerpt() ?>
		</div>

		<div class="article-box__footer">
			<?php if(get_post_type($post) == 'post'): ?>
				<div class="article-box__footer__col article-box__footer__col--meta">
					<time datetime="<?php echo get_the_date('Y-m-d\TH:i:s') ?>"><?php the_date('j F, Y H:i') ?></time>
				</div>
				<div class="article-box__footer__col article-box__footer__col--meta">
					<?php _e('Författare', 'wally-theme') ?>:
					<?php echo get_the_author_posts_link() ?>
				</div>
				<div class="article-box__footer__col article-box__footer__col--meta article-box__footer__col--meta--comments">
					<a href="<?php the_permalink() ?>#comments"><i class="material-icons" aria-label="<?php _e('Kommentar', 'wally-theme') ?>" aria-hidden="true">insert_comment</i> <?php $comment_count = get_comment_count($post->ID); echo $comment_count['approved'] ?> <?php _e('kommentarer', 'wally-theme') ?></a>				</div>
			<?php endif ?>
		</div>
	</article>
<?php do_action("wally_after-post-loop-item") ?>