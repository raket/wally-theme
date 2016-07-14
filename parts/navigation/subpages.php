<?php /*
global $post;

$args = array(
	'post_parent'  => $post->ID,
	'post_type'    => 'page',
	'post_status'  => 'publish',
	'order_by'      => 'menu_order',
	'order'     => 'ASC',
	'title_li'     => null
);

// Check if current page has parents
$parents = get_post_ancestors($post);
if($parents) {
	$top_parent = array_pop($parents);
	$args['post_parent'] = $top_parent;
}

$subpages = get_posts($args);
?>

<?php if($subpages): ?>

	<div class="subpages list-group" data-tree>
		<ul class="list-group__list" data-tree-group>

			<?php foreach($subpages as $post): setup_postdata($post) ?>

				<?php $children = get_posts(array(
					'post_parent' => $post->ID,
					'post_type' => 'page'
				)) ?>

				<li class="list-group__item" data-collapsable>

					<a href="<?php the_permalink() ?>" role="link" title="<?php the_title() ?>">
						<?php the_title() ?>
						<?php if($children): ?><button role="button" title="Visa undersidor" data-collapse-trigger></button><?php endif ?>
					</a>

					<?php if($children): ?>
						<ul class="list-group__sublist" data-collapsable-element>
							<?php foreach($children as $child): ?>
							<li class="list-group__subitem"><ul class="children" data-colla></ul><a href="<?php echo get_the_permalink($child) ?>" role="link" title="<?php echo get_the_title($child) ?>"><?php echo get_the_title($child) ?></a>
								<?php endforeach ?>
						</ul>
					<?php endif ?>

				</li>
			<?php endforeach ?>

		</ul>
	</div>

	<?php wp_reset_postdata(); endif ?> */
?>
<nav class="subpages" role="navigation" aria-label="<?php _e('Undersidor', 'wally') ?>">
	<ul class="list-group">
		<?php

		// Do new query to get the pages to exclude
		$exclude_query = new WP_Query(array(
			'fields' => 'ids',
			'post_type' => 'page',
			'meta_query' => array(
				array(
					'key'     => 'exclude_page',
					'value'   => TRUE
				)
			)
		));
		$excludes = $exclude_query->posts;

		$args = array(
			'depth'        => 1300,
			'echo'         => 0,
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'sort_column'  => 'menu_order, post_title',
			'title_li'     => false,
			'exclude'      => join(',', $excludes)
		);
		echo apply_filters('w_list_group', wp_list_pages($args)) ?>
	</ul>
</nav>

