<?php

if ( post_password_required() ) {
	return;
}
?>

<?php $is_replying = !empty($_GET['tab']) && $_GET['tab'] === 'writeComment' ? true : false ?>

	<div id="comments" class="comments">
	<a name="kommentarer" class="anchor"></a>
	<h2 class="comments__title"><?php comments_number('Inga kommentarer', 'En kommentar', '% kommentarer' );?> <?php _e('till artikeln') ?></h2>
	<div class="tabs">
		<ul class="tabs__titles" data-tabs role="tablist">
			<li data-tab class="tabs__title<?php echo !$is_replying ? ' is-active' : '' ?>" role="presentation"><a href="#readComments" role="tab" tabindex="0" aria-selected="<?php echo !$is_replying ? 'true' : 'false' ?>" aria-controls="readComments">
					<span><?php echo wp_is_mobile() ? __('Läs', 'wally') : __('Läs kommentarer', 'wally') ?></span>
			</a></li>
			<li data-tab class="tabs__title<?php echo $is_replying ? ' is-active' : '' ?>" role="presentation"><a href="#writeComment" role="tab" tabindex="0" aria-selected="<?php echo $is_replying ? 'true' : 'false' ?>" aria-controls="writeComment">
					<span><?php echo wp_is_mobile() ? __('Skriv', 'wally') : __('Skriv kommentar', 'wally') ?></span>
			</a></li>
		</ul>
		<div class="tabs__panels">
			<section role="tabpanel" aria-hidden="<?php echo $is_replying ? 'true' : 'false' ?>" class="tabs__panel<?php echo !$is_replying ? ' is-active' : '' ?>" id="readComments">

				<?php if(have_comments()) : ?>

					<h3 class="comments__title">
						<?php _e('Kommentarer', 'wally') ?>
					</h3>

					<?php $post_author_name = get_userdata($post->post_author)->user_login ?>
					<ol class="comments__list">

					<?php wp_list_comments(array(
						'callback' => function() use ($post_author_name) { ?>

							<?php
							/**
							 * This is a callback functions which WordPress uses to list each comment
							 */
							?>


								<?php global $comment, $post ?>

								<li id="comment-<?php echo $comment->comment_ID ?>">


									<?php $is_author = $comment->comment_author === $post_author_name ?>
									<div class="comment<?php echo $comment->comment_parent ? ' comment__reply' : '' ?><?php echo $is_author ? ' comment__reply--author' : '' ?>">

										<div class="comment__metadata">
											<div class="comment__image">
												<?php echo get_avatar($comment->comment_author_email) ?>
											</div>
											<div class="comment__author">
												<a href="mailto:<?php echo $comment->comment_author_email ?>">
													<?php echo $comment->comment_author ?>
												</a>
												<br>
												<time>
													<?php echo $comment->comment_date ?>
												</time>
											</div>
										</div>

										<?php $emotion = get_comment_meta($comment->comment_ID, 'emotion', true) ?>

										<?php if($emotion && get_emotion($emotion)): ?>
											<div class="comment__text has-emotion">
												<?php if($comment->comment_content !== $emotion): ?>
													<?php if($is_author) { ?><span class="comment__response__note">Artikelns författare svarar:</span><?php } ?>
													<q><?php echo $comment->comment_content ?></q>
												<?php endif ?>
												<img src="<?php echo get_template_directory_uri() . '/assets/icons/twemojis/' . get_emotion($emotion) . '.svg' ?>" alt="" class="comment__emotion">
											</div>
										<?php else: ?>
											<div class="comment__text">
												<?php if($is_author) { ?><span class="comment__response__note">Artikelns författare svarar:</span><?php } ?>
												<q><?php echo $comment->comment_content ?></q>
											</div>
										<?php endif ?>

										<div class="comment__actions">
											<?php
											$link = sprintf( '<a rel="nofollow" class="comment__actions__reply" href="%s" aria-label="' . __('Svara på kommentar', 'wally') . '">%s</a>',
												esc_url(add_query_arg('replytocom', $comment->comment_ID, get_permalink($post->ID))) . "#" . $comment->comment_ID,
												__('Svara', 'wally')
											);
											echo $link;
											?>
										</div>

									</div>


						<? }
						));

						?>
						<div class="pagination">
							<?php

								$pq = phpQuery::newDocumentHTML(get_the_comments_pagination());
								$list = pq('.nav-links')->wrapInner('<ul class="page-numbers">');

								foreach($list->find('a, span') as $li) {

									$li = pq($li);

									$li->wrap('<li>');
								}

								echo $list->htmlOuter();

								phpquery::unloadDocuments();

							?>
						</div>

				<?php else: ?>

					<p><?php _e('Inga kommentarer funna för detta inlägg') ?></p>

				<?php endif; // have_comments() ?>

			</section>
			<section role="tabpanel" aria-hidden="<?php echo !$is_replying ? 'true' : 'false' ?>" class="tabs__panel<?php echo $is_replying ? ' is-active' : '' ?>" id="writeComment">

				<div class="comment-form">

					<?php if(!comments_open() && post_type_supports( get_post_type(), 'comments')): ?>
						<p class="comment-form__note no-comments"><?php _e( 'Kommentarer är stängda för den här sidan.', 'wally' ); ?></p>
					<?php endif; ?>

					<?php if(comments_open() && post_type_supports(get_post_type(), 'comments')): ?>

					<div class="comment-form__header">
						<h3><?php _e('Skriv kommentar eller välj symbol', 'wally') ?></h3>
					</div>

					<?php

					$commenter = wp_get_current_commenter();
					$required = get_option( 'require_name_email' );
					$aria_required = $required ? 'required aria-required="true"' : '';
					$label_required = $required ? ' form__label--required' : '';

					$comment_args = array(
							'title_reply' => '',
							'comment_notes_before' => __( 'Skriv in ditt namn och din e-postadress', 'wally' ) . ':',
							'logged_in_as' => '<div class="alert alert--info"><p>' . __('Du är inloggad som', 'wally') . ' <strong>' . wp_get_current_user()->display_name . '</strong>.</p><a href="#" class="alert__action">Logga ut</a></div>',
							'comment_field' =>
									'<div class="comment-form__comment form__group">' .
									'<label class="form__label form__label--required" for="commentFormComment">' . __( 'Kommentar', 'wally' ) . ':</label>' .
									'<textarea id="commentFormComment" placeholder="'. __( 'Skriv din kommentar här...', 'wally' ) .'" class="form__control" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>',
							'comment_notes_after' => '',
							'fields' => apply_filters('comment_form_default_fields', array(
											'author' =>
													'<div class="comment-form__author form__group">' . '<label class="form__label' . $label_required . '" for="commentFormAuthor">' . __( 'Namn', 'wally' ) . ':</label><br>' .
													'<input id="commentFormAuthor" class="form__control" placeholder="' . __( 'Fyll i ditt namn', 'wally' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_required . '></div>',
											'email'  =>
													'<div class="comment-form__email form__group">' .
													'<label class="form__label' . $label_required . '" for="commentFormEmail">' . __( 'E-postadress', 'wally' ) . ':</label><br>' .
													'<input class="form__control" id="commentFormEmail" placeholder="' . __( 'Fyll i din e-postadress', 'wally' ) . '" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_required . '></div>',
											'url'    => '' )
							),
							'class_submit' => 'button button--primary'
					);

					comment_form($comment_args);
					?>

				</div>

				<div class="comment-form__preview" id="commentFormPreview">
					<h3><?php _e( 'Så här kommer din kommentar att se ut när du skickat den:', 'wally' ); ?></h3>

					<div class="comment">

						<div class="comment__metadata">
							<div class="comment__image">
							</div>
							<div class="comment__author">
								<a href="mailto:" id="commentFormPreviewAuthor">
									<?php echo is_user_logged_in() ? wp_get_current_user()->display_name : "Förnamn Efternamn" ?>
								</a>
								<br>
								<time id="commentFormPreviewTime">
									<?php echo date(get_option('date_format')) ?>
									<?php echo date(get_option('time_format')) ?>
								</time>
							</div>
						</div>
						<div class="comment__text">
							<q id="commentFormPreviewText">Min kommentar...</q>
							<img src="" id="commentFormPreviewEmotion" class="comment__emotion">
						</div>
					</div>

				</div>
				<?php endif; ?>

			</section>
		</div>
	</div>

</div>