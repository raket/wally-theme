<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <section id="site-content" class="site-content" role="region" aria-labelledby="page-title-<?php echo $post->ID ?>">
                <?php
                do_action('before-post-loop');
                if(have_posts()):
                    while(have_posts()): the_post();
                        get_template_part('parts/posts/single');
                    endwhile;
                endif;
                do_action('after-post-loop');
                comments_template();
                ?>
            </section>
            <?php get_sidebar() ?>
        </div>

        <?php

        $categories = wp_get_post_categories($post->ID);
        $tags = wp_get_post_tags($post->ID);
        $args =
            array(
                'tax_query' => array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'category',
                        'field'    => 'id',
                        'terms'    => $categories,
                    ),
                    array(
                        'taxonomy' => 'tag',
                        'field'    => 'id',
                        'terms'    => $tags,
                    ),
                ),
                'posts_per_page' => 2,
                'post__not_in' => array($post->ID)
            );
        $related = new WP_Query( $args );

        if($related->have_posts()): ?>

            <div class="row">
                <div class="related-posts">
                    <h2 class="related-posts__title"><?php _e('Relaterade artiklar', 'wally') ?></h2>
                    <?php
                    do_action('before-related-loop');
                    while($related->have_posts()): $related->the_post();

                        $relation = false;
                        if(array_intersect($categories, wp_get_post_categories($post->ID))) {
                            $relation = 'category';
                        } else if(array_intersect($tags, wp_get_post_tags($post->ID))) {
                            $relation = 'tag';
                        }
                        include(locate_template(('parts/posts/related.php')));
                    endwhile; wp_reset_postdata();
                    do_action('after-related-loop');
                    ?>
                </div>
            </div>

        <?php endif ?>

    </div>
<?php get_footer(); ?>