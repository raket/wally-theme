<header id="site-header" class="site-header">

	<div class="container">
		<div class="row">
			<?php if(has_nav_menu('mobile_primary_navigation')): ?>
				<button class="off-canvas__open">
					<i class="material-icons" aria-label="<?php _e('Meny', 'wally-theme') ?>"
					   aria-hidden="true">menu
					</i>
				</button>
			<?php endif ?>
		</div>
	</div>

	<div class="container" style="position: relative">

		<div class="row">
			<?php $logo = ($logo_img = fw_get_db_customizer_option('logo')) ? $logo_img : false ?>
			<a href="<?php echo esc_url( home_url() ) ?>" class="site-title <?php if ($logo) echo 'has-image' ?>">
				<?php if ($logo): ?>
					<img src="<?php echo make_image($logo['attachment_id'], apply_filters('logotype_width', false), apply_filters('logotype_height', 80), true) ?>"
					     alt="<?php bloginfo('name') ?>"/>
				<?php endif ?>
				<span><?php bloginfo('name') ?></span>
				<p><?php echo apply_filters('wally_header_description', get_bloginfo('description')) ?></p>
			</a>

			<?php if ( fw_get_db_customizer_option('header_setting') == 'horizontal-header' ) : ?>
				<div class="site-header__tools">
					<ul>
						<?php if (Wally_Sitemap::sitemap_exists()): ?>
							<li><a href="<?php echo get_the_permalink(get_page_by_path('sitemap')->ID) ?>"><i
										class="material-icons" aria-label="<?php _e('Karta', 'wally-theme') ?>"
										aria-hidden="true">map</i> <?php _e('Webbplatskarta', 'wally-theme') ?></a></li>
						<?php endif ?>

						<?php if (isset($_COOKIE['wally_contrast']) && $_COOKIE['wally_contrast'] == true) {
							$contrast = true;
						} else {
							$contrast = false;
						} ?>

						<li><a href="<?php echo add_query_arg('toggle_contrast', 1) ?>"><i class="material-icons"
						                                                                   aria-label="<?php echo w_is_contrast() ? __('Minska kontrast', 'wally-theme') : __('Öka kontrast', 'wally-theme') ?>"
						                                                                   aria-hidden="true">tonality</i>
								<span class="increaseContrast"><?php echo w_is_contrast() ? __('Minska kontrast', 'wally-theme') : __('Öka kontrast', 'wally-theme') ?></span></a>
						</li>
					</ul>
				</div>
			<?php endif; ?>
		</div>

	</div>

	<div id="site-navigation" class="navigation site-navigation">
		<div class="container">

			<div class="row">

				<nav class="primary-navigation" role="navigation" aria-label="<?php _e('Huvudmeny', 'wally-theme') ?>">
					<?php if (has_nav_menu('primary_navigation')) {
						echo apply_filters('w_desktop_navigation',
							wp_nav_menu(array(
									'theme_location' => 'primary_navigation',
									'container' => '',
									'echo' => false,
								)
							));


					} ?>
				</nav>

				<?php if ( fw_get_db_customizer_option('header_setting') == 'horizontal-header' ) : ?>
					<div class="search-form">
						<?php get_search_form() ?>
					</div>
				<?php endif; ?>

			</div>

		</div>
	</div>
</header>

<div class="main-content">
	<?php do_action("wally_after_site_header") ?>

	<?php do_action("wally_before_site_content") ?>

	<?php if ( fw_get_db_customizer_option('header_setting') == 'vertical-header' ) : ?>
		<div class="before-main">
			<div class="container">
				<div class="site-header__tools">
					<ul>
						<?php if (Wally_Sitemap::sitemap_exists()): ?>
							<li><a href="<?php echo get_the_permalink(get_page_by_path('sitemap')->ID) ?>"><i
										class="material-icons" aria-label="<?php _e('Karta', 'wally-theme') ?>"
										aria-hidden="true">map</i> <?php _e('Webbplatskarta', 'wally-theme') ?></a></li>
						<?php endif ?>

						<?php if (isset($_COOKIE['wally_contrast']) && $_COOKIE['wally_contrast'] == true) {
							$contrast = true;
						} else {
							$contrast = false;
						} ?>

						<li><a href="<?php echo add_query_arg('toggle_contrast', 1) ?>"><i class="material-icons"
						                                                                   aria-label="<?php echo w_is_contrast() ? __('Minska kontrast', 'wally-theme') : __('Öka kontrast', 'wally-theme') ?>"
						                                                                   aria-hidden="true">tonality</i>
								<span class="increaseContrast"><?php echo w_is_contrast() ? __('Minska kontrast', 'wally-theme') : __('Öka kontrast', 'wally-theme') ?></span></a>
						</li>
					</ul>
					<div class="search-form">
						<?php get_search_form() ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<main class="main" role="main" aria-labelledby="page-title">

		<div class="alert-wrapper">
			<div class="container">
				<?php do_action("wally_theme_alerts") ?>
			</div>
		</div>

		<?php if (function_exists('fw_ext_breadcrumbs')): ?>
			<div class="breadcrumbs-wrapper">
				<div class="container">
					<div class="row">
						<?php fw_ext_breadcrumbs('') ?>
					</div>
				</div>
			</div>
		<?php endif ?>

<?php do_action("wally_prepend_site_content") ?>