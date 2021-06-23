<?php
/*
Template Name: Test Page
*/
?>

<!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-apexcharts"></script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="font-family: Rubik, sans-serif" >
<?php wp_body_open(); ?>
<script>
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
        )
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
        )
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
        )
    </script>
<?php get_header(); ?>

   <main class="main__wrapper" id="testpage">

       <?php
        echo "<script> window.showSendTestModal = '" . $_GET['modal'] . "' </script>"
       ?>
        
          <modal-send-test v-bind:show="showSendTestModal" v-bind:exam-id="<?=$_GET['id']?>" v-on:close-modal="closeModal"></modal-send-test>
        
        <nav id="navigation-panel" class="navigation-panel">
            <ul class="navigation-panel__list">
                <li class="navigation-panel__item">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/user-icon.png" alt="icon" class="navigation-panel__icon">
                    <a href="/profile" class="navigation-panel__link">פרופיל</a>
                </li>
                <li class="navigation-panel__item">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/list-icon.png" alt="icon" class="navigation-panel__icon">
                    <a href="/all-tests" class="navigation-panel__link">מבחנים</a>
                </li>
                <li class="navigation-panel__item">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/label-icon.png" alt="icon" class="navigation-panel__icon">
                    <a href="/רכישת-חבילות/" class="navigation-panel__link">חבילות</a>
                </li>
            </ul>
    </nav>
        
        <?php
          if(!(isset($_GET['id']) && !empty($_GET['id']))) {
            echo '<script>window.location = "/dashboard"</script>';
            wp_die();
          }
          
          $id = $_GET['id'];
          
          $table_name = $wpdb->prefix . 'exam_results';
          
          global $wpdb;
          
          if(isset($_GET['delete']) && !empty($_GET['delete'])) {
            $results = $wpdb->get_results( "DELETE FROM $table_name WHERE uniqe_id = '" . $_GET['token'] . "' and exam_id = " . $id);
            if(!$userId) {
               echo '<script>window.location = "/test-page?id=' . $id . '"</script>';
               die;
            }
          }
          
          $exam = get_post($id);
          
          $userId = get_current_user_id();
          $user = new WP_User($userId);
              
          $logo = get_user_meta($userId, 'logo', false)[0];
          $phone = get_user_meta($userId, 'phone', false)[0];
          $bussinessType = get_user_meta($userId, 'bussinessType', false)[0];
          $address = get_user_meta($userId, 'address', false)[0];
          $question1 = get_user_meta($userId, 'question1', false)[0];
          $question2 = get_user_meta($userId, 'question2', false)[0];          
          
          $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE user_id = " . get_current_user_id() . " and exam_id = " . $id);
          
          
          $full_count = $wpdb->get_results( "SELECT count(1) as count FROM $table_name WHERE user_id = " . get_current_user_id() . " and exam_id = " . $id);
          $full_count = $full_count[0]->count;
          
          $finished_count = $wpdb->get_results( "SELECT count(1) as count FROM $table_name WHERE user_id = " . get_current_user_id() . " and exam_id = " . $id . " and finished = TRUE");
          $finished_count = $finished_count[0]->count;
          
          $overs_score = $wpdb->get_results( "SELECT count(1) as count FROM $table_name WHERE user_id = " . get_current_user_id() . " and exam_id = " . $id . " and finished = TRUE and score > 56");
          $overs_score = $overs_score[0]->count;
          
          $exam_sended = $wpdb->get_results( "SELECT count(1) as count FROM $table_name WHERE user_id = " . get_current_user_id() . " and exam_id = " . $id);
          $exam_sended = $exam_sended[0]->count;
          
          $top_10 = $wpdb->get_results( "SELECT * FROM $table_name WHERE exam_id = " . $id . " AND finished = 1 AND user_id = " . get_current_user_id() . " ORDER BY score DESC LIMIT 10");
          
          // var_export($top_10);
          
          function calculateScore($result) {
            $result = json_decode($result, true);
            if(is_array($result)) {
              $percObject = $result['percObject'];
              $result = $result['results'];
              // var_export($result); 
              if(is_array($result)){
                $count = count($result);
                $countRight = 0;
                foreach($result as $key => $val) {
                  if($val['answer'] === 1){
                    $countRight ++;
                  }
                }
                return $countRight/$count*100;
              } else {
                return '-';
              }
            } else {
              return '-';
            }
            
            return 76;
          }
          
        ?>
        
        <script>
          window.examLink = "<?=$exam->guid?>";
        </script>
        
       <section class="send_test">
           <div class="send_test__column">
               <a href="#" @click.preventDefault="showSendTestModal = true" class="send_test__btn 
               <?php 
                    if($finished_count >= get_field('purched_send', 'user_'.get_current_user_id())||in_array('past_customer', $user->roles))
                     echo 'disabled'; 
                     else echo '';
                ?>">שליחת מבחן למועמד</a>
           </div>
           <div class="send_test__column">
               <div class="send_test__title"><?=$exam->post_title?></div>
               <div class="send_test__subtitle">
                    <span> <?php     
                                  $date = date_create($exam->post_date);
                                  echo date_format($date, "d.m.Y");
                            ?> </span> 
                   תאריך יצירת מבחן: &nbsp; 
                </div>
           </div>
       </section>
       
       <section class="tests-info" id="chart-dashboard">

           <div class="tests-info__container">
            <div class="tests-info__col tests-info-col">
                <div class="tests-info-col__title">קיבלו ציון עובר</div>
                <div class="tests-info-col__num"><?=$overs_score?></div>
            </div>
            <div class="tests-info__col tests-info-col">
                <div class="tests-info-col__title">מבחנים שבוצעו</div>
                <div class="tests-info-col__num"><?=$finished_count?></div>
            </div>
           </div>
           
            <div class="tests-info__container">
                <div class="tests-info__col tests-info-col">
                    <div class="tests-info-col__title">מבחנים שנשלחו</div>
                    <div class="tests-info-col__num"><?=$full_count?></div>
                </div>
                <div class="tests-info__col tests-info-col">
                    <div class="tests-info-col__title">כמות נבחנים</div>
                    <div class="tests-info-col__num"><?=$exam_sended?></div>
                </div>
            </div>

       </section>
       
       <script>
        
        window.labels = <?php 
             $labelsNames = [];
             foreach($top_10 as $key => $val) {
               $labelsNames[] = $val->worker_name;
             }
             echo json_encode($labelsNames);
        ?>;
        window.series = <?php 
             $labelsNames = [];
             foreach($top_10 as $key => $val) {
               $labelsNames[] = +$val->score;
             }
             echo json_encode($labelsNames);
        ?>; 
      
    
</script>
       
       <div class="tests-wrapper">
           <section class="best-tests">
               <h1 class="best-tests__title">המבחנים הטובים ביותר</h1>
               <div class="best-tests__container">

                   <div class="best-tests__column chart" v-if="series && series.length>0?true:false">
                        <h2 class="chart__title">10 הנבחנים המובילים</h2>
                        <apexchart width="380" :options="chartPieOptions" :series="series"></apexchart>

                   </div>
                    <img v-if="!(series && series.length>0?true:false)" src="<?=get_template_directory_uri()?>/assets/img/2.png">
                   <div class="best-tests__column">
                         
                   <?php foreach($top_10 as $key => $val): ?>
                        <div class="best-tests__examinees-card examinees-card">
                            <a href="/results?uniqe_id=<?=$val->uniqe_id?>" class="examinees-card__btn">כניסה למבחן</a>
                            <div class="examinees-card__line-body">
                                <div class="examinees-card__progress" style="width: <?=$val->score?>%"></div>
                            </div>
                            <div class="examinees-card__percentage"><?=$val->score?></div>
                            <div class="examinees-card__full-name"><?=$val->worker_name?></div>
                            <div class="examinees-card__photo" style="display: flex; justify-content: center;"><img style="width: 100%" src="<?=get_template_directory_uri() . '/assets/img/avatar-icon.png'?>" /></div>
                            
                            
                            
                            
                        </div>
                   <?php endforeach; ?>
                        
                   </div>

               </div>
           </section>

           <section class="examinees-list">
               <h2 class="examinees-list__title">רשימת נבחנים</h2>


                 <?php foreach($results as $key => $val): ?>
                            <div class="examinees-list__item examinee <?=($val->finished == 1?'examined-employees-item--completed':'')?>">
                              
                              <div class="examinee__column">
                                                                              
                                  <a <?=$val->finished != 1?'style="visibility: hidden"':''?> class="examinee__login-btn" href="<?=site_url()?>/results?uniqe_id=<?=$val->uniqe_id?>">כניסה למבחן</a>
                                  
                                  <a href="/test-page?id=<?=$id?>&token=<?=$val->uniqe_id?>&delete=true" class="examinee__delete-btn">מחיקת מועמד</a>                                  
                                  
                                  <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                                  <div class="examinee__date">תאריך: <span><?php 
                                                                                  $date = date_create($val->insert_date);
                                                                                  echo date_format($date, "d.m.Y")
                                                                            ?></span></div>                                  
                                  
                                  
                              </div>
                              
                              <div class="examinee__column">
                                <div class="examinee__percentage"><?=($val->finished == 1?$val->score:'-')?></div>
                                <div class="examinee__full-name"><?=$val->worker_name?></div>
                                <div class="examinees-card__photo" style="display: flex; justify-content: center;"><img style="width: 100%" src="<?=get_template_directory_uri() . '/assets/img/avatar-icon.png'?>" /></div>
                                  
                                
                              </div>
                  					</div>
                <?php endforeach;?>
                

           </section>

           

       </div>
   </main>

    <?php get_footer(); ?>

</body>
</html>