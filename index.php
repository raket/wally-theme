<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <section id="site-content" class="site-content" role="region" aria-labelledby="page-title-articles" data-paginate>

                <h1 id="page-title-articles"><?php _e('Artiklar', 'wally') ?></h1>

                <?php
                    do_action('before-post-loop');
                    if(have_posts()):
                        while(have_posts()): the_post();
                            get_template_part('parts/posts/loop');
                        endwhile;

                        ?>

                        <div class="pagination" id="pagination" data-pagination="<?php echo $post->ID ?>">
                            <?php the_posts_pagination(array(
                                'prev_text'          => __( 'Föregående sida', 'wally' ),
                                'next_text'          => __( 'Nästa sida', 'wally' ),
                                'screen_reader_text' => __( 'Sidnavigation' ),
                            )) ?>
                        </div>

                        <?php
                    endif;
                    do_action('after-post-loop');
                ?>
            </section>
            <?php get_sidebar() ?>
        </div>
    </div>
<?php get_footer(); ?>