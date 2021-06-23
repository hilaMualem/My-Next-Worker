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

			<?php $links = get_field('useful_links', 202); ?>
			<ul class="footer-column__list">
				<li class="footer-column__item">
					<a href="<?php echo $links['footer_link_1'] ?>" class="footer-column__link">
						<?php echo $links['footer_link_text_1'] ?>
					</a>
				</li>
				<li class="footer-column__item">
					<a href="<?php echo $links['footer_link_2'] ?>" class="footer-column__link">
						<?php echo $links['footer_link_text_2'] ?>
					</a>
				</li>
			</ul>
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
			</div>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
