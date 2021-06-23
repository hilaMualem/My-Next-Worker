<?php
/*
Template Name: Test Builder
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

    <main>
        <div class="test-builder">
            <section class="test-builder__step-1 test-builder-step-1">
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
                <input type="text" class="test-builder-step-1__test-name-input" placeholder="שם המבחן">
                <div class="test-builder-step-1__next-step test-builder-next-step-btn">&lt;המשך</div>
            </section>

            <section class="test-builder__step-2 test-builder-step-2">

                <div class="test-builder-step-2__column test-summary">
                    <h2 class="test-summary__title">סיכום מבחן</h2>
                    <div class="test-summary__decor-line"></div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">שם המבחן</div>
                        <div class="test-summary__value">מבחן קבלה מעצב גרפי</div>
                    </div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">עיר</div>
                        <div class="test-summary__value">באר שבע</div>
                        <div class="test-summary__card-label">שכר</div>
                        <div class="test-summary__value">6000-9000</div>
                        <div class="test-summary__card-label">ניסיון נדרש</div>
                        <div class="test-summary__value">ניסיון</div>
                        <div class="test-summary__card-label">סוג המשרה</div>
                        <div class="test-summary__value">משרה חלקית/מלאה</div>
                        <div class="test-summary__card-label">דרישות המשרה</div>
                        <div class="test-summary__value">תואר ראשון</div>
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
                            <input type="text" class="vacancy-info-form__input" placeholder="כתובת המשרה">
                            <input type="text" class="vacancy-info-form__input" placeholder="באיזו עיר?">
                        </div>
                        <div>
                            <input type="text" class="vacancy-info-form__input" placeholder="תאריך תחילת עבודה">
                            <input type="text" class="vacancy-info-form__input" placeholder="שכר">
                        </div>
                        <div>
                            <input type="text" class="vacancy-info-form__input" placeholder="סוג המשרה">
                            <input type="text" class="vacancy-info-form__input" placeholder="ניסיון נדרש">
                        </div>

                        <textarea name="" class="vacancy-info-form__textarea" placeholder="דרישות המשרה"></textarea>
                        <textarea name="" class="vacancy-info-form__textarea" placeholder="תיאור המשרה"></textarea>

                        <div class="vacancy-info-form__buttons">
                            <button class="vacancy-info-form__prev-step-btn test-builder-prev-step-btn">
                                <span> &lt; </span>
                                <span> המשך </span>
                            </button>
                            <button class="vacancy-info-form__next-step-btn test-builder-next-step-btn">
                                <span> אחורה </span>
                                <span> &gt; </span>
                            </button>
                        </div>
                    </form>
                </div>

            </section>

            <section class="test-builder__step-3 test-builder-step-3">

                <div class="test-builder-step-3__column test-summary">
                    <h2 class="test-summary__title">סיכום מבחן</h2>
                    <div class="test-summary__decor-line"></div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">שם המבחן</div>
                        <div class="test-summary__value">מבחן קבלה מעצב גרפי</div>
                    </div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">עיר</div>
                        <div class="test-summary__value">באר שבע</div>
                        <div class="test-summary__card-label">שכר</div>
                        <div class="test-summary__value">6000-9000</div>
                        <div class="test-summary__card-label">ניסיון נדרש</div>
                        <div class="test-summary__value">ניסיון</div>
                        <div class="test-summary__card-label">סוג המשרה</div>
                        <div class="test-summary__value">משרה חלקית/מלאה</div>
                        <div class="test-summary__card-label">דרישות המשרה</div>
                        <div class="test-summary__value">תואר ראשון</div>
                    </div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">שם המבחן</div>
                        <div class="test-summary__value">
                            ניהול אנשים, יוזמה </br> בעבודה, אנגלית </br>מתקדמים
                        </div>
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
                                placeholder="שם מלא">
                            <span class="candidate-selection-form__check">&#10003;</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="עיר מגורים">
                            <span class="candidate-selection-form__check">&#10003;</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="גיל / תאריך לידה">
                            <span class="candidate-selection-form__check">&#10003;</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="ניסיון">
                            <span class="candidate-selection-form__check">&#10003;</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="כתובת">
                            <span class="candidate-selection-form__check">&#10003;</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="דרישות שכר">
                            <span class="candidate-selection-form__check">&#10003;</span>
                        </div>

                        <div>
                            <textarea class="candidate-selection-form__textarea candidate-selection-form__input--valid"
                                placeholder="טקסט חופשי"></textarea>
                            <span class="candidate-selection-form__check">&#10003;</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="העלאת קורות חיים">
                            <span class="candidate-selection-form__check">&#10003;</span>
                        </div>

                        <div>
                            <input type="text"
                                class="candidate-selection-form__input candidate-selection-form__input--valid"
                                placeholder="כתוב את השאלה - טקסט קצר">
                            <span class="candidate-selection-form__check">&#10003;</span>
                        </div>

                        <label class="candidate-selection-form__label candidate-selection-form__label--type-file">
                            <span>הוספת שאלה חדשה</span>
                            <input type="file" class="candidate-selection-form__download-file">
                            <span class="candidate-selection-form__download-file-icon">+</span>
                        </label>

                        <div class="candidate-selection-form__checkbox-container">
                            <div class="candidate-selection-form__checkbox-box">
                                <label class="candidate-selection-form__label">
                                    <span>הוספת שאלה אמריקאית</span>
                                    <input type="checkbox" class="candidate-selection-form__checkbox">
                                    <img class="candidate-selection-form__list-icon" src="./assets/img/list-icn-3.png"
                                        alt="i">
                                </label>

                                <label class="candidate-selection-form__label">
                                    <span>הוספת שאלה - טקסט קצר</span>
                                    <input type="checkbox" class="candidate-selection-form__checkbox">
                                    <img class="candidate-selection-form__list-icon" src="./assets/img/list-icn.png"
                                        alt="i">
                                </label>

                                <label class="candidate-selection-form__label">
                                    <span>הוספת שאלה - טקסט ארוך</span>
                                    <input type="checkbox" class="candidate-selection-form__checkbox">
                                    <img class="candidate-selection-form__list-icon" src="./assets/img/list-icn-2.png"
                                        alt="i">
                                </label>
                            </div>
                        </div>




                        <div class="candidate-selection-form__buttons">
                            <button class="candidate-selection-form__prev-step-btn test-builder-prev-step-btn">
                                <span> &lt; </span>
                                <span> המשך </span>
                            </button>
                            <button class="candidate-selection-form__next-step-btn test-builder-next-step-btn">
                                <span> אחורה </span>
                                <span> &gt; </span>
                            </button>
                        </div>

                    </form>

                </div>

            </section>

            <section class="test-builder__step-4 test-builder-step-4">

                <div class="test-builder-step-4__column test-summary">
                    <h2 class="test-summary__title">סיכום מבחן</h2>
                    <div class="test-summary__decor-line"></div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">שם המבחן</div>
                        <div class="test-summary__value">מבחן קבלה מעצב גרפי</div>
                    </div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">עיר</div>
                        <div class="test-summary__value">באר שבע</div>
                        <div class="test-summary__card-label">שכר</div>
                        <div class="test-summary__value">6000-9000</div>
                        <div class="test-summary__card-label">ניסיון נדרש</div>
                        <div class="test-summary__value">ניסיון</div>
                        <div class="test-summary__card-label">סוג המשרה</div>
                        <div class="test-summary__value">משרה חלקית/מלאה</div>
                        <div class="test-summary__card-label">דרישות המשרה</div>
                        <div class="test-summary__value">תואר ראשון</div>
                    </div>

                    <div class="test-summary__card">
                        <div class="test-summary__icon">&#10003;</div>
                        <div class="test-summary__card-label">שם המבחן</div>
                        <div class="test-summary__value">
                            ניהול אנשים, יוזמה </br> בעבודה, אנגלית </br>מתקדמים
                        </div>
                    </div>
                    <div class="test-summary__card">
                        <img src="./assets/img/wait-icon.png" alt="icn" class="test-summary__icon-wait">
                        <div class="test-summary__card-label">זמן מבחן מוערך</div>
                        <div class="test-summary__value">
                            בערך 48 דק
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
                        <div class="select-qualities__item">פסיכוטכני</div>
                        <div class="select-qualities__item">עצמאות</div>
                        <div class="select-qualities__item select-qualities__item--selected">ניהול אנשים</div>
                        <div class="select-qualities__item">יכולת סדר וארגון</div>

                        <div class="select-qualities__item select-qualities__item--selected">יוזמה בעבודה</div>
                        <div class="select-qualities__item">עבודה תחת לחץ</div>
                        <div class="select-qualities__item">אחראיות אישית</div>

                        <div class="select-qualities__item">השתלבות במסגרת</div>
                        <div class="select-qualities__item">יציבות תעסוקתית</div>
                        <div class="select-qualities__item">יכולת מתן שירות</div>

                        <div class="select-qualities__item">פסיכוטכני</div>
                        <div class="select-qualities__item">עצמאות</div>
                        <div class="select-qualities__item select-qualities__item--selected">ניהול אנשים</div>
                        <div class="select-qualities__item">יכולת סדר וארגון</div>

                        <div class="select-qualities__item"> אנגלית בסיסית</div>
                        <div class="select-qualities__item select-qualities__item--selected">הבנת הוראות</div>
                        <div class="select-qualities__item">אינטליגניציה</div>

                        <div class="select-qualities__item">אנגלית מתקדמים</div>
                    </div>

                    <div class="select-qualities__items selected-qualities">
                        <ul class="selected-qualities__list">
                            <h3 class="selected-qualities__subtitle">:התכונות שנבחרו</h3>
                            <li class="selected-qualities__item">ניהול אנשים</li>
                            <li class="selected-qualities__item">יוזמה בעבודה</li>
                            <li class="selected-qualities__item">יכולת סדר וארגון</li>
                        </ul>
                    </div>

                    <div class="select-qualities__notice notice">
                        <p class="notice__text">שים לב! מומלץ להפחית בכמות התכונות כדי לא לעבור את זמן המבחן הממוצע</p>
                    </div>

                    <div class="select-qualities__buttons">
                        <button class="candidate-selection-form__next-step-btn test-builder-next-step-btn">
                            <span> אחורה </span>
                            <span> &gt; </span>
                        </button>
                        <button class="select-qualities__next-step-btn test-builder-next-step-btn">
                            <span> סיום ושמירת מבחן </span>
                        </button>
                    </div>
                </div>

            </section>

            <section class="test-builder__finish test-builder-finish">
                <div class="test-builder-finish__container">
                    <img src="./assets/img/label-icon.png" alt="icon" class="test-builder-finish__icon">
                    <h2 class="test-builder-finish__title">סיימת לבנות את המבחן בהצלחה!</h2>
                    <div class="test-builder-finish__subtitle">!באפשרותך 3 דרכים לשלוח את המבחןמה שנשאר זה רק לשלוח אותו
                        למועמדים ולראות את התוצאות בלוח הבקרה,בהצלחה</div>
                    <div class="test-builder-finish__info test-builder-finish-info">
                        <div class="test-builder-finish-info__code test-code">
                            <span class="test-code__num">354</span>
                            <span class="test-code__label">קוד לשליחה למייל</span>
                        </div>
                        <div class="test-builder-finish-info__link-box test-link">
                            <div class="test-link__body">https://mynextworker/some-link</div>
                            <div class="test-link__copy-link-btn">
                                <img src="./assets/img/copy-icn.png" alt="i">
                            </div>
                            <div class="test-link__label">קישור</div>
                        </div>
                        <div class="test-builder-finish-info__email test-email">
                            <div class="test-email__add-email">הוספת מייל</div>
                            <div class="test-email__send">שליחה בדוא״ל</div>
                        </div>
                    </div>
                    <div class="test-builder-finish__finish-btn">סיום</div>
                </div>
            </section>
        </div>
    </main>


    <?php get_footer(); ?>


</body>

</html>