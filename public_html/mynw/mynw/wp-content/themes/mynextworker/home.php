<?php
/*
Template Name: Home
*/
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="font-family: Rubik, sans-serif">
<?php wp_body_open(); ?>

<?php get_header(); ?>
<style type="text/css">
	.woocommerce div.product {
		margin: 25px !important;
	}
	.why-us-card__icon {
	  	background: url("https://mynetworker.tzlilhosting.com/wp-content/uploads/2021/03/icon.png") no-repeat;
	}
</style>

	<main id="primary" class="main">
		
		<div class="select-packages">

			<div class="select-packages__top">
				<a class="select-packages__button" href="<?php the_field('link_on_packages'); ?>"> 
					<?php the_field('text_link_on_packages'); ?> 
				</a>
				<div class="select-packages__title"><?php the_field('block_1_text_content'); ?></div>
			</div>

			<div class="select-packages__bottom">
				<p class="select-packages__content">
					<?php the_field('block_2_content'); ?>
				</p>
				<h3 class="select-packages__subtitle">
					<?php the_field('block_2_question'); ?>
				</h3>
			</div>
			
			<div class="select-packages__video">
				<?php echo the_field('block_2_video'); ?>
			</div>
			

		</div>

		<div class="why-us">

			<h2 class="why-us__title">
				<?php the_field('why_us_title'); ?>
			</h2>
			
			<?php
				$card_1 = get_field('why_us_card_1'); 
				$card_2 = get_field('why_us_card_2'); 
				$card_3 = get_field('why_us_card_3');
				$card_4 = get_field('why_us_card_4');
			?>

        	<div class="why-us__body">

				<div class="why-us__card why-us-card">

					<div class="why-us-card__icon">
						
					</div>

					<div class="why-us-card__title">
						<?php echo $card_1['why_us_card_1_title'] ?>
					</div>

					<p class="why-us-card__content">
						<?php echo $card_1['why_us_card_1_text'] ?>
					</p>

				</div>

				<div class="why-us__card why-us-card">

					<div class="why-us-card__icon">
						
					</div>

					<div class="why-us-card__title">
						<?php echo $card_2['why_us_card_2_title'] ?>
					</div>

					<p class="why-us-card__content">
						<?php echo $card_2['why_us_card_2_text'] ?>
					</p>

				</div>
				
				<div class="why-us__card why-us-card">

					<div class="why-us-card__icon">
						
					</div>

					<div class="why-us-card__title">
						<?php echo $card_3['why_us_card_3_title'] ?>
					</div>

					<p class="why-us-card__content">
						<?php echo $card_3['why_us_card_3_text'] ?>
					</p>

				</div>

				<div class="why-us__card why-us-card">

					<div class="why-us-card__icon">
						
					</div>

					<div class="why-us-card__title">
						<?php echo $card_4['why_us_card_4_title'] ?>
					</div>

					<p class="why-us-card__content">
						<?php echo $card_4['why_us_card_4_text'] ?>
					</p>

				</div>
						
			</div>

		</div> 

		<div class="registration">
				<div class="registration__text">
					<?php the_field('registration_block_text'); ?>
				</div>
				<a href="<?php the_field('registration_block_link'); ?>" class="registration__button">
					<?php the_field('registration_block_link_text'); ?>
				</a>
		</div>

		<?php echo do_shortcode('[products ids="270, 271, 272, 273"]'); ?>

		<div class="registration-form">
				<h3 class="registration-form__title">
					<?php the_field('registration_form_title'); ?>
				</h3>

				<form action="#" class="registration-form__form">
					<input type="text" class="registration-form__input" 
					placeholder="<?php the_field('registration_form_input_1_placeholder'); ?>" >

					<input type="text" class="registration-form__input" 
					placeholder="<?php the_field('registration_form_input_2_placeholder'); ?>" >

					<input type="text" class="registration-form__input" 
					placeholder="<?php the_field('registration_form_input_3_placeholder'); ?>" >

					<button class="registration-form__button" type="submit">
						<?php the_field('registration_form_button'); ?>
					</button>
				</form>

		</div>

	</main>

<?php get_footer(); ?>


</body>
</html>