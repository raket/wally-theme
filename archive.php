<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <section id="site-content" class="main" role="region" aria-labelledby="page-title-<?php echo $post->ID ?>" data-paginate>
                <?php the_archive_title('<h1 class="page-title" id="page-title-' . $post->ID .'">', '</h1>') ?>
                <h2><?php _e('Artiklar', 'wally') ?></h2>
                <?php
                    do_action('before-post-loop');
                    if(have_posts()): while(have_posts()): the_post();
                            get_template_part('parts/posts/loop');
                    endwhile ?>

                        <div class="pagination">
                            <?php the_posts_pagination(array(
                                'prev_text'          => __( 'Föregående sida', 'wally' ),
                                'next_text'          => __( 'Nästa sida', 'wally' ),
                                'screen_reader_text' => __( 'Sidnavigation' ),
                            )) ?>
                        </div>

                    <?php endif;
                    do_action('after-post-loop');

                ?>
            </section>
            <?php get_sidebar() ?>
        </div>
    </div>
<?php get_footer(); ?>