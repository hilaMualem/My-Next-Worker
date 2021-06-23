<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mynextworker
 */

?>

<footer class="footer">
	<div class="footer__body">

		<div class="footer__column footer-column">
			<span class="footer-column__logo">mynextworker.</span>
			<p class="footer-column__content">
				<?php the_field('footer_content', 202); ?>
			</p>
		</div>

		<div class="footer__column footer-column">
			<h3 class="footer-column__subtitle">לינקים שימושיים</h3>
      
      <?php wp_nav_menu( [
	                    'theme_location' => 'menu-1',
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
    					'items_wrap'      => '<ul class="footer-column__list">%3$s</ul>',
    					'depth'           => 0,
    					'walker'          => '',
    				] ); ?>
      
      
      
  	</div>
   
   <div class="footer__column footer-column">
			<h3 class="footer-column__subtitle">המערכת</h3>

	   <?php wp_nav_menu( [
		   'theme_location' => 'menu-2',
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
		   'items_wrap'      => '<ul class="footer-column__list">%3$s</ul>',
		   'depth'           => 0,
		   'walker'          => '',
	   ] ); ?>
      
  	</div>
   
     

		<div class="footer__column footer-column">
			<h3 class="footer-column__subtitle">פרטים ליצירת קשר</h3>
			<div class="footer-column__contacts contacts">
				<span class="contacts__label">טלפון</span>
				<a href="tel:<?php the_field('telephone', 202); ?>" class="contacts__tel">
					<?php the_field('telephone_label', 202); ?>
				</a>

				<span class="contacts__label">מייל</span>
				<a href="mailto:<?php the_field('email', 202); ?>" class="contacts__email">
					<?php the_field('email', 202); ?>
				</a>
				<div class="contact-box__social-icons social-icons">
                    <!-- <a href="<?php /*the_field('instagram'); ?>" class="social-icons__icon"><img src="<?php echo get_stylesheet_directory_uri()*/ ?>/assets/img/contact/instegram.svg" alt="icon"></a> -->
                    <a href="<?php the_field('facebook'); ?>" class="social-icons__icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/contact/f.svg" alt="icon"></a>
                    <a href="<?php the_field('linkedin'); ?>" class="social-icons__icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/contact/in.svg" alt="icon"></a>
                </div>
			</div>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/60c1de1465b7290ac6353008/1f7qkn0es';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
</body>
</html>
