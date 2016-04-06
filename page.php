<?php get_header(); ?>
    <div class="container">
        <div class="row">

            <?php
            $sidebar_location = fw_get_db_customizer_option('sidebar_setting');

            if($sidebar_location === 'left') {get_sidebar();} ?>

            <section id="site-content" class="main" id="main" role="region" aria-labelledby="page-title-<?php echo $post->ID ?>">
                <?php while (have_posts()) : the_post(); ?>
                <div <?php post_class('article-box') ?> id="post-<?php the_ID(); ?>">
                    <div class="article-box__header">
                        <?php do_action('page-before-title'); ?>
                        <h1 id="page-title-<?php echo $post->ID ?>"><?php the_title(); ?></h1>
                        <?php do_action('page-after-title'); ?>
                        <?php //Show Edit in Backend button for logged in Editors and Admins
                        if(is_user_logged_in() && current_user_can('edit_posts')):
                            $url = get_bloginfo('url').'/wp-admin/post.php?post='.$post->ID.'&action=edit';
                            ?>
                            <a href="<?= $url; ?>" class="edit-btn" title="<?php echo $post->post_type === 'post' ? __('Redigera inlägg', 'wally') : __('Redigera sida', 'wally') ?>">
                                <span>
                                    <?php echo $post->post_type === 'post' ? __('Redigera inlägg', 'wally') : __('Redigera sida', 'wally') ?>
                                </span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="article-box__content">
                        <?php  get_template_part('parts/media/thumbnail'); ?>
                        <?php
                            do_action('page-before-content');
                            the_content();
                            do_action('page-after-content');
                        ?>
                    </div>
                </div>
                <?php endwhile ?>

            </section>
            <?php if($sidebar_location === 'right') {get_sidebar();} ?>
        </div>
    </div>
<?php get_footer(); ?>
