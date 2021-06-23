<?php
/**
 * mynextworker functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mynextworker
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'mynextworker_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mynextworker_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on mynextworker, use a find and replace
		 * to change 'mynextworker' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'mynextworker', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'mynextworker' ),
			)
		);
		register_nav_menus(
			array(
				'menu-2' => esc_html__( 'Bottom', 'mynextworker' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'mynextworker_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'mynextworker_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mynextworker_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mynextworker_content_width', 640 );
}
add_action( 'after_setup_theme', 'mynextworker_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mynextworker_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'mynextworker' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'mynextworker' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'mynextworker_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mynextworker_scripts() {
	wp_enqueue_style( 'mynextworker-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'mynextworker-style', 'rtl', 'replace' );

	wp_enqueue_script( 'mynextworker-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'employee-test', get_template_directory_uri() . '/js/employee-test.js', array(), _S_VERSION, true );
  wp_enqueue_script( 'test-page', get_template_directory_uri() . '/js/test-page.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
}

add_action( 'wp_enqueue_scripts', 'mynextworker_scripts' );


// ajax actions
add_action('wp_ajax_mynw_user_registration', 'mynw_user_registration_callback');
add_action('wp_ajax_nopriv_mynw_user_registration',  'mynw_user_registration_callback');

function mynw_user_registration_callback() {
  $user_data = [];
  if($_FILES['logo']) {
    $result = wp_upload_bits(wp_generate_uuid4() . $_FILES['logo']['name'], null, file_get_contents($_FILES['logo']['tmp_name']));
    $user_data['logo'] = $result['url'];
    $user_data['logo_path'] = $result['path'];
  }
  
  $user_data['phone']          =    isset($_POST['phone']) ? sanitize_text_field( wp_unslash($_POST['phone'])) : '';
  $user_data['bussinessType']  =    isset($_POST['bussinessType']) ? sanitize_text_field( wp_unslash($_POST['bussinessType'])) : '';
  $user_data['address']        =    isset($_POST['address']) ? sanitize_text_field( wp_unslash($_POST['address'])) : '';
  $user_data['question1']      =    isset($_POST['question1']) ? sanitize_text_field( wp_unslash($_POST['question1'])) : '';
  $user_data['question2']      =    isset($_POST['question2']) ? sanitize_text_field( wp_unslash($_POST['question2'])) : '';
  
  $id = wp_create_user( sanitize_text_field( wp_unslash($_POST['email'])), $_POST['password'], sanitize_text_field( wp_unslash($_POST['email'])));
  
  if(is_wp_error( $id )) {
    echo json_encode(array('status' => false, 'data' => $id->get_error_message()));
    wp_die();
  }
  
  $user = new WP_User($id);
  
  if ( $user->exists() ) {
  
    $user->add_role('customer');
    $user->nickname = sanitize_text_field( wp_unslash($_POST['companyName']));
    wp_update_user($user);
    //update_field( 'purched_test', 1, 'user_' . $id );
    //update_field( 'purched_send', 20, 'user_' . $id );
    
    add_user_meta($id, 'logo', isset($user_data['logo'])?$user_data['logo']:'');
    add_user_meta($id, 'phone', $user_data['phone']);
    add_user_meta($id, 'bussinessType', $user_data['bussinessType']);
    add_user_meta($id, 'address', $user_data['address']);
    add_user_meta($id, 'question1', $user_data['question1']);
    add_user_meta($id, 'question2', $user_data['question2']);
    
    $info = get_bloginfo();
    
    $userEmail = $user->user_email;
    $title = " משתמש חדש";
    
    $content = get_stylesheet_directory() . '/emails/mail1/mail1.html';
    $content = file_get_contents($content);
    
    $iconPath = get_stylesheet_directory_uri() . '/emails/mail1';
    $content = str_replace('{{iconURL}}', $iconPath, $content);
    
    // $emailURI = get_stylesheet_directory_uri() . '/emails/mail1';
    
    //  if($user_data['logo_path']){
    //   $logoPath1 = get_stylesheet_directory() . '/emails/mail1/img/icon.png';
    //   $logoType1 = pathinfo($logoPath1, PATHINFO_EXTENSION);
    //   $logoData1 = file_get_contents($logoPath1);
    //   $logoBase64_1 = 'data:image/' . $pictureType1 . ';base64,' . base64_encode($logoData1);
    //   $content = str_replace('{{logoBase64}}', $logoBase64_1, $content);
    // }
    
    $loginPageURI = get_site_url() . '/login/';
    $content = str_replace('{{loginURI}}', $loginPageURI, $content);
    
    $content_type = function() { return 'text/html'; };
    add_filter( 'wp_mail_content_type', $content_type );
    wp_mail($userEmail, $title, $content);
    remove_filter( 'wp_mail_content_type', $content_type );
    
    
    echo (json_encode(array('status' => 'ok', 'data' => "user created successfully"))); // get_user_meta( $id, 'data', false )
    wp_die(); 
  }
}

if (!function_exists('write_log')) {
  function write_log($log) {
      if (true === WP_DEBUG) {
          if (is_array($log) || is_object($log)) {
              error_log(print_r($log, true));
          } else {
              error_log($log);
          }
      }
  }
}

add_action('after_setup_theme','my_add_role_function');

function my_add_role_function(){
    $roles_set = get_option('my_roles_are_set');
    if(!$roles_set){
        add_role('past_customer', 'לקוח עבר');
        update_option('my_roles_are_set',true);
    }
}

add_action( 'woocommerce_thankyou', 'add_subscription' );
function add_subscription( $order_id )
{
  $order = wc_get_order( $order_id );
  $order->update_status( 'completed' );
  $user = $order->get_user();
  if (in_array('past_customer', $user->roles)) 
  {
    $user->remove_role('past_customer');
  }
  $products = $order->get_items();
  foreach($products as $product )
  {
    $prduct_purchased_test_count=get_field("prduct_purchased_test_count", $product->get_product_id());
    $prduct_purchased_send_count=get_field("prduct_purchased_send_count", $product->get_product_id());
    update_field( 'purched_test', $prduct_purchased_test_count  , 'user_' . $user->ID );
    update_field( 'purched_send', $prduct_purchased_send_count , 'user_' . $user->ID );
    break;
  }
}

add_action('woocommerce_subscription_status_updated', 'switched_subscription_to_past_customer');
function switched_subscription_to_past_customer($subscription)
{
  $order = wc_get_order($subscription->get_parent_id());
  $user = $order->get_user();
  if (!in_array('subscriber', $user->roles)) 
  {
    $user->set_role('past_customer');
  }
}

function redirect_past_customer_to_payment($user_login, $user) {
  $page = get_page_by_title( "רכישת חבילות");
  $link = get_permalink($page->ID);
  if(in_array('past_customer', $user->roles))
  {
    wp_redirect( $link ); exit;
  }
}
add_action('wp_login', 'redirect_past_customer_to_payment', 10, 2);

// ajax actions
add_action('wp_ajax_mynw_send_test', 'mynw_send_test_callback');
add_action('wp_ajax_nopriv_mynw_send_test',  'mynw_send_test_callback');

function mynw_send_test_callback() {

  if(isset($_POST['email']) && isset($_POST['examId'])) {
    
    $email = stripslashes($_POST['email']);
    $examId = stripslashes($_POST['examId']);
    
    $post = get_post($_POST['examId']);
    
    $test_data = [];
    $test_data['token'] = wp_generate_uuid4();
    $test_data['worker_mail'] = $email;
    
    $test_data['user_id'] = get_current_user_id();
    $test_data['finished'] = false;
    $test_data['exam_id'] = $examId;
    $test_data['results'] = null;
 
    global $wpdb;
  
    $table_name = $wpdb->prefix . 'exam_results';
    $wpdb->insert( $table_name, array(
      'uniqe_id' => $test_data['token'],
      'worker_mail' => $test_data['worker_mail'],
      'worker_name' => "",
      'user_id' => $test_data['user_id'],
      'exam_id' => $examId,
      'finished' => $test_data['finished'],
      // 'results' => $test_data['results'],
    ) );
    
    $success = empty($wpdb->last_error);
    
    if(!$success) {
      echo json_encode(array('status' => false, 'data' => $wpdb->last_error));
      wp_die();
    }
    
    $userEmail = $test_data['worker_mail'];
    $title = "New test of " . $info->name;
    
    $content = get_stylesheet_directory() . '/emails/mail2/mail2.html';
    $content = file_get_contents($content);
    $emailURI = get_stylesheet_directory_uri() . '/emails/mail2';
    
    $examPage = $post->guid . '?uniqe_id=' . $test_data['token'];
    
    $content = str_replace('{{iconURL}}', $emailURI, $content);
    $content = str_replace('{{testURL}}', $examPage, $content);
    
    $user = new WP_User($test_data['user_id']);
    
    $postMeta = get_post_meta($post->ID, 'testData')[0];
    
    $content = str_replace('{{company_name}}', $user->nickname, $content);
    $content = str_replace('{{position_name}}', $postMeta['testBuilderName'], $content);
    
    $content = str_replace('{{position_address}}', $postMeta['testBuilderAdress'], $content);
    $content = str_replace('{{position_city}}', $postMeta['testBuilderCity'], $content);
    
    $content = str_replace('{{position_date}}', $postMeta['testBuilderDateBegin'], $content);
    $content = str_replace('{{position_sallary}}', $postMeta['testBuilderSalary'], $content);
    
    $content = str_replace('{{position_expir}}', $postMeta['testBuilderExperienceRequired'], $content);
    $content = str_replace('{{position_req}}', $postMeta['testBuilderJobRequirements'], $content);
    
    $content = str_replace('{{position_type}}', $postMeta['testBuilderTypeJob'], $content);
    
    
    $content = str_replace('{{position_description}}', $postMeta['testBuilderJobDescription'], $content);

    $content = str_replace('{{linkToLogo}}', get_logo(get_current_user_id()), $content);
    
    $content_type = function() { return 'text/html'; };
    add_filter( 'wp_mail_content_type', $content_type );
    wp_mail($userEmail, $title, $content);
    remove_filter( 'wp_mail_content_type', $content_type );
    
    $count = (int) get_field('exam_send');
    update_field( 'exam_send', $count++, $examId );
    
      echo (json_encode(array('status' => 'ok', 'data' => "test created successfully")));
      wp_die(); 
  } else {
    echo (json_encode(array('status' => false, 'data' => "Name or mail not exists")));
    wp_die(); 
  }
}
function get_logo($user_id)
{
  if(isset($logo) && !empty($user_id)) $logo = get_user_meta($user_id, 'logo', false)[0];
  if(!isset($logo) || empty($logo))$logo=get_stylesheet_directory_uri().'/assets/img/favicon@3x.png';
  return $logo;
}
// ajax actions
add_action('wp_ajax_mynw_send_recommendation', 'mynw_send_recommendation_callback');
add_action('wp_ajax_nopriv_mynw_send_recommendation',  'mynw_send_recommendation_callback');

function mynw_send_recommendation_callback() {

	if(isset($_POST['email'])) {

		$email = stripslashes($_POST['email']);

		$test_data = [];
		$userEmail = $email;

		$userId = get_current_user_id();
		$nickName = get_user_meta($userId, 'nickname', false)[0];

		$title = "New recommendation From mynextworker";

		$content = get_stylesheet_directory() . '/emails/mail6/mail6.html';
		$content = file_get_contents($content);
		$emailURI = get_stylesheet_directory_uri() . '/emails/mail6';

    $content = str_replace('{{mailURL}}', $emailURI, $content);
		$content = str_replace('{{username}}', $nickName, $content);
		$content = str_replace('{{testURL}}', get_site_url(), $content);


		$content_type = function() { return 'text/html'; };
		add_filter( 'wp_mail_content_type', $content_type );
		wp_mail($userEmail, $title, $content);
		remove_filter( 'wp_mail_content_type', $content_type );

		echo (json_encode(array('status' => 'ok', 'data' => "test created successfully")));
		wp_die();
	} else {
		echo (json_encode(array('status' => false, 'data' => "Name or mail not exists")));
		wp_die();
	}
}

// ajax actions
add_action('wp_ajax_mynw_send_result_to_candidate', 'mynw_send_result_to_candidate_callback');
add_action('wp_ajax_nopriv_mynw_send_result_to_candidate',  'mynw_send_result_to_candidate_callback');

function mynw_send_result_to_candidate_callback() {
  if(isset($_GET['email_type']) && isset($_GET['uniqe_id'])) {
    $emailType = $_GET['email_type'];
    $token = $_GET['uniqe_id'];
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'exam_results';
    
    $examData = $wpdb->get_results("SELECT * FROM $table_name WHERE uniqe_id = '$token'");
    
    if(count($examData) > 0) {
      $examData = $examData[0];
    }
    
    $userId = $examData->user_id;
    $candidate_name = $examData->worker_name;
    $candidate_email = $examData->worker_mail;
    
    if($emailType === 'ok') {
      $content = get_stylesheet_directory() . '/emails/mail3/mail3.html';
      $content = file_get_contents($content);
      $emailURI = get_stylesheet_directory_uri() . '/emails/mail3';
      
    } else {
      $content = get_stylesheet_directory() . '/emails/mail5/mail5.html';
      $content = file_get_contents($content);
      $emailURI = get_stylesheet_directory_uri() . '/emails/mail5';
      
    }
    
    $content = str_replace('{linkToMail}', $emailURI, $content);
    // $content = str_replace('{linkToLogo}', $examPage, $content);
    
    // $examPage = $post->guid . '?uniqe_id=' . $test_data['token'];
    
    $user = new WP_User($test_data['user_id']);
    
    $postMeta = get_post_meta($post->ID, 'testData')[0];
    
    $title = "Result of test " . $postMeta['testBuilderName'];
        
    $content = str_replace('{{company_name}}', $user->nickname, $content);
    $content = str_replace('{{position_name}}', $postMeta['testBuilderName'], $content);
    $content = str_replace('{{position_type}}', $postMeta['testBuilderTypeJob'], $content);
    $content = str_replace('{{position_description}}', $postMeta['testBuilderJobDescription'], $content);
    
    $content = str_replace('{{linkToLogo}}', get_logo($user_id), $content);
    
    $content_type = function() { return 'text/html'; };
    add_filter( 'wp_mail_content_type', $content_type );
    wp_mail($candidate_email, $title, $content);
    remove_filter( 'wp_mail_content_type', $content_type );
    
    echo (json_encode(array('status' => 'ok', 'data' => "email send successfully")));
    
    wp_die();
  } else {
    echo (json_encode(array('status' => false, 'data' => "email type or token not exists")));
    wp_die(); 
  }
}

// ajax actions
add_action('wp_ajax_mynw_test_complete', 'mynw_test_complete_callback');
add_action('wp_ajax_nopriv_mynw_test_complete',  'mynw_test_complete_callback');

function mynw_test_complete_callback() {
  $resume = '';
  if($_FILES['resume']) {
    $result = wp_upload_bits(wp_generate_uuid4() . $_FILES['resume']['name'], null, file_get_contents($_FILES['resume']['tmp_name']));
    $resume           =    $result['url'];
  }
  if(isset($_POST['test_result']) && isset($_POST['percentageObject']) && isset($_POST['percentage'])) {

	  $test_result = json_decode(stripslashes($_POST['test_result']), true);
	  $percObject = json_decode(stripslashes($_POST['percentageObject']), true);
	  $percentage = json_decode(stripslashes($_POST['percentage']), true);
	  $userData = json_decode(stripslashes($_POST['userData']), true);
	  $postID = json_decode(stripslashes($_POST['postid']), true);

	  global $wpdb;
  	    if(!$_POST['token']) {
	    $email = stripslashes($userData['email']);
	    $examId = stripslashes($postID);

	    $post = get_post($examId);

	    $test_data = [];
	        $token = wp_generate_uuid4();
	    $test_data['token'] = $token;
	    $test_data['worker_mail'] = $email;

	    $author_id = get_post_field( 'post_author', $examId );
	    $test_data['user_id'] = $author_id;
	    $test_data['finished'] = false;
	    $test_data['exam_id'] = $examId;
	    $test_data['results'] = null;

	    $table_name = $wpdb->prefix . 'exam_results';
	    $wpdb->insert( $table_name, array(
		    'uniqe_id' => $test_data['token'],
		    'worker_mail' => $test_data['worker_mail'],
		    'worker_name' => "",
		    'user_id' => $test_data['user_id'],
		    'exam_id' => $examId,
		    'finished' => $test_data['finished'],
		    // 'results' => $test_data['results'],
	    ) );

	    $success = empty($wpdb->last_error);
    } else {
	        $token = $_POST['token'];
	  }
    $name = $userData['name'];
    $userData['resume'] = $resume;
    
    $score = calcScore($test_result, $percObject);

    $table_name = $wpdb->prefix . 'exam_results';
    
    $results = ['percObject' => $percObject, 'results' => $test_result, 'userData' => $userData];
    $results = json_encode($results);
    // var_export($results);die;
    $update = $wpdb->update( $table_name, array('finished' => 1 , 'results' => $results, 'worker_name' => $name, score => $score), array('uniqe_id' => $token));
    
    $success = empty($wpdb->last_error);
    
    if(!$success) {
      echo json_encode(array('status' => false, 'data' => $wpdb->last_error));
      wp_die();
    }
    
      echo (json_encode(array('status' => 'ok', 'data' => "result saved successfully")));
      wp_die(); 
  } else {
    echo (json_encode(array('status' => false, 'data' => "Name or mail not exists")));
    wp_die(); 
  }
}

function calcScore($result, $percObject) {
  if(is_array($result)) {
      $count = count($result);
      $countRight = 0;
      foreach($result as $key => $val) {
        if($val['answer'] === 1){
          $countRight ++;
        }
      }
      return $countRight/$count*100;
  } else {
    return 0;
  }
}

// ajax actions
add_action('wp_ajax_mynw_test_builder', 'mynw_test_builder_callback');
add_action('wp_ajax_nopriv_mynw_test_builder',  'mynw_test_builder_callback');

function mynw_test_builder_callback() {
  
  if(isset($_POST['testData']) && isset($_POST['testBuilderQuestionFields']) && isset($_POST['questionsCategories'])) {
    
    $testData = json_decode(stripslashes($_POST['testData']), true);
    $testBuilderQuestionFields = json_decode(stripslashes($_POST['testBuilderQuestionFields']), true);
    $questionsCategories = json_decode(stripslashes($_POST['questionsCategories']), true);
    
    $user_id =get_current_user_id();
    $user = new WP_User($user_id);
    
    $post_data = array (
      'post_type' => 'exam',
      'post_title' => $testData['testBuilderName'],
      'post_author' => $user->ID,
      'post_content' => null,
      'post_status' => 'publish',
      
      'comment_status' => 'closed',   // if you prefer
      'ping_status' => 'closed',      // if you prefer
    );
    
    
    // ------------------------------------------------------------------------------------------------
    $post_id = wp_insert_post($post_data);
    
    if ($post_id) {
       // insert post meta
       add_post_meta($post_id, 'testData', $testData);
       add_post_meta($post_id, 'testBuilderQuestionFields', $testBuilderQuestionFields);
       add_post_meta($post_id, 'questionsCategories', $questionsCategories);
    }
    
    $post = get_post($post_id);
    $tax = get_object_taxonomies('question');
    $terms = get_terms(array( 'taxonomy'   => $tax[0], 'hide_empty' => false, ));

    update_field('question_amount', 10, $post_id);
    foreach($questionsCategories as $key => $val) {
      foreach($terms as $cat) {
          if ($val == $cat->name) {
              $item = $cat;
              break;
          }
      }
      $questionCount = get_field('total_random_quesion_status', 'term_' . $item->term_id);
      if($questionCount === true) {
        $questionCount = get_field('total_random_quesion_number', 'term_' . $item->term_id);
      }else{
        $questionCount = 0;
      }
      if(isset($item) && !empty($item)) {
        add_row('add_questions', array('question_category' => $item->term_id, 'category_percentage' => $questionCount), $post_id);
      }
    }
   
    // ------------------------------------------------------------------------------------------------------
    
            
    echo json_encode(array('status' => 'ok', 'data' => get_post_permalink($post_id), 'post_id' => $post_id));
    wp_die();
    
  } else {
    echo (json_encode(array('status' => false, 'data' => "wrong data")));
    wp_die(); 
  }
}

// ajax actions
add_action('wp_ajax_mynw_fetch_exams', 'mynw_fetch_exams_callback');
add_action('wp_ajax_nopriv_mynw_fetch_exams',  'mynw_fetch_exams_callback');
function mynw_fetch_exams_callback() {
  $userId = get_current_user_id();
   global $wpdb;
  if(isset($_GET['exam_offset'])) {
    $table_name = $wpdb->prefix . 'exam_results';
    $offset = $_GET['exam_offset'];
    $post_query = array(
                        'numberposts'      => 5,
                        'offset'           => $offset,
                        'category'         => 0,
                        'orderby'          => 'post_date',
                        'order'            => 'DESC',
                        'author'           => $userId,
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
    echo json_encode($uiData);
    wp_die();
  }
  wp_die();
}

// ajax actions
add_action('wp_ajax_mynw_update_user_data', 'mynw_update_user_data_callback');
add_action('wp_ajax_nopriv_mynw_update_user_data',  'mynw_update_user_data_callback');

function mynw_update_user_data_callback() {
  $userId = get_current_user_id();
  $logo = '';
  if($_FILES['file']) {
    $result = wp_upload_bits(wp_generate_uuid4() . $_FILES['file']['name'], null, file_get_contents($_FILES['file']['tmp_name']));
    $logo           =    $result['url'];
  }
  if (isset($_POST['email'])) {
    $first_name = stripslashes($_POST['first_name']);
    $nickname = stripslashes($_POST['nickname']);
    $email = stripslashes($_POST['email']);
    
    $currentUser = new WP_User($userId);
    
    if($email !== $currentUser->user_email) {
      $args = array(
        'ID'         => $userId,
        'user_email' => esc_attr( trim($email) )
      );
      wp_update_user( $args );
    }
   
    update_user_meta($userId, 'firstname', trim($first_name));
    update_user_meta($userId, 'nickname', trim($nickname));
    if($logo){
      update_user_meta($userId, 'logo', $logo);
    }
    
    echo json_encode(["status" => "ok", "message" => "user updated successfully"]);
    wp_die(); 
  }

  wp_die();
}


add_filter('template_include', function ($template) {
  // Get template file.
  $file = basename($template);

  if ($file === 'employee-test-exam-1.php') {
    if(!isset($_GET['uniqe_id']) || empty($_GET['uniqe_id'])){
      wp_redirect(home_url());
      exit;      
    }
  }
  
  if($file === 'wp-login.php'){
    wp_redirect(site_url().'/login');
    exit;
  }

  return $template;
});

// Hook the appropriate WordPress action
add_action('init', 'prevent_wp_login');

function prevent_wp_login() {
    global $pagenow;
    $action = (isset($_GET['action'])) ? $_GET['action'] : '';
    if($_SERVER['REQUEST_METHOD'] == 'GET' && !is_user_logged_in() && $pagenow == 'wp-login.php' && ( ! $action || ( $action && ! in_array($action, array('logout', 'lostpassword', 'rp', 'resetpass'))))) {
        wp_redirect(site_url() . '/login');
        exit();
    }
}

function mynetworker_login_redirect( $redirect_to, $request, $user ) {
    if ( !is_wp_error($user) && $user && is_object( $user ) ) {
      if (user_can( $user, "subscriber" )) {
        return '/dashboard';        
      } else {
        return home_url();
      }
    } else {
        return $redirect_to;
    }
}
 
add_filter( 'login_redirect', 'mynetworker_login_redirect', 10, 3 );

// header hook print js variables
add_action('wp_head', 'js_variables');

function js_variables(){
		$variables = array (
			'ajax_url' => admin_url('admin-ajax.php'),
		);
		echo(
			'<script type="text/javascript">window.wp_data = ' . 
			json_encode($variables) . 
			';</script>'
		);
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function custom_dir_attr($lang){
	if (is_admin())
		return $lang;
	$dir_attr="";
	if (!is_rtl())
		$dir_attr='dir="rtl"';

	return $lang." ".$dir_attr;
}
add_filter('language_attributes','custom_dir_attr');

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Site General Settings',
		'menu_title'	=> 'Site Settings',
		'menu_slug' 	=> 'Site-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Site Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'Site-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Site Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'Site-general-settings',
	));
}
function wpb_sender_email( $original_email_address ) {
  return 'support@mynextworker.co.il';
}

// Function to change sender name
function wpb_sender_name( $original_email_from ) {
  return 'My Next Worker';
}

// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );