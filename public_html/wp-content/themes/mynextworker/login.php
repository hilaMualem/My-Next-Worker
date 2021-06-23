
<?php
/*
Template Name: Login
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
    <!--<?php get_header(); ?>-->

<section class="login">

        <div class="login__col">
            <div class="login__content">
                <h1 class="login__title"><?php the_field('login_title'); ?></h1>
                <p class="login__text"><?php the_field('login_text'); ?></p>
                <span class="login__question"><?php the_field('login_question'); ?></span>
                <a href="https://mynetworker.tzlilhosting.com/registration/" class="login__content-link">להרשמה</a>
            </div>
        </div>

        <div class="login__col">
            <form action="<?=site_url() . '/wp-login.php'?>" method="post" class="login__form">

                <div class="login__logo">
                    <?php 
                            $logo = get_field('logo_img', 200);
                            if( !empty( $logo ) ): ?>
                                <a href="<?=site_url()?>">
                                    <img class="header__logo" src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" />
                                </a>
                    <?php endif; ?>   
                </div>

                <input type="text" name="log" class="login__input" placeholder="דוא״ל" required >
                <input type="password" name="pwd" class="login__input" placeholder="סיסמא" required >

                <button class="login__btn" type="submit">כניסה</button>

                <div class="login__links">
                    <a href="<?=site_url()?>" class="login__link">בחזרה לאתר</a>
                    <a href="<?= site_url() . '/my-account/lost-password/' ?>" class="login__link">שחכת סיסמא?</a>
                    <a href="https://mynetworker.tzlilhosting.com/registration/" class="login__link login__link--registration">אין לך חשבון? הרשם עכשיו!</a>
                </div>

            </form>
        </div>


    </section>

    <!--<?php get_footer(); ?> -->


</body>
</html>