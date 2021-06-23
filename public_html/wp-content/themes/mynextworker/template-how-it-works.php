<?php
/* Template Name: How It Works */

function add_font()
{
    echo ('<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600&display=swap" rel="stylesheet">');
}

add_action("wp_head", "add_font");
get_header();
?>
<section class="how-it-works-page">
    <?php
    $section = get_field("section");
    if ($section) {
        echo '<section class="wrap-sections">';
        foreach ($section as $item) {
            $title = $item["section_title"];
            $text = $item["section_text"];
            $image = $item["section_img"];
    ?>
            <section class="how-it-works-section">
                <div class="container">
                    <div class="wrap-text">
                        <h2><?php echo $title; ?></h2>
                        <div><?php echo $text; ?></div>
                    </div>
                    <div class="wrap-image">
                        <img src="<?php echo $image; ?>" alt="">
                    </div>
                </div>
            </section>
    <?php
        }
        echo '</section>';
    }

    ?>

    <section class="cta-section" style="background-image: url('<?php echo get_field("background_img") ?>');">
        <div class="container">
            <h2><?php echo get_field("cta_text") ?></h2>
            <a href="<?php echo get_field("cta_btn_link") ?>"><span><?php echo get_field("cta_btn_txt") ?></span></a>
        </div>
    </section>

</section>



<?php get_footer();
?>

<style>
    img {
        max-width: 100%;
    }

    section.how-it-works-page {
        padding-top: 100px;
        font-family: Rubik, sans-serif !important;
        line-height: 32px;
    }

    section.how-it-works-page h2 {
        font-size: 45px;
        font-weight: 500;
    }

    section.how-it-works-page div {
        font-size: 16px;
    }

    section.how-it-works-section {
        padding: 100px;
    }

    section.how-it-works-section .container {
        max-width: 1440px;
        margin: auto;
    }

    section.how-it-works-page .wrap-sections .how-it-works-section:nth-child(2),
    section.how-it-works-page .wrap-sections .how-it-works-section:nth-child(5) {
        background: #F8F8F8;
    }

    .wrap-sections .how-it-works-section .container {
        display: flex;
    }

    .wrap-sections .how-it-works-section:nth-child(2) .container {
        flex-direction: column;
    }

    .wrap-sections .how-it-works-section:nth-child(2) .container>div {
        text-align: center;
    }

    .wrap-sections .how-it-works-section:nth-child(2) .container .wrap-text {
        margin-bottom: 90px;
    }

    .wrap-sections .how-it-works-section:nth-child(2) .container .wrap-text>div {
        width: 60%;
        margin: auto;
    }

    .wrap-sections .how-it-works-section .container>div {
        flex-basis: 50%;
        padding: 0px 80px;
    }

    .wrap-sections .how-it-works-section:nth-child(4) .container {
        flex-direction: row-reverse;
    }

    section.cta-section .container {
        display: flex;
        flex-direction: column;
        text-align: center;
        padding: 150px;
    }

    section.cta-section .container a {
        background: #3ECCB5;
        width: 160px;
        height: 38px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 5px;
        margin: auto;
        text-decoration: none;
    }

    section.cta-section .container a span {
        color: white;
    }

    @media (max-width:1280px) {
        .wrap-sections .how-it-works-section .container>div {
            padding: 0px 30px;
        }
    }

    @media (max-width:1024px) {
        section.how-it-works-section {
            padding: 100px 0px;
        }
    }

    @media (max-width:768px) {
        section.how-it-works-page {
            padding-top: 0px;
        }

        section.how-it-works-section {
            padding: 75px 0px
        }

        section.how-it-works-page h2 {
            text-align: center;
            font-size: 35px;
        }

        .wrap-sections .how-it-works-section:nth-child(4) .container,
        .wrap-sections .how-it-works-section .container {
            flex-direction: column;
        }

        .wrap-sections .how-it-works-section .container>div {
            flex-basis: 100%;
        }

        .wrap-sections .how-it-works-section:nth-child(2) .container .wrap-text>div {
            width: 100%;
        }
        .wrap-sections .how-it-works-section .container .wrap-image{
            text-align: center;
        }

        section.cta-section .container {
            padding: 0px;
        }

        .wrap-sections .how-it-works-section .container .wrap-text {
            margin-bottom: 32px;
        }
    }
</style>