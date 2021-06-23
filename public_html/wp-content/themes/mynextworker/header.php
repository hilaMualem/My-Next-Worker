<!DOCTYPE html>
<html <?php language_attributes(); ?>>
 <head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <?php wp_head(); ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
  <header class="header">
    <div class="header-menu__col1">
      <div class="header__burger">
        &#9776;
      </div>
      <?php if (get_current_user_id() !== 0): ?>
        <?php
          $userId = get_current_user_id();
          $user = new WP_User($userId);
        ?>
        <div class="header-user-info">
          <div class="header-user-info__info">
            <img src="<?=get_template_directory_uri()?>/assets/img/avatar-icon.png" class="header-user-info__photo">
            <div>
              <div class="header-user-info__name"><?=$user->nickname?></div>
              <div class="header-user-info__email"><?=$user->user_email?></div>
            </div>
            <div class="header-user-info__menu"><img src="<?=get_template_directory_uri()?>/assets/img/bulits-icon.png">
              <div class="user-popup-menu" style="display: none">
                <div  class="user-popup-item" onclick="window.location.href = '/dashboard'"><?= get_field('private_area_text', 'option'); ?></div>
                <div class="user-popup-item" onclick="window.location.href = '/wp-login.php?action=logout'"><?= get_field('logout_text', 'option'); ?></div>
              </div>
            </div>
          </div>
        </div>
        <img class="header-user__notify-icon" src="<?=get_template_directory_uri()?>/assets/img/notify-icon.png">
      <?php endif; ?>
      <img class="header__country-icon" src="<?=get_template_directory_uri()?>/assets/img/country-icon.png">
      <?php wp_nav_menu( [
    					'theme_location'  => 'menu-1',
    					'menu'            => '', 
    					'container'       => '', 
    			  	'container_class' => '', 
    					'container_id'    => '',
    					'menu_class'      => '', 
    					'menu_id'         => '',
    					'echo'            => true,
    					'before'          => '',
    					'after'           => '',
    					'link_before'     => '',
    					'link_after'      => '',
    					'items_wrap'      => '<ul class="header__list header-menu">%3$s</ul>',
    					'depth'           => 0,
    					'walker'          => '',
    				] ); ?>
    </div>
      
    <div class="header-menu__col2">
      <?php if (get_current_user_id() === 0): ?>
        <a href="/registration" class="header__link header__link--registration">הרשמה למעסיקים</a>
      <?php endif; ?>
      
      <?php if (get_current_user_id() === 0): ?>
        <a href="/login" class="header__link header__link--login">כניסה לאיזור האישי</a>
      <?php endif; ?>
      <?php 
  						$logo = get_field('logo_img', 200);
  						if( !empty( $logo ) ): ?>
  							<a href="<?=site_url()?>">
  								<img class="header__logo" src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" />
  							</a>
  				<?php endif; ?>
      
    </div>

    <div class="header__adaptive-menu" style="display: none;" >
      <?php if (get_current_user_id() !== 0): ?>
        <div class="header-user-info header-user-info--adaptive">
          <div class="header-user-info__info">
            <img src="<?=get_template_directory_uri()?>/assets/img/avatar-icon.png" class="header-user-info__photo">
            <div>
              <div class="header-user-info__name"><?=$user->user_login?></div>
              <div class="header-user-info__email"><?=$user->user_email?></div>
            </div>
            <div class="header-user-info__menu"><img src="<?=get_template_directory_uri()?>/assets/img/bulits-icon.png"></div>
          </div>
        </div>
      <?php endif; ?>
          
    				<?php wp_nav_menu( [
    					'theme_location'  => 'menu-1',
    					'menu'            => '', 
    					'container'       => '', 
    			  	'container_class' => '', 
    					'container_id'    => '',
    					'menu_class'      => '', 
    					'menu_id'         => '',
    					'echo'            => true,
    					'before'          => '',
    					'after'           => '',
    					'link_before'     => '',
    					'link_after'      => '',
    					'items_wrap'      => '<ul class="adaptive-menu__list adaptive-menu">%3$s</ul>',
    					'depth'           => 0,
    					'walker'          => '',
    				] ); ?>
      <a href="<?=get_current_user_id() === 0?'/login':'/dashboard'?>" class="header__link header__link--login adaptive-menu__btn"><?=get_current_user_id() === 0?'כניסה לאיזור האישי':'לאיזור האישי'?></a>
    <?php if (get_current_user_id() === 0): ?>
      <a href="/registration" class="header__link header__link--registration adaptive-menu__btn">הרשמה למעסיקים</a>
    <?php endif; ?>
    
    <?php if (get_current_user_id() > 0): ?>
        <a href="/wp-login.php?action=logout" class="header__link header__link--registration adaptive-menu__btn">להתנתק</a>
      <?php endif; ?>

    </div>
    

  </header>


  <script type="text/javascript">
    const btnMenu = document.querySelector(".header__burger"),
    menu = document.querySelector(".header__adaptive-menu")
    
    btnMenu.addEventListener("click", (function (e) {
      if(menu.style.display === "none") {
        menu.style.display = "flex";
      } else if(menu.style.display === "flex") {
        menu.style.display = "none";
      }
    }));
    
    const userPanelMenu = document.querySelector(".header-user-info__menu"),
    popupUserPanelMenu = document.querySelector('.header-user-info__menu>.user-popup-menu');
    
    userPanelMenu.addEventListener("click", (function (e) {
      if(popupUserPanelMenu.style.display === "none") {
        popupUserPanelMenu.style.display = "block";
      } else if (popupUserPanelMenu.style.display === "block") {
        popupUserPanelMenu.style.display = "none";
      }
    }));
  </script>
</body>

</html>