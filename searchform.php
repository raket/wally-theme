<?php
    global $wp_search_forms;
    if(!isset($wp_search_forms)) {
        $wp_search_forms = 0;
    }
    $wp_search_forms++;
?>

<form method="get" action="<?php bloginfo('url'); ?>/" class="search__form" role="search">
    <input class="search__input" type="search" name="s" id="search-form-<?php echo $wp_search_forms ?>" placeholder="<?php _e("Sök på webbplatsen") ?>" aria-haspopup="true" aria-live="polite" aria-relevant="additions" aria-atomic="false" value="<?php the_search_query() ?>" accesskey="4">
    <label class="screen-reader-text" for="search-form-<?php echo $wp_search_forms ?>"><?php _e("Sök på webbplatsen") ?></label>
    <span role="status" class="accessibility__alert" id="searchAlert-<?php echo $wp_search_forms ?>" aria-live="polite"></span>
    <button class="search__submit button" type="submit"><?php _e("Sök") ?></button>
</form>