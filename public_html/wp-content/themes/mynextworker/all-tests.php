<?php
/*
Template Name: All tests
*/
?>
<?php
  if(!is_user_logged_in()){
    wp_redirect('/');
    die;
  }
?>
<!doctype html>
<html <?php language_attributes(); ?> >
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

    <div class="all-tests">
        <div class="all-tests__header">
            <h1 class="all-tests__title">רשימת מבחנים שנוצרו</h1> 
            <!--<div class="all-tests__nav">
                <select name="" class="all-tests__select">
                    <option value="1">תאריך</option>
                    <option value="1">2</option>
                    <option value="1">3</option>
                </select>
                <select name="" class="all-tests__select">
                    <option value="1">תאריך</option>
                    <option value="1">2</option>
                    <option value="1">3</option>
                </select>
            </div> -->           
        </div> 

        <?php
                               
                     $userId = get_current_user_id();
                     $table_name = $wpdb->prefix . 'exam_results';
                     
                    if(!$userId) {
                      echo '<script>window.location = "/dashboard"</script>';
                      die;
                    }
                    
                    $user = new WP_User($userId);      
                    
                    $post_query = array(
                        'numberposts'      => 1000,
                        'offset'           => 0,
                        'category'         => 0,
                        'orderby'          => 'post_date',
                        'order'            => 'DESC',
                        'author'      => $user->ID,
                        'post_type'        => 'exam',
                        'post_status'      => 'publish',
                        'suppress_filters' => true,
                    );
                    
                    $posts = wp_get_recent_posts($post_query);
        ?>

        <div class="all-tests__body">
            <?php foreach($posts as $key => $post): ?>
                    <div class="all-tests__item all-tests-item">
                        <div class="all-tests-item__col">
                        
                        <?php
                          $exam_count = $wpdb->get_results( "SELECT count(1) as count FROM $table_name WHERE user_id = " . get_current_user_id() . " and exam_id = " . $post['ID']);
                          $exam_count = $exam_count[0]->count;
                        ?>
                        
                            <div class="all-tests-item__examiners">
                                נבחנים:
                                <span><?=$exam_count?></span>
                            </div>
                            <a href="/test-page/?id=<?=$post['ID']?>" class="all-tests-item__link">כניסה למבחן</a>
                        </div>

                        <div class="all-tests-item__col">
                            <div class="all-tests-item__name"><?= $post['post_title'] ?></div>
                            <div class="all-tests-item__date">
                                תאריך:
                                <span> <?php
                                              $date = date_create($post['post_date']); 
                                              echo date_format($date, "d.m.Y"); 
                                        ?>
                                </span> 
                            </div>
                        </div>        
                    </div>
            <?php endforeach; ?>
        </div>         

    </div>                                  






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
    <?php get_footer(); ?>


</body>
</html>