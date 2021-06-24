
<?php
/*
    Template Name: Exam
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
        $testData = get_post_meta($post->ID, 'testData');
        $testBuilderQuestionFields = get_post_meta($post->ID, 'testBuilderQuestionFields');
        $questionsCategories = get_post_meta($post->ID, 'questionsCategories');
        
       // var_export($testData);
       // var_export($testBuilderQuestionFields[0]);die;
       // var_export($questionsCategories);die;
       ?> 
       <script> window.testBuilderQuestionFields = <?php echo json_encode($testBuilderQuestionFields[0]); ?>; 
       </script>
       <?php
           if(isset($_GET['uniqe_id'])){
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
           } else {
	           $author_id = get_post_field( 'post_author', get_the_ID() );
	           $userMeta = get_user_meta($author_id);
	           echo "<script> window.showEmail = true</script>";
	           echo "<script> window.postid = " . get_the_ID() . "</script>";
	           if(isset($userMeta['data']) && isset($userMeta['data'][0])){
		           $userMeta['data'][0] = json_decode($userMeta['data'][0]);
	           }
           }
			$amountQuestion = 0; //get_field('question_amount');
      $countQuestion = $amountQuestion;
			$amountQuestionConst = 0; //get_field('question_amount');
			$categoriesArr = array();
			$percentageArr = array();
      $percentageData = array();
			
			if( have_rows('add_questions') ):
          
			    // Loop through rows.
			    while( have_rows('add_questions') ) : the_row();
               $category = get_sub_field('question_category');
               $count = get_sub_field('category_percentage');
               
			        array_push( $categoriesArr, $category->name );
			        array_push( $percentageArr, $count );
              $amountQuestionConst += $count;
              $percentageData[] = Array( 'category_name' => $category->name, 'category_id' => $category->term_id, 'taxonomy' => $category->taxonomy, 'term_taxonomy_id' => $category->term_taxonomy_id, 'count' => $count );               
				// End loop.
			    endwhile;
			endif;
      
      $logo = get_logo($examData->user_id);

	  $user = get_userdata($post->post_author);
	  $table_name = $wpdb->prefix . 'exam_results';
	  $finished_count = $wpdb->get_results( "SELECT count(1) as count FROM $table_name WHERE user_id = " . $user->ID . " and exam_id = " . get_the_ID() . " and finished = TRUE");
	  $finished_count = $finished_count[0]->count;
	  if( in_array( 'past_customer', $user->roles ) || $finished_count >= get_field('purched_send', 'user_'.$user->ID)) $is_valid_to_continue = "false";
	  else $is_valid_to_continue = "true";
	?>
        <script>
			window.percentObj = <?php echo json_encode($percentageData)?>;
        </script>
        
        
    
    <main class="employee-test" id="emptest" @click="addAnswer" >
      <div class="test-shadow-popup" v-bind:style="{ zIndex: testRunnerZIndex }"></div>
  	<div class="test-start" v-bind:style="{ display: testStartIsVisible, zIndex: zIndexForTestStart }" >
  		<div class="test-start__body">
    			<div class="test-start__company-logo">
            <?php echo '<img style="width: 100%;" src="' . $logo . '"/>';?>
    			</div>
    
    			<h2 class="test-start__title">מזל טוב!</h2>
    			<p class="test-start__info">
    				<span>קיבלת מבחן מהחברה:</span>
    				<span><?=$userMeta['nickname'][0]?></span>
    			</p>
    			<span v-if="<?php echo $is_valid_to_continue; ?>" class="test-start__button">
    				<span class="test-start__button-label" @click.stop="show=!show" >המשך ></span>
    			</span>
  
  		</div>
     
  	</div>
   
   
   <div class="test-start" v-bind:style="{ display: testStartIsVisible, zIndex: zIndexForTestStart }" >
  		<div class="test-start__body" v-if="show">
  			<div class="test-start__company-logo">
          <?php echo '<img style="width: 100%;" src="' . $logo . '"/>';?>
  			</div>
  
  			<h2 class="test-start__title">מזל טוב!</h2>
  			<p class="test-start__info">
  				<span>קיבלת מבחן מהחברה:</span>
  				<span><?=$userMeta['nickname'][0]?></span>
  			</p>
  			<span v-if="<?php echo $is_valid_to_continue; ?>" class="test-start__button">
  				<span class="test-start__button-label" @click="show = !show" >המשך ></span>
  			</span>
  
  		</div>
     
       <div class="test-start__body" v-if="!show">
       <form enctype="multipart/form-data" method="post" class="registration-page__form">
            <span class="registration-page__label">
                מילוי פרטים
            </span>
           <div style="display: flex; flex-wrap: wrap;">
               <input type="text" class="registration-page__input" v-model="userData.name" required placeholder="שם פרטי ומשפחה" >
			   <input v-if="testBuilderQuestionFields.address" type="text" class="registration-page__input" v-model="userData.address" required placeholder="כתובת מגורים" >
           		<input v-if="showEmail" type="text" class="registration-page__input" v-model="userData.email" required placeholder="דואר אלקטרוני" >
				<input v-if="testBuilderQuestionFields.phone" type="phone" class="registration-page__input"  v-model="userData.phone" required placeholder="טלפון נייד" >
				<input v-if="testBuilderQuestionFields.experience" type="text" class="registration-page__input"  v-model="userData.experience" required placeholder="מהי השכלתך?" >
            	<input v-if="testBuilderQuestionFields.language" type="text" class="registration-page__input" v-model="userData.language" required placeholder="איזה שפות הינך דובר?" >
            
            	<input v-if="testBuilderQuestionFields.freeText" type="text" class="registration-page__input" v-model="userData.freeText" required placeholder="טקסט חופשי" >
            
            <div style="display: inline-block; width: 50%;" v-if="testBuilderQuestionFields.resumeUploading" class="registration-page__file-body">
                <label class="registration-page__file-label">
                    <span>{{ userData.resume.name }} קורות חיים</span>
                    <input type="file" required class="registration-page__file" v-on:change="onFileChange">
                </label>
            </div>
            
            <div v-for="q in testBuilderQuestionFields.questions" style="display: flex; align-items: start;">
              <input v-if="q.enabled && q.questionType === 'sq'" type="text" class="registration-page__input registration-page__input--full-width" v-model="q.answer" required v-bind:placeholder="q.question" >
              <textarea v-if="q.enabled && q.questionType === 'lq'" type="text" style="max-width: calc(100% - 20px); margin: 0;" class="candidate-selection-form__textarea" v-model="q.answer" required v-bind:placeholder="q.question" >
              </textarea>
              <div v-if="q.enabled && q.questionType === 'aq'">
                <span class="registration-page__label">{{ q.question }}</span>
                <div style="display: flex; flex-direction: column; align-items: start;">
                  <label class=""><input type="radio" name="group1" v-bind:value="q.answer1" class="registration-page__radio-btn" v-model="q.answer">       {{ q.answer1 }}           </label>
                  <label class=""><input type="radio" name="group1" v-bind:value="q.answer2" class="registration-page__radio-btn" v-model="q.answer">       {{ q.answer2 }}           </label>
                  <label class=""><input type="radio" name="group1" v-bind:value="q.answer3" class="registration-page__radio-btn" v-model="q.answer">       {{ q.answer3 }}           </label>
                  <label class=""><input type="radio" name="group1" v-bind:value="q.answer4" class="registration-page__radio-btn" v-model="q.answer">       {{ q.answer4 }}           </label>
                </div>
              </div>
            </div>
           </div>
            <div style="display: flex; align-items: center;">
              <input type="checkbox" v-model="enabled"> <a style="margin-right: 5px;" href="/wp-content/uploads/2021/06/תקנון-הערכת-עובדים.docx">קראתי ואישרתי את תנאי השימוש באתר</a>
            </div>

           <div style="display: flex; align-items: center;">
               <input type="checkbox" v-model="enabled1"> <a style="margin-right: 5px;">אני מאשר/ת שאני עושה את המבחן בעצמי וללא עזרה</a>
           </div>
            
            <span class="test-start__button" v-if="enabled && enabled1">
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
      
      <?php
            
         $totalQuestionCount = 0;
				foreach ($categoriesArr as $index=>$value) {
				
						$the_query = new WP_Query( array(
						'post_type' => 'question',
						'tax_query' => array(
							array(
								'taxonomy' => 'category_question',
								'field'    => 'slug',
								'terms'    => $value,
							)
						)
							) );

              $amountF = $percentageArr[$index] == 0 ? 1000 : $percentageArr[$index];
							$amountQuestionInCategory = $the_query->found_posts;
							
               if($amountF > $amountQuestionInCategory) {
                 $totalQuestionCount += $amountQuestionInCategory;
               } else {
                 $totalQuestionCount += $amountF;
               }
               
               
							wp_reset_query();
       }
                                                              
      ?>
      
			<?php
      
     
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

              $amountF = $percentageArr[$index] == 0?1000:$percentageArr[$index];
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
									<test-component @onzindexchanged="onZindexChanged"
										class="test-item"
										v-bind:content="'<?php echo str_replace( "'", "\\'", htmlspecialchars(get_field('question_content', get_the_ID())));?>'"
										v-bind:answer1="'<?php echo str_replace( "'", "\\'", htmlspecialchars(get_field('question_answer_1', get_the_ID())));?>'"
										v-bind:answer2="'<?php echo str_replace( "'", "\\'", htmlspecialchars(get_field('question_answer_2', get_the_ID())));?>'"
										v-bind:answer3="'<?php echo str_replace( "'", "\\'", htmlspecialchars(get_field('question_answer_3', get_the_ID())));?>'"
										v-bind:answer4="'<?php echo str_replace( "'", "\\'", htmlspecialchars(get_field('question_answer_4', get_the_ID())));?>'"
										v-bind:tempquestion="'<?php echo $tempQuestion ?>'"
										v-bind:totalquestions="'<?php echo $totalQuestionCount ?>'"
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
								<?php 
                    $amountQuestion--;
										$tempQuestion++;
										
										$delay2 = $delay2 + 150000;
										$zIndex = $zIndex - 10; ?>
						<?php endwhile; ?>
						<?php wp_reset_query(); ?>
	
				<?php } ?>
			

			
			

   
			<div class="test-finish" v-bind:style="{ zIndex: <?=$zIndex?> }" >
				<div class="test-finish__body">

					<div class="test-finish__company-logo">
               <?php echo '<img style="width: 100%;" src="' . $logo . '"/>';?>
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