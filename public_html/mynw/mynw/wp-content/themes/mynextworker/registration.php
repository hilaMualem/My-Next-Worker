<?php
/*
Template Name: Registration
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

    <section class="registration-page">

        <h1 class="registration-page__title">
            <?php the_field('registration_page_title'); ?>
        </h1>

        <form action="#" class="registration-page__form">

            <span class="registration-page__label">
                <?php the_field('registration_page_label_1'); ?>
            </span>

            <input type="text" class="registration-page__input" 
                placeholder="<?php the_field('registration_page_input_1'); ?>" >
            <input type="text" class="registration-page__input" 
                placeholder="<?php the_field('registration_page_input_2'); ?>" >
            <input type="text" class="registration-page__input" 
                placeholder="<?php the_field('registration_page_input_3'); ?>" >
            <input type="text" class="registration-page__input" 
                placeholder="<?php the_field('registration_page_input_4'); ?>" >
            <input type="text" class="registration-page__input" 
                placeholder="<?php the_field('registration_page_input_5'); ?>" >
            <input type="text" class="registration-page__input" required
                placeholder="<?php the_field('registration_page_input_6'); ?>" >
            <input type="text" class="registration-page__input" 
                placeholder="<?php the_field('registration_page_input_7'); ?>" >
            <input type="text" class="registration-page__input" 
                placeholder="<?php the_field('registration_page_input_8', 43); ?>" >

            <input type="text" class="registration-page__input registration-page__input--full-width" 
                placeholder="<?php the_field('registration_page_input_9'); ?>" >

            <span class="registration-page__label">
                <?php the_field('registration_page_label_2'); ?>
            </span>

            <?php
                $radio_labels_1 = get_field('registration_page_radio_labels_1');
                $radio_labels_2 = get_field('registration_page_radio_labels_2');
            ?>
            
            <label class="registration-page__radio-label" dir="rtl">
                <input type="radio" name="group1" class="registration-page__radio-btn">
                <?php echo $radio_labels_1['registration_page_radio_label_1'] ?>
            </label>

            <label class="registration-page__radio-label" dir="rtl">
                <input type="radio" name="group1" class="registration-page__radio-btn" checked>
                <?php echo $radio_labels_1['registration_page_radio_label_2'] ?>
            </label>

            <label class="registration-page__radio-label" dir="rtl">
                <input type="radio" name="group1" class="registration-page__radio-btn">
                <?php echo $radio_labels_1['registration_page_radio_label_3'] ?>
            </label>

            <label class="registration-page__radio-label" dir="rtl">
                <input type="radio" name="group1" class="registration-page__radio-btn">
                <?php echo $radio_labels_1['registration_page_radio_label_4'] ?>
            </label>

            <label class="registration-page__radio-label" dir="rtl">
                <input type="radio" name="group1" class="registration-page__radio-btn">
                <?php echo $radio_labels_1['registration_page_radio_label_5'] ?>
            </label>

            <span class="registration-page__label">
                <?php the_field('registration_page_label_3'); ?>
            </span>

            <label class="registration-page__radio-label" dir="rtl">
                    <input type="radio" name="group2" class="registration-page__radio-btn">
                    <?php echo $radio_labels_2['registration_page_radio_label_6'] ?>
            </label>

            <label class="registration-page__radio-label" dir="rtl">
                    <input type="radio" name="group2" class="registration-page__radio-btn" checked>
                    <?php echo $radio_labels_2['registration_page_radio_label_7'] ?>
            </label>

            <label class="registration-page__radio-label" dir="rtl">
                    <input type="radio" name="group2" class="registration-page__radio-btn">
                    <?php echo $radio_labels_2['registration_page_radio_label_8'] ?>
            </label>

            <label class="registration-page__radio-label" dir="rtl">
                    <input type="radio" name="group2" class="registration-page__radio-btn">
                    <?php echo $radio_labels_2['registration_page_radio_label_9'] ?>
            </label>

            <span class="registration-page__label">
                <?php the_field('registration_page_label_4'); ?>
            </span>

            <div class="registration-page__warning">
                <?php the_field ('registration_page_text_warning') ?>
            </div>

            <div class="registration-page__file-body">
                <label class="registration-page__file-label">
                    <span>בחירת קובץ</span>
                    <input type="file" class="registration-page__file">
                </label>
            </div>

            <button type="submit" class="registration-page__submit-btn">
                <?php the_field('registration_page_text_btn'); ?>
            </button>

        </form>

    </section>

    <?php get_footer(); ?>

<script>
    let input = document.querySelector('.registration-page__file');
    
    let label = input.previousElementSibling;
      
    input.addEventListener('change', function (e) {
        let countFiles = '';
        if (this.files && this.files.length >= 1)
            countFiles = this.files.length;
    
        if (countFiles) {
            label.innerText = 'בחירת קובץ (' + countFiles + ')';
        }
                
        else {
            label.innerText = 'בחירת קובץ';
        }
    });

</script>

</body>
</html>