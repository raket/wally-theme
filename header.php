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
        <meta charset="<?php bloginfo('charset') ?>">
        <title><?php wp_title('|', true, 'right') ?></title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name') ?> Feed" href="/">
        <?php
        wp_head();
        ?>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
              rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="<?php echo $turl ?>/assets/js/vendor/respond.min.js" type="text/javascript"></script>
        <script src="<?php echo $turl ?>/assets/js/vendor/selectivizr.min.js" type="text/javascript"></script>
        <![endif]-->

    </head>

<body <?php
    $body_class = get_post_meta(get_queried_object_id(), 'boxed_columns', true) ? 'appearance-column-boxes' : '';
    body_class($body_class) ?>>

    <?php if(!w_has_accepted_cookies()) {
        echo apply_filters('wally_cookiebar', '
            <form class="cookiebar" method="post">
                <div class="container">
                    <div class="row">
                        <div class="cookiebar__text">' . __('Den här webbplatsen använder cookies för att förbättra användarupplevelsen.', 'wally-theme') . '</div>
                        <a href="' . add_query_arg('accept_cookies', 1) . '" class="button button--primary cookiebar__button">' . __('Jag förstår', 'wally-theme') . '</a>
                    </div>
                </div>
            </form>
        ');
    } ?>

    <div class="print">
        <?php do_action('wally_print_content') ?>
    </div>

    <a href="#site-navigation" class="skiplink" tabindex="1">
        <div class="container">
            <div class="col-6"><i class="material-icons" aria-label="<?php _e('Nedåtpil', 'wally-theme') ?>"
                                  aria-hidden="true">keyboard_arrow_down</i><?php _e('Gå till navigation', 'wally-theme') ?>
            </div>
        </div>
    </a>
    <a href="#site-content" class="skiplink" tabindex="2" accesskey="s">
        <div class="container">
            <div class="col-6"><i class="material-icons" aria-label="<?php _e('Nedåtpil', 'wally-theme') ?>"
                                  aria-hidden="true">keyboard_arrow_down</i><?php _e('Gå till huvudinnehåll', 'wally-theme') ?>
            </div>
        </div>
    </a>

    <div class="main-wrapper">

    <?php do_action("wally_before_site_header") ?>

<?php
    $header_setting = ( fw_get_db_customizer_option('header_setting') ) ?  fw_get_db_customizer_option('header_setting') : 'horizontal-header';
    get_template_part('parts/header/' . $header_setting );


?>