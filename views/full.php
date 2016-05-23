<?php
/**
* Template Name: Fullbredd
* @package WordPress
* @subpackage wally
* @since Twenty Fourteen 1.0
*/
?>
<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>

	<div class="container">
		<div class="row">
			<section id="site-content" class="site-content" role="region" aria-labelledby="page-title-<?php echo $post->ID ?>">
				<div <?php post_class('article-box') ?> id="post-<?php the_ID(); ?>">
					<header class="article-box__header">
						<?php do_action('page-before-title'); ?>
						<h1 class="page-title" id="page-title-<?php echo $post->ID ?>"><?php the_title(); ?></h1>
						<?php do_action('page-after-title'); ?>
					</header>
					<?php  get_template_part('parts/media/thumbnail'); ?>
					<div class="article-box__content">
						<?php
						do_action('page-before-content');
						the_content();
						do_action('page-after-content');
						?>
					</div>
				</div>
			</section>
		</div>
	</div>

<?php endwhile ?>
<?php get_footer(); ?>