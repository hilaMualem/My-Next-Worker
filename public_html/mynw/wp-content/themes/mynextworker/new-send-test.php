<?php
/*
Template Name: New Send Test
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

<body <?php body_class(); ?> style="font-family: Rubik, sans-serif"  style="padding: 15px;" >
    <?php wp_body_open(); ?>

    <div id="header__top" class="header__top">
        <div class="header__logo">
            <?php 
					$logo = get_field('logo_img', 200);
					if( !empty( $logo ) ): ?>
            <a href="http://mynw/home/">
                <img class="header__logo" src="<?php echo esc_url($logo['url']); ?>"
                    alt="<?php echo esc_attr($logo['alt']); ?>" />
            </a>
            <?php endif; ?>
        </div>

    </div>
    
        <div id="send-test-pop-up" class="send-test-pop-up">

            <svg class="send-test-pop-up__close-icon" id="send-test-pop-up__close-icon" width="21.673" height="23.356"
                viewBox="0 0 21.673 23.356">
                <defs>
                    <style>
                        .cls-1 {
                            fill: none;
                            stroke: #5c5c5c;
                            stroke-width: 2px
                        }
                    </style>
                </defs>
                <g id="Group_29109" transform="translate(423.237 1410.176)">
                    <path id="Line_1" d="M0 0L20.2 22.003" class="cls-1" transform="translate(-422.5 -1409.5)" />
                    <path id="Line_2" d="M20.2 0L0 22.003" class="cls-1" transform="translate(-422.5 -1409.5)" />
                </g>
            </svg>


            <img src="assets/img/msg-icon.png" alt="icon" class="send-test-pop-up__icon">
            <h3 class="send-test-pop-up__title">שליחת מבחן למועמד</h3>
            <p class="send-test-pop-up__info">באפשרותכם לשלוח לכמה מועמדים במקבלים</p>
            <p class="send-test-pop-up__info">רק נשאר למלא את מייל המועמד וללחוץ שליחה</p>


            <form action="" class="send-test-pop-up__form">
                <div>
                    <button class="send-test-pop-up__btn" type="button">נשלח</button>
                    <input type="text" class="send-test-pop-up__input" placeholder="dordavid34@gmail.com">
                </div>

                <div>
                    <button class="send-test-pop-up__btn send-test-pop-up__btn--sending" type="button">שליחה</button>
                    <input type="text" class="send-test-pop-up__input" placeholder="מייל מועמד">
                </div>

                <div class="send-test-pop__add-candidate add-candidate">
                    <span class="add-candidate__label">הוספת מועמד</span>
                    <img src="assets/img/add-icon.png" class="add-candidate__icon" alt="icon">
                </div>

                <button type="submit" class="send-test-pop-up__submit-btn">סיום</button>
            </form>

        </div>



    <?php get_footer(); ?>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let btnOpenPopUp = document.getElementById("header__top");
            let popUp = document.getElementById("send-test-pop-up");
            let popUpCloseIcon = document.getElementById("send-test-pop-up__close-icon");
            btnOpenPopUp.addEventListener("click", () => {
                popUp.style.display = "block";
            })
            popUpCloseIcon.addEventListener("click", () => {
                popUp.style.display = "none";
            })
        })

    </script>
</body>

</html>