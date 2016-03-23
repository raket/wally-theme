<?php get_header(); ?>
<div class="container">
    <div class="row">
        <section class="main" id="search-results" role="region" aria-labelledby="page-title-search-results">
            <h1 id="page-title-search-results">Söker efter "<?php echo $s ?>":</h1>

            <?php global $wp_query ?>
            <p>
                <?php printf(__('Hittade %s sökresultat.', 'wally'), $wp_query->found_posts) ?>
                <?php printf(__('Sökresultaten är uppdelade i  %s sidor.', 'wally'), $wp_query->max_num_pages) ?><br>
            </p>

            <h2 class="subtitle">Sökresultat:</h2>

            <div class="pagination no-margin">
                <?php the_posts_pagination() ?>
            </div>

            <?php do_action('before-post-loop');
            if(have_posts()):
                while(have_posts()): the_post();
                    get_template_part('parts/posts/loop');
                endwhile;
            endif;
            do_action('after-post-loop') ?>

            <div class="pagination no-margin">
                <?php the_posts_pagination() ?>
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
<?php get_footer(); ?>
