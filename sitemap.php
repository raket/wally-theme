<?php /* Template Name: Webbplatskarta */ ?>
<?php get_header() ?>
<div class="container">
    <div class="row">
        <?php
        $sidebar_location = fw_get_db_customizer_option('sidebar_setting');

        if($sidebar_location === 'left') {get_sidebar();} ?>
        <section id="site-content" class="site-content" role="region" aria-labelledby="page-title-sitemap">
            <?php while (have_posts()) : the_post() ?>
                <div <?php post_class('article-box') ?> id="post-<?php the_ID() ?>">
                    <header class="article-box__header">
                        <h1 id="page-title-sitemap"><?php the_title() ?></h1>
                    </header>
                    <div class="article-box__content">
                        <?php wp_list_pages(array('title_li' => false)) ?>
                    </div>
                </div>
            <?php endwhile ?>
        </section>
        <?php if($sidebar_location === 'right') {get_sidebar();} ?>
    </div>
</div>
<?php get_footer() ?>

