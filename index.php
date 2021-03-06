<?php get_header() ?>
    <div class="container">
        <div class="row">
            <?php
            $sidebar_location = fw_get_db_customizer_option('sidebar_setting');
            if($sidebar_location === 'left') {get_sidebar();}
            ?>
            <section id="site-content" class="site-content" role="region" aria-labelledby="page-title-articles" data-paginate>

                <h1 id="page-title-articles"><?php _e('Artiklar', 'wally-theme') ?></h1>

                <?php
                    do_action("wally_before_post_loop");
                    if(have_posts()):
                        while(have_posts()): the_post();
                            get_template_part('parts/posts/loop');
                        endwhile;

                        ?>

                        <div class="pagination" id="pagination" data-pagination="<?php echo $post->ID ?>">
                            <?php the_posts_pagination(array(
                                'prev_text'          => __( 'Föregående sida', 'wally-theme'),
                                'next_text'          => __( 'Nästa sida', 'wally-theme'),
                                'screen_reader_text' => __( 'Sidnavigation' ),
                            )) ?>
                        </div>

                        <?php
                    endif;
                    do_action("wally_after_post_loop");
                ?>
            </section>
            <?php if($sidebar_location === 'right') {get_sidebar();} ?>
        </div>
    </div>
<?php get_footer() ?>