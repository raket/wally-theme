<nav class="internal-navigation" role="navigation" aria-label="<?php _e('Innehåll', 'wally') ?>">
    <h2 class="internal-navigation__title"><?php _e('Innehåll', 'wally') ?></h2>
    <ul class="list-group">
        <li class="list-group__item">
            <a href="#artikel" title="<?php _e('Artikel', 'wally') ?>"><?php _e('Artikel', 'wally') ?></a>
        </li>
        <?php if(!empty(wp_get_post_tags($post->ID))): ?>
        <li class="list-group__item">
            <a href="#taggar" title="<?php _e('Taggar', 'wally') ?>"><?php _e('Taggar', 'wally') ?></a>
        </li>
        <?php endif ?>
        <li class="list-group__item">
            <a href="#kommentarer" title="<?php _e('Kommentarer', 'wally') ?>"><?php _e('Kommentarer', 'wally') ?></a>
        </li>
    </ul>
</nav>
<?php
$facebook = "https://www.facebook.com/sharer/sharer.php?u=" . get_permalink(get_queried_object_id());

$twitter_href = "https://twitter.com/intent/tweet?text=";
$twitter_text = get_the_title(get_queried_object_id());
$twitter_link = get_permalink(get_queried_object_id());

$twitter = $twitter_href . $twitter_text . "%20" . $twitter_link;
?>
<div class="share-sidebar">
    <h2 class="share-sidebar__title"><?php _e('Dela artikeln', 'wally') ?></h2>
    <ul class="share list-group">
        <li class="list-group__item">
            <a target="_blank" href="<?php echo $facebook ?>" class="button button--regular button--fb"><span><img src="<?php echo get_template_directory_uri() ?>/assets/icons/icon-facebook.svg" alt="Ikon för Facebook"> Dela på Facebook</span></a>
        </li>
        <li class="list-group__item">
            <a target="_blank" href="<?php echo $twitter ?>" class="button button--regular button--twitter"><span><img src="<?php echo get_template_directory_uri() ?>/assets/icons/icon-twitter.svg" alt="Ikon för Twitter"> Dela på Twitter</span></a>
        </li>
    </ul>
</div>
