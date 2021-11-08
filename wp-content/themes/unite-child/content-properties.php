<?php
/**
 * @package unite-child
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('property-card'); ?>>
	<header class="entry-header page-header">
		<h2 class="property-card__title"><a href="<?php the_permalink(); ?>" class="property-card__title-link" rel="bookmark"><?php the_title(); ?></a></h2>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<!-- Property's info: -->
		<div class="property-card__info">
			<?php if (get_field('area')) : ?>
				<p class="property-card__info-item"><strong>Площадь:</strong> <?php echo get_field('area'); ?> м<sup>2</sup></p>
			<?php endif; ?>

			<?php if (get_field('price')) : ?>
				<p class="property-card__info-item"><strong>Стоимость:</strong> <?php echo get_field('price'); ?> руб.</p>
			<?php endif; ?>

			<?php if (get_field('address')) : ?>
				<p class="property-card__info-item"><strong>Адрес:</strong> <?php echo get_field('address'); ?></p>
			<?php endif; ?>

			<?php if (get_field('living_area')) : ?>
				<p class="property-card__info-item"><strong>Жилая площадь:</strong> <?php echo get_field('living_area'); ?> м<sup>2</sup></p>
			<?php endif; ?>

			<?php if (get_field('floor')) : ?>
				<p class="property-card__info-item"><strong>Этаж:</strong> <?php echo get_field('floor'); ?></p>
			<?php endif; ?>
		</div>
		
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'unite' ), '<footer class="entry-meta"><i class="fa fa-pencil-square-o"></i><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
