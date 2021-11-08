<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package unite-child
 */

get_header(); ?>

	<div id="primary" class="content-area col-sm-12 col-md-8">
		<main id="main" class="site-main" role="main">

		<?php if (false !== ($property_list = get_transient( 'property_list' ))) : ?>
		
			<?php echo $property_list; ?>

		<?php else : ?>

			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Format name) and that will be used instead.
						*/
						ob_start();
						get_template_part( 'content', 'properties' );
						$property_list .= ob_get_clean();
					?>

				<?php endwhile; ?>

				<?php
					echo $property_list;
					set_transient( 'property_list', $property_list, 12 * HOUR_IN_SECONDS );
				?>

				<?php unite_paging_nav(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<div class="home-widget-area row">
		<div class="col-sm-6 col-md-4 home-widget">
			<?php if( is_active_sidebar('home1') ) dynamic_sidebar( 'home1' ); ?>
		</div>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
