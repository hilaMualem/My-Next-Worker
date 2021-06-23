<?php
/*
Template Name: Profile New
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

    <?php
              $user_id = get_current_user_id();
              
              $table_name = $wpdb->prefix . 'exam_results';
                  
              global $wpdb;
              
              $full_count_exam = $wpdb->get_results( "SELECT count(1) as count FROM $table_name WHERE user_id = " . get_current_user_id());
              $full_count_exam = $full_count_exam[0]->count;
    
              $userId = get_current_user_id();
              $user = new WP_User($userId);
              $logo = get_user_meta($userId, 'logo', false)[0];
              $phone = get_user_meta($userId, 'phone', false)[0];
              $bussinessType = get_user_meta($userId, 'bussinessType', false)[0];
              $address = get_user_meta($userId, 'address', false)[0];
              $question1 = get_user_meta($userId, 'question1', false)[0];
              $question2 = get_user_meta($userId, 'question2', false)[0];
              $firstname = get_user_meta($userId, 'firstname', false)[0];
              $nickname = get_user_meta($userId, 'nickname', false)[0];
              
              
              $post_query = array(
                        'numberposts'      => 10000000,
                        'offset'           => 0,
                        'category'         => 0,
                        'orderby'          => 'post_date',
                        'order'            => 'DESC',
                        'author'           => $userId,
                        'post_type'        => 'exam',
                        'post_status'      => 'publish',
                        'suppress_filters' => true,
                    );
                    
                    $posts = wp_get_recent_posts($post_query);
                    
                    $post_count = count($posts);
              
          ?>
          
          <script>
            window.firstName = "<?=$firstname?>";
            window.nickName = "<?=$nickname?>";
            window.email = "<?=$user->user_email?>";
            window.logo = "<?=$logo?>";
          </script>


    <div class="profile" id="profile">
        <div class="profile__body">
                        
            <h1 class="profile__title">עריכת פרופיל</h1>
            <input type="file" ref="file" v-on:change="showPhotos" style="display: none" />
            <div class="profile__header profile-header">
                <div class="profile-header__col1">
                    <div class="profile-header__photo">
                      <img style="height: 100%" src="<?=get_template_directory_uri() . '/assets/img/avatar-icon.png'?>" />
                    </div>

                    <div class="profile-header__info">
                        <span class="profile-header__name"><?=$user->nickname?></span>
                        <span class="profile-header__email"><?=$user->user_email?></span>
                    </div>
                </div>
                <div class="profile-header__col2">
                   <!-- <a href="#" class="profile-header__link">הזמן חבר</a> -->
                </div>
            </div>

            <div class="profile__info profile-info">
                
                <div class="profile-info__col1">
                    <div class="profile-info__item">
                        <span class="profile-info__label">מבחנים בחבילה</span>
                        <span class="profile-info__amount"><?=$post_count?>/<?=get_field('purched_test', 'user_'.get_current_user_id())?></span>
                    </div>
                </div>
                <div class="profile-info__col2">
                    <div class="profile-info__item">
                        <span class="profile-info__label">מבחנים שבוצעו</span>
                        <span class="profile-info__amount"><?=$full_count_exam?></span>
                    </div>
                    <div class="profile-info__item">
                        <span class="profile-info__label">משרות פתוחות</span>
                        <span class="profile-info__amount"><?=$post_count?></span>
                    </div>
                </div>
            </div>

            <div class="profile__detail profile-detail">

                <div class="profile-detail__col1">
                    <form action="" class="profile-detail__form profile-detail-form">
                        <div class="profile-detail-form__col1">
                            <label class="profile-detail-form__label">
                                <span>שם העסק</span>
                                <input type="text" class="profile-detail-form__input" v-model="nickName" value="<?=$nickname?>" >
                            </label>
                            <label class="profile-detail-form__label">
                                <span>שם פרטי</span>
                                <input type="text" class="profile-detail-form__input" v-model="firstName" value="<?=$firstname?>">
                            </label>
                        </div>
                        <div class="profile-detail-form__col2">
                            <label class="profile-detail-form__label">
                                <span>מייל</span>
                                <input type="text" class="profile-detail-form__input" v-model="email" value="<?=$user->user_email?>" >
                            </label>
                            <button type="button" v-on:click="updateProfile" class="profile-detail-form__btn profile-btn">עדכון פרטים אישיים</button>
                        </div>
                    </form>
                </div>
                
                <div class="profile-detail__col2">
                    <span class="profile-detail__logo-label">לוגו עסק:</span>
                    <div class="profile-detail__logo" @click="$refs.file.click()">
                       <img style='height: 100%;' v-if="fileData" v-bind:src='fileData'>
                    </div>
                </div>
            </div>

            <div class="profile__package profile-package">
                <div class="profile-package__col1 profile-package-info">
                    <div class="profile-package-info__row">
                        <div class="profile-package-info__col">
                            <span class="profile-package-info__title">החבילה שלי:</span>
                            <span class="profile-package-info__name">Expert</span>
                        </div>
                        <div class="profile-package-info__col">
                            <a href="#" class="profile-package-info__about">עומד לפוג</a>
                        </div>
                    </div>
                    <div class="profile-package-info__row">
                        <div class="profile-package-info__item">
                            <span class="profile-package-info__label">כמות מבחנים:</span>
                            <span class="profile-package-info__amount"><?=get_field('purched_test', 'user_'.get_current_user_id())?></span>
                        </div>
                        <div class="profile-package-info__item">
                            <span class="profile-package-info__label">מחזור חיוב</span>
                            <span class="profile-package-info__amount">שנתי</span>
                        </div>
                        <div class="profile-package-info__item">
                            <span class="profile-package-info__label">מבחנים שנותרו:</span>
                            <span class="profile-package-info__amount">23</span>
                        </div>
                    </div>
                </div>
                <div class="profile-package__col2">
                    <a href="/רכישת-חבילות/" class="profile-btn profile-package__link">רכישת / שדרוג מנוי</a>
                </div>
            </div>
            
        </div>
    </div>                                                   

    <?php get_footer(); ?>
<script>

      new Vue({
        el: '#profile',
        data: {
          firstName: window.firstName,
          nickName: window.nickName,
          email: window.email,
          fileData: window.logo,
          file: '',
        },
        methods: {
          showPhotos(e) {
            if(event.target.files && event.target.files.length > 0){
              var files = e.target.files || e.dataTransfer.files;
              if (!files.length)
                return;
              this.file = files[0];
              
                // this.filesArray = [];
                var reader = [];
                var self = this;
                for(var i=0; i< event.target.files.length; i++){
                    reader.push(new FileReader());
                    reader[i].readAsDataURL(event.target.files[i]);
                    reader[i].onload = function(e) {
                        this.fileData = e.target.result;
                    }.bind(this);
                }
            }
          },
          updateProfile() {
          
                  var self = this;
                  var formData = new FormData();
                      formData.append('email', this.email);
                      formData.append('first_name', this.firstName);
                      formData.append('nickname', this.nickName);
                      formData.append('file', this.file);
                      
                      const requestOptions = {
                                            method: "POST",
                                            body: formData
                                          };
                  fetch(window.wp_data.ajax_url + '?action=mynw_update_user_data', requestOptions)
            	                .then(function (response) {
                       if(response.ok === true) {
                         window.location.reload();
                       }
                    });
            
            
          }
        }
        
      })
    </script>

</body>
</html>