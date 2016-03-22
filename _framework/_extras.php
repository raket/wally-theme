<?php

//---------------------------------------------------------------------------------
//	Clean up menu output
//---------------------------------------------------------------------------------
//	Reduce nav classes, leaving only 'current-menu-item'
function nav_class_filter( $var ) {
    return is_array($var) ? array_intersect($var, array(
	    'current-menu-item',
	    'current-menu-parent',
	    'current-menu-ancestor',
	    'current-page-ancestor',
	    'current-page-parent',
        'menu-item-has-children',
        'current_page_parent'
    )) : '';
}
add_filter('nav_menu_css_class', 'nav_class_filter', 100, 1);
//	Add page slug as nav IDs
function nav_id_filter( $id, $item ) {
    return 'nav-'.cleanname($item->title);
}
add_filter( 'nav_menu_item_id', 'nav_id_filter', 10, 2 );


function cleanname($v) {
    $v = preg_replace('/[^a-zA-Z0-9s]/', '', $v);
    $v = str_replace(' ', '-', $v);
    $v = strtolower($v);
    return $v;
}

add_filter( 'pre_comment_content', 'esc_html' );


//---------------------------------------------------------------------------------
//	Dump'n'Die
//---------------------------------------------------------------------------------

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}