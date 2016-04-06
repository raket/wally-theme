</main>
</div> <?php // div.container ?>


<?php
	$wsdt = get_option('wally_settings_contact_details');
	$wssm = get_option('wally_settings_social_media');
?>

<div class="overlay" role="presentation" id="overlay"></div>

<?php if (has_nav_menu('mobile_primary_navigation')): ?>
	<div class="off-canvas" role="menu" id="off-canvas">
		<nav class="off-canvas__navigation" role="navigation" aria-label="<?php _e('Huvudmeny', 'wally') ?>">
			<header class="off-canvas__navigation__header">
				<h3>Meny</h3>
				<button class="off-canvas__close" tabindex="-1">Stäng</button>
			</header>

			<?php echo apply_filters('w_mobile_navigation',
				wp_nav_menu(array(
						'theme_location' => 'mobile_primary_navigation',
						'container' => '',
						'echo' => false,
					)
				)) ?>
		</nav>
	</div>
<?php endif; ?>

<footer id="site-footer" class="site-footer" role="contentinfo" aria-label="<?php _e('Sidfot', 'wally') ?>">
	<div class="container">
		<div class="row">
			<div class="site-footer__section" data-match-height>
				<div class="site-footer__subsection">

					<?php if(!empty($wsdt)): ?>

					<h2><?php _e('Kontakt', 'wally') ?></h2>
					<div class="menu__list">
						<?php echo @$wsdt['phone'] ? '<span class="menu__item"><a href="tel:' . $wsdt['phone'] . '"> ' . $wsdt['phone'] . '</a></span>' : '' ?>
						<?php echo @$wsdt['email'] ? '<span class="menu__item"><a href="mailto:' . $wsdt['email'] . '"> ' . $wsdt['email'] . '</a></span>' : '' ?>
						<?php echo @$wsdt['fax'] ? '<span class="menu__item"><a href="#">' . $wsdt['fax'] . '</a></span>' : '' ?>
						<?php echo @$wsdt['address'] ? '<span class="menu__item">' . $wsdt['address'] . '</a></span>' : '' ?>

						<?php if($wsdt['zip_code'] || $wsdt['city']): ?>
							<span class="menu__item">
								<?php echo $wsdt['zip_code'] ? $wsdt['zip_code'] : '' ?>
								<?php echo $wsdt['city'] ? $wsdt['city'] : '' ?>
							</span>
						<?php endif ?>
					</div>

					<?php endif ?>
					<?php if(!empty($wssm)): ?>

					<h2><?php _e('Sociala Medier', 'wally') ?></h2>
					<ul class="menu__list horizontal">
						<?php echo @$wssm['facebook'] ? '<li><a target="_blank" href="'.$wssm['facebook'].'"><span><img src="'.get_stylesheet_directory_uri().'/assets/icons/icon-facebook.svg" alt="Ikon för Facebook"> Facebook</span></a></li>' : '' ?>
						<?php echo @$wssm['twitter'] ? '<li><a target="_blank" href="'.$wssm['twitter'].'"><span><img src="'.get_stylesheet_directory_uri().'/assets/icons/icon-twitter.svg" alt="Ikon för Twitter"> Twitter</span></a></li>' : '' ?>
						<?php echo @$wssm['youtube'] ? '<li><a target="_blank" href="'.$wssm['youtube'].'"><span><img src="'.get_stylesheet_directory_uri().'/assets/icons/icon-youtube.svg" alt="Ikon för Youtube"> Youtube</span></a></li>' : '' ?>
						<?php echo @$wssm['bambuser'] ? '<li><a target="_blank" href="'.$wssm['bambuser'].'"><span><img src="'.get_stylesheet_directory_uri().'/assets/icons/icon-bambuser.svg" alt="Ikon för Bambuser"> Bambuser</span></a></li>' : '' ?>
					</ul>

					<?php endif ?>

				</div>
				<?php if(!empty($wsdt['website_description'])): ?>
					<div class="site-footer__subsection">
						<h2><?php _e('Om denna webbplats', 'wally') ?></h2>
						<p><?php echo @$wsdt['website_description'] ?></p>
					</div>
				<?php endif ?>
			</div>
			<div class="site-footer__section site-footer__section__last-child" data-match-height>
				<h2><?php _e('Hjälpmedel', 'wally') ?></h2>
				<ul class="menu__list">

					<?php if(Wally_Sitemap::sitemap_exists()): ?>
						<li class="menu__item"><a href="<?php echo get_the_permalink(get_page_by_path('sitemap')->ID) ?>"><i class="material-icons" aria-label="<?php _e('Karta', 'wally') ?>" aria-hidden="true">map</i> <?php _e('Webbplatskarta', 'wally') ?></a></li>
					<?php endif ?>

					<?php if(isset($_COOKIE['wally_contrast']) && $_COOKIE['wally_contrast'] == true) {
						$contrast = true;
					} else {
						$contrast = false;
					} ?>

					<li class="menu__item"><a href="<?php echo add_query_arg('toggle_contrast', 1) ?>"><i class="material-icons" aria-label="<?php _e('Kontrast', 'wally') ?>" aria-hidden="true">tonality</i>
							<?php echo $contrast ? __('Minska kontrast', 'wally') : __('Öka kontrast', 'wally') ?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer>

<!-- WP footer -->
<?php wp_footer(); ?>
</body>
</html>
