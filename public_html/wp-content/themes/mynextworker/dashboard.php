<?php
/*
Template Name: Dashboard
*/
?>

<?php
  if(!is_user_logged_in()){
    wp_redirect('/');
    die;
  }
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
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
    
    <?php
      $user_id = get_current_user_id();
          
      $table_name = $wpdb->prefix . 'exam_results';
          
      global $wpdb;
      
          
      $full_count_exam = $wpdb->get_results( "SELECT count(1) as count FROM $table_name WHERE user_id = " . get_current_user_id());
      $full_count_exam = $full_count_exam[0]->count;
      
      $finished_count_exam = $wpdb->get_results( "SELECT count(1) as count FROM $table_name WHERE finished=1 AND user_id = " . get_current_user_id());
      $finished_count_exam = $finished_count_exam[0]->count;
    ?>
    
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

    <div class="profile dashboard" id="dashboard">
        <modal-send-test v-bind:show="showSendTestModal" v-bind:exam-id="null" v-on:close-modal="closeModal"></modal-send-test>
        <div class="profile__body">
          <?php 
              $userId = get_current_user_id();
              $user = new WP_User($userId);
              
              // $user_meta = get_user_meta($userId, 'data', false)[0];
              // $user_meta = json_decode($user_meta, false);
              
              // $examList = $wpdb->get_results( "SELECT exam_id, count(1) as makedTimes FROM $table_name WHERE finished = TRUE AND user_id =  " . get_current_user_id() . " GROUP BY exam_id");
              
              
              
              $logo = get_user_meta($userId, 'logo', false)[0];
              $phone = get_user_meta($userId, 'phone', false)[0];
              $bussinessType = get_user_meta($userId, 'bussinessType', false)[0];
              $address = get_user_meta($userId, 'address', false)[0];
              $question1 = get_user_meta($userId, 'question1', false)[0];
              $question2 = get_user_meta($userId, 'question2', false)[0];
              
              // $result = $wpdb->get_results( "Select * from $table_name LIMIT 1");
              
              $endedExam = $wpdb->get_results( "SELECT count(1) as count, MONTH(insert_date) as month, YEAR(insert_date) as year FROM $table_name WHERE finished = TRUE AND user_id =  " . get_current_user_id() . " GROUP BY MONTH(insert_date), YEAR(insert_date) ORDER BY MONTH(insert_date), YEAR(insert_date) DESC LIMIT 7");
              
              $bestWorkers = $wpdb->get_results( "SELECT exam_id, worker_name, score FROM $table_name WHERE finished = TRUE AND user_id =  " . get_current_user_id() . " ORDER BY score DESC LIMIT 10");

              $bestExam = $wpdb->get_results( "SELECT exam_id, count(1) as makedTimes FROM $table_name WHERE finished = TRUE AND user_id =  " . get_current_user_id() . " GROUP BY exam_id");
              $examSum = $wpdb->get_results( "SELECT SUM(a.makedTimes) as examSum FROM (SELECT exam_id, count(1) as makedTimes FROM $table_name WHERE finished = TRUE AND user_id =  " . get_current_user_id() . " GROUP BY exam_id) a");
              $examSum = $examSum[0]->examSum;
              
              $examCountByExam = $wpdb->get_results( "SELECT exam_id, count(1) as makedTimes FROM $table_name WHERE user_id =  " . get_current_user_id() . " GROUP BY exam_id");
              $examAllCount = $wpdb->get_results( "SELECT count(1) as makedTimes FROM $table_name WHERE user_id =  " . get_current_user_id());
              $examAllCount = $examAllCount[0]->makedTimes;
              
              // $examCount = 0;        
              foreach($bestExam as $key => $val){
                $val->percent = $val->makedTimes * 100 / $examSum; 
              }
              
              foreach($examCountByExam as $key => $val){
                $val->percent = $val->makedTimes * 100 / $examAllCount; 
              }
              
              $post_query = array(
                        'numberposts'      => 10000000,
                        'offset'           => 0,
                        'category'         => 0,
                        'orderby'          => 'post_date',
                        'order'            => 'DESC',
                        'author'           => $user->ID,
                        'post_type'        => 'exam',
                        'post_status'      => 'publish',
                        'suppress_filters' => true,
                    );
                    
                    $posts = wp_get_recent_posts($post_query);
                    
                    $post_count = count($posts);
            
             
          ?>
          
          <script>
            var endedExam = <?php echo json_encode($endedExam); ?>;
            var seriasTMP = [{
              name: 'Data',
              data: [],
            }];
            for(var i = 0; i < endedExam.length; i ++) {
              seriasTMP[0].data.push({
                x: endedExam[i].month.toString() + '/' + endedExam[i].year.toString(),
                y: endedExam[i].count
              });
              
            }
            window.barChartData = seriasTMP;
          </script>
          
          <script>
            window.bestWorkers = <?php echo json_encode($bestWorkers); ?>;
            window.examFullList = <?php
              $post_req = array(
                        'numberposts'      => 1000000,
                        'offset'           => 0,
                        'category'         => 0,
                        'orderby'          => 'post_date',
                        'order'            => 'DESC',
                        'author'           => $user_id,
                        'post_type'        => 'exam',
                        'post_status'      => 'publish',
                        'suppress_filters' => true,
                    );
                    
                    $postList = wp_get_recent_posts($post_req);
                    $shortPostList = [];
                    foreach($postList as $key => $val) {
                      $shortPostList[] = ['exam_id' => $val['ID'], 'exam_name' => $val['post_title']];
                    }
                    
                    echo json_encode($shortPostList);
            ?>;
            
            var examCountByExam = <?php echo json_encode($examCountByExam);?>;
            
            var examsCountFirstGraph = [];
            var examsListForFirstGraph = [];
            var examsPercentFirstGraph = [];
            
            for(var i = 0; i < window.examCountByExam.length; i++) {
              var curIndex = window.examFullList.findIndex(function(item) {
                  return item.exam_id === +window.examCountByExam[i].exam_id;
              });
              if (curIndex > -1) {
                examsListForFirstGraph.push(window.examFullList[curIndex].exam_name);
                examsCountFirstGraph.push(+window.examCountByExam[i].makedTimes);
                examsPercentFirstGraph.push(+window.examCountByExam[i].percent)
              }
            }
            
            window.examsListForFirstGraph = examsListForFirstGraph;
            window.examsCountFirstGraph = examsCountFirstGraph;
            window.examsPercentFirstGraph = examsPercentFirstGraph;
            
            
            
            console.log("window.examCountByExam = ", window.examCountByExam);
            
            console.log("window.examFullList = ", window.examFullList);
            window.bestWorkersObj = {};
            
            var examList = [];
            var examCount = [];
            var examColors = [];
            var users = [];
            var index = 0;
            for(var i = 0; i < window.bestWorkers.length; i++) {
              var curIndex = window.examFullList.findIndex(function(item) {
                  return item.exam_id === +window.bestWorkers[i].exam_id;
              });
              index = examList.indexOf(window.examFullList[curIndex].exam_name); 
              if (index > -1) {
                examCount[index] += 1;
                users[index].push(window.bestWorkers[i].worker_name);
              } else {
                examList.push(window.examFullList[curIndex].exam_name);
                examCount.push(1);
                users.push([window.bestWorkers[i].worker_name]);
              }
            }
            window.bestWorkersObj.examList = examList;
            window.bestWorkersObj.examCount = examCount;
            window.bestWorkersObj.users = users;
            window.colors = ['#147AD6', '#79D2DE', '#EC6666', '#EA4DFF', '#6CDB5E', '#CDD5E1', '#FEB019', '#169682', '#E4FCF2', '#775DD0'];
          </script>
          
            <div class="profile__header profile-header">
                <div class="profile-header__col1">
                    <div class="profile-header__photo">
                    <?php 
                        if(isset($logo) && $logo !== ''){
                          echo "<img style='width: 100%;' src='" . $logo . "'>";
                        }else{
                          echo "לוגו חברה";
                        }
                    ?>
                    </div>

                    <div class="profile-header__info">
                        <span class="profile-header__name"><?=$user->nickname?></span>
                        <span class="profile-header__email"><?=$user->user_email?></span>
                    </div>
                </div>
                <div class="profile-header__col2">
                    <a href="/test-builder" class="profile-header__link 
                    <?php 
                    if($post_count >= get_field('purched_test', 'user_'.get_current_user_id())||in_array('past_customer', $user->roles))
                     echo 'disabled'; 
                     else echo '';
                     ?>" >יצירת מבחן</a>
                </div>
            </div>

            <div class="profile__info profile-info">
                <div class="profile-info__col1">
                    <div class="profile-info__item">
                        <span class="profile-info__label">מבחנים בחבילה</span>
                        <span class="profile-info__amount"><?=$post_count > 0?$post_count:0?>/<?=get_field('purched_test', 'user_'.get_current_user_id())?get_field('purched_test', 'user_'.get_current_user_id()):0?></span>
                    </div>
                </div>
                <div class="profile-info__col2">
                    <div class="profile-info__item">
                        <span class="profile-info__label">מבחנים שבוצעו</span>
                        <span class="profile-info__amount"><?=$finished_count_exam?></span>
                    </div>
                    <div class="profile-info__item">
                        <span class="profile-info__label">משרות פתוחות</span>
                        <span class="profile-info__amount"><?=$post_count?></span>
                    </div>
                </div>
            </div>

            <div class="dashboard__charts">
                <div class="dashboard__chart-box dashboard-chart-box" v-if="examsCountFirstGraph.length>0?true:false">
                    <span class="dashboard-chart-box__tilte">מבחנים פעילים</span>
                    <apexchart width="380" :options="chartOptions" :series="examsCountFirstGraph"></apexchart>
                </div>
                <img v-if="!(examsCountFirstGraph.length>0?true:false)" src="<?=get_template_directory_uri()?>/assets/img/3.png">
                <div class="dashboard__chart-box dashboard-chart-box" v-if="bestWorkersObj && bestWorkersObj.examCount.length > 0?true:false">
                    <span class="dashboard-chart-box__tilte">10 העובדים המובילים</span>
                    <apexchart width="380" :options="chartPieOptions" :series="bestWorkersObj.examCount"></apexchart>
                    <!--<div class="chart__decor-line" style="margin-top: 10px;"></div>
                    <div v-for="(user, index) in bestWorkersObj.users" style="display: flex; justify-content: space-around; width: 100%; flex-wrap: wrap;">
                      <div v-for="name in user" style="display: flex; flex-wrap: wrap;">
                        <span style="border: 1px solid; border-radius: 50%; display:inline-block; width: 16px; height: 16px; margin: 3px;"
                              v-bind:style="{'background-color': colors[index], 'border-color': colors[index]}"></span>
                        <span style="display: inline-block;">{{name}}</span>
                      </div>
                    </div>-->
                </div>
                <img v-if="!(bestWorkersObj && bestWorkersObj.examCount.length>0?true:false)" src="<?=get_template_directory_uri()?>/assets/img/2.png">
                <div class="dashboard__chart-box dashboard-chart-box" v-if="barChartData[0].data.length > 0?true:false">
                    <span class="dashboard-chart-box__tilte">ביצוע מבחנים</span>
                    <apexchart height="300" :options="barChartOptions" :series="barChartData"></apexchart>
                </div>
                <img v-if="!(barChartData[0].data.length > 0?true:false)" src="<?=get_template_directory_uri()?>/assets/img/1.png">
            </div>
            
            <div class="all-tests--dashboard">
                <div class="all-tests__header all-tests__header--dashboard">
                    <div>
                        <a href="" @click.prevent="showSendTestModal = true" class="all-tests__link--dashboard">הזמן חבר</a>
                        <a href="/all-tests" class="all-tests__link--dashboard">לכל המבחנים</a>
                    </div>
                    <div>
                        <h1 class="all-tests__title">רשימת מבחנים שנוצרו</h1>    
                    </div>   
                </div> 

                <?php
                    $exam_num = isset($_GET['exam']) && $_GET['exam'] > 0?$_GET['exam']:5;
                    
                    
                    // var_export($post_count);
                    
                    $post_query = array(
                        'numberposts'      => $exam_num,
                        'offset'           => 0,
                        'category'         => 0,
                        'orderby'          => 'post_date',
                        'order'            => 'DESC',
                        'author'           => $user->ID,
                        'post_type'        => 'exam',
                        'post_status'      => 'publish',
                        'suppress_filters' => true,
                    );
                    
                    
                    
                    $posts = wp_get_recent_posts($post_query);
                    
                    $uiData = [];
                    
                    foreach($posts as $key => $post) {
                      $tmp = [];
                      $exam_count = $wpdb->get_results( "SELECT count(1) as count FROM $table_name WHERE user_id = " . get_current_user_id() . " and exam_id = " . $post['ID']);
                      $exam_count = $exam_count[0]->count;
                      
                      $tmp['exam_count'] = $exam_count;
                      $tmp['link'] = '/test-page/?id=' . $post['ID'];
                      $tmp['exam_title'] = $post['post_title'];
                      $date = date_create($post['post_date']); 
                      $tmp['creation_date'] = date_format($date, "d.m.Y");
                      $uiData[] = $tmp;
                    }
                    
                 ?>
                 
                 <script>
                   window.examListData = <?=json_encode($uiData)?>;
                   window.postsCount = +"<?=$post_count?>";
                   console.log(window.examListData);
                 </script>
                
                <div class="all-tests__body">
                      
                    <div class="all-tests__item all-tests-item" v-for="exam in examListData">
                        <div class="all-tests-item__col">
                            <div class="all-tests-item__examiners">
                                נבחנים:
                                <span>{{exam.exam_count}}</span>
                            </div>
                            <a :href="exam.link" class="all-tests-item__link">כניסה למבחן</a>
                        </div>

                        <div class="all-tests-item__col">
                            <div class="all-tests-item__name">{{exam.exam_title}}</div>
                            <div class="all-tests-item__date">
                                תאריך:
                                <span> {{exam.creation_date}}
                                </span> 
                            </div>
                        </div>        
                    </div>

                    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;" v-if="postsCount > examListData.length">
                      <a v-if="!loadingExams" @click.prevent="loadAddExam" href="/dashboard?exam=<?=$exam_num + 5?>" class="all-tests__show-more">טען עוד</a>
                      <div v-if="loadingExams"><div class='myworker-loader'></div></div>
                    </div>
                </div>         

            </div>                                  

            <div class="best-tests__tilte--dashboard">המועמדים המובילים</div>
            
            <div class="best-tests__container">

                   <div class="best-tests__column chart" v-if="bestWorkersObj && bestWorkersObj.examCount.length>0?true:false">
                        <h2 class="chart__title">10 הנבחנים המובילים</h2>

                        <apexchart width="380" :options="chartPieOptions" :series="bestWorkersObj.examCount"></apexchart>
                        <!--<div class="chart__decor-line" style="margin-top: 10px;"></div>
                        <div v-for="(user, index) in bestWorkersObj.users" style="display: flex; justify-content: space-around; width: 100%; flex-wrap: wrap;">
                          <div v-for="name in user" style="display: flex; flex-wrap: wrap;">
                            <span style="border: 1px solid; border-radius: 50%; display:inline-block; width: 16px; height: 16px; margin: 3px;"
                                  v-bind:style="{'background-color': colors[index], 'border-color': colors[index]}"></span>
                            <span style="display: inline-block;">{{name}}</span>
                          </div>
                        </div>-->

                   </div>
                   <img v-if="!(bestWorkersObj && bestWorkersObj.examCount.length>0?true:false)" src="<?=get_template_directory_uri()?>/assets/img/2.png">

                    <?php
                        $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE finished = 1 AND user_id = " . get_current_user_id() . " ORDER BY score DESC LIMIT 10");
                        
                      ?>
                      

                   <div class="best-tests__column best-tests__column--dashboard">
                         <?php foreach($results as $key => $val):?>
                        <div class="best-tests__examinees-card examinees-card examinees-card--dashboard">
                            <a href="/results/?uniqe_id=<?=$val->uniqe_id?>" class="examinees-card__btn">כניסה למבחן</a>
                            <div class="examinees-card__box">
                                <div class="examinees-card__full-name"><?=$val->worker_name?></div>
                                <div class="examinees-card__photo" style="display: flex; justify-content: center;"><img style="width: 50px" src="<?=get_template_directory_uri() . '/assets/img/avatar-icon.png'?>" /></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                   </div>

               </div>

        </div>
    </div>        
                                            

    <?php get_footer(); ?>
    
    <script>
    
    Vue.component('modal-send-test', {
        props: ['show', 'exam-id'],
    
        data: function () {
            return {
                sendEmail: [{mail: "", finished: false, loader: false, disabled: false}],
                copyLinkImg: window.location.origin + '/wp-content/themes/mynextworker/assets/img/add-icon.png',
                linkToExam: window.examLink,
                // copyResult: 
            };
        },
        template: `
              <div v-if="show">
                <div class="shadow-popup" style="width: 100%; height: 100%; background-color: #fff; opacity: 0.8; position: fixed; top: 0; right: 0; z-index: 10;">
                
              </div>
              <div id="send-test-pop-up" class="send-test-pop-up" style="height: 530px;">
                <div class="send-test-pop-up__close-icon" id="send-test-pop-up__close-icon" v-on:click="$emit('close-modal', true)"> X </div>
                
                <img :src="window.location.origin + '/wp-content/themes/mynextworker/assets/img/msg-icon.png'" alt="icon" class="send-test-pop-up__icon">
                <h3 class="send-test-pop-up__title">אהבת את המערכת?</h3>
                <p class="send-test-pop-up__info">באפשרותך לשתף את חבריך ולעזור גם להם לגייס עובדים טובים יותר.</p>
    
    
                <form action="" class="send-test-pop-up__form">
                    <div class="row-wrapper" v-for="(mail, index) in sendEmail">
                        <input type="text" v-model:value="mail.mail" class="send-test-pop-up__input" placeholder="מייל החבר">
                        <div v-if="mail.loader"><div class='myworker-loader-small'></div></div>
                        <button v-bind:disabled="mail.finished" v-if="!mail.loader" @click="sendExam(mail, index)" class="send-test-pop-up__btn" v-bind:class="{ 'send-test-pop-up__btn--sending': !mail.finished }" type="button">
                          {{ mail.finished ? 'נשלח' : 'שליחה' }}
                        </button>
                    </div>
                    
                    <div class="send-test-pop__add-candidate add-candidate">
                        <span class="add-candidate__label">הוספת חבר</span>
                        <img @click="addMail" :src="copyLinkImg" class="add-candidate__icon" alt="icon">
                    </div>
                    
                    <button type="button" v-on:click="$emit('close-modal', true)" class="send-test-pop-up__submit-btn">סיום</button>
                </form>
    
             </div>
              </div>
              
                `,
    
        mounted: function () {
            // this.sourceArr.sort(() => Math.random() - 0.5);
        },
    
        methods: {
          copyLink() {
            this.copyTextToClipboard(this.linkToExam);
          },
          copyTextToClipboard(text) {
            if (!navigator.clipboard) {
              fallbackCopyTextToClipboard(text);
              return;
            }
            navigator.clipboard.writeText(text).then(function() {
              console.log('Async: Copying to clipboard was successful!');
              this.copyResult = true;
            }, function(err) {
              this.copyResult = false;        
              console.error('Async: Could not copy text: ', err);
            });
          },
          addMail() {
            this.sendEmail.push({mail: "", finished: false, loader: false});
          },
          sendExam(obj, i) {
            // console.log(obj);
            // console.log(i);
            // console.log(this.examId);
            obj.loader = true;
            obj.disabled = true;
            var self = this;
            var formData = new FormData();
                formData.append('email', obj.mail);
                formData.append('examId', this.examId);
                
            const requestOptions = {
                                      method: "POST",
                                      body: formData
                                    };
            fetch(window.wp_data.ajax_url + '?action=mynw_send_recommendation', requestOptions)
      	                .then(function (response) {
                                       console.log(response);
                                       obj.loader = false;
                                       obj.finished = true;
                                       return;
                           if(response.ok === true) {
                             window.location = '/dashboard';
                           }
                        });
          }
        }
    
      });
    
    
    
      new Vue({
        el: '#dashboard',
        components: {
          apexchart: VueApexCharts,
        },
        data: {
          loadingExams: false,
          showSendTestModal: false,
          examListData: window.examListData,
          postsCount: window.postsCount,
          barChartData: window.barChartData,
          examsCountFirstGraph: window.examsCountFirstGraph,
          chartColors: window.colors,
          series: [44, 55, 13, 43, 22],
          bestWorkersObj: window.bestWorkersObj,
          chartPieOptions: {
            chart: {
              width: 380,
              type: 'pie',
            },
            colors: window.colors,
            dataLabels: {
              enabled: true,
            },
            labels: window.bestWorkersObj.examList, // this.bestWorkersObj.examList, // ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
            legend: {
              show: true,
              position: "bottom",
            },
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
              }
            }]
          },
          chartOptions: {
            chart: {
              width: 380,
              type: 'donut',
            },
            dataLabels: {
              enabled: true
            },
            // pie: {
            //   customScale: 1.5
            // },
            labels: window.examsListForFirstGraph, // this.bestWorkersObj.examList, // ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
            legend: {
              show: true,
              position: "bottom",
            },
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
              }
            }]
          },
          barChartOptions: {
            chart: {
              width: 380,
              height: 300,
              type: 'bar',
            },
            plotOptions: {
              bar: {
                horizontal: false,
                columnWidth: '10%'
              },
            },
            stroke: {
              width: 0,
            },
            dataLabels: {
              enabled: false
            },
            yaxis: {
              labels: {
                // formatter: function(val) {
                //  return val; // / 1000 + 'K $'
                // }
              }
            },
            fill: {
              opacity: 1,
            },
            xaxis: {
              // type: 'string'
            }
          },
          
        },
        methods: {
          closeModal() {
            this.showSendTestModal = false;
          },
          loadAddExam() {
            this.loadingExams = true;
            var count = this.examListData.length;
            
            fetch(window.wp_data.ajax_url + '?action=mynw_fetch_exams&exam_offset='+count)
	                .then(function(response) {
                     if(response.status != 200) {
                       this.loadingExams = false; 
                     } else {
                       response.json().then(function(data) {
                         this.examListData = this.examListData.concat(data);
                         this.loadingExams = false; 
                         console.log(data);
                       }.bind(this))
                     }
                  }.bind(this));
          }
        }
        
      });
    </script>

</body>
</html>