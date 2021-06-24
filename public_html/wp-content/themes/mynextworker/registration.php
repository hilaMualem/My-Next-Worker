
<?php
/*
Template Name: Registration
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
    
	

    <section class="registration-page" id="user-registration">

        <h1 class="registration-page__title">
            <?php the_field('registration_page_title'); ?>
        </h1>

        <form enctype="multipart/form-data" method="post" class="registration-page__form">

            <span class="registration-page__label">
                <?php the_field('registration_page_label_1'); ?>
            </span>

            <!-- <input type="text" class="registration-page__input" v-model="userData.contactName" placeholder="<?php the_field('registration_page_input_1'); ?>" > -->
            
            <input style="width: 100%;" type="text" class="registration-page__input registration-page__input--full-width" v-model="userData.companyName" required placeholder="<?php the_field('registration_page_input_2'); ?>" >
            <input type="text" class="registration-page__input" v-model="userData.firstname" placeholder="<?php the_field('registration_page_input_3'); ?>" >
            <input type="mail" class="registration-page__input" v-model="userData.email" required placeholder="<?php the_field('registration_page_input_4'); ?>" >
            <input type="password" class="registration-page__input" v-model="userData.password" required placeholder="<?php the_field('registration_page_input_6'); ?>" >
            
            <input type="password" class="registration-page__input" v-model="userData.stage" placeholder="<?php the_field('registration_page_input_8'); ?>" >
            
            
            
            <select v-model="userData.bussinessType" class="all-tests__select registration-page__input registration-page__input--full-width" style="width: calc(50% - 25px); height: 50px; border: 1px solid #ccc;">
              <option value="בחירת מקצוע" disabled>בחירת מקצוע</option>
              <?php
                $field = get_field_object('registration_page_input_5');
                $choices = $field['choices'];
                foreach($choices as $key => $val): 
                  echo '<option value="' . $key . '">' . $val . '</option>';
                endforeach; 
              ?>
            </select>
            
            <input type="text" class="registration-page__input" v-model="userData.address" placeholder="<?php the_field('registration_page_input_9'); ?>" >
            
            
            
<!--
            <span class="registration-page__label">
                <?php the_field('registration_page_label_2'); ?>
            </span>

            <?php
                $radio_labels_1 = get_field('registration_page_radio_labels_1');
                $radio_labels_2 = get_field('registration_page_radio_labels_2');
            ?>
            
            <label class="registration-page__radio-label"> 
                <input type="radio" name="group1" class="registration-page__radio-btn" v-model="userData.question1" value="<?=$radio_labels_1['registration_page_radio_label_1']?>">
                <?=$radio_labels_1['registration_page_radio_label_1']?>
            </label>

            <label class="registration-page__radio-label">
                <input type="radio" name="group1" class="registration-page__radio-btn" v-model="userData.question1" value="<?=$radio_labels_1['registration_page_radio_label_2']?>">
                <?=$radio_labels_1['registration_page_radio_label_2']?>
            </label>

            <label class="registration-page__radio-label">
                <input type="radio" name="group1" class="registration-page__radio-btn" v-model="userData.question1" value="<?=$radio_labels_1['registration_page_radio_label_3'] ?>">
                <?=$radio_labels_1['registration_page_radio_label_3'] ?>
            </label>

            <label class="registration-page__radio-label">
                <input type="radio" name="group1" class="registration-page__radio-btn" v-model="userData.question1" value="<?=$radio_labels_1['registration_page_radio_label_4'] ?>">
                <?=$radio_labels_1['registration_page_radio_label_4'] ?>
            </label>

            <label class="registration-page__radio-label">
                <input type="radio" name="group1" class="registration-page__radio-btn" v-model="userData.question1" value="<?=$radio_labels_1['registration_page_radio_label_5'] ?>">
                <?=$radio_labels_1['registration_page_radio_label_5'] ?>
            </label>

            <span class="registration-page__label">
                <?php the_field('registration_page_label_3'); ?>
            </span>

            <label class="registration-page__radio-label">
                    <input type="radio" name="group2" class="registration-page__radio-btn" v-model="userData.question2" value="<?=$radio_labels_2['registration_page_radio_label_6'] ?>">
                    <?=$radio_labels_2['registration_page_radio_label_6'] ?>
            </label>

            <label class="registration-page__radio-label">
                    <input type="radio" name="group2" class="registration-page__radio-btn" v-model="userData.question2" value="<?=$radio_labels_2['registration_page_radio_label_7'] ?>">
                    <?=$radio_labels_2['registration_page_radio_label_7'] ?>
            </label>

            <label class="registration-page__radio-label">
                    <input type="radio" name="group2" class="registration-page__radio-btn" v-model="userData.question2" value="<?=$radio_labels_2['registration_page_radio_label_8'] ?>">
                    <?=$radio_labels_2['registration_page_radio_label_8'] ?>
            </label>

            <label class="registration-page__radio-label">
                    <input type="radio" name="group2" class="registration-page__radio-btn" v-model="userData.question2" value="<?=$radio_labels_2['registration_page_radio_label_9'] ?>">
                    <?=$radio_labels_2['registration_page_radio_label_9'] ?>
            </label>
-->
            <span class="registration-page__label">
                <?php the_field('registration_page_label_4'); ?>
            </span>

            <div class="registration-page__warning">
                <?php the_field ('registration_page_text_warning') ?>
            </div>

            <div class="registration-page__file-body">
                <label class="registration-page__file-label">
                    <span>{{ userData.logo.name }}<span v-if="!userData.logo">בחירת קובץ</span></span>
                    <input type="file" class="registration-page__file" v-on:change="onFileChange">
                </label>
            </div>
            <div style="display: flex; align-items: center;">
              <input type="checkbox"> <a style="margin-right: 5px;" href="/wp-content/uploads/2021/05/תקנון-הערכת-עובדים.docx">קראתי ואישרתי את תנאי השימוש באתר</a>
            </div>
            <button type="submit" v-on:click.prevent="submitForm()" class="registration-page__submit-btn">
                <?php the_field('registration_page_text_btn'); ?>
            </button>

          


        </form>

    </section>

    <?php get_footer(); ?>

<script>
    
    var app = new Vue({
        el: "#user-registration",
        data: {
            userData: {
                companyName: '',
                contactName: '',
                email: '',
                phone: '',
                firstname:'',
                password: '',
                confirmPassword: '',
                bussinessType: 'בחירת מקצוע',
                stage: '',
                workersCount: null,
                address: '',
                logo: '',
                question1: '',
                question2: ''
            }
        },
        methods: {
            changeCategory(index) {
            
            },
            addFilterRemove(filter) {
            
            },
            isSelectedFilter(filter) {
            
            },
            onFileChange(e) {
              var files = e.target.files || e.dataTransfer.files;
              if (!files.length)
                return;
              this.userData.logo = files[0];
            },
            submitForm() {
                if(this.userData.password !== this.userData.stage){
                  alert("passwords not equal");
                }
                if(this.companyName != '' && this.email != '' && this.password != '') 
                {
                    var formData = new FormData();
                    formData.append('companyName', this.userData.companyName);
                    formData.append('email', this.userData.email);
                    formData.append('phone', this.userData.phone);
                    formData.append('firstname', this.userData.firstname);
                    formData.append('password', this.userData.password);
                    formData.append('bussinessType', this.userData.bussinessType);
                    formData.append('stage', this.userData.stage);
                    formData.append('address', this.userData.address);
                    formData.append('logo', this.userData.logo);
                    formData.append('question1', this.userData.question1);
                    formData.append('question2', this.userData.question2);
                    
                    const requestOptions = {
                        method: "POST",
                        // headers: { 'Content-Type' : 'multipart/form-data' },
                        body: formData
                    };
                    fetch(window.wp_data.ajax_url + '?action=mynw_user_registration', requestOptions)
                    .then(response => response.json())
                    .then(json => {
                        if(json.status === 'ok') {
                          window.location.href = 'dashboard';
                          this.userData = {
                                              companyName: '',
                                              contactName: '',
                                              email: '',
                                              phone: '',
                                              firstName:'',
                                              password: '',
                                              bussinessType: '',
                                              stage: '',
                                              workersCount: null,
                                              address: '',
                                              logo: '',
                                              question1: '',
                                              question2: ''
                                          };
                        } else {
                          alert(json.data);
                        }
                    });
                }
                else {
                    alert("Please enter your company name, email and password");
                }
                
            }
        },
    });

</script>

</body>
</html>