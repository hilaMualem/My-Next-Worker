<?php
/*
    Template Name: Employee Test Exam 1
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

<body <?php body_class(); ?> style="font-family: Rubik, sans-serif">
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

    <main class="employee-test" id="emptest" @click="addAnswer" >

	<div class="test-start" v-bind:style="{ display: testStartIsVisible, zIndex: zIndexForTestStart }" >
		<div class="test-start__body">

			<div class="test-start__company-logo">
			</div>

			<h2 class="test-start__title">מזל טוב!</h2>
			<p class="test-start__info">
				<span>קיבלת מבחן מהחברה:</span>
				<span>קפה נאמן</span>
			</p>
			<span class="test-start__button">
				<span class="test-start__button-label" @click="startTest" >המשך ></span>
			</span>

		</div>
	</div>


	<?php 
			$amountQuestion = get_field('question_amount', 220);
			$amountQuestionConst = get_field('question_amount', 220);
			$categoriesArr = array();

			// if(get_field('exam_1_category_1', 220) == true) {
			// 	array_push($categoriesArr, 'category_1');
			// 	if(get_field('exam_1_category_1_percentage', 220)) {
			// 		$p1 = get_field('exam_1_category_1_percentage', 220);
			// 	}
			// 	else {
			// 		$p1 = 100;
			// 	}
			// }
			// if(get_field('exam_1_category_2', 220) == true) {
			// 	array_push($categoriesArr, 'category_2');
			// 	if(get_field('exam_1_category_2_percentage', 220)) {
			// 		$p2 = get_field('exam_1_category_2_percentage', 220);
			// 	}
			// 	else {
			// 		$p2 = 100;
			// 	}
			// }
			// $percentageArr = array();
			// array_push($percentageArr, $p1, $p2);
			// $tempQuestion = 1;
			if( have_rows('add_questions') ):

			    // Loop through rows.
			    while( have_rows('add_questions') ) : the_row();

			        // Load sub field value.
			        $sub_value = get_sub_field('question_category');
			        echo $sub_value;
			        // Do something...

			    // End loop.
			    endwhile;

			// No value.
			else :
			    echo '--'
			endif;
?>







   
			<div class="test-finish" style="" >
				<div class="test-finish__body">

					<div class="test-finish__company-logo">
					</div>

					<h2 class="test-finish__title">איזה יופי, סיימתם את המבחן!</h2>
					<p class="test-finish__info">
						<span>קיבל את התוצאות</span>
						<span>[קפה סניף באר שבע]</span>
					</p>
					<span class="test-finish__button" >
						<span class="test-finish__button-label" @click="finishTest" >תודה, סיימתי</span>
					</span>

				</div>
			</div>
	
	</main>



    <?php get_footer(); ?>


</body>
</html>