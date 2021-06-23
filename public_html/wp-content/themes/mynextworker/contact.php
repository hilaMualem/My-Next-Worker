<?php
/*
Template Name: Contact
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
<?php get_header(); ?>
    <div class="contact-page">
        <h1 class="contact__title">יש לכם שאלות אלינו? רק תשאירו לנו הודעה!</h1>

        <section class="contact__body">

            <div class="contact__col1">
            
            <?php echo do_shortcode('[contact-form-7 id="492" html_class="contact__form contact-form" title="' . get_field('home_page_form_title') . '"]'); ?>
              
            </div>

            <div class="contact__col2 contact-box">
                <h2 class="contact-box__title">פרטי התקשרות</h2>
                <span class="contact-box__subtitle">השאירו לנו פרטים והצוות שלנו יחזור אליכם עד 24 שעות.</span>
                <ul class="contact-box__list">
                    <li class="contact-box__list-item">
                        <a href="tel:<?php the_field('phone_number'); ?>" class="contact-box__list-link"><?php the_field('phone_number'); ?></a>
                    </li>
                    <li class="contact-box__list-item">
                        <a href="mailto:<?php the_field('email'); ?>" class="contact-box__list-link"><?php the_field('email'); ?></a>
                    </li>
                    <li class="contact-box__list-item">
                        <span><?php the_field('address'); ?></span>
                    </li>
                    <li class="contact-box__list-item">
                        <a href="https://wa.me/<?php echo str_replace('-', '', get_field('phone_number') ); ?>" class="contact-box__list-link"><?php the_field('phone_number'); ?></a>
                    </li>
                </ul>

                <div class="contact-box__social-icons social-icons">
                    <!-- <a href="<?php /*the_field('instagram_link'); ?>" class="social-icons__icon"><img src="<?php echo get_stylesheet_directory_uri() */?>/assets/img/contact/instagram-icon.png" alt="icon"></a> -->
                    <a href="<?php the_field('facebook_link'); ?>" class="social-icons__icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/contact/facebook-icon.png" alt="icon"></a>
                    <a href="<?php the_field('linkedin_link'); ?>" class="social-icons__icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/contact/linkedin-icon.png" alt="icon"></a>
                </div>

                <div class="contact-box__decor">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/contact/contact-decor.png" alt="">
                </div>
            </div> 

        </section>    

    </div>                                    

    <?php get_footer(); ?>


</body>
</html>