<?php
	$facebook = "https://www.facebook.com/sharer/sharer.php?u=" . get_permalink(get_queried_object_id());

	$twitter_href = "https://twitter.com/intent/tweet?text=";
	$twitter_text = "Testing";
	$twitter_link = get_permalink(get_queried_object_id());

	$twitter = $twitter_href . $twitter_text . "%20" . $twitter_link;
?>
		<div class="article-box">
			<div class="article-box__content share">
				<h2 class="share__title">Dela den här sidan</h2>
				<p>
					<a target="_blank" href="<?php echo $facebook ?>" class="button--fb">Dela på Facebook</a>
					<a target="_blank" href="<?php echo $twitter ?>" class="button--twitter">Dela på Twitter</a>
				</p>
			</div>
		</div>