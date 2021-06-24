 <?php
/*
Template Name: About
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
    <section class="about-page">
			<div class="wrapper">
			  <div class="system" style="background: url(<?=get_field('full_screen_img')['url']?>) center;">
				<div class="system_logo" dir="ltr"><?=get_field('full_screen_title')?></div>
				<div class="system_title"><?=get_field('full_screen_subtitle')?></div>
				<div class="system_text"><?=get_field('full_screen_text')?></div>
			  </div>
			</div> 

			<div class="wrapper">
			  <div class="nextgeneration">
				<div class="nextgeneration_title"><?=get_field('nextgeneration_title')?></div>
				<div class="nextgeneration_text"><?=get_field('nextgeneration_text')?></div>
			  </div>
			</div>
      
      <div class="wrapper">
      <div class="piople">
        <div class="piople_img__wr">  
          <img class="piople_img" src="<?=get_field('piople_img')['url']?>" alt="piople">
       </div>

        <div class="piople_descr">
          <div class="piople_title"><?=get_field('piople_title')?></div>
          <div class="piople_text"><?=get_field('piople_text')?></div>
        </div>
      </div>
    </div>
    
    <div class="wrapper">
      <div class="partners">
        <div class="partners_descr">
          <div class="partners_title"><?=get_field('partners_title')?></div>
          <div class="partners_text"><?=get_field('partners_text')?></div>
      </div>
      <div class="partners_img__wr">
        <img class="partners_img" src="<?=get_field('partners_img')['url']?>" alt="hands">
      </div>
    </div> 
    
    <div class="wrapper">
      <div class="professionals">
        <div class="professionals_img__wr" >
          <img class="professionals_img" src="<?=get_field('professionals_img')['url']?>" alt="shine">
        </div>
        <div class="professionals_descr">
          <div class="professionals_title"><?=get_field('professionals_title')?></div>
          <div class="professionals_text"><?=get_field('professionals_text')?></div>
        </div>
      
      </div>
    </div>
    
    <!-- <div class="wrapper">
      <div class="name">
        <div class="name_content">
          <div class="name_descr">
            <div class="name_title">שם היזם</div>
            <div class="name_text">לעזוב ללא שום סיבה, לגיטימי נכון? ​ אבל מה אם מדובר בעובד שזה כבר מקום העבודה החמישי בחודש האחרון שהוא עושה בו את אותו הדבר?</div>
          </div>
          <div class="name_descr">
            <div class="name_title">שם היזם</div>
            <div class="name_text">לעזוב ללא שום סיבה, לגיטימי נכון? ​ אבל מה אם מדובר בעובד שזה כבר מקום העבודה החמישי בחודש האחרון שהוא עושה בו את אותו הדבר?</div>
          </div>
          <div class="name_descr">
            <div class="name_title">שם היזם</div>
            <div class="name_text">לעזוב ללא שום סיבה, לגיטימי נכון? ​ אבל מה אם מדובר בעובד שזה כבר מקום העבודה החמישי בחודש האחרון שהוא עושה בו את אותו הדבר?</div>
          </div>
        </div>
        <div class="name_logo">
          <img src="img/logotype.png" alt="" class="name__logo">
          <img src="img/logotype.png" alt="" class="name__logo">
          <img src="img/logotype.png" alt="" class="name__logo">
          <img src="img/logotype.png" alt="" class="name__logo">
          <img src="img/logotype.png" alt="" class="name__logo">
          <img src="img/logotype.png" alt="" class="name__logo">
          <img src="img/logotype.png" alt="" class="name__logo">
        </div>
      </div>
    </div> -->

    <div class="wrapper">
      <div class="botton">
        <div class="botton_title">גיוס עובדים מעולם לא היה קל ומדויק יותר</div>
        <a href="/registration" class="botton_btn">התחל עכשיו</a>
      </div>
    </div>
    
    
  </section>    
                                 

    <?php get_footer(); ?>


</body>
</html>