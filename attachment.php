<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <section id="site-content" class="main" role="region" aria-labelledby="page-title-<?php echo $post->ID ?>">
                <?php
                do_action('before-post-loop');
                if(have_posts()):
                    while(have_posts()): the_post();
                        get_template_part('parts/posts/attachment');
                    endwhile;
                endif;
                do_action('after-post-loop');
                ?>
            </section>
        </div>

    </div>
<?php get_footer(); ?>