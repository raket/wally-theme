<?php get_header() ?>
<div class="container">
    <div class="row">
        <section class="site-content" id="search-results" role="region" aria-labelledby="page-title-search-results">
            <h1 id="page-title-search-results">Söker efter "<?php echo $s ?>":</h1>

            <?php global $wp_query ?>
            <p>
                <?php
                if($wp_query->found_posts > 0) {
                    printf(__('Hittade %s sökresultat.', 'wally'), $wp_query->found_posts);
                    if ($wp_query->max_num_pages > 1) {
                        echo ' ';
                        printf(__('Sökresultaten är uppdelade i  %s sidor.', 'wally'), $wp_query->max_num_pages);
                    }
                } else {
                    printf(__('Hittade inga sökresultat', 'wally'));
                }
                ?>
            </p>
            <?php if($wp_query->found_posts > 0): ?>
            <h2 class="subtitle">Sökresultat:</h2>
            <?php endif ?>

            <div class="pagination no-margin">
                <?php the_posts_pagination(array('type' => 'list')) ?>
            </div>

            <?php do_action("wally_before_post_loop");
            if(have_posts()):
                while(have_posts()): the_post();
                    get_template_part('parts/posts/loop');
                endwhile;
            endif;
            do_action("wally_after_post_loop") ?>

            <div class="pagination no-margin">
                <?php the_posts_pagination(array('type' => 'list')) ?>
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
