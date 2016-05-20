<?php
//Set variables for performance
$turl = get_template_directory_uri();
?>
    <!doctype html>
    <!--[if lt IE 7]>
    <html class="no-js ie6 oldie" lang="sv">    <![endif]-->
    <!--[if IE 7]>
    <html class="no-js ie7 oldie" lang="sv">    <![endif]-->
    <!--[if IE 8]>
    <html class="no-js ie8 oldie" lang="sv">    <![endif]-->
    <!--[if gt IE 8]>	<!-->
    <html class="no-js" lang="sv">        <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="/">
        <?php
        wp_head();
        ?>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
              rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="<?php echo $turl; ?>/assets/js/vendor/respond.min.js" type="text/javascript"></script>
        <script src="<?php echo $turl; ?>/assets/js/vendor/selectivizr.min.js" type="text/javascript"></script>
        <![endif]-->

    </head>

<body <?php
    $body_class = get_post_meta(get_queried_object_id(), 'boxed_columns', true) ? 'appearance-column-boxes' : '';
    body_class($body_class) ?>>

    <a href="#site-navigation" class="skiplink" tabindex="1">
        <div class="container">
            <div class="col-6"><i class="material-icons" aria-label="<?php _e('Nedåtpil', 'wally') ?>"
                                  aria-hidden="true">keyboard_arrow_down</i><?php _e('Gå till navigation', 'wally') ?>
            </div>
        </div>
    </a>
    <a href="#site-content" class="skiplink" tabindex="2" accesskey="s">
        <div class="container">
            <div class="col-6"><i class="material-icons" aria-label="<?php _e('Nedåtpil', 'wally') ?>"
                                  aria-hidden="true">keyboard_arrow_down</i><?php _e('Gå till huvudinnehåll', 'wally') ?>
            </div>
        </div>
    </a>

<div id="site-document" class="site-document">

<?php do_action('before-site-header'); ?>
    <header id="site-header" class="site-header">

        <div class="container">
            <div class="row">
                <?php if(has_nav_menu('mobile_primary_navigation')): ?>
                <button class="off-canvas__open">
                    <i class="material-icons" aria-label="<?php _e('Meny', 'wally') ?>"
                                                    aria-hidden="true">menu
                    </i>
                </button>
                <?php endif ?>
            </div>
        </div>

        <div class="container" style="position: relative">

            <div class="row">
                <?php $logo = ($logo_img = fw_get_db_customizer_option('logo')) ? $logo_img : false ?>
                <a href="<?php echo get_bloginfo('url') ?>" class="site-title <?php if ($logo) echo 'has-image'; ?>">
                    <?php if ($logo): ?>
                        <img src="<?php echo make_image($logo['attachment_id'], false, 80, true) ?>"
                             alt="<?php bloginfo('name'); ?>"/>
                    <?php endif; ?>
                    <span><?php bloginfo('name'); ?></span>

                    <p><?php bloginfo('description'); ?></p>
                </a>
                <div class="site-header__tools">
                    <ul>

                        <?php if (Wally_Sitemap::sitemap_exists()): ?>
                            <li><a href="<?php echo get_the_permalink(get_page_by_path('sitemap')->ID) ?>"><i
                                        class="material-icons" aria-label="<?php _e('Karta', 'wally') ?>"
                                        aria-hidden="true">map</i> <?php _e('Webbplatskarta', 'wally') ?></a></li>
                        <?php endif ?>

                        <?php if (isset($_COOKIE['wally_contrast']) && $_COOKIE['wally_contrast'] == true) {
                            $contrast = true;
                        } else {
                            $contrast = false;
                        } ?>

                        <li><a href="<?php echo add_query_arg('toggle_contrast', 1) ?>"><i class="material-icons"
                                                                                           aria-label="<?php _e('Kontrast', 'wally') ?>"
                                                                                           aria-hidden="true">tonality</i>
                                <span class="increaseContrast">Öka kontrast</span></a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <div id="site-navigation" class="navigation site-navigation">
            <div class="container">

                <div class="row">

                    <nav class="primary-navigation" role="navigation" aria-label="<?php _e('Huvudmeny', 'wally') ?>">
                        <?php if (has_nav_menu('primary_navigation')) {
                            echo apply_filters('w_desktop_navigation',
                                wp_nav_menu(array(
                                        'theme_location' => 'primary_navigation',
                                        'container' => '',
                                        'echo' => false,
                                    )
                                ));


                        } ?>
                    </nav>

                    <div class="search-form">
                        <?php get_search_form() ?>
                    </div>

                </div>

            </div>
        </div>
    </header>
<?php do_action('after-site-header'); ?>

<?php do_action('before-site-content'); ?>

<div class="alert-wrapper">
    <div class="container">
        <?php do_action('theme_alerts') ?>
    </div>
</div>

<?php if (function_exists('fw_ext_breadcrumbs')): ?>
    <div class="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <?php fw_ext_breadcrumbs('') ?>
            </div>
        </div>
    </div>
<?php endif; ?>

    <main class="main" role="main" aria-labelledby="page-title">


<?php do_action('prepend-site-content'); ?>