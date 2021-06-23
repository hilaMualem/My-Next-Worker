<?php
/*
Template Name: Results
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
    <?php $token = $_GET['uniqe_id'];
          $table_name = $wpdb->prefix . 'exam_results';
          $examData = $wpdb->get_results("SELECT * FROM $table_name WHERE uniqe_id = '$token'");
          if(is_array($examData) && count($examData) > 0) {
            $examData = $examData[0];
            $userMeta = get_user_meta($examData->user_id);
            $logo = get_user_meta($examData->user_id, 'logo', false)[0];
            $phone = get_user_meta($examData->user_id, 'phone', false)[0];
            $bussinessType = get_user_meta($examData->user_id, 'bussinessType', false)[0];
            $address = get_user_meta($examData->user_id, 'address', false)[0];
            $question1 = get_user_meta($examData->user_id, 'question1', false)[0];
            $question2 = get_user_meta($examData->user_id, 'question2', false)[0];
            
            $examData->results = json_decode($examData->results);
            $percentObject = $examData->results->percObject;
            $examResults = $examData->results->results;
            $userData =  $examData->results->userData;
          }
          
          
           
          // var_export($userData); 
          
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
          }
          
          function calculateCategoryScore($categoryName, $result) {
            if(is_array($result)) {
              $currentTest = [];
              foreach($result as $key => $val) {
                if($categoryName === $val->category){
                 $currentTest[] = $val;
                }
              }
              $questionCount = count($currentTest);
              $rightAnswers = 0;
              
              foreach($currentTest as $key => $val) {
                 if($val->answer === 1){
                   $rightAnswers ++;
                 }
              }
                return $rightAnswers/$questionCount*100;
            }
          }
          
          $user = get_user_meta(get_current_user_id());
          // var_export($data);
    ?>
    

    <div class="results" id="results">

        <div class="results__top">
        
            <div class="test-start__company-logo">
              <!-- <img style="width: 100%;" src="<?php/* echo $logo*/?>"> -->
              <img src="<?php
						    if(is_array($examData) && count($examData) > 0)$user_id = $examData[0]->user_id;
						    echo get_logo($user_id);?>" style="width: 100%;">
            </div>
            
            <h1 class="results__title">תוצאות מבחן התאמה</h1>
        </div>

        <div class="results__info results-info">
            <!--<?php var_export($examData); ?>-->
            <div class="results-info__column">
                <div class="results-info__item">
                    <span>שם מועמד:</span>
                    <b><?=$examData->worker_name?></b>
                </div>
                <div class="results-info__item">
                    <span>אימייל:</span>
                    <b><?=$examData->worker_mail?></b>
                </div>
                <div class="results-info__item">
                    <span>טלפון:</span>
                    <b><?=$userData->phone?></b>
                </div>
                <div class="results-info__item">
                    <span>גיל:</span>
                    <b><?=$userData->age?></b>
                </div>
                <div class="results-info__item">
                    <span>כתובת:</span>
                    <b><?=$userData->address?></b>
                </div>
                <div class="results-info__item">
                    <span>טקסט חופשי:</span>
                    <b><?=$userData->freeText?></b>
                </div>
                <?php foreach($userData->customQuestions->questions as $key => $val): ?>
                  <div class="results-info__item">
                      <span><?=$val->question?>:</span>
                      <b><?=$val->answer?></b>
                  </div>
                <?php endforeach; ?>
            </div>
            <?php if($userData->resume):?>
            <div class="results-info__column">
              <a href="<?=$userData->resume?>">
                <div class="results-info__btn">צפה/י בקו״ח</div>
              </a>
            </div>
          <?php endif; ?>
        </div>

        <div class="results__gradation gradation">
            <h2 class="gradation__title">מקרא ציונים</h2>
            <div class="gradation__btns">
                <div class="gradation__btn gradation__btn--low">נמוך</div>
                <div class="gradation__btn gradation__btn--good">טוב</div>
                <div class="gradation__btn gradation__btn--very-good">טוב מאוד</div>
                <div class="gradation__btn gradation__btn--excellent">מצויין</div>
            </div>
        </div>

        <div class="results__block">
            <?php foreach($percentObject as $key => $val): ?>
              <?php if(calculateCategoryScore($val->category_name, $examResults) >= 0):?>
                <div class="results__item">
                    <div class="results__persentage">
                        <b><?= calculateCategoryScore($val->category_name, $examResults) ?>%</b>
                    </div>
                    <div class="results__progres">
                        <div class="results__progres-interior" style="width: <?=calculateCategoryScore($val->category_name, $examResults)?>%"></div>
                    </div>
                    <div class="results__label"><?=$val->category_name?></div>
                </div>
              <?php endif;?>              
            <?php endforeach;?>
        </div>

        <div class="results__summary summary">
            <div class="summary__body">
                <div class="summary__item low-result"></div>
                <div class="summary__item good-result"></div>
                <div class="summary__item veryGood-result"></div>
                <div class="summary__item excellent-result"></div>
            </div>
            <h2 class="summary__title">סיכום</h2>
        </div>

        <div class="results__details details">
            <div class="details__column">
                <div class="details__num-body">
                    <span class="details__num"><?=calculateScore($examResults)?></span>
                </div>
                <div class="details__write-message-btn">שלח/י הודעה</div>
            </div>

            <div class="details__column details-content">
            
                <b><?=$examData->worker_name?></b>
                <span>ציון משוכלל -</span>
                
            </div>
        </div>

        <div class="results__buttons">
            <div class="results__found-invalid-btn" v-on:click="sendMailToCandidate('notok')">שלח הודעה - נמצא לא מתאים</div>
            <div class="results__set-time-btn" v-on:click="sendMailToCandidate('ok')">הזמן מועמד לראיון אישי</div>
        </div>

    </div>

                       

    <?php get_footer(); ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let htmlCollection = document.getElementsByClassName("results__progres-interior");

        let excellentResultTag = document.querySelector(".excellent-result");
        let veryGoodResultTag = document.querySelector(".veryGood-result");
        let goodResultTag = document.querySelector(".good-result");
        let lowResultTag = document.querySelector(".low-result");

        amountCategories = 0;
        amountCategoriesPersentage = 0;

        let arrItems = Array.from(htmlCollection);

        let excellent = 0, veryGood = 0, good = 0, low = 0;

        arrItems.forEach((item) => {
            amountCategories++;
            amountCategoriesPersentage += parseInt(item.style.width);
            if(parseInt(item.style.width) > 0) {
                item.style.backgroundColor = "#d00008";
                low++;
            }

            if(parseInt(item.style.width) > 25) {
                item.style.backgroundColor = "#ffce00";
                good++;
            }

            if(parseInt(item.style.width) > 50) {
                item.style.backgroundColor = "#ff9d00";
                veryGood++;
            }

            if(parseInt(item.style.width) > 75) {
                item.style.backgroundColor = "#11c177";
                excellent++;
            }
            
        })

        let totalResult = excellent + veryGood + good + low;

        excellentResultTag.style.width = (excellent * 100) / totalResult + "%";
        veryGoodResultTag.style.width = (veryGood * 100) / totalResult + "%";
        goodResultTag.style.width = (good * 100) / totalResult + "%";
        lowResultTag.style.width = (low * 100) / totalResult + "%";

        let averageResult = document.querySelector(".details__num")
        averageResult.innerText = Math.round(amountCategoriesPersentage / amountCategories)
    })
    
    var test = new Vue({
      el: "#results",
      data: {
          working: false
      },
      methods: {
           sendMailToCandidate(emailType) {
            // if(!this.working) {
                this.working = true;
                // debugger;
                const requestOptions = {
                                          method: "GET",
                                        };
                                        
                fetch(window.wp_data.ajax_url + '?action=mynw_send_result_to_candidate&email_type=' + emailType + '&uniqe_id=' + '<?=$_GET['uniqe_id']?>', requestOptions)
      	                .then(function (response) {
                           if(response.ok === true) {
                             // alert(response);
                             window.location.href = '/dashboard';
                           }
                        });
              }
           // }
    	}
    });


</script>

</body>
</html>