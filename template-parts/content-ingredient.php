<?php
/**
 * The default template for displaying ingredients.
 *
 * @package WordPress
 * @subpackage OneSocial Theme
 * @since OneSocial Theme 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-main">
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'onesocial' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'onesocial' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<div class="row">
				<div class="entry-tags col">
					<?php
					$terms = wp_get_post_tags( get_the_ID() );
					if ( $terms ) {
						?>
						<h3><?php _e( 'Tagged in', 'onesocial' ); ?></h3><?php
						foreach ( $terms as $t ) {
							echo '<a href="' . get_tag_link( $t->term_id ) . '">' . $t->name . '<span>' . $t->count . '</span></a>';
						}
					}
					?>
				</div>

                            <?php if ( get_post_status(get_the_ID()) == 'publish' ) { ?>
				<!-- /.entry-tags -->
				<div class="entry-share col">
					<?php
					if ( function_exists( 'get_simple_likes_button' )  && is_singular( 'post' ) ) {
						echo get_simple_likes_button( get_the_ID() );
					}
					?>

					<ul class="helper-links">

						<?php if ( function_exists( 'sap_get_bookmark_button' ) && is_singular( 'post' ) && is_user_logged_in() ) { ?>
							<li>
								<?php
								$button = sap_get_bookmark_button();

								if ( !empty( $button ) ) {
									echo $button;
								} else {
									?>
									<a id="bookmarkme" href="#siteLoginBox" class="bookmark-it onesocial-login-popup-link">
										<span class="fa bb-helper-icon fa-bookmark-o"></span>
										<span><?php _e( 'Bookmark', 'onesocial' ); ?></span>
									</a><?php
								}
								?>
							</li>
						<?php } ?>

						<?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ?>
							<li>
								<?php ADDTOANY_SHARE_SAVE_KIT( array( 'use_current_page' => true ) ); ?>
							</li><?php
						}
						?>
					</ul>
				</div>
				<!-- /.entry-share -->
                            <?php } ?>
			</div>

			<?php //edit_post_link( __( 'Edit', 'onesocial' ), '<span class="edit-link">', '</span>' );    ?>

		</footer><!-- .entry-meta -->
	</div>
	<!-- /.entry-main -->
</article>