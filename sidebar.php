<div class="sidebar" aria-label="<?php _e('Sidomeny', 'wally') ?>">
    <?php
    if(is_front_page() || is_home() || is_archive() || is_page_template('home.php')){
        ob_start();
        dynamic_sidebar( 'blog-sidebar' );
        $sidebar_output = ob_get_contents();
        ob_end_clean();
        echo apply_filters('w_blog_sidebar_output', $sidebar_output);
    } elseif(is_page()){
        get_template_part('parts/navigation/subpages');
    } elseif(is_single()){
        get_template_part('parts/navigation/single');
    }
    ?>
</div>