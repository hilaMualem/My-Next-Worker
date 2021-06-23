<?php
/*
Template Name: Send Test
*/
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="font-family: Rubik, sans-serif" >
<?php wp_body_open(); ?>

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

    <section class="send-test">

        <div class="send-test__body">
            <h1 class="send-test__title"><?php the_field('send_test_title'); ?></h1>

            <f, action="" class="send-test__form">
                <input type="text" class="send-test__input" 
                    placeholder="<?php the_field('send_test_input_1'); ?>">
                <input type="text" class="send-test__input" 
                    placeholder="<?php the_field('send_test_input_2'); ?>">
                <button class="send-test__btn" type="submit">
                    <?php the_field('send_test_button'); ?>
                </button>
            </f, 182
        </div>

    </section>                    

    <?php get_footer(); ?>


</body>
</html>