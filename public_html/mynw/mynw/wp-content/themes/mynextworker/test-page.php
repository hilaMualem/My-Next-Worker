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

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="font-family: Rubik, sans-serif" >
<?php wp_body_open(); ?>


   <main class="main__wrapper">
        
        <nav id="navigation-panel" class="navigation-panel">
            <ul class="navigation-panel__list">
                <li class="navigation-panel__item">
                    <img src="assets/img/user-icon.png" alt="icon" class="navigation-panel__icon">
                    <a href="#" class="navigation-panel__link">פרופיל</a>
                </li>
                <li class="navigation-panel__item">
                    <img src="assets/img/list-icon.png" alt="icon" class="navigation-panel__icon">
                    <a href="#" class="navigation-panel__link">מבחנים</a>
                </li>
                <li class="navigation-panel__item">
                    <img src="assets/img/label-icon.png" alt="icon" class="navigation-panel__icon">
                    <a href="#" class="navigation-panel__link">חבילות</a>
                </li>
            </ul>
        </nav>

       <section class="send_test">
           <div class="send_test__column">
               <a href="#" class="send_test__btn">שליחת מבחן למועמד</a>
           </div>
           <div class="send_test__column">
               <div class="send_test__title">מבחן קבלה מעצב גרפי</div>
               <div class="send_test__subtitle">
                    <span>24.04.2021</span>
                   תאריך יצירת מבחן:
                </div>
           </div>
       </section>
       
       <section class="tests-info">

           <div class="tests-info__container">
            <div class="tests-info__col tests-info-col">
                <div class="tests-info-col__title">קיבלו ציון עובר</div>
                <div class="tests-info-col__num">6</div>
            </div>
            <div class="tests-info__col tests-info-col">
                <div class="tests-info-col__title">מבחנים שבוצעו</div>
                <div class="tests-info-col__num">15</div>
            </div>
           </div>
           
            <div class="tests-info__container">
                <div class="tests-info__col tests-info-col">
                    <div class="tests-info-col__title">מבחנים שנשלחו</div>
                    <div class="tests-info-col__num">34</div>
                </div>
                <div class="tests-info__col tests-info-col">
                    <div class="tests-info-col__title">כמות נבחנים</div>
                    <div class="tests-info-col__num">15</div>
                </div>
            </div>

       </section>

       <div class="tests-wrapper">
           <section class="best-tests">
               <h1 class="best-tests__title">המבחנים הטובים ביותר</h1>
               <div class="best-tests__container">

                   <div class="best-tests__column chart">
                        <h2 class="chart__title">10 הנבחנים המובילים</h2>

                        <div class="chart__body">

                        </div>

                        <div class="chart__decor-line"></div>

                        <div class="chart__info">

                        </div>

                   </div>

                   <div class="best-tests__column">
                        <div class="best-tests__examinees-card examinees-card">
                            <a href="#" class="examinees-card__btn">כניסה למבחן</a>
                            <div class="examinees-card__line-body">
                                <div class="examinees-card__progress" style="width: 99%"></div>
                            </div>
                            <div class="examinees-card__percentage">99</div>
                            <div class="examinees-card__full-name">ברק אובמה</div>
                            <div class="examinees-card__photo"></div>
                        </div>
                        <div class="best-tests__examinees-card examinees-card">
                            <a href="#" class="examinees-card__btn">כניסה למבחן</a>
                            <div class="examinees-card__line-body">
                                <div class="examinees-card__progress" style="width: 76%"></div>
                            </div>
                            <div class="examinees-card__percentage">76</div>
                            <div class="examinees-card__full-name">דנה בננה</div>
                            <div class="examinees-card__photo"></div>
                        </div>
                        <div class="best-tests__examinees-card examinees-card">
                            <a href="#" class="examinees-card__btn">כניסה למבחן</a>
                            <div class="examinees-card__line-body">
                                <div class="examinees-card__progress" style="width: 50%"></div>
                            </div>
                            <div class="examinees-card__percentage">50</div>
                            <div class="examinees-card__full-name">ג׳ון גואו</div>
                            <div class="examinees-card__photo"></div>
                        </div>
                        <div class="best-tests__examinees-card examinees-card">
                            <a href="#" class="examinees-card__btn">כניסה למבחן</a>
                            <div class="examinees-card__line-body">
                                <div class="examinees-card__progress" style="width: 85%"></div>
                            </div>
                            <div class="examinees-card__percentage">85</div>
                            <div class="examinees-card__full-name">דנית מסקוביץ</div>
                            <div class="examinees-card__photo"></div>
                        </div>
                        
                   </div>

               </div>
           </section>

           <section class="examinees-list">
               <h2 class="examinees-list__title">רשימת נבחנים</h2>

               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>

           </section>

           <section class="finished-test">
               <h2 class="finished-test__title">מי עשה את המבחן</h2>

               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
           </section>

           <section class="not-pass-test">
               <h2 class="not-pass-test__title">מי עשה את המבחן</h2>

               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
               <div class="examinees-list__item examinee">

                    <div class="examinee__column">
                        <a href="#" class="examinee__login-btn">כניסה למבחן</a>
                        <a href="#" class="examinee__delete-btn">מחיקת מועמד</a>
                        <a href="#" class="examinee__send-msg-btn">שלח/י הודעה</a>
                        <div class="examinee__date">תאריך: <span>12/07/2020</span></div>
                    </div>

                    <div class="examinee__column">
                        <div class="examinee__percentage">76</div>
                        <div class="examinee__full-name">ג׳ון דואו</div>
                        <div class="examinee__photo"></div>
                    </div>

               </div>
           </section>

       </div>
   </main>

    <?php get_footer(); ?>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        let cardProgressHtmlCollection = document.getElementsByClassName("examinees-card__progress");
        let cardProgressArr = Array.from(cardProgressHtmlCollection);

        cardProgressArr.forEach((item) => {
            item.style.width = item.parentNode.nextElementSibling.textContent + "%";
        })

        let navPanel = document.getElementById("navigation-panel")
        window.addEventListener('scroll', () => {
            if(pageYOffset > 120) {
                navPanel.style.top = 0;
            }
            if(pageYOffset < 120) {
                navPanel.style.top = 120 + 'px';
            }
        });
    })
    
</script>

</body>
</html>