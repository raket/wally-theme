<?php

$thumbnail_type = get_post_meta($post->ID, 'thumbnail_type', true);


if(has_post_thumbnail() || $thumbnail_type == 'video'):


	if($thumbnail_type == 'video'):

		$thumbnail_video = get_post_meta($post->ID, 'thumbnail_video', true);

		global $wp_embed;

		$post_embed = $wp_embed->run_shortcode('[embed width="820"]'. $thumbnail_video .'[/embed]');
		echo '<div data-fitvids>' . $post_embed . '</div>' ?>

	<?php else:

		$thumbnail_id = get_post_thumbnail_id();
		$thumbnail_small = wp_get_attachment_image_src( $thumbnail_id, 'large' );
		$thumbnail_small = $thumbnail_small[0];
		$thumbnail_large = wp_get_attachment_image_src( $thumbnail_id, 'full' );
		$thumbnail_large = $thumbnail_large[0];
		$caption = get_post_meta($post->ID, 'thumbnail_text', true) ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : false;
		$display_size = get_post_meta($post->ID, 'thumbnail_size', true) ?>

		<div class="image thumbnail<?php echo $display_size ? ' thumbnail--' . $display_size : '' ?><?php echo is_single() ? ' thumbnail--single' : '' ?>" data-image="<?= $thumbnail_small ?>" style="background-image: url(<?= $thumbnail_small ?>)">
			<img src="<?= $thumbnail_small ?>" alt="<?= $caption ?>">
			<?php if($caption): ?>
				<?php if(!is_single()): ?>
					<div class="image__caption"><?php echo apply_filters('thumbnail_caption', $caption) ?></div>
				<?php endif ?>
			<?php endif ?>

			<?php if(is_page()): ?>
				<div class="image__buttons">
					<button class="image__button make-fullscreen" data-mfp-src="<?= $thumbnail_large ?>"><i class="material-icons" aria-label="<?php _e('Helskärm', 'wally') ?>" aria-hidden="true">&#xE5D0;</i> Visa i helskärm</button>
				</div>
			<?php endif ?>

			<?php if($caption): ?>
				<?php if(is_single()): ?>
					<div class="image__caption image__caption--below"><?php echo apply_filters('thumbnail_caption', $caption) ?></div>
				<?php endif ?>
			<?php endif ?>

		</div>

	<?php endif ?>


<?php endif ?>