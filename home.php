<?php
get_header() ?>

<div class="container">

	<div class="row">

		<section id="site-content" class="main" aria-labelledby="page-title-start" role="region">


			<h1 class="page-title"><?php echo is_front_page() ? __('Start', 'wally') : __('Artiklar', 'wally') ?></h1>
			<h2>Senaste artiklarna</h2>

			<?php

				do_action('before-post-loop');

				// Start the loop
				if(have_posts()): while(have_posts()): the_post();

				get_template_part('parts/posts/loop');

				// End the loop
				endwhile; ?>
					<div class="pagination" id="pagination" data-pagination="<?php echo $post->ID ?>">
						<?php the_posts_pagination(array(
							'prev_text'          => __( 'Föregående sida', 'wally' ),
							'next_text'          => __( 'Nästa sida', 'wally' ),
							'screen_reader_text' => __( 'Sidnavigation' ),
						)) ?>
					</div>

				<?php wp_reset_postdata();

				endif;

				do_action('after-post-loop');

			?>

		</section>

		<?php get_sidebar() ?>

	</div>
</div>

<?php get_footer(); ?>