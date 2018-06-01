<?php get_header() ?>
<div class="container">
    <div class="row">
        <section class="site-content" id="search-results" role="region" aria-labelledby="page-title-search-results">
            <h1 id="page-title-search-results">Söker efter "<?php echo $s ?>":</h1>

			<?php global $wp_query ?>
            <p>
				<?php
				if ( $wp_query->found_posts > 0 ) {
					printf( __( 'Hittade %s sökresultat.', 'wally-theme' ), $wp_query->found_posts );
					if ( $wp_query->max_num_pages > 1 ) {
						echo ' ';
						printf( __( 'Sökresultaten är uppdelade i  %s sidor.', 'wally-theme' ), $wp_query->max_num_pages );
					}
				} else {
					printf( __( 'Hittade inga sökresultat', 'wally-theme' ) );
				}
				?>
            </p>
			<?php if ( $wp_query->found_posts > 0 ): ?>
                <h2 class="subtitle">Sökresultat:</h2>
			<?php endif ?>

            <div class="pagination no-margin">
				<?php
				global $wp_query;

				$big        = 999999999;
				$translated = __( 'Sida', 'wally-theme' );

				echo paginate_links( array(
					'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'             => '?paged=%#%',
					'current'            => max( 1, get_query_var( 'paged' ) ),
					'total'              => $wp_query->max_num_pages,
					'prev_text'          => __( '« Föregående sida' ),
					'next_text'          => __( 'Nästa sida »' ),
					'before_page_number' => '<span class="screen-reader-text">' . $translated . ' </span>'
				) );
				?>
            </div>

			<?php do_action( "wally_before_post_loop" );
			if ( have_posts() ):
				while ( have_posts() ): the_post();
					get_template_part( 'parts/posts/loop' );
				endwhile;
			endif;
			do_action( "wally_after_post_loop" ) ?>

            <div class="pagination no-margin">
				<?php the_posts_pagination( array( 'type' => 'list' ) ) ?>
            </div>

            <div class="row">
                <div class="search-form search-form--boxed">
                    <h2>Sök på nytt:</h2>
					<?php get_search_form() ?>
                </div>
            </div>

        </section>
    </div>
</div>
<?php get_footer() ?>
