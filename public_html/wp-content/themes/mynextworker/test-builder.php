<?php
/*
Template Name: Test Builder
*/
?>

<!doctype html>
<html <?php language_attributes(); ?> dir="ltr">

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="font-family: Rubik, sans-serif" >
    <?php wp_body_open(); ?>
    <script>
						           window.questionTaxonomies = <?php
                              $tax = get_object_taxonomies( 'question');
                              $terms = get_terms(array( 'taxonomy'   => $tax[0], 'hide_empty' => false, ));
                              echo json_encode($terms);
                       ?>;
        </script>
    <main>
        <div class="test-builder" dir="rtl" id="emptest">
            <section v-if="countSteps === 0" class="test-builder__step-1 test-builder-step-1">
                <div class="test-builder-step-1__pagination test-builder-pagination">
                    <div class="test-builder-pagination__line-decor"></div>
                    <div class="test-builder-pagination__num test-builder-pagination__num--active">1</div>
                    <div class="test-builder-pagination__line-decor"></div>
                    <div class="test-builder-pagination__num">2</div>
                    <div class="test-builder-pagination__line-decor"></div>
                    <div class="test-builder-pagination__num">3</div>
                    <div class="test-builder-pagination__line-decor"></div>
                    <div class="test-builder-pagination__num">4</div>
                    <div class="test-builder-pagination__line-decor"></div>
                </div>
                <h2 class="test-builder-step-1__title">תחילה, בואו נבחר שם למבחן</h2>
                <div class="test-builder-step-1__subtitle">תוכלו לחפש את המבחן בלוח הבקרה כדי לשלוח אותו למועמד, לראות
                    סטטיסטיקות וכו</div>
                <input v-model="testBuilderName" type="text" class="test-builder-step-1__test-name-input" placeholder="שם המבחן">
                <div @click="nextStep" class="test-builder-step-1__next-step test-builder-next-step-btn"><span>&gt;</span>המשך</div>
            </section>

            <section v-if="countSteps === 1" class="test-builder__step-2 test-builder-step-2">

                <div class="test-builder-step-2__column test-summary">
                    <h2 class="test-summary__title">סיכום מבחן</h2>
                    <div class="test-summary__decor-line"></div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">שם המבחן</div>
                        <div class="test-summary__value">{{this.testBuilderName}}</div>
                    </div>

                </div>

                <div class="test-builder-step-2__column vacancy-info">
                    <div class="vacancy-info__pagination test-builder-pagination">
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num test-builder-pagination__num--active">1</div>
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num test-builder-pagination__num--active">2</div>
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num">3</div>
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num">4</div>
                        <div class="test-builder-pagination__line-decor"></div>
                    </div>

                    <div class="vacancy-info__title">מלאו את פרטי המשרה</div>
                    <div class="vacancy-info__subtitle">אלו הפרטים שהמועמד יראה</div>

                    <form action="" class="vacancy-info__form vacancy-info-form">
                        <div>
                            <input v-model="testBuilderAdress" type="text" class="vacancy-info-form__input" placeholder="כתובת המשרה">
                            <input v-model="testBuilderCity" type="text" class="vacancy-info-form__input" placeholder="באיזו עיר?">
                        </div>
                        <div>
                            <input v-model="testBuilderDateBegin" type="text" class="vacancy-info-form__input" placeholder="תאריך תחילת עבודה">
                            <input v-model="testBuilderSalary" type="text" class="vacancy-info-form__input" placeholder="שכר">
                        </div>
                        <div>
                            <input v-model="testBuilderTypeJob" type="text" class="vacancy-info-form__input" placeholder="סוג המשרה">
                            <input v-model="testBuilderExperienceRequired" type="text" class="vacancy-info-form__input" placeholder="ניסיון נדרש">
                        </div>

                        <textarea v-model="testBuilderJobRequirements" name="" class="vacancy-info-form__textarea" placeholder="דרישות המשרה"></textarea>
                        <textarea v-model="testBuilderJobDescription" name="" class="vacancy-info-form__textarea" placeholder="תיאור המשרה"></textarea>

                        <div class="vacancy-info-form__buttons">
                            <div @click="nextStep" class="vacancy-info-form__next-step-btn test-builder-next-step-btn">
                                <span> &gt; </span>
                                <span> המשך </span>
                            </div>
                            <div @click="prevStep" class="vacancy-info-form__prev-step-btn test-builder-prev-step-btn">
                                <span> אחורה </span>
                                <span> &lt; </span>
                            </div>
                        </div>
                    </form>
                </div>

            </section>

            <section v-if="countSteps === 2" class="test-builder__step-3 test-builder-step-3">

                <div class="test-builder-step-3__column test-summary">
                    <h2 class="test-summary__title">סיכום מבחן</h2>
                    <div class="test-summary__decor-line"></div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">שם המבחן</div>
                        <div class="test-summary__value">{{this.testBuilderName}}</div>
                    </div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>

                        <div class="test-summary__card-label">עיר</div>
                        <div class="test-summary__value">{{this.testBuilderCity}}</div>

                        <div class="test-summary__card-label">שכר</div>
                        <div class="test-summary__value">{{this.testBuilderSalary}}</div>

                        <div class="test-summary__card-label">ניסיון נדרש</div>
                        <div class="test-summary__value">{{this.testBuilderExperienceRequired}}</div>

                        <div class="test-summary__card-label">סוג המשרה</div>
                        <div class="test-summary__value">{{this.testBuilderTypeJob}}</div>
                        
                        <div class="test-summary__card-label">דרישות המשרה</div>
                        <div class="test-summary__value">{{this.testBuilderJobRequirements}}</div>
                    </div>

                </div>

                <div class="test-builder-step-3__column candidate-selection">
                    <div class="candidate-selection__pagination test-builder-pagination">
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num test-builder-pagination__num--active">1</div>
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num test-builder-pagination__num--active">2</div>
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num test-builder-pagination__num--active">3</div>
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num">4</div>
                        <div class="test-builder-pagination__line-decor"></div>
                    </div>

                    <div class="candidate-selection__title">דף לבחירת שאלות למועמד</div>
                    <div class="candidate-selection__subtitle">אלו השאלות שיישאלו בתחילת המבחן - ניתן להחסיר / להוסיף
                        שאלות
                        חדשות</div>

                    <form action="" class="candidate-selection__form candidate-selection-form">
                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="שם פרטי ומשפחה">
                            <span class="candidate-selection-form__check" style="cursor: pointer" v-on:click="testBuilderQuestionFields.name = !testBuilderQuestionFields.name">{{testBuilderQuestionFields.name?'&#10003;':''}}</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="כתובת מגורים">
                            <span class="candidate-selection-form__check" style="cursor: pointer" v-on:click="testBuilderQuestionFields.address = !testBuilderQuestionFields.address">{{testBuilderQuestionFields.address?'&#10003;':''}}</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="דואר אלקטרוני">
                            <span class="candidate-selection-form__check" style="cursor: pointer" v-on:click="testBuilderQuestionFields.email = !testBuilderQuestionFields.email">{{testBuilderQuestionFields.email?'&#10003;':''}}</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="טלפון נייד">
                            <span class="candidate-selection-form__check" style="cursor: pointer" v-on:click="testBuilderQuestionFields.phone = !testBuilderQuestionFields.phone">{{testBuilderQuestionFields.phone?'&#10003;':''}}</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="מהי השכלתך?">
                            <span class="candidate-selection-form__check" style="cursor: pointer" v-on:click="testBuilderQuestionFields.experience = !testBuilderQuestionFields.experience">{{testBuilderQuestionFields.experience?'&#10003;':''}}</span>
                        </div>
                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="איזה שפות הינך דובר?">
                            <span class="candidate-selection-form__check" style="cursor: pointer" v-on:click="testBuilderQuestionFields.language = !testBuilderQuestionFields.language">{{testBuilderQuestionFields.language?'&#10003;':''}}</span>
                        </div>
                        <div>
                            <textarea class="candidate-selection-form__textarea candidate-selection-form__input--valid"
                                placeholder="טקסט חופשי"></textarea>
                            <span class="candidate-selection-form__check" style="cursor: pointer" v-on:click="testBuilderQuestionFields.freeText = !testBuilderQuestionFields.freeText">{{testBuilderQuestionFields.freeText?'&#10003;':''}}</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="העלאת קורות חיים">
                            <span class="candidate-selection-form__check" style="cursor: pointer" v-on:click="testBuilderQuestionFields.resumeUploading = !testBuilderQuestionFields.resumeUploading">{{testBuilderQuestionFields.resumeUploading?'&#10003;':''}}</span>
                        </div>

                        <div v-for="item in testBuilderQuestionFields.questions">
                          <div v-if="item.questionType === 'aq'">
                            <input type="text" v-model="item.question"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="כתוב טקסט של השאלה">
                            <span class="candidate-selection-form__check" v-on:click="item.enabled = !item.enabled">{{item.enabled?'&#10003;':''}}</span>
                            <input type="text" v-model="item.answer1"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="כתוב את התשובה 1">
                            <input type="text" v-model="item.answer2"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="כתוב את התשובה 2">
                            <input type="text" v-model="item.answer3"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="כתוב את התשובה 3">
                            <input type="text" v-model="item.answer4"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="כתוב את התשובה 4">
                          </div>
                          <div v-if="item.questionType === 'sq'">
                            <input type="text" v-model="item.question"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="כתובת את הטקסט של השאלה">
                            <span class="candidate-selection-form__check" style="cursor: pointer" v-on:click="item.enabled = !item.enabled">{{item.enabled?'&#10003;':''}}</span>
                            </div>
                            <div v-if="item.questionType === 'lq'">
                              <input type="text" v-model="item.question"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder=" טקכתובת את הטקסט של השאלה">
                              <span class="candidate-selection-form__check" style="cursor: pointer" v-on:click="item.enabled = !item.enabled">{{item.enabled?'&#10003;':''}}</span>
                            </div>
                        </div>

                        <label class="candidate-selection-form__label candidate-selection-form__label--type-file">
                            <span>הוספת שאלה חדשה</span>
                            <input type="text" class="candidate-selection-form__add-new-question">
                            <span class="candidate-selection-form__add-new-question-body" v-on:click="showMenuPanel = !showMenuPanel">+</span>
                            <div class="candidate-selection-form__checkbox-container" v-if="showMenuPanel">
                                <div class="candidate-selection-form__checkbox-box">
                                    <div v-on:click.stop="addAmericanQuestion">
                                      <div class="candidate-selection-form__label">
                                          <span>הוספת שאלה אמריקאית</span>
                                          <input type="checkbox" class="candidate-selection-form__checkbox">
                                          <img class="candidate-selection-form__list-icon" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/list-icn-2.png"
                                              alt="i">
                                      </div>
                                    </div>
                                    <div>
                                      <div v-on:click.stop="addShortQuestion" class="candidate-selection-form__label">
                                          <span>הוספת שאלה - טקסט קצר</span>
                                          <input type="checkbox" class="candidate-selection-form__checkbox">
                                          <img class="candidate-selection-form__list-icon" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/list-icn.png"
                                              alt="i">
                                      </div>
                                    </div>
                                    <div v-on:click.stop="addLongQuestion">
                                      <div class="candidate-selection-form__label">
                                          <span>הוספת שאלה - טקסט ארוך</span>
                                          <input type="checkbox" class="candidate-selection-form__checkbox">
                                          <img class="candidate-selection-form__list-icon" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/list-icn-2.png"
                                              alt="i">
                                      </div>
                                    </div>
                                </div>
                            </div>                            
                        </label>

                        
                        <div class="candidate-selection-form__buttons">
                            <div @click="nextStep" class="candidate-selection-form__next-step-btn test-builder-next-step-btn">
                                <span> &gt; </span>
                                <span> המשך </span>
                            </div>
                            <div @click="prevStep" class="candidate-selection-form__prev-step-btn test-builder-prev-step-btn">
                                <span> אחורה </span>
                                <span> &lt; </span>
                            </div>
                        </div>

                    </form>

                </div>

            </section>

            <section v-if="countSteps === 3" class="test-builder__step-4 test-builder-step-4">

                <div class="test-builder-step-4__column test-summary">
                    <h2 class="test-summary__title">סיכום מבחן</h2>
                    <div class="test-summary__decor-line"></div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">שם המבחן</div>
                        <div class="test-summary__value">{{this.testBuilderName}}</div>
                    </div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">עיר</div>
                        <div class="test-summary__value">{{ this.testBuilderCity }}</div>
                        <div class="test-summary__card-label">שכר</div>
                        <div class="test-summary__value">{{this.testBuilderSalary}}</div>
                        <div class="test-summary__card-label">ניסיון נדרש</div>
                        <div class="test-summary__value">{{this.testBuilderExperienceRequired}}</div>
                        <div class="test-summary__card-label">סוג המשרה</div>
                        <div class="test-summary__value">{{this.testBuilderTypeJob}}</div>
                        <div class="test-summary__card-label">דרישות המשרה</div>
                        <div class="test-summary__value">{{ this.testBuilderJobRequirements }}</div>
                    </div>

                    <div class="test-summary__card">
                        <div v-if="qualitiesArr.length > 0" class="test-summary__icon">&#10003;</div>
                        <img v-if="qualitiesArr.length === 0" class="test-summary__icon" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/wait-icon.png" alt="">
                        <div class="test-summary__card-label">שם המבחן</div>
                        <div class="test-summary__value">
                            
                            {{testBuilderName}}
                            
                        </div>
                    </div>
                    
                </div>

                <div class="test-builder-step-4__column select-qualities">
                    <div class="select-qualities__pagination test-builder-pagination">
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num test-builder-pagination__num--active">1</div>
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num test-builder-pagination__num--active">2</div>
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num test-builder-pagination__num--active">3</div>
                        <div class="test-builder-pagination__line-decor"></div>
                        <div class="test-builder-pagination__num test-builder-pagination__num--active">4</div>
                        <div class="test-builder-pagination__line-decor"></div>
                    </div>

                    <div class="select-qualities__title">בחירת תכונות חשובות</div>
                    <div class="select-qualities__subtitle">בחרו תכונות שיתאימו למשרה בכדי לסנן את המועמדים</div>

                    <div class="select-qualities__list">
                        <div @click="addQualities" class="select-qualities__item" v-for="tax in questionTaxonomies">{{tax.name}}</div>
                    </div>

                    <div class="select-qualities__items selected-qualities">
                        <ul class="selected-qualities__list">
                            <h3 class="selected-qualities__subtitle">:התכונות שנבחרו</h3>
                            <li v-for="qualities in qualitiesArr" class="selected-qualities__item">
                                {{qualities}}
                            </li>
                            
                        </ul>
                    </div>

                    <div class="select-qualities__notice notice">
                        <p class="notice__text">שים לב! מומלץ להפחית בכמות התכונות כדי לא לעבור את זמן המבחן הממוצע</p>
                    </div>

                    <div class="select-qualities__buttons">
                        <div @click="prevStep" class="candidate-selection-form__prev-step-btn test-builder-prev-step-btn">
                            <span> אחורה </span>
                            <span> &lt; </span>
                        </div>
                        <div @click="nextStep" class="select-qualities__next-step-btn test-builder-next-step-btn">
                            <span> סיום ושמירת מבחן </span>
                        </div>
                    </div>
                </div>

            </section>

            <section v-if="countSteps === 4" class="test-builder__finish test-builder-finish">
                <div class="test-builder-finish__container">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/test-finish-icon.png" alt="icon" class="test-builder-finish__icon">
                    <h2 class="test-builder-finish__title">סיימת לבנות את המבחן בהצלחה!</h2>
                    <div class="test-builder-finish__subtitle">!באפשרותך 2 דרכים לשלוח את המבחן מה שנשאר זה רק לשלוח אותו
                        למועמדים ולראות את התוצאות בלוח הבקרה,בהצלחה</div>
                    <div class="test-builder-finish__info test-builder-finish-info">
<!--                        <div class="test-builder-finish-info__code test-code">
                            <span class="test-code__num">354</span>
                            <span class="test-code__label">קוד לשליחה למייל</span>
                        </div>-->
                        <div class="test-builder-finish-info__link-box test-link" dir="ltr">
                            <div ref="testLinkText" class="test-link__body">{{this.testLink}}</div>
                            <div @click="copyLink" class="test-link__copy-link-btn">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/copy-icn.png" alt="i">
                            </div>
                            <div class="test-link__label">קישור</div>
                        </div>
                        <div class="test-builder-finish-info__email test-email">
                            <div class="test-email__add-email" @click="redirectToTestPage()">הוספת מייל</div>
                            <div class="test-email__send">שליחה בדוא״ל</div>
                        </div>
                    </div>
                    <div @click="redirectToDashboard()" class="test-builder-finish__finish-btn">סיום</div>
                </div>
            </section>
        </div>
    </main>


    <?php get_footer(); ?>
    
   
    <script type="script"></script>
</body>

</html>