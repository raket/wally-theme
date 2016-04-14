<?php

//---------------------------------------------------------------------------------
//  Development Mode On / Off
//---------------------------------------------------------------------------------
if((defined('WP_LOCAL_DEV') && WP_LOCAL_DEV ) || strpos($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],'.dev') !== false ){
    add_action('houston_after_footer', function(){

            $file = 'http://localhost:35729/livereload.js';
            $file_headers = @get_headers($file);
            if($file_headers) {
                wp_enqueue_script('livereload', 'http://localhost:35729/livereload.js', '', '', true);
            }
    });
}

//---------------------------------------------------------------------------------
//	Load module with attribute passing
//---------------------------------------------------------------------------------
function load_module($file, $attributes = false){
    if($attributes){
        /** @noinspection PhpParamsInspection */
        /** @noinspection PhpParamsInspection */
        /** @noinspection PhpParamsInspection */
        /** @noinspection PhpParamsInspection */
        /** @noinspection PhpParamsInspection */
        /** @noinspection PhpParamsInspection */
        extract($attributes, EXTR_PREFIX_SAME, "module");
    }
    include(locate_template($file));
}

//---------------------------------------------------------------------------------
//	Require Files and load Wally
//---------------------------------------------------------------------------------
add_action('after_setup_theme', '_w_check_plugin_nopriv');
function _w_check_plugin_nopriv() {

    if(!class_exists('Wally') && !is_admin() && is_user_logged_in()) {
        //echo file_get_contents(get_stylesheet_directory() . '/install-plugin.php');
        load_template(get_stylesheet_directory() . '/install-plugin.php');
        die;
        //die(__('Var god aktivera Wally-tilläget.', 'wally'));
    }

}

//----------------------------------------------------
//	Enqueue JS & CSS
//----------------------------------------------------

add_action('admin_init', '_w_check_plugin');
function _w_check_plugin() {

    if(!class_exists('Wally') && is_admin()) {

        add_action( 'admin_notices', function() {
            $class = "update-nag";
            $message = sprintf(__('Wally-tillägget är för närvarande inte aktiverat. <a href="%s">Klicka här</a> för att aktivera tillägget.', 'wally'), 'plugins.php');

            if(get_current_screen()->base !== 'plugins') {
                echo"<div class=\"$class\"><p>$message</p></div>";
            }

        });

    }
}

add_action('wp_enqueue_scripts', function() {

    wp_enqueue_style('wally', get_stylesheet_directory_uri() . '/assets/css/app.css');

    $theme = fw_get_db_customizer_option('color_theme');
    wp_enqueue_style('wally_theme', get_stylesheet_directory_uri() . '/assets/css/themes/' . $theme . '.css');

    wp_enqueue_script('jquery');
    wp_enqueue_script('bower', get_template_directory_uri() . '/assets/bower/_bower.js', false, false, true);
    wp_enqueue_script('wally', get_template_directory_uri() . '/assets/js/build/all.js', array('bower'), false, true);

    if(is_user_logged_in()) {
        wp_enqueue_script('tota11y', 'https://cdnjs.cloudflare.com/ajax/libs/tota11y/0.1.3/tota11y.js', false, false, true);
    }

    wp_localize_script('wally', 'ajax', array(
        'url' => admin_url('admin-ajax.php')
   ));

});

add_action( 'after_setup_theme', '_w_init', 9 );
function _w_init() {

	// Configure theme support
	add_theme_support( 'html5', array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption'
   ));
	add_theme_support( 'menus' );

	add_theme_support( 'phpquery' );
    if(current_theme_supports('phpquery')) {

        // Don't throw errors on html5 tags
        libxml_use_internal_errors(true);

    }

	add_theme_support( 'clean-head' );
	add_theme_support( 'relative-urls' );
	add_theme_support( 'pretty-search' );
    add_theme_support( 'post-thumbnails', array( 'post', 'page'));

    // Initialize stella
    require_once(get_template_directory() .'/_framework/init.php');

    // Add Stella Admin files if we're logged in
    if(is_admin()){
        require_once(get_template_directory() .'/_framework/admin.php');
    }
    add_editor_style( 'editor-style.css' );

    // Register navigation
    register_nav_menus(array(
        'primary_navigation' => __('Huvudmeny','wally'),
        'mobile_primary_navigation' => __('Mobilmeny', 'wally'),
   ));
}

// Register sidebars
add_action( 'widgets_init', function(){
    register_sidebar( array(
        'name' => __( 'Bloggmeny', 'wally' ),
        'id' => 'blog-sidebar',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget__title">',
        'after_title'   => '</h2>',
   ));
});

//---------------------------------------------------------------------------------
//	Register Sidebars
//---------------------------------------------------------------------------------


/**
 * Adds a "navigation__item" class to navigation list items.
 */
add_filter('nav_menu_css_class', '_w_set_navigation_classes', 101, 2);
function _w_set_navigation_classes($classes) {

    $swap = array(
        'current-menu-item' => 'is-current',
        'current_page_item' => 'is-current',
        'menu-item-has-children' => 'is-parent'
    );

    foreach($swap as $from => $to) {
        if(in_array($from, $classes)) {
            $classes[array_search($from, $classes)] = $to;
        }
    }

    return $classes;
}

/**
 * Set nice classes to mobile navigation
 */
add_filter('w_mobile_navigation', '_w_mobile_navigation_markup', 10, 3);
function _w_mobile_navigation_markup($navigation) {

    if(current_theme_supports( 'phpquery')) {

        $doc = phpQuery::newDocument($navigation);

        $list = $doc->children()->removeAttr('class')
            ->addClass('off-canvas__navigation__list')
            ->attr('role', 'menu');

        $items = $list->children('li')
            ->addClass('off-canvas__navigation__item');

        $subitems = $items->find('li')
            ->addClass('off-canvas__navigation__subitem');

        $sublists = $items->find('ul')
            ->addClass('off-canvas__navigation__sublist');

        foreach($list->find('li') as $li) {

            $li = pq($li);

            if($li->hasClass('is-parent')) {
                $li->children('a')->append('<button class="off-canvas__navigation__toggle" role="button" title="Visa undersidor"></button>');
            };
        }

        $html = $doc->html();
        phpQuery::unloadDocuments();

        return $html;
    }
    return $navigation;

}

/**
 * Set nice classes to desktop navigation
 */
add_filter('w_desktop_navigation', '_w_desktop_navigation_markup', 10, 3);
function _w_desktop_navigation_markup($navigation) {

    if(current_theme_supports( 'phpquery')) {

        $doc = phpQuery::newDocument($navigation);

        $list = $doc->children()->removeAttr('class')
            ->addClass('navigation__list')
            ->attr('role', 'menu');

        $items = $list->children('li')
            ->addClass('navigation__item')->children('a')->wrapInner('<span>');

        $items->find('li')
            ->addClass('navigation__subitem');

        $items->find('ul')
            ->addClass('navigation__sublist');


        $html = $doc->html();
        phpQuery::unloadDocuments();

        return $html;
    }
    return $navigation;

}

/**
 * Build a list group with phpQuery
 */
add_filter('w_blog_sidebar_output', '_w_build_list_group', 10);
add_filter('w_list_group', '_w_build_list_group', 10);
function _w_build_list_group($output) {

    if(current_theme_supports( 'phpquery')) {
        $doc = phpQuery::newDocument($output);

        $items = $doc->find('li');
        foreach(pq($items) as $item) {
            $item = pq($item);
            //Add pills appearance for categories
            if($item->hasClass('cat-item')) {
                $item_class= 'pills__item';
                $subitem_class = $item_class;
                $item->parents('ul')->addClass('pills');
                $item->children('a')->addClass('pills__link');
            } else {
                $subitem_class= 'list-group__subitem';
                $item_class= 'list-group__item';
            }

            if($item->parent()->parent()->is('li')) {
                $item->addClass($subitem_class);
            } else {
                $item->addClass($item_class);
            }

            $item->children('a')->wrapInner('<span>');

            // Filter wordpress classes
            $classes = explode(' ', $item->attr('class'));
            $item->removeAttr('class');
            $item->attr('class', implode(' ', _w_set_navigation_classes($classes)));

            // Add sublists
            $sub_list = pq($item->children('ul'));
            if($sub_list->length) {
                $sub_list->addClass('list-group__sublist is-open');
                $item->children('a')->addClass('is-open')->append('<button role="button" title="Visa undersidor" data-collapse-trigger></button>');
            }

            // Open current items parent lists
//            if($item->hasClass('is-current')) {
//                $parents = $item->parents('li');
//                pq($parents)->children('ul, a')->addClass('is-open');
//            }

        }


        $html = $doc->html();
        phpQuery::unloadDocuments();

        return $html;
    }
    return $output;

}

/**
 * Build the latest comments template
 */
add_filter('w_blog_sidebar_output', '_w_build_latest_comments', 10);
function _w_build_latest_comments($output) {

    if(current_theme_supports( 'phpquery')) {
        $doc = phpQuery::newDocument($output);

        $list = $doc->find('#recentcomments');
        pq($list)->addClass('recent-comments recent__list');

        $items = pq($list)->find('li');

        if(pq($items)->length) {
            foreach(pq($items) as $item) {

                // Get comment id
                foreach(pq($item)->find("a") as $link) {
                    $href = pq($link)->attr("href");
                    preg_match('/#comment-(\d+)/', $href, $matches);

                    if(!empty($matches)) {
                        $id = $matches[1];
                    }
                }

                pq($item)->empty();
                pq($item)->addClass("recent__item");

                if(!empty($id) && $comment = get_comment($id)):

                    if(post_password_required($comment->comment_post_ID)) {
                        pq($item)->remove();
                        continue;
                    }

                    $default_avatar = home_url(get_template_directory_uri() . '/assets/images/avatar.svg');
                    if((defined('WP_LOCAL_DEV') && WP_LOCAL_DEV)) {
                        $avatar = '<img alt="" src="' . $default_avatar . '" class="avatar avatar-72 photo" height="64" width="72">';
                    } else {
                        $avatar = get_avatar($comment->comment_author_email, '72', $default_avatar);
                    }

                    $date = '<time class="recent__date">' . get_comment_date('j F, Y H:i', $comment->comment_ID) . '</time>';
                    $author = '<div class="recent__author">' . $avatar . '<span>' . $comment->comment_author . '</span></div>';

                    $emotion = get_comment_meta($comment->comment_ID, 'emotion', true);
                    $content = $comment->comment_content;

                    if($content == $emotion) {
                        $content = '';
                    } else {
                        $content = '<q>' . get_comment_excerpt(($id)) . '</q>';
                    }

                    if($emotion && get_emotion($emotion)) {
                        $content = '<img src="' . get_template_directory_uri() . '/assets/icons/twemojis/' . get_emotion($emotion) . '.svg" alt="" class="recent__emotion">' . $content;
                    }

                    $text = '<div class="recent__text">'.$author.' · '.$date. '<span class="recent__content">'. $content . '</span></div><a class="recent__link" href="' . get_comment_link($comment->comment_ID) . '">' . __("Läs kommentar om", 'wally') . ' ' . get_the_title($comment->comment_post_ID) . '</a>';

                    $article = '<h3>Om artikeln: <a href="' . get_permalink($comment->comment_post_ID) . '" class="recent__article">' . get_the_title($comment->comment_post_ID) . '</a></h3> <br>';

                    pq($item)
                        ->append($article)
                        ->append($text);

                endif;

            }
        } else {
            pq($list)->append('<p class="recent__not-found">Inga kommentarer skrivna ännu.</p>');
        }


        $html = $doc->html();
        phpQuery::unloadDocuments();

        return $html;

    }
    return $output;

}

/**
 * Unyson form builder
 */
add_action('fw_ext_forms_frontend_submit', function($form) {

    global $wpdb;
    global $post;
    $form_fields = (json_decode($form['instance']->get_form_builder_value($form['id'])['json']));
    $data = "";

    foreach($form_fields as $field) {
        if(array_key_exists($field->shortcode, $_POST)) {
            $label = "<label><b>" . $field->options->label . "</b></label>";

            if(is_string($_POST[$field->shortcode])) {
                $value = "<pre>" . $_POST[$field->shortcode] . "</pre>";
            } else if(is_array($_POST[$field->shortcode])) {
                $value = "";
                foreach($_POST[$field->shortcode] as $answer) {
                    $value .= "<pre>" . $answer . "</pre>";
                }
            } else {
                $value = "-";
            }



            $data .= "<div>" . $label . "<br>" . $value . "</div>";

        }
    }

    wp_insert_post(array(
        'post_content' => serialize($data),
        'post_type' => 'survey',
        'post_title' => __('Svar till formulär', 'wally'),
        'post_status' => 'publish'
   ));

});

function _w_create_post_types() {

	$types = array(

		'survey' => array(
			'args' => array(
				'hierarchical' => true,
				'public' => false,
                'show_ui' => true,
				'labels' => array(
                    'name'               => _x( 'Enkätsvar', 'post type general name', 'wally' ),
                    'singular_name'      => _x( 'Enkätsvar', 'post type singular name', 'wally' ),
                    'menu_name'          => _x( 'Enkätsvar', 'admin menu', 'wally' ),
                    'name_admin_bar'     => _x( 'Enkätsvar', 'add new on admin bar', 'wally' ),
                    'add_new'            => _x( 'Skapa nytt', 'book', 'wally' ),
                    'add_new_item'       => __( 'Skapa nytt enkätsvar', 'wally' ),
                    'new_item'           => __( 'Nytt enkätsvar', 'wally' ),
                    'edit_item'          => __( 'Redigera enkätsvar', 'wally' ),
                    'view_item'          => __( 'Visa enkätsvar', 'wally' ),
                    'all_items'          => __( 'Alla enkätsvar', 'wally' ),
                    'search_items'       => __( 'Sök enkätsvar', 'wally' ),
                    'parent_item_colon'  => __( 'Föräldra-enkätsvar:', 'wally' ),
                    'not_found'          => __( 'Hittade inga enkätsvar.', 'wally' ),
                    'not_found_in_trash' => __( 'Hittade inga enkätsvar i papperskorgen.', 'wally' )
                ),
				'has_archive' => false,
                'menu_icon' => 'dashicons-format-status',
                'supports' => array(
                    'editor' => false
                )
			),
			'taxonomies' =>  array(
//				'cpt_tax' => array('label' => 'CPT Tax','hierarchical' => true)
			)
		),

	);

    // Register them
    foreach($types as $type => $cpt) {
        register_post_type( $type, $cpt['args'] );

        foreach($cpt['taxonomies'] as $taxonomy => $args){
            register_taxonomy($taxonomy, $type, $args);
        }
    }

}
add_action( 'init', '_w_create_post_types' );

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function _w_survey_add_meta_box() {
    add_meta_box(
        'myplugin_sectionid',
        __( 'Enkätsvar', 'wally' ),
        '_w_survey_meta_box_callback',
        'survey',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', '_w_survey_add_meta_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function _w_survey_meta_box_callback($post) {
    $data = get_post_meta( $post->ID, '_w_survey_data', true );
    echo unserialize($post->post_content);
}

/**
 * Hides metaboxes when editing the sitemap.
 */
add_action( 'admin_init', function() {

    $post_id = @$_GET['post'] ? @$_GET['post'] : @$_POST['post_ID'] ;
    if(!isset($post_id)) return;

    $template_file = get_post_meta($post_id, '_wp_page_template', true);

    if($template_file == 'sitemap.php'){ // edit the template name
        remove_post_type_support('page', 'editor');
        remove_post_type_support('page', 'title');
        remove_post_type_support('page', 'thumbnail');
        remove_post_type_support('page', 'discussion');
        remove_post_type_support('page', 'comments');
    }

});

/**
 * Show a notice when editing the sitemap.
 */
add_action('all_admin_notices', function() {

    $post_id = @$_GET['post'] ? @$_GET['post'] : @$_POST['post_ID'] ;
    if(!isset($post_id)) {
        return;
    }

    $template_file = get_post_meta($post_id, '_wp_page_template', true);

    if($template_file === 'sitemap.php'): ?>
        <div class="update-nag"><?php _e('Den här sidan används som webbplatskarta och går därför inte att redigera.') ?></div>
    <? endif;

});

/**
 * Function for toggling the contrast cookie.
 */
add_action('init', function() {
    if(isset($_GET['toggle_contrast'])) {
        if(isset($_COOKIE['wally_contrast'])) {
            setcookie('wally_contrast', "", -1, '/');
            unset($_COOKIE['wally_contrast']);
        } else {
            setcookie('wally_contrast', 1, time() + (60 * 60 * 24 * 30), '/');
        }
        header("Location: " . remove_query_arg('toggle_contrast'));
        die();
    }
});


/**
 * Add sizing options for the post thumbnail
 */
add_filter( 'admin_post_thumbnail_html', '_w_post_thumbnail_options' );
function _w_post_thumbnail_options($html) {

    global $post;

    $size = get_post_meta($post->ID, 'thumbnail_size', true);
    $text = get_post_meta($post->ID, 'thumbnail_text', true);

    $small = $size == 'small' ? 'checked' : '';
    $large = $size == 'large' ? 'checked' : '';


    if(!$small && !$large) {
        $small = 'checked';
    }
    if($text === null) {
        $text = false;
    }

    $no_text = $text ? '' : 'checked';
    $text = $text ? 'checked' : '';

    return $html . '

        <p style="border-top: solid 1px rgb(238, 238, 238);padding-top: 1rem;"><strong>' . __('Storlek', 'wally') . '</strong></p>
        <p>' . __('Välj i vilken storlek bilden ska visas.', 'wally') . '</p>
        <p>
            <label for="small_thumbnail" style="padding-right: 15px">
                <input type="radio" name="thumbnail_size" id="small_thumbnail" value="small" '. $small .'>
                ' . __('Liten', 'wally') . '
            </label>
            <label for="large_thumbnail">
                <input type="radio" name="thumbnail_size" id="large_thumbnail" value="large" '. $large .'>
                ' . __('Stor', 'wally') . '
            </label>
        </p>

        <p><strong>' . __('Bildtext', 'wally') . '</strong></p>
        <p>' . __('Välj om bildens bildtext ska visas.', 'wally') . '</p>
        <p>
            <label for="thumbnail_text_off" style="padding-right: 15px">
                <input type="radio" name="thumbnail_text" id="thumbnail_text_off" value="0" '. $no_text .'>
                ' . __('Visa inte', 'wally') . '
            </label>
            <label for="thumbnail_text_on">
                <input type="radio" name="thumbnail_text" id="thumbnail_text_on" value="1" '. $text .'>
                ' . __('Visa', 'wally') . '
            </label>
        </p>
';
}


/**
 * Allow SVG upload
 */
function allow_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_mime_types');


/**
 * Save the post thumbnail size as metadata
 */
add_action( 'save_post', '_w_save_post_thumbnail_options' );
function _w_save_post_thumbnail_options($post_id) {
    if(@isset($_POST['thumbnail_size'])) {
        update_post_meta($post_id, 'thumbnail_size', $_POST['thumbnail_size']);
    }
    if(@isset($_POST['thumbnail_text'])) {
        update_post_meta($post_id, 'thumbnail_text', $_POST['thumbnail_text']);
    }
}


/**
 * Generates a pagination for all kinds of queries.
 *
 * @param string $numpages
 * @param string $pagerange
 * @param string $paged
 */
function custom_pagination($numpages = '', $pagerange = '', $paged='') {

    if (empty($pagerange)) {
        $pagerange = 2;
    }

    global $paged;
    if (empty($paged)) {
        $paged = 1;
    }
    if ($numpages == '') {
        global $wp_query;
        $numpages = $wp_query->max_num_pages;
        if(!$numpages) {
            $numpages = 1;
        }
    }

    $pagination_args = array(
        'base'            => get_pagenum_link(1) . '%_%',
        'format'          => 'page/%#%',
        'total'           => $numpages,
        'current'         => $paged,
        'show_all'        => False,
        'end_size'        => 1,
        'mid_size'        => $pagerange,
        'prev_next'       => True,
        'prev_text'       => __('&laquo;'),
        'next_text'       => __('&raquo;'),
        'type'            => 'plain',
        'add_args'        => false,
        'add_fragment'    => ''
    );

    $paginate_links = paginate_links($pagination_args);

    if ($paginate_links) {
        echo '<div class="pagination">';
        echo "<nav class='custom-pagination'>";
        echo $paginate_links;
        echo "</nav>";
        echo "</div>";
    }

}

/**
 * Ajax actions for lazy loading posts.
 */
add_action( 'wp_ajax_nopriv_ajax_pagination', '_w_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', '_w_ajax_pagination' );
function _w_ajax_pagination() {

    $query = new WP_Query(array(
        'post__not_in' => get_option('sticky_posts'),
        'post_type' => 'post',
        'post_status' => 'publish',
        'paged' => $_GET['page']
   ));

//    echo $query->max_num_pages;

    $object = new stdClass();

    $object->pages = intval($query->max_num_pages);

    ob_start();
    if($query->have_posts()): while($query->have_posts()): $query->the_post();
        get_template_part('parts/posts/loop');
    endwhile; wp_reset_postdata(); endif;
    $object->articles = ob_get_clean();

    echo json_encode($object);

    die();
}

/**
 * Ajax actions for autocomplete. The functions reads wordlist.txt inside the uploads dir
 * and returns the top three matches.
 */
add_action( 'wp_ajax_nopriv_autocomplete', '_w_autocomplete' );
add_action( 'wp_ajax_autocomplete', '_w_autocomplete' );
function _w_autocomplete() {

    $wordlist = get_template_directory() . '/assets/wordlist.txt';
    $query = $_GET['query'];

    if(file_exists($wordlist)) {

        // Open and read words
        $file = fopen($wordlist, 'r');
        $words = (fread($file, filesize($wordlist)));

        // Find words matching query
        preg_match_all('/(*UTF8)\R(' . $query . '.*)/i', $words, $matches);
        fclose($file);

        // Return the top three results
        $suggestions = array_slice($matches[0], 0, 3);

        $object = new stdClass();
        $object->suggestions = $suggestions;

        echo json_encode($object);

    } else {
        echo "File not found: " . $wordlist;
    }

    die();

}

/**
 * Rename Unyson's "Blog posts" to "Blogginlägg"
 */
add_action( 'admin_menu', '_w_rename_post_menu', 999 );
function _w_rename_post_menu() {
    global $menu;

    if ( isset( $menu[5])) {
        $menu[5][0] = __( 'Blogginlägg', 'wally' );
    }
}

/**
 * Checks if the specified email is connected to a Gravatar
 *
 * @param $email
 * @return bool
 */
function has_gravatar($email) {
    $hash = md5(strtolower(trim($email)));
    $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
    $headers = @get_headers($uri);
    if (!preg_match("|200|", $headers[0])) {
        $has_valid_avatar = FALSE;
    } else {
        $has_valid_avatar = TRUE;
    }
    return $has_valid_avatar;
}

/**
 * Sets the query to highlight when searching.
 */
add_action('wp_print_scripts', '_w_set_highlight_query');
function _w_set_highlight_query() {
    $query  = esc_attr(get_search_query());

    if(strlen($query) > 0){
        echo '
      <script type="text/javascript">
        var wallySearchQuery  = "'.$query.'";
      </script>
    ';
    }
}

/**
 * @return array An array containing pairs of title => filename/character.
 */
function get_emotions() {
    return array(
        'Tummen upp' => '1f44d',
        'Tummen ner' => '1f44e',
        'Glad' => '1f600',
        //'Skrattar' => '1f604',
//        'Hjärta som ögon' => '1f60d',
//        'Voíla' => '1f44c',
//        'Blinka med ena ögat' => '1f609',
        'Neutral' => '1f610',
//        'Gråter' => '1f622',
        'Ledsen' => '1f641',
//        'Ler' => '1f642',
//        'Frågetecken' => '2753',
//        'Utropstecken' => '2757',
//        'Hjärta' => '2764'
    );
}

/**
 * @param $emotion string A string starting with emotion and ending with a character-code/filename like "emotion1234".
 * @return bool|string The corresponding filename/character or false if it doesn't exist.
 */
function get_emotion($emotion) {
    $emotions = get_emotions();

    if(strpos($emotion, 'emotion') !== false) {
        $emotion = substr($emotion, strlen('emotion'));

        if(in_array($emotion, $emotions)) {
            return $emotions[array_search($emotion, $emotions)];
        }

    }

    return false;
}

/**
 * Add some feel-good to the comment form.
 */
add_action( 'comment_form_logged_in_after', '_w_comment_form_emotions' );
add_action( 'comment_form_after_fields', '_w_comment_form_emotions' );
function _w_comment_form_emotions () {

        $emotions = get_emotions();
        echo '<fieldset class="comment-form__emotion form__group">' . '<legend class="form__label">' . __( 'Välj en symbol för kommentaren:', 'wally' ) . '</legend><br>';
        $i = 0;
        foreach($emotions as $key => $emotion):
            echo '<input id="emotion' . $emotion . '" class="form__control" name="commentFormEmotion" type="radio" value="emotion' . $emotion . '"><label class="form__label emotion" for="emotion' . $emotion . '"><img src="' . get_template_directory_uri() .'/assets/icons/twemojis/' . $emotion . '.svg" alt="' . __($key, 'wally') .'"></label>';
            $i++;
        endforeach;
         echo '</fieldset>';
}

add_action( 'comment_post', '_w_comment_form_save' );
function _w_comment_form_save($comment_id) {
    if((isset($_POST['commentFormEmotion'])) && $_POST['commentFormEmotion'] != '' && strpos($_POST['commentFormEmotion'], 'emotion') !== false) {
        $emotion = wp_filter_nohtml_kses($_POST['commentFormEmotion']);
    } else {
        $emotion = '';
    }
    add_comment_meta($comment_id, 'emotion', $emotion);
}

/**
 * A somewhat hacky way to allow empty comments if an emotion is set.
 */
add_action('pre_comment_on_post', '_w_pre_comment_on_post', 1);
function _w_pre_comment_on_post($post_id) {

    global $comment_content;

    if($_POST['comment'] === '') {

        // Check if the comment has got an emotion.
        if((isset($_POST['commentFormEmotion'])) && $_POST['commentFormEmotion'] !== '' && strpos($_POST['commentFormEmotion'], 'emotion') !== false) {
            $emotion = wp_filter_nohtml_kses($_POST['commentFormEmotion']);
            $_POST['comment'] = $emotion;
            $comment_content = $emotion;
        }

    }
}



add_filter('mce_buttons', function($buttons) {
    array_unshift($buttons, 'formatselect');
    return $buttons;
});

add_filter('mce_buttons_2', function($buttons) {

    unset($buttons[0]);

    // Remove paste-as-text
    if(($key = array_search('pastetext', $buttons)) !== false) {
        unset($buttons[$key]);
    }

    $buttons = array_values($buttons);
    return $buttons;
});

add_filter('wp_editor_settings', function($settings) {

    if(!empty($settings['toolbar1'])) {
        $settings['toolbar1'] = 'formatselect,'.$settings['toolbar1'];
    }

    $settings['block_formats'] = 'Paragraph=p;Ingress=h5;Heading 2=h2;Heading 3=h3;Heading 4=h4';
    return $settings;
});


/**
 * Register the plugin so that it's recognized by TinyMCE.
 */
add_filter( 'mce_external_plugins', 'add_tooltip_plugin' );
function add_tooltip_plugin( $plugin_array ) {
    $plugin_array['tooltip'] = get_template_directory_uri() . '/assets/js/tinymce/tooltip.js';
    return $plugin_array;
}

/**
 * Add custom CSS to tinyMCE
 */
function add_tooltip_css($css) {
    $css .= ',' . get_template_directory_uri() . '/assets/css/tinymce/tooltip.css';
    return $css;
}
add_filter('mce_css', 'add_tooltip_css');

/**
 * Add the tooltip-button to the TinyMCE toolbar.
 */
add_filter( 'mce_buttons', 'add_tooltip_button' );
function add_tooltip_button( $buttons ) {
    array_push($buttons, 'tooltip_button');
    return $buttons;
}

/**
 * Only used for Unyson's custom WP-Editor. Does the same as the two functions above this one.
 */
add_filter('wp_editor_settings', function($settings) {
    if(array_key_exists('plugins', $settings) && array_key_exists('toolbar1', $settings)) {
        $settings['plugins'] .= ',tooltip';

        // Remove the "read more"
        $settings['toolbar1'] = str_replace(',wp_more', '', $settings['toolbar1']) . ',tooltip_button';
        $settings['toolbar2'] .= ',wp_more';
    }
    return $settings;
});

/**
 * Give the tooltip-button a nice icon.
 */
function _w_add_tooltip_css() {
    wp_register_style( '_w_tooltip_css', get_template_directory_uri() . '/assets/css/tinymce/tooltip.css', false);
    wp_enqueue_style( '_w_tooltip_css' );
}
add_action( 'admin_enqueue_scripts', '_w_add_tooltip_css');

/**
 * Register the tooltip shortcode.
 */
function _w_get_tooltip_html($atts, $content){
    return '<span data-tooltip="' . @$atts['value'] .'">' . $content . '</span>';
}
add_shortcode('tooltip', '_w_get_tooltip_html' );


/**
 * Theme customizations
 */
add_filter( 'body_class', '_w_customizer_classes' );
function _w_customizer_classes($classes) {

    if(!is_child_theme()) {
        $classes[] = ($logo_img = fw_get_db_customizer_option('logo')) ? $logo_img : false;
    }

    $classes[] = ($font = fw_get_db_customizer_option('heading_font')) ? 'heading-font-'.$font : '';
    $classes[] = ($font = fw_get_db_customizer_option('body_font')) ? 'body-font-'.$font : '';
    $classes[] = ($font = fw_get_db_customizer_option('color_theme')) ? 'color-theme-'.$font : '';
    $classes[] = fw_get_db_customizer_option('image_height');
    $classes[] = fw_get_db_customizer_option('header_height');
    $classes[] = fw_get_db_customizer_option('appearance');

    return $classes;
}

/**
 * Enqueue google fonts if needed
 */
add_action('wp_enqueue_scripts', '_w_google_fonts');
function _w_google_fonts() {

    $heading_font = fw_get_db_customizer_option('heading_font');
    $body_font = fw_get_db_customizer_option('body_font');

    $available_fonts = array(
        'roboto' => 'Roboto:400,500',
        'source-sans-pro' => 'Source+Sans+Pro:400,700',
    );

    $wanted_fonts = array();
    if(array_key_exists($heading_font, $available_fonts)) {
        $wanted_fonts[$heading_font] = $available_fonts[$heading_font];
    }

    if(array_key_exists($body_font, $available_fonts)) {
        $wanted_fonts[$body_font] = $available_fonts[$body_font];
    }

    $query_args = array(
        'family' => implode('|', $wanted_fonts),
		'subset' => 'latin,latin-ext',
	);
	wp_register_style('google_fonts', "//fonts.googleapis.com/css?" . http_build_query($query_args));
    wp_enqueue_style('google_fonts');
}



/**
 * Add an option to
 */
add_filter( 'admin_post_thumbnail_html', '_reflex_video_thumbnail', 11);
function _reflex_video_thumbnail($html) {

    global $post;

    $type = get_post_meta($post->ID, 'thumbnail_type', true);
    $url = get_post_meta($post->ID, 'thumbnail_video', true);

    if($type == 'video') {
        $image = '';
        $video = 'checked';
    } else {
        $image = 'checked';
        $video = '';
    }

    $hide_video = $type != 'video' ? 'style="display: none"' : '';
    $hide_image = $type != 'image' ? 'style="display: none"' : '';

    return '
        <p>Utvald bild kan också kallas huvudbild.</p>
        <p><strong>' . __('Använd', 'reflex') . '</strong></p>
        <p>' . __('Välj mellan att använda bild eller video.', 'reflex') . '</p>
        <p>
            <label for="image_thumbnail" style="padding-right: 15px">
                <input type="radio" name="thumbnail_type" id="image_thumbnail" value="image" '. $image .'>
                ' . __('Bild', 'wally') . '
            </label>
            <label for="video_thumbnail">
                <input type="radio" name="thumbnail_type" id="video_thumbnail" value="video" '. $video .'>
                ' . __('Video', 'wally') . '
            </label>
        </p>

        <div id="thumbnail_type_image" ' . $hide_image . '>
' . $html . '
		</div>
		<div id="thumbnail_type_video" ' . $hide_video . '>
	        <p><strong>' . __('Video-URL', 'reflex') . '</strong></p>
			<input style="width: 100%" type="text" id="thumbnail-video-url" name="thumbnail_video" class="thumbnailvideo form-input-tip" size="16" autocomplete="off" value=" '. $url .'">

		</div>
	<script type="text/javascript">
		var $ = jQuery;
        $("#set-post-thumbnail").addClass("button button-primary button-large");
		$(\'input:radio[name="thumbnail_type"]\').on("change", function(e) {

			e.preventDefault();

			if ($(this).val() == \'image\') {
				$("#thumbnail_type_video").hide();
				$("#thumbnail_type_image").show();
			} else if ($(this).val() == \'video\') {
				$("#thumbnail_type_image").hide();
				$("#thumbnail_type_video").show();
			}

		});

	</script>
';
}


/**
 * Save the post thumbnail size as metadata
 */
add_action( 'save_post', '_reflex_save_video_thumbnail' );
function _reflex_save_video_thumbnail($post_id) {
    if(@isset($_POST['thumbnail_video'])) {
        update_post_meta($post_id, 'thumbnail_video', $_POST['thumbnail_video']);
    }
    if(@isset($_POST['thumbnail_type'])) {
        update_post_meta($post_id, 'thumbnail_type', $_POST['thumbnail_type']);
    }
}


/**
 * Modify TinyMCE editor to remove H1, H5 & H6 and add h5.
 */
function tiny_mce_remove_unused_formats($init) {
    // Add block format elements you want to show in dropdown
    $init['block_formats'] = 'Paragraph=p;Ingress=h5;Heading 2=h2;Heading 3=h3;Heading 4=h4';
    return $init;
}
add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );

/**
 * Always paste text as plain text (and not formatted)
 */
function tiny_mce_force_paste_as_plain_text($init) {
    $init[ 'paste_text_sticky' ] = true;
    $init[ 'paste_text_sticky_default' ] = true;
    $init[ 'paste_as_text' ] = true;

    return $init;
}
add_filter('tiny_mce_before_init', 'tiny_mce_force_paste_as_plain_text', 1, 2);
add_filter('teeny_mce_before_init', 'tiny_mce_force_paste_as_plain_text', 1, 2 );

/**
 * Load the paste plugin to teeny mce
 */
add_filter( 'teeny_mce_plugins', function($plugins) {
    return array_merge( $plugins, (array) 'paste' );
});


/**
 * Register meta box(es).
 */
function _w_register_meta_boxes() {
    add_meta_box( 'wally_box-styling', __( 'Utseende', 'wally' ), '_w_column_styling_meta_box_content', 'page', 'side', 'default' );
    add_meta_box( 'wally_exclude-page', __( 'Göm från navigation', 'wally' ), '_w_exclude_page_meta_box_content', 'page', 'side', 'default' );
}
add_action( 'add_meta_boxes', '_w_register_meta_boxes' );

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function _w_column_styling_meta_box_content( $post ) {

    wp_nonce_field( 'wally_column_styling', 'wally_column_styling_nonce' );
    $choice = get_post_meta($post->ID, 'boxed_columns', true);
    echo '

        <p><strong>Kolumnutseende</strong></p>
        <p>Välj om kolumnerna ska visas som lådor.</p>
        <p>
            <label for="boxed_columns" style="padding-right: 15px">
                <input type="checkbox" name="boxed_columns" id="boxed_columns" value="1"' . (empty($choice) ? '' : ' checked') . '>
                Visa kolumner som lådor
            </label>
        </p>
    ';
}

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function _w_exclude_page_meta_box_content( $post ) {

    wp_nonce_field( 'wally_exclude_page', 'wally_exclude_page_nonce' );
    $choice = get_post_meta($post->ID, 'exclude_page', true);
    echo '

        <p><strong>Göm från navigation</strong></p>
        <p>Välj om sidan ska gömmas från alla navigationsmenyer.</p>
        <p>
            <label for="exclude_page" style="padding-right: 15px">
                <input type="checkbox" name="exclude_page" id="exclude_page" value="1"' . (empty($choice) ? '' : ' checked') . '>
                Göm sida från navigation
            </label>
        </p>
    ';
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function _w_column_styling_meta_box_save( $post_id ) {

    if ( ! isset( $_POST['wally_column_styling_nonce'])) {
        return $post_id;
    }

    $nonce = $_POST['wally_column_styling_nonce'];

    if ( ! wp_verify_nonce( $nonce, 'wally_column_styling')) {
        return $post_id;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ('page' == $_POST['post_type'] ) {
        if (!current_user_can( 'edit_page', $post_id)) {
            return $post_id;
        }
    } else {
        if (!current_user_can( 'edit_post', $post_id)) {
            return $post_id;
        }
    }

    $value = isset($_POST['boxed_columns']) ? 1 : 0;
    update_post_meta( $post_id, 'boxed_columns', $value );

}
add_action( 'save_post', '_w_column_styling_meta_box_save' );

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function _w_exclude_page_meta_box_save( $post_id ) {

    if ( ! isset( $_POST['wally_exclude_page_nonce'])) {
        return $post_id;
    }

    $nonce = $_POST['wally_exclude_page_nonce'];

    if ( ! wp_verify_nonce( $nonce, 'wally_exclude_page')) {
        return $post_id;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ('page' == $_POST['post_type'] ) {
        if (!current_user_can( 'edit_page', $post_id)) {
            return $post_id;
        }
    } else {
        if (!current_user_can( 'edit_post', $post_id)) {
            return $post_id;
        }
    }

    $value = isset($_POST['exclude_page']) ? 1 : 0;
    update_post_meta( $post_id, 'exclude_page', $value );

}
add_action( 'save_post', '_w_exclude_page_meta_box_save' );

add_filter( 'wp_video_shortcode', '_w_video_shortcode', 10, 4);
function _w_video_shortcode($output, $atts, $video, $id) {

    /** @var wpdb WPDB */
    global $wpdb;

    $extensions = (wp_get_video_extensions());

    $urls = [];
    foreach($extensions as $extension) {
        $urls[] = "'" . $atts[$extension] . "'";
    }
    $src = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https:' : 'http:';
    $src .= $atts['src'];
    $urls[] = "'" . $src . "'";

    $urls = join(',', $urls);

    $titles = $wpdb->get_row("SELECT post_title FROM {$wpdb->posts} WHERE guid IN (" . $urls . ") LIMIT 1", ARRAY_N);

    if(!empty($titles)) {
        $title = $titles[0];

        $pq = phpQuery::newDocument($output);
        pq('video')->attr('title', $title)
            ->append(__('Din webbläsare har inte stöd för HTML5-video.', 'wally'))
            ->parent('div')->attr('data-title', $title);

        $html = $pq->htmlOuter();
        phpQuery::unloadDocuments();

        return $html;

    }

    return $output;

}

/**
 * Converts h5 elements to p.preamble elements
 */
function _w_h5_to_preamble($content) {
    return str_replace('<h5>', '<p class="preamble">', str_replace('</h5>', '</p>', $content));
}
add_filter( 'the_content', '_w_h5_to_preamble');

/**
 * Load Roboto font for Wally Admin Screens
 */
add_action( 'admin_enqueue_scripts', 'add_google_font' );
function add_google_font() {
    wp_enqueue_style( 'roboto', '//fonts.googleapis.com/css?family=Roboto:400,500' );
}

/**
 * Remove the "empty" h3 in comments form
 */
function _w_comment_form_before() {
    ob_start();
}
add_action( 'comment_form_before', '_w_comment_form_before' );

function _w_comment_form_after() {
    $html = ob_get_clean();
    $html = preg_replace(
        '/<h3 id="reply-title"(.*)>(.*)<\/h3>/',
        '<p id="reply-title"\1>\2</p>',
        $html
    );
    echo $html;
}
add_action( 'comment_form_after', '_w_comment_form_after' );

add_filter('comment_post_redirect', function($location) {
    return add_query_arg('alert', 'comment_success', $location);
}, 1, 1);

add_action('theme_alerts', '_w_comment_success_alert');
function _w_comment_success_alert() {
    if(!empty($_GET['alert']) && $_GET['alert'] === 'comment_success') {
        echo '<div class="alert alert--success">Kommentar skickad.</div>';
    }
}

/**
 * @param FW_Form $form FW_Form
 */
add_action('fw_form_display_errors_frontend', function($form) {
    echo '<div aria-live="assertive" aria-atomic="true">';
    $errors = $form->get_errors();
    foreach($errors as $nonce => $error) {
        echo '<div class="alert alert--danger" data-input-name="' . $nonce . '">' . $error . '</div>';
    }
    echo '</div>';
});