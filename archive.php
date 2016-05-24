<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <?php
            $sidebar_location = fw_get_db_customizer_option('sidebar_setting');
            if($sidebar_location === 'left') {get_sidebar();}
            ?>
            <section id="site-content" class="site-content" role="region" aria-labelledby="page-title-<?php echo $post->ID ?>" data-paginate>
                <?php the_archive_title('<h1 class="page-title" id="page-title-' . $post->ID .'">', '</h1>') ?>
                <h2><?php _e('Artiklar', 'wally') ?></h2>
                <?php
                    do_action("wally_before_post_loop");
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
                    do_action("wally_after_post_loop");

                ?>
            </section>
            <?php if($sidebar_location === 'right') {get_sidebar();} ?>

        </div>
    </div>
<?php get_footer(); ?>