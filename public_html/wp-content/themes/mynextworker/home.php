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
	  	background: url("<?=site_url()?>/wp-content/uploads/2021/03/icon.png") no-repeat;
	}
</style>


    <?php $full_screen_img = get_field('full_screen_img', 200); ?>

		<div class="header__full-screen-body full-screen">
				<div class="full-screen__content">
					<h1 class="full-screen__title"><?php the_field('full_screen_title'); ?></h1>
					<h2 class="full-screen__subtitle" style="font-weight: 400;"><?php the_field('full_screen_subtitle'); ?></h2>
					<div class="full-screen__text"><?php the_field('full_screen_text'); ?></div>
					<a href="<?= the_field('full_screen_link'); ?>" class="full-screen__link">בואו נתחיל</a>
				</div>	
		</div>
     
	<main id="primary" class="main">
		
		<!-- <div class="select-packages">

			<div class="action-field">
				<p class="action-field__content">
					<?php the_field('block_1_text_content'); ?>
				</p>
			</div> -->

		</div>
   
   <div class="select-packages">

			<div class="select-packages__bottom">
				<!--<p class="select-packages__content">
					<?php the_field('block_2_content'); ?>
				</p>
				<h3 class="select-packages__subtitle">
					<?php the_field('block_2_question'); ?>
				</h3>-->
        <?php
  				$card_block_1 = get_field('card_1'); 
  				$card_block_2 = get_field('card_2'); 
  				$card_block_3 = get_field('card_3');
  				$card_block_4 = get_field('card_4');
          
          // var_export($card_block_1);
			  ?>
        <div class="full-scrin-block">
          <div class="full-scrin-block__wrapper">
            <div class="full-scrin-block__image-wrapper"><img src="<?=$card_block_1['card_1_icon']['sizes']['shop_thumbnail']?>"/></div>
            <p class="full-scrin-block__text"><?=$card_block_1['card_1_text']?></p>
          </div>
          
          <div class="full-scrin-block__wrapper">
            <div class="full-scrin-block__image-wrapper"><img src="<?=$card_block_2['card_2_icon']['sizes']['shop_thumbnail']?>"/></div>
            <p class="full-scrin-block__text"><?=$card_block_2['card_2_text']?></p>
          </div>
          
          <div class="full-scrin-block__wrapper">
            <div class="full-scrin-block__image-wrapper"><img src="<?=$card_block_3['card_3_icon']['sizes']['shop_thumbnail']?>"/></div>
            <p class="full-scrin-block__text"><?=$card_block_3['card_3_text']?></p>
          </div>
          
          <div class="full-scrin-block__wrapper">
            <div class="full-scrin-block__image-wrapper"><img src="<?=$card_block_4['card_4_icon']['sizes']['shop_thumbnail']?>"/></div>
            <p class="full-scrin-block__text"><?=$card_block_4['card_4_text']?></p>
          </div>
        </div>
			</div>
			
			<div class="select-packages__video" id="work">
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

		<!--<div class="registration">
				<div class="registration__text">
					<?php the_field('registration_block_text'); ?>
				</div>
				<a href="<?php the_field('registration_block_link'); ?>" class="registration__button">
					<?php the_field('registration_block_link_text'); ?>
				</a>
		</div> -->

		<div class="registration-form">
   
				<h3 class="registration-form__title">
					<?php the_field('home_page_form_title'); ?>
				</h3>
        
        <?php echo do_shortcode('[contact-form-7 id="' . get_field('home_page_form_id') . '" html_class="registration-form__form" title="' . get_field('home_page_form_title') . '"]'); ?>

		</div>

	</main>

<?php get_footer(); ?>


</body>
</html>