<?php
/*
    Template Name: User
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

    <main class="user">

        <div class="user__block">
			<div class="user__logo">לוגו חברה</div>
			<h1 class="user__title">משתמש לדוגמא</h1>
		</div>

		<div class="user__body">
			<div class="user__company-info company-info" dir="rtl">

				<div class="company-info__column">
					<div class="company-info__address">
						<span>כתובת העסק:</span>
						<span>אליהו נאוי 24, באר שבע</span>
					</div>

					<div class="company-info__employees">
						<div class="company-info__amount-employes">
							3
						</div>
						<span>מס׳ עובדים ועוסקים:</span>
					</div>

					<div class="company-info__send-test-btn">שלח מבחן הערכה לעובד</div>

				</div>

				<div class="company-info__column customer">

					<div class="customer__name">
						<span>לקוח לדוגמא</span>
						<span>שם הלקוח: </span>
					</div>
					
					<div class="customer__area-of-practice">
						<span>מתכנת</span>
						<span>תחום עיסוק:</span>
					</div>
					
					<div class="customer__employees">
						<div class="customer__amount-employees">12</div>
						<span>מס׳ עובדים ועוסקים:</span>
					</div>

					<div class="customer__examined-employees">
						<div class="customer__amount-examined-employees">4</div>
						<span>מספר עובדים שבחנתי:</span>
					</div>

				</div>

			</div>

			<div class="user__container">
				<div class="user__card user-card">
					<div class="user-card__amount">16</div>
					<h3 class="user-card__title">מס׳ עובדים שבחנתי</h3>
				</div>

				<div class="user__card user-card">
					<div class="user-card__amount">16</div>
					<h3 class="user-card__title">מס׳ עובדים שבחנתי</h3>
				</div>

				<div class="user__card user-card">
					<div class="user-card__amount">3</div>
					<h3 class="user-card__title">מבחנים שנשארו בחבילה</h3>
				</div>
			</div>

			<div class="user__examined-employees examined-employees" dir="rtl">
						
				<h2 class="examined-employees__title">רשימת עובדים שבחנתי:</h2>
			
				<div class="examined-employees__list">

					<div class="examined-employees__item examined-employees-item examined-employees-item--completed">
						<div class="examined-employees-item__column">
							<div class="examined-employees-item__date">
							    <span>12/07/2020</span>
								<span>תאריך:</span>	
							</div>

							<div class="examined-employees-item__box">
								<div class="examined-employees-item__num">76</div>
								<div class="examined-employees-item__send-message-btn">שלח/י הודעה</div>
							</div>

						</div>


						<div class="examined-employees-item__column">
							<div class="examined-employees-item__name">
								<span>עובד עובדוס</span>
								<span>שם העובד:</span>
							</div>
							<div class="examined-employees-item__container">
								<div class="examined-employees-item__options-btn">אפשרויות</div>
								<div class="examined-employees-item__results-btn">צפה/י בתוצאות</div>
							</div>
						</div>
					</div>

					<div class="examined-employees__item examined-employees-item">
						<div class="examined-employees-item__column">
							<div class="examined-employees-item__date">
							    <span>12/07/2020</span>
								<span>תאריך:</span>	
							</div>

							<div class="examined-employees-item__box">
								<div class="examined-employees-item__num">76</div>
								<div class="examined-employees-item__send-message-btn">שלח/י הודעה</div>
							</div>

						</div>


						<div class="examined-employees-item__column">
							<div class="examined-employees-item__name">
								<span>עובד עובדוס</span>
								<span>שם העובד:</span>
							</div>
							<div class="examined-employees-item__container">
								<div class="examined-employees-item__options-btn">אפשרויות</div>
								<div class="examined-employees-item__results-btn">ממתין לתשובות</div>
							</div>
						</div>
					</div>

					<div class="examined-employees__item examined-employees-item">
						<div class="examined-employees-item__column">
							<div class="examined-employees-item__date">
							    <span>12/07/2020</span>
								<span>תאריך:</span>	
							</div>

							<div class="examined-employees-item__box">
								<div class="examined-employees-item__num">76</div>
								<div class="examined-employees-item__send-message-btn">שלח/י הודעה</div>
							</div>

						</div>


						<div class="examined-employees-item__column">
							<div class="examined-employees-item__name">
								<span>עובד עובדוס</span>
								<span>שם העובד:</span>
							</div>
							<div class="examined-employees-item__container">
								<div class="examined-employees-item__options-btn">אפשרויות</div>
								<div class="examined-employees-item__results-btn">ממתין לתשובות</div>
							</div>
						</div>
					</div>

					<div class="examined-employees__item examined-employees-item examined-employees-item--completed">
						<div class="examined-employees-item__column">
							<div class="examined-employees-item__date">
							    <span>12/07/2020</span>
								<span>תאריך:</span>	
							</div>

							<div class="examined-employees-item__box">
								<div class="examined-employees-item__num">76</div>
								<div class="examined-employees-item__send-message-btn">שלח/י הודעה</div>
							</div>

						</div>


						<div class="examined-employees-item__column">
							<div class="examined-employees-item__name">
								<span>עובד עובדוס</span>
								<span>שם העובד:</span>
							</div>
							<div class="examined-employees-item__container">
								<div class="examined-employees-item__options-btn">אפשרויות</div>
								<div class="examined-employees-item__results-btn">צפה/י בתוצאות</div>
							</div>
						</div>
					</div>

					<div class="examined-employees__item examined-employees-item examined-employees-item--completed">
						<div class="examined-employees-item__column">
							<div class="examined-employees-item__date">
							    <span>12/07/2020</span>
								<span>תאריך:</span>	
							</div>

							<div class="examined-employees-item__box">
								<div class="examined-employees-item__num">76</div>
								<div class="examined-employees-item__send-message-btn">שלח/י הודעה</div>
							</div>

						</div>


						<div class="examined-employees-item__column">
							<div class="examined-employees-item__name">
								<span>עובד עובדוס</span>
								<span>שם העובד:</span>
							</div>
							<div class="examined-employees-item__container">
								<div class="examined-employees-item__options-btn">אפשרויות</div>
								<div class="examined-employees-item__results-btn">צפה/י בתוצאות</div>
							</div>
						</div>
					</div>

				</div>
						
			</div>

			<div class="user__purchase-container purchase-container">
				<a href="#" class="purchase-container__link">לחץ כאן</a>
				<div class="purchase-container__label">לרכישת חבילת מבחנים</div>
			</div>

		</div>

    </main>

    <?php get_footer(); ?>

</body>
</html>