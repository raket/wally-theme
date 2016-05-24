<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <section id="site-content" class="site-content" role="region" aria-labelledby="page-title-<?php echo $post->ID ?>">
                <?php
                do_action("wally_before_post_loop");
                if(have_posts()):
                    while(have_posts()): the_post();
                        get_template_part('parts/posts/attachment');
                    endwhile;
                endif;
                do_action("wally_after_post_loop");
                ?>
            </section>
        </div>

    </div>
<?php get_footer(); ?>