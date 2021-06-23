<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mynextworker
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="header">
	<div class="header__wrapper">

		<div class="header__top">
			<div class="header__logo">
				<?php 
						$logo = get_field('logo_img', 200);
						if( !empty( $logo ) ): ?>
							<a href="http://mynw/home/">
								<img class="header__logo" src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" />
							</a>
				<?php endif; ?>
			</div>

			<div class="header__nav">
				<a class="header__button" href="<?php the_field('header_link_1', 200); ?>"> <?php the_field('header_text_link_1', 200); ?> </a>
				<a class="header__button" href="<?php the_field('header_link_2', 200); ?>"> <?php the_field('header_text_link_2', 200); ?> </a>
			</div>
		</div>

		<?php $full_screen_img = get_field('full_screen_img'); ?>

		<div class="header__full-screen-body full-screen" style="background: url(<?php echo esc_url($full_screen_img['url']); ?>);background-position-y: -300px;">
				<div class="full-screen__content">
					<h1 class="full-screen__title"><?php the_field('full_screen_title'); ?></h1>
					<h2 class="full-screen__subtitle"><?php the_field('full_screen_subtitle'); ?></h2>
					<a href="<?php the_field('full_screen_link'); ?>" class="full-screen__link">הרשמה למעסיקים</a>
				</div>	
		</div>

	</div>

</header>


