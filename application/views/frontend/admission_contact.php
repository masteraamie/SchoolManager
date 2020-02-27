<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>assets/assets/images/favicon.ico"/>
    <title>Contact Us | Srinagar British School</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="icon" type="image/png" href="<?= base_url(); ?>assets/assets/images/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/assets/css/master.css">


    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Source+Sans+Pro" rel="stylesheet">


    <style>


    </style>


</head>
<body class="page body_style_fullscreen body_filled article_style_boxed top_panel_style_dark top_panel_opacity_solid top_panel_above menu_right sidebar_hide">
<a id="toc_top" class="sc_anchor" title="To Top"
   data-description="&lt;i&gt;Back to top&lt;/i&gt; - &lt;br&gt;scroll to top of the page"
   data-icon="icon-angle-double-up" data-url="" data-separator="yes"></a>

<div class="body_wrap">
    <div class="page_wrap">
        <div class="top_panel_fixed_wrap"></div>

        <?php
        $this->load->view('frontend/header');
        ?>

        <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>assets/assets/images/favicon.ico"/>
        <title>Contact Us | Srinagar British School</title>
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&amp;subset=latin%2Clatin-ext&amp;ver=4.3.1"
              type="text/css" media="all"/>
        <link rel="stylesheet"
              href="http://fonts.googleapis.com/css?family=Roboto:100,100italic,300,300italic,400,400italic,700,700italic&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext"
              type="text/css" media="all"/>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister:400&amp;subset=latin"
              type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/fontello/css/fontello.css" type="text/css"
              media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/js/rs-plugin/settings.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/shortcodes.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/core.animation.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/tribe-style.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/skins/skin.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/js/mediaelement/mediaelementplayer.min.css"
              type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/js/mediaelement/wp-mediaelement.css" type="text/css"
              media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/js/prettyPhoto/css/prettyPhoto.css" type="text/css"
              media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/js/core.customizer/front.customizer.css" type="text/css"
              media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/js/core.messages/core.messages.css" type="text/css"
              media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/js/swiper/idangerous.swiper.min.css" type="text/css"
              media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/homepage3-custom.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/core.portfolio.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/responsive.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/skins/skin-responsive.css" type="text/css"
              media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/slider-style.css" type="text/css" media="all"/>
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom-style.css" type="text/css" media="all"/>
        <!--Menu End  Here-->
        <div class="page_top_wrap page_top_title page_top_breadcrumbs sc_pt_st1">
            <div class="content_wrap">
                <div class="breadcrumbs">
                    <a class="breadcrumbs_item home">Home</a>
                    <span class="breadcrumbs_delimiter"></span>
                    <span class="breadcrumbs_item current">Admission Query</span>
                </div>
                <h1 class="page_title">Admission Query</h1>
            </div>
        </div>
        <div class="page_content_wrap">
            <div class="content">
                <article class="post_item post_item_single page">
                    <section class="post_content">
                        <div class="sc_section">
                        <!-- ERROR SUCCESS MESSAGES-->
                        <div class="row mt-3">

                            <div class="col-lg-12">


                                <?php


                                $errors = validation_errors();

                                if ($errors) {
                                    echo $errors;
                                }


                                ?>


                            </div>

                        </div>
                        <!-- ERROR SUCCESS MESSAGES-->
                        <form method="post">
                            <div class="sc_section bg_tint_dark sc_contact_bg_img">
                                <div class="sc_section_overlay sc_contact_bg_color" data-overlay="0.8"
                                     data-bg_color="#05BDEB">
                                    <div class="sc_section_content">
                                        <div class="sc_content content_wrap margin_top_3em_imp margin_bottom_3_5em_imp">
                                            <div id="sc_contact_form"
                                                 class="sc_contact_form sc_contact_form_standard aligncenter width_80per">

                                                <p class="sc_contact_form_description">Your email address will not be
                                                    published. Required fields are marked *</p>
                                                <form id="sc_contact_form_1" data-formtype="contact" method="post">
                                                    <div class="sc_contact_form_info">
                                                        <div class="sc_contact_form_item sc_contact_form_field label_over">
                                                            <label class="required"
                                                                   for="sc_contact_form_username">Name</label>
                                                            <input id="sc_contact_form_username" type="text"
                                                                   name="username" placeholder="Name *">
                                                        </div>
                                                        <div class="sc_contact_form_item sc_contact_form_field label_over">
                                                            <label class="required"
                                                                   for="sc_contact_form_email">E-mail</label>
                                                            <input id="sc_contact_form_email" type="text" name="email"
                                                                   placeholder="E-mail">
                                                        </div>
                                                        <div class="sc_contact_form_item sc_contact_form_field label_over">
                                                            <label class="required"
                                                                   for="sc_contact_form_subj">Contact</label>
                                                            <input id="sc_contact_form_subj" type="text" name="subject"
                                                                   placeholder="Contact *">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <input type="submit" value="Download"/>
                                                    </div>
                                                    <div class="result sc_infobox"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </article>
            </div>
        </div>
    </div>
</div>

<?php
$this->load->view("frontend/footer");
?>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/core.googlemap.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/diagram/chart.min.js"></script>
<script src="<?= base_url(); ?>assets/assets/js/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>assets/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/scrollreveal.js/3.1.4/scrollreveal.min.js"></script>
</body>
</html>