<?php
/**
 * Fallback template for QR code items without destination.
 *
 * @package Reusable_QR_Codes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" style="max-width: 800px; margin: 50px auto; padding: 20px; text-align: center;">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header" style="margin-bottom: 30px;">
					<h1 class="entry-title" style="font-size: 2.5em; margin-bottom: 10px;">
						<?php the_title(); ?>
					</h1>
				</header>

				<div class="entry-content" style="padding: 40px 20px; background: #f9f9f9; border-radius: 8px; border: 2px dashed #ddd;">
					<div style="font-size: 4em; margin-bottom: 20px;">⚠️</div>

					<h2 style="color: #d63638; margin-bottom: 15px;">
						<?php esc_html_e( 'QR Code Not Configured', 'reusable-qr-codes' ); ?>
					</h2>

					<p style="font-size: 1.2em; color: #666; margin-bottom: 20px;">
						<?php esc_html_e( 'This QR code does not have a destination URL configured yet.', 'reusable-qr-codes' ); ?>
					</p>

					<?php if ( current_user_can( 'edit_post', get_the_ID() ) ) : ?>
						<div style="margin-top: 30px; padding: 20px; background: #fff; border-left: 4px solid #2271b1; text-align: left;">
							<h3 style="margin-top: 0;">
								<?php esc_html_e( 'For Administrators:', 'reusable-qr-codes' ); ?>
							</h3>
							<p>
								<?php esc_html_e( 'You are seeing this message because no destination URL has been set for this QR code.', 'reusable-qr-codes' ); ?>
							</p>
							<p>
								<a href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>" class="button" style="display: inline-block; padding: 10px 20px; background: #2271b1; color: #fff; text-decoration: none; border-radius: 3px;">
									<?php esc_html_e( 'Edit QR Code & Set Destination', 'reusable-qr-codes' ); ?>
								</a>
							</p>
						</div>
					<?php endif; ?>

					<?php if ( get_the_content() ) : ?>
						<div style="margin-top: 30px; padding: 20px; background: #fff; border-radius: 4px; text-align: left;">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>
				</div>

			</article>

		<?php endwhile; ?>

	</main>
</div>

<?php
get_footer();
