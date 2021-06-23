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

    <?php get_header(); ?>

    <main class="user" id="user-cabinet">
        <?php 
              $userId = get_current_user_id();
              $user = new WP_User($userId);
              
              // $user_meta = get_user_meta($userId, 'data', false)[0];
              // $user_meta = json_decode($user_meta, false);
              
              $logo = get_user_meta($userId, 'logo', false)[0];
              $phone = get_user_meta($userId, 'phone', false)[0];
              $bussinessType = get_user_meta($userId, 'bussinessType', false)[0];
              $address = get_user_meta($userId, 'address', false)[0];
              $question1 = get_user_meta($userId, 'question1', false)[0];
              $question2 = get_user_meta($userId, 'question2', false)[0];
               
  
              $table_name = $wpdb->prefix . 'exam_results';
          
              global $wpdb;
          
              $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE user_id = " . get_current_user_id());
          
          // var_dump($results);
          
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
        <div class="user__block">
			<div class="user__logo">
        <?php
                if(isset($logo) && $logo !== ''){
                  echo "<img src='" . $logo . "'>";
                }else{
                  echo "לוגו חברה";
                }
          ?>
      </div>
			<h1 class="user__title"><?=$user->nickname?></h1>
		</div>

		<div class="user__body">
			<div class="user__company-info company-info">

				<div class="company-info__column">
					<div class="company-info__address">
						<span>כתובת העסק:</span>
						<span><?=$address?></span>
					</div>

				<!--	<div class="company-info__employees">
						<div class="company-info__amount-employes">
							<?=$user_meta->workersCount?>
						</div>
						<span>מס׳ עובדים ועוסקים:</span>
					</div> -->

					<div class="company-info__send-test-btn" v-on:click="redirectSendExam()">שלח מבחן הערכה לעובד</div>

				</div>

				<div class="company-info__column customer">

					<div class="customer__name">
               <span>שם הלקוח: </span>
						<span> <?=$user->nickname?> </span>
						
					</div>
					
					<div class="customer__area-of-practice">
               <span>תחום עיסוק:</span>
						    <span><?=$bussinessType?></span>
						
					</div>
					
					<div class="customer__employees">
						<div class="customer__amount-employees">12</div>
						<span>מס׳ עובדים ועוסקים:</span>
					</div>

					<div class="customer__examined-employees">
						<div class="customer__amount-examined-employees"><?= count($results) ?></div>
						<span>מספר עובדים שבחנתי:</span>
					</div>

				</div>

			</div>

			<div class="user__container">
				<div class="user__card user-card">
					<div class="user-card__amount"><?= count($results) ?></div>
					<h3 class="user-card__title">מס׳ עובדים שבחנתי</h3>
				</div>

				<div class="user__card user-card">
					<div class="user-card__amount"><?= count($results) ?></div>
					<h3 class="user-card__title">מס׳ עובדים שבחנתי</h3>
				</div>

				<div class="user__card user-card">
					<div class="user-card__amount"><?=isset($user_meta->exam_count)?$user_meta->exam_count:0?></div>
					<h3 class="user-card__title">מבחנים שנשארו בחבילה</h3>
				</div>
			</div>

			<div class="user__examined-employees examined-employees">
						
				<h2 class="examined-employees__title">רשימת עובדים שבחנתי:</h2>
			
      
      
      
      
				<div class="examined-employees__list">
          <?php foreach($results as $key => $val): ?>
                <div class="examined-employees__item examined-employees-item <?=($val->finished == 1?'examined-employees-item--completed':'')?>">
      						<div class="examined-employees-item__column">
      							<div class="examined-employees-item__date">
                         
  							      <span><?=$val->insert_date?></span>  <!--12/07/2020-->
      								<span>תאריך:</span>	
      							</div>
      
      							<div class="examined-employees-item__box">
      								<div class="examined-employees-item__num"><?=($val->finished == 1?calculateScore($val->results):'-')?></div>
      								<div class="examined-employees-item__send-message-btn">שלח/י הודעה</div>
      							</div>
      
      						</div>
      
      
      						<div class="examined-employees-item__column">
      							<div class="examined-employees-item__name">
      								<span><?=$val->worker_name?></span>
      								<span>שם העובד:</span>
      							</div>
      							<div class="examined-employees-item__container">
      								<div class="examined-employees-item__options-btn">אפשרויות</div>
                      <?= $val->finished == 1?'<a href="' . site_url() . '/results?uniqe_id=' . $val->uniqe_id . '">':'' ?>
      								  <div class="examined-employees-item__results-btn">צפה/י בתוצאות</div>
                      <?= $val->finished == 1?'</a>':'' ?>
      							</div>
      						</div>
      					</div>
                
          <?php endforeach;?>

				</div>
						
			</div>

			<div class="user__purchase-container purchase-container">
				<a href="#" class="purchase-container__link">לחץ כאן</a>
				<div class="purchase-container__label">לרכישת חבילת מבחנים</div>
			</div>

		</div>
   
    </main>
    
       <script>
     var app = new Vue({
        el: "#user-cabinet",
        data: {
            
        },
        methods: {
            redirectSendExam() {
              window.location.href='/send-test';
            },
        },
    });
   </script>

    <?php get_footer(); ?>

</body>
</html>