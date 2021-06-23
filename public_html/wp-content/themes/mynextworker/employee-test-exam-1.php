
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

<?php get_header(); ?>


  	<?php 
  			$token = $_GET['uniqe_id'];
        
		    $table_name = $wpdb->prefix . 'exam_results';
		    $examData = $wpdb->get_results("SELECT * FROM $table_name WHERE uniqe_id = '$token'");
		    if(is_array($examData) && count($examData) > 0) {
		        $examData = $examData[0];
		        $userMeta = get_user_meta($examData->user_id);
		        if(isset($userMeta['data']) && isset($userMeta['data'][0])){
		            $userMeta['data'][0] = json_decode($userMeta['data'][0]);
		        }
		    }
           
         	 // var_export($userMeta); 
			$amountQuestion = get_field('question_amount', 220);
      $countQuestion = $amountQuestion; 
			$amountQuestionConst = get_field('question_amount', 220);

			$categoriesArr = array();
			$percentageArr = array();
      $percentageData = array();
			
			if( have_rows('add_questions', 220) ):

			    // Loop through rows.
			    while( have_rows('add_questions', 220) ) : the_row();
               $category = get_sub_field('question_category');
               $count = get_sub_field('category_percentage');
               
			        array_push( $categoriesArr, $category->name );
			        array_push( $percentageArr, $count );
              $percentageData[] = Array( 'category_name' => $category->name, 'category_id' => $category->term_id, 'taxonomy' => $category->taxonomy, 'term_taxonomy_id' => $category->term_taxonomy_id, 'count' => $count );               
				// End loop.
			    endwhile;
			endif;
	?>
        <script>
						           window.percentObj = <?php echo json_encode($percentageData)?>;
        </script>

    <main class="employee-test" id="emptest" @click="addAnswer" >

  	<div class="test-start" v-bind:style="{ display: testStartIsVisible, zIndex: zIndexForTestStart }" >
  		<div class="test-start__body">
        
    			<div class="test-start__company-logo">
            		<!-- <img src="<?php/* count($userMeta['data']) > 0?($userMeta['data'][0]->logo?$userMeta['data'][0]->logo:''):''*/?>"> -->
            		<img src="<?php
						if(is_array($examData) && count($examData) > 0)$user_id = $examData[0]->user_id;
						echo get_logo($user_id);?>">
    			</div>
    
    			<h2 class="test-start__title">מזל טוב!</h2>
    			<p class="test-start__info">
    				<span>קיבלת מבחן מהחברה:</span>
    				<span><?=$userMeta['nickname'][0]?></span>
    			</p>
    			<span class="test-start__button">
    				<span class="test-start__button-label" @click.stop="show=!show" >המשך ></span>
    			</span>
  
  		</div>
     
  	</div>
   
   
   <div class="test-start" v-bind:style="{ display: testStartIsVisible, zIndex: zIndexForTestStart }" >
  		<div class="test-start__body" v-if="show">
  
  			<div class="test-start__company-logo">
            <!-- <img src="<?php/* count($userMeta['data']) > 0?($userMeta['data'][0]->logo?$userMeta['data'][0]->logo:''):''*/?>"> -->
            	<img src="<?php
						if(is_array($examData) && count($examData) > 0)$user_id = $examData[0]->user_id;
						echo get_logo($user_id);?>">
  			</div>
  
  			<h2 class="test-start__title">מזל טוב!</h2>
  			<p class="test-start__info">
  				<span>קיבלת מבחן מהחברה:</span>
  				<span><?=$userMeta['nickname'][0]?></span>
  			</p>
  			<span class="test-start__button">
  				<span class="test-start__button-label" @click="show = !show" >המשך ></span>
  			</span>
  
  		</div>
     
       <div class="test-start__body" v-if="!show">
       <form enctype="multipart/form-data" method="post" class="registration-page__form">
            <span class="registration-page__label">
                מילוי פרטים
            </span>
            <input type="text" class="registration-page__input" v-model="userData.name" required placeholder="שם" >
            <input type="number" class="registration-page__input" v-model="userData.age" required placeholder="גיל" >
            
            <input type="text" class="registration-page__input" v-model="userData.city" required placeholder="עיר מגורים" >
           
            <input type="phone" class="registration-page__input"  v-model="userData.phone" required placeholder="טלפון" >
            
            <input type="text" class="registration-page__input registration-page__input--full-width" v-model="userData.address" required placeholder="כתובת" >
            <input type="text" class="registration-page__input registration-page__input--full-width" v-model="userData.freeText" required placeholder="טקסט חופשי" >
            
            <div class="registration-page__file-body">
                <label class="registration-page__file-label">
                    <span>{{ userData.resume.name }} קורות חיים</span>
                    <input type="file" required class="registration-page__file" v-on:change="onFileChange">
                </label>
            </div>

            <span class="test-start__button">
    				  <span class="test-start__button-label" @click="startTest" >התחיל מבחן</span>
    			  </span>
          </form>
       </div>
  	</div>
  
	

			<?php 
				$tempQuestion = 1;
				$delay2 = 150000;
				$zIndex = 1000; 
			?>

			<?php while ($amountQuestion > 0) {
				foreach ($categoriesArr as $index=>$value) { ?>
				
						<?php $the_query = new WP_Query( array(
						'post_type' => 'question',
						'tax_query' => array(
							array(
								'taxonomy' => 'category_question',
								'field'    => 'slug',
								'terms'    => $value,
							)
						)
							) );
              $amountF = round(((int) $countQuestion * (int) $percentageArr[$index])/ 100);
							$amountQuestionInCategory = $the_query->found_posts;
							// $amountF = round($amountQuestionInCategory * $percentageArr[$index] / 100);
               
               
							wp_reset_query();
						?>
	
						<?php $the_query = new WP_Query( array(
							'posts_per_page' => $amountF,
							'post_type' => 'question',
							'orderby' => rand(),
							'tax_query' => array(
								array(
									'taxonomy' => 'category_question',
									'field'    => 'slug',
									'terms'    => $value,
								)
							)
								) );	
						?>
						
						<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
								<?php if($amountQuestion != 0) { ?>
									<test-component
										class="test-item"
										v-bind:content="'<?php echo the_field('question_content', get_the_ID());?>'"
										v-bind:answer1="'<?php echo the_field('question_answer_1', get_the_ID());?>'"
										v-bind:answer2="'<?php echo the_field('question_answer_2', get_the_ID());?>'"
										v-bind:answer3="'<?php echo the_field('question_answer_3', get_the_ID());?>'"
										v-bind:answer4="'<?php echo the_field('question_answer_4', get_the_ID());?>'"
										v-bind:tempquestion="'<?php echo $tempQuestion ?>'"
										v-bind:totalquestions="'<?php echo $amountQuestionConst ?>'"
										v-bind:numzindex="'<?php echo $zIndex ?>'"
										v-bind:tempcategory="'<?php echo $value ?>'"
										v-bind:token="'<?php echo $token ?>'"
										v-bind:categories="'<?php 
											foreach ($categoriesArr as $item) {
												echo $item . " ";
											}
										?>'"
										v-bind:percentage="'<?php 
											foreach ($percentageArr as $item) {
												echo $item . "" . " ";
											}
										?>'"
									></test-component>
								<?php } $amountQuestion--;
										$tempQuestion++;
										
										$delay2 = $delay2 + 150000;
										$zIndex = $zIndex - 10; ?>
						<?php endwhile; ?>
						<?php wp_reset_query(); ?>
	
				<?php } ?>
			<?php } ?>

			
			

   
			<div class="test-finish" style="" >
				<div class="test-finish__body">

					<div class="test-finish__company-logo">
               <img src="<?=count($userMeta['data']) > 0?($userMeta['data'][0]->logo?$userMeta['data'][0]->logo:''):''?>">
					</div>

					<h2 class="test-finish__title">איזה יופי, סיימתם את המבחן!</h2>
					<p class="test-finish__info">
						<span>קיבל את התוצאות</span>
						<span>[ <?=$userMeta['nickname'][0]?> ]</span>
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