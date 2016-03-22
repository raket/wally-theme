<?php
    //---------------------------------------------------------------------------------
    //	Clean up WP_head
    //---------------------------------------------------------------------------------
	if(current_theme_supports( 'clean-head' )) {
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		remove_action( 'wp_head', 'noindex', 1 );

		// remove WordPress versions
		function wp_no_generator() {
			return '';
		}

		add_filter( 'the_generator', 'wp_no_generator' );

		// remove injected CSS for recent comments widget
		function remove_wp_widget_recent_comments_style() {
			if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
				remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
			}
		}

		// remove WP version from scripts
		function remove_wp_ver_css_js( $src ) {
			if ( strpos( $src, 'ver=' ) ) {
				$src = remove_query_arg( 'ver', $src );
			}

			return $src;
		}

		function bones_rss_version() {
			return '';
		}

		add_filter( 'style_loader_src', 'remove_wp_ver_css_js', 9999 );
		// remove Wp version from scripts
		add_filter( 'script_loader_src', 'remove_wp_ver_css_js', 9999 );

		add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );
		function remove_jquery_migrate( &$scripts ) {
			if ( ! is_admin() ) {
				$scripts->remove( 'jquery' );
				$scripts->add( 'jquery', false, array( 'jquery-core' ) );
			}
		}
	}

    //---------------------------------------------------------------------------------
    //	Add appropriate classes to Body depending on browser.
    //	Note: Be careful with this on Cached sites.
    //---------------------------------------------------------------------------------
    function browser_body_class($classes) {
        global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

        if($is_lynx) $classes[] = 'lynx';
        elseif($is_gecko) $classes[] = 'gecko';
        elseif($is_opera) $classes[] = 'opera';
        elseif($is_NS4) $classes[] = 'ns4';
        elseif($is_safari) $classes[] = 'safari';
        elseif($is_chrome) $classes[] = 'chrome';
        elseif($is_IE) $classes[] = 'ie';
        else $classes[] = 'unknown';

        return $classes;
    }
    add_filter('body_class','browser_body_class');

    function slug_body_class($classes){
        // Add post/page slug
        if (is_single() || is_page() && !is_front_page()) {
            $classes[] = basename(get_permalink());
        }
        return $classes;
    }
    add_filter('body_class', 'slug_body_class');



    //---------------------------------------------------------------------------------
    //	Better SEO title
    //---------------------------------------------------------------------------------
    add_filter( 'wp_title', 'filter_wp_title' );
    function filter_wp_title( $title ) {
        global $page, $paged;

        if ( is_feed() )
        return $title;

        $site_description = get_bloginfo( 'description' );

        $filtered_title = $title . get_bloginfo( 'name' );
        $filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' | ' . $site_description: '';
        $filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) ) : '';

        return $filtered_title;
        }

        add_filter('post_class','add_worpdresscontent_class',10,1);
        function add_worpdresscontent_class($classes){
        $classes[] = "wordpress-content";
        return $classes;
    }



    //---------------------------------------------------------------------------------
    //	Custom Excerpt
    //	Returns excerpt with given length.
    //---------------------------------------------------------------------------------

    function custom_excerpt($limit) {
        $excerpt = explode(' ', get_the_excerpt(), $limit);
        if (count($excerpt)>=$limit) {
            array_pop($excerpt);
            $readmore_text = _x('Läs mer', 'Nyheter', 'stella');
            $readmore_link = '<a href="' . get_permalink() . '" title="' . get_the_title() . '">'. $readmore_text .' &raquo;</a>';
            $excerpt = implode( " ", $excerpt ).'... ' . $readmore_link;
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
        return $excerpt;
    }


    //---------------------------------------------------------------------------------
    //	Return to home if no search query given
    //---------------------------------------------------------------------------------
	if(current_theme_supports( 'pretty-search' )) {

		function nosearch_request_filter( $query_vars ) {
			if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) && ! is_admin() ) {
				$query_vars['s'] = ' ';
			}

			return $query_vars;
		}

		add_filter( 'request', 'nosearch_request_filter' );


		//---------------------------------------------------------------------------------
		//	Return to home if no search query given
		//---------------------------------------------------------------------------------
		function nice_search_redirect() {
			global $wp_rewrite;
			if ( ! isset( $wp_rewrite ) || ! is_object( $wp_rewrite ) || ! $wp_rewrite->using_permalinks() ) {
				return;
			}

			$search_base = $wp_rewrite->search_base;
			if ( is_search() && ! is_admin() && strpos( $_SERVER['REQUEST_URI'], "/{$search_base}/" ) === false ) {
				wp_redirect( home_url( "/{$search_base}/" . urlencode( get_query_var( 's' ) ) ) );
				exit();
			}
		}

		add_action( 'template_redirect', 'nice_search_redirect' );

	}


    //---------------------------------------------------------------------------------
    //	Use relative URLS instead of default absolute [tiny bit risky]
    //---------------------------------------------------------------------------------
	if(current_theme_supports( 'relative-urls' )){

	    function theme_relative_url($input) {
	        preg_match('|https?://([^/]+)(/.*)|i', $input, $matches);

	        if (!isset($matches[1]) || !isset($matches[2])) {
	            return $input;
	        } elseif (($matches[1] === $_SERVER['SERVER_NAME']) || $matches[1] === $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']) {
	            return wp_make_link_relative($input);
	        } else {
	            return $input;
	        }
	    }

	    function enable_theme_relative_urls() {
	        return !(is_admin() || in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')));
	    }

	    if (enable_theme_relative_urls()) {
		    function add_filters($tags, $function) {
			    foreach($tags as $tag) {
				    add_filter($tag, $function);
			    }
		    }
	        $rel_filters = array(
	            'bloginfo_url',
	            'template_directory_uri',
	            'the_permalink',
	            'wp_list_pages',
	            'wp_list_categories',
	            'soil_wp_nav_menu_item',
	            'the_content_more_link',
	            'the_tags',
	            'get_pagenum_link',
	            'get_comment_link',
	            'month_link',
	            'day_link',
	            'year_link',
	            'tag_link',
	            'the_author_posts_link'
	        );

	        add_filters($rel_filters, 'theme_relative_url');
	    }


		add_filter('image_send_to_editor','image_to_relative',5,8);

		function image_to_relative($html, $id, $caption, $title, $align, $url, $size, $alt)
		{
			$sp = strpos($html,"src=") + 5;
			$ep = strpos($html,"\"",$sp);

			$imageurl = substr($html,$sp,$ep-$sp);

			$relativeurl = str_replace(array("http://"),"",$imageurl);
			$sp = strpos($relativeurl,"/");
			$relativeurl = substr($relativeurl,$sp);

			$html = str_replace($imageurl,$relativeurl,$html);

			return $html;
		}
	}