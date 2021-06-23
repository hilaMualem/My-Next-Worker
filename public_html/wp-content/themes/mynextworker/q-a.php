<?php
/*
Template Name: QA
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
  <?php get_header(); ?>
<body <?php body_class(); ?> style="font-family: Rubik, sans-serif" >
<?php wp_body_open(); ?>

<div class="qa" id="tabs">
        <div class="qa__body">
            <h1 class="qa__title"><?=get_the_title()?></h1>
            <p class="qa__subtitle"><?= get_field('content'); ?></p>

            <?php while( have_rows('add_faq_questions') ): the_row();?>
                    
                    <div class="qa__item qa-item" >
                        <span class="qa-item__title"><?=the_sub_field('faq_question');?></span>
                    </div>
                    
                    <div class="qa__tab-content qa__tab-content--active">
                        <p class="qa__tab-text"><?=the_sub_field('answer')?></p>
                    </div> 
               
            <?php endwhile; ?>
        </div>

        <h2 class="qa__contact-title">יש לכם שאלה שלא מופיעה כאן?</h2>
        <p class="qa__contact-subtitle">תרגישו חופשי לשאול כל שאלה ונחזור אליכם בהקדם עם תשובה :)</p>

<!--[contact-form-7 id="542" title="תשובות ושאלות צור קשר"]-->
        <section class="contact__body contact__body--qa">
          <div class="contact__col1">
                <form action="" class="contact__form contact-form">
                  <?php echo do_shortcode('[contact-form-7 id="542" html_class="contact__form contact-form" title="' . get_field('home_page_form_title') . '"]'); ?>
                </form>
          </div>  
        </section>


        <!--  <section class="contact__body contact__body--qa">

            <div class="contact__col1">
                <form action="" class="contact__form contact-form">
                    <div class="contact-form__row">
                        <label class="contact-form__label contact-form__label--name">
                            <span>שם פרטי</span>
                            <input type="text" class="contact-form__input" placeholder="ג׳וני">
                        </label>
                        <label class="contact-form__label">
                            <span>שם משפחה</span>
                            <input type="text" class="contact-form__input">
                        </label>
                    </div>
                    
                    <div class="contact-form__row">
                        <label class="contact-form__label contact-form__label--tel">
                            <span>טלפון</span>
                            <input type="tel" class="contact-form__input" placeholder="544409777 972+">
                        </label>
                        <label class="contact-form__label">
                            <span>דוא״ל</span>
                            <input type="email" class="contact-form__input" placeholder="mailledugma@gmail.com">
                        </label>
                    </div>

                    <div class="contact-form__row contact-form__row--radio-btns">
                        <div class="contact-form__row-title">באיזה נושא הפניה?</div>
                        <div class="contact-form__radio-btns">
                            <label class="contact-form__label-radio">
                                <input name="theme" type="radio" class="contact-form__input-radio">
                                <span>רכישה/שדרוג חבילה</span>
                            </label>

                            <label class="contact-form__label-radio">
                                <input name="theme" type="radio" class="contact-form__input-radio">
                                <span>שירות לקוחות</span>
                            </label>

                            <label class="contact-form__label-radio">
                                <input name="theme" type="radio" class="contact-form__input-radio">
                                <span>תמיכה טכנית</span>
                            </label>

                            <label class="contact-form__label-radio">
                                <input name="theme" type="radio" class="contact-form__input-radio">
                                <span>אחר</span>
                            </label>
                        </div>
                    </div>

                    <div class="contact-form__row">
                        <label class="contact-form__label">
                            <span>הודעה</span>
                            <textarea name="message" class="contact-form__input contact-form__textarea" placeholder="כתוב כאן את ההודעה שלך…"></textarea>
                        </label>
                    </div>

                    <div class="contact-form__row contact-form__row--btn qa-row-btn">
                        <button type="submit" class="contact-form__submit-btn">שליחת פניה ></button>
                    </div>

                </form>        
            </div>  

        </section>  --> 
    </div>    
   
<?php get_footer(); ?>

<script>
    // Tabs
let tab; // заголовок вкладки
let tabContent; // блок содержащий контент вкладки

window.onload = function () {
    tabContent = document.getElementsByClassName('qa__tab-content');
    tab = document.getElementsByClassName('qa__item qa-item');
    hideTabsContent(1);  // передаем 1 для того чтобы 0 елемент остался на странице
}


function hideTabsContent(a) {
    for (let i = a; i < tabContent.length; i++) {
        tabContent[i].classList.remove('qa__tab-content--active');
        tabContent[i].classList.add("qa__tab-content--no-active");
    }
}

document.getElementById('tabs').onclick = function (event) {
    let target = event.target;
    if (target.className == 'qa__item qa-item' || target.parentElement.className == 'qa__item qa-item') {
        for (let i = 0; i < tab.length; i++) {
            if (target == tab[i] || target.parentElement == tab[i]) {
                showTabsContent(i);  // как только узнаем на какой tab был клик, останавливаем цыкл и передаем значение в функцию
                break;
            }
        }
    }
}


function showTabsContent(b) {
        hideTabsContent(0);  // скрываем все tabContents 
        tabContent[b].classList.remove('qa__tab-content--no-active');
        tabContent[b].classList.add('qa__tab-content--active');
}
</script>

</body>
</html>