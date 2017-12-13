<?php get_header() ?>
    <div class="container">
        <div class="row">

            <?php
                $header_setting = fw_get_db_customizer_option('header_setting');
                $sidebar_location = fw_get_db_customizer_option('sidebar_setting');
                if($sidebar_location === 'left' && $header_setting != 'vertical-header' ) {get_sidebar();}
            ?>

            <section id="site-content" class="site-content" tabindex="0" id="main" role="region" aria-labelledby="page-title-<?php echo $post->ID ?>">
                <?php while (have_posts()) : the_post() ?>
                <div <?php post_class('article-box') ?> id="post-<?php the_ID() ?>">
                    <div class="article-box__header">
                        <?php do_action("wally_page_before_title") ?>
                        <h1 id="page-title-<?php echo $post->ID ?>"><?php the_title() ?></h1>
                        <?php do_action("wally_page_after_title") ?>
                        <?php //Show Edit in Backend button for logged in Editors and Admins
                        if(is_user_logged_in() && current_user_can('edit_posts')):
                            $url = esc_url( home_url() ).'/wp-admin/post.php?post='.$post->ID.'&action=edit';
                            ?>
                            <a href="<?php echo $url ?>" class="edit-btn" title="<?php echo $post->post_type === 'post' ? __('Redigera inlägg', 'wally-theme') : __('Redigera sida', 'wally-theme') ?>">
                                <span>
                                    <?php echo $post->post_type === 'post' ? __('Redigera inlägg', 'wally-theme') : __('Redigera sida', 'wally-theme') ?>
                                </span>
                            </a>
                        <?php endif ?>
                    </div>
                    <?php  get_template_part('parts/media/thumbnail') ?>
                    <div class="article-box__content">
                        <?php
                            do_action("wally_page_before_content");
                            the_content();
                            do_action("wally_page_after_content");
                        ?>
                    </div>
                </div>
                <?php endwhile ?>

            </section>
            <?php if($sidebar_location === 'right' && $header_setting != 'vertical-header' ) {get_sidebar();} ?>
        </div>
    </div>
<?php get_footer() ?>
