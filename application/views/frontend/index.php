<!DOCTYPE html>
<html lang="en">
<head>

    <!--[if IE]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <title>Srinagar British School</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="icon" type="image/png" href="<?= base_url(); ?>assets/assets/images/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/assets/css/animate.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/assets/css/master.css">


    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400" rel="stylesheet">


    <style>

        body {
            overflow-x: hidden;
        }

        #events {
            background-image: url("https://www.sbssrinagar.com/Skeletal-Weave-White-Tileable-pattern-for-website-background.jpg");
            padding-top: 70px;
            padding-bottom: 70px;
        }

        .card a:hover {
            text-decoration: none;
        }

        #events .card {
            border-radius: 0 !important;
            border: 0;
            box-shadow: 10px 10px 55px 1px #e5e5ea;
            transform: perspective(600px) rotateY(15deg);
            transition: all 300ms;
        }

        #events .card:hover {
            transform: perspective(0) rotateY(10deg) scale(1.1);
        }

        #events .card-header {
            font-weight: 500;
            color: #ffffff;
            background-color: #025AA5;
        }

        #events a {
            color: #000;
            font-family: "Montserrat", sans-serif;
            font-weight: 400;
            font-size: 14px;
        }

        #latest_visits {
            background-image: url("https://www.sbssrinagar.com/Skeletal-Weave-White-Tileable-pattern-for-website-background.jpg");
            margin-top: 30px;
            margin-bottom: 60px;
            padding: 50px 0;
        }

        #latest_visits .card {
            box-shadow: 5px 5px 10px 0 #dadada;
            border: 0;
            border-radius: 0;
            margin-bottom: 40px;
            margin-top: 40px;
            text-align: center;
            transform: perspective(600px) rotate(10deg);
            transition: all 300ms;
        }

        #latest_visits .card:hover {
            transform: rotate(4deg) scale(1.1);
            box-shadow: 25px 25px 30px 0 #cccccc;
        }

        #latest_visits .card .btn {
            border-radius: 40px;
            font-size: 14px;
            padding: 10px 20px;
        }

        #latest_visits h4 {
            font-family: "Montserrat", sans-serif;
            font-size: 18px;
            color: #000;
            margin-top: 20px;
            margin-bottom: 3px;
        }

        #latest_visits p {
            font-family: "Lato", sans-serif;
            color: #5d5d63;
            margin-top: 0;
            padding-top: 0;
        }

        .carousel img {
            width: 100% !important;
            height: 100% !important;
        }

        #footer .nav-item > a {
            color: #fff;
            font-size: 15px;
            margin-left: 15px;
        }

        #testimonials {
            background-color: #fff !important;
        }

        #testimonials li {
            background-color: #00216f;
        }

        #testimonials li.active {
            background-color: #0cbcf1;
        }

        @media only screen and (max-width: 750px) {
            #events .card .col-lg-8 {
                margin-top: 20px;
                text-align: center;
            }

        }

        #footer {
            background-color: #ffffff !important;
        }

    </style>


</head>

<body>


<?php
$this->load->view('frontend/header');
?>


<div id="slider">




    <a href="<?= base_url('admission_contact') ?>">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">


                <img  class="d-block img-fluid" src="<?= base_url('assets/images/Website.jpg');?>" >


                <?php
                /*if ($images[0]['Image1'] != "") {
                    echo '<img class="d-block img-fluid" src="' . base_url() . $images[0]['Image1'] . '" alt="First slide">';
                } else {
                    echo '<img class="d-block img-fluid" src="' . base_url("assets/assets/images/slide1.jpg") . '" alt="First slide">';
                }*/

                ?>

            </div>
           <!-- <div class="carousel-item">
                <?php
/*
                if ($images[0]['Image2'] != "") {
                    echo '<img class="d-block img-fluid" src="' . base_url() . $images[0]['Image2'] . '" alt="First slide">';
                } else {
                    echo '<img class="d-block img-fluid" src="' . base_url("assets/assets/images/slide1.jpg") . '" alt="First slide">';
                }

                */?>
            </div>
            <div class="carousel-item">
                <?php
/*
                if ($images[0]['Image3'] != "") {
                    echo '<img class="d-block img-fluid" src="' . base_url() . $images[0]['Image3'] . '" alt="First slide">';
                } else {
                    echo '<img class="d-block img-fluid" src="' . base_url("assets/assets/images/slide1.jpg") . '" alt="First slide">';
                }

                */?>
            </div>
            <div class="carousel-item">
                <?php
/*
                if ($images[0]['Image4'] != "") {
                    echo '<img class="d-block img-fluid" src="' . base_url() . $images[0]['Image4'] . '" alt="First slide">';
                } else {
                    echo '<img class="d-block img-fluid" src="' . base_url("assets/assets/images/slide1.jpg") . '" alt="First slide">';
                }

                */?>
            </div>-->
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    </a>

</div>

<div id="events">

    <div class="container">

        <div class="row">

            <div class="col-12 card-deck">

                <div class="card">
                    <div class="card-header">LATEST NEWS</div>
                    <div class="card-block">

                        <?php

                        if (isset($news) && count($news) > 0) {

                            foreach ($news as $e) {

                                echo '<div class="row mb-4">';

                                echo '<div class="col-3">';
                                if ($e['Image'] != "")
                                    echo '<img class="d-block img-fluid" src="' . base_url() . $e['Image'] . '" alt="First slide">';
                                else
                                    echo '<img class="d-block img-fluid" src="' . base_url() . $images[0]['Image1'] . '" alt="First slide">';
                                echo '</div>';


                                echo ' <div class="col-9"><a href="' . base_url('view_news/' . $e['NewsID']) . '">';
                                echo $e['Title'];


                                $date = date_create($e['Date']);

                                echo "<span style='color: #c7c7cb;font-size: 13px;font-weight: 500;letter-spacing: 2px'>";
                                echo '<br/><i class="fa fa-calendar"></i> ' . date_format($date, "d M Y");
                                echo "</span>";
                                echo '</a></div></div>';
                                echo "<hr style='border: 0;border-bottom: thin #dfdfe6 solid'/>";
                            }


                        } else {
                            echo '<div class="row mb-4">';

                            echo '<div class="col-3">';
                            echo '<img src="' . base_url() . $images[0]['Image1'] . '" class="img-fluid">';
                            echo '</div>';
                            echo ' <div class="col-9">';
                            echo "No News Available</div>";

                            echo "<hr style='border: 0;border-bottom: thin #dfdfe6 solid'/></div>";
                        }

                        ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">LATEST EVENTS</div>
                    <div class="card-block">
                        <?php

                        if (isset($events) && count($events) > 0) {


                            foreach ($events as $e) {

                                echo '<div class="row mb-4">';
                                echo '<div class="col-3">';

                                echo '<img class="d-block img-fluid" src="' . base_url() . $images[0]['Image1'] . '" alt="First slide">';

                                echo '</div>';
                                echo ' <div class="col-9"><a href="' . base_url('view_event/' . $e['EventID']) . '">';
                                echo $e['Name'];
                                $date = date_create($e['StartDate']);

                                echo "<span style='color: #c7c7cb;font-size: 13px;font-weight: 500;letter-spacing: 2px'>";
                                echo '<br/><i class="fa fa-calendar"></i> ' . date_format($date, "d M Y");
                                echo "</span>";
                                echo '</a></div></div>';
                                echo "<hr style='border: 0;border-bottom: thin #dfdfe6 solid'/>";
                            }
                        } else {
                            echo '<div class="row mb-4">';

                            echo '<div class="col-3">';
                            echo '<img src="' . base_url() . $images[0]['Image1'] . '" class="img-fluid">';
                            echo '</div>';
                            echo ' <div class="col-9">';
                            echo "No Events Available</div>";

                            echo "<hr style='border: 0;border-bottom: thin #dfdfe6 solid'/></div>";
                        }
                        ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">LATEST ACHIEVEMENTS</div>
                    <div class="card-block">
                        <?php

                        if (isset($achievements) && count($achievements) > 0) {

                            foreach ($achievements as $e) {

                                echo '<div class="row mb-4">';
                                echo '<div class="col-3">';

                                if ($e['Image'] != "")
                                    echo '<img class="d-block img-fluid" src="' . base_url() . $e['Image'] . '" alt="First slide">';
                                else
                                    echo '<img class="d-block img-fluid" src="' . base_url() . $images[0]['Image1'] . '" alt="First slide">';
                                echo '</div>';
                                echo ' <div class="col-9"><a href="' . base_url('view_achievement/' . $e['AchievementID']) . '">';
                                echo $e['Title'];
                                echo "<span style='color: #c7c7cb;font-size: 13px;font-weight: 500;letter-spacing: 2px'>";
                                echo '<br/><i class="fa fa-user"></i> ' . $e['AchievementBy'];
                                echo "</span>";
                                echo '</a></div>';
                                echo "<hr style='border: 0;border-bottom: thin #dfdfe6 solid'/></div>";
                            }
                        } else {
                            echo '<div class="row mb-4">';

                            echo '<div class="col-3">';
                            echo '<img src="' . base_url() . $images[0]['Image1'] . '" class="img-fluid">';
                            echo '</div>';
                            echo ' <div class="col-9">';
                            echo "No Achievements Available</div>";

                            echo "<hr style='border: 0;border-bottom: thin #dfdfe6 solid'/> </div>";
                        }

                        ?>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<div id="latest_visits">

    <div class="container">

        <div class="row">

            <div class="col-lg-12 mb-3">
                <h1 class="text-center" style="margin-bottom: 20px">Latest Visits<span class="heading-border"></span>
                </h1>

            </div>

            <div class="col-lg-12 card-deck">


                <?php

                if (isset($visits) && count($visits) > 0) {
                    foreach ($visits as $e) {

                        echo '<div class="card">';
                        echo '<div class="card-block">';

                        if ($e['Image'] != "")
                            echo '<img class="d-block img-fluid" src="' . base_url() . $e['Image'] . '" alt="First slide">';
                        else
                            echo '<img class="d-block img-fluid" src="' . base_url() . $images[0]['Image1'] . '" alt="First slide">';
                        echo "<h4>" . $e['VisitBy'] . "</h4>";
                        echo "<p>" . $e['Designation'] . "</p>";
                        echo '<a href="' . base_url('view_visit/' . $e['VisitID']) . '" class="btn btn-primary btn-sm">VIEW DETAILS</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="card">';
                    echo '<div class="card-block">';
                    echo '<img class="d-block img-fluid" src="' . base_url("assets/assets/images/slide1.jpg") . '" alt="First slide">';
                    echo "<h4>No Latest Visits</h4>";
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="card">';
                    echo '<div class="card-block">';
                    echo '<img class="d-block img-fluid" src="' . base_url("assets/assets/images/slide1.jpg") . '" alt="First slide">';
                    echo "<h4>No Latest Visits</h4>";
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="card">';
                    echo '<div class="card-block">';
                    echo '<img class="d-block img-fluid" src="' . base_url("assets/assets/images/slide1.jpg") . '" alt="First slide">';
                    echo "<h4>No Latest Visits</h4>";
                    echo '</div>';
                    echo '</div>';
                }

                ?>


            </div>

        </div>

    </div>

</div>

<div id="testimonials"
     style="margin-bottom: 50px;color: #000;background-image: url('https://www.sbssrinagar.com/Skeletal-Weave-White-Tileable-pattern-for-website-background.jpg')">

    <div class="container">

        <div class="row">

            <div class="col-12 mt-4">
                <h3>Testimonials</h3>
                <hr>
            </div>

            <div class="col-lg-12 pb-5 pt-3">

                <div id="carouselExampleIndicators" style="position: static !important;" class="carousel slide"
                     data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <div class="carousel-caption-testimonials">
                                <div class="row">

                                    <div class="col-lg-2">
                                        <?php

                                        if (!empty($principal[0]['Image'])) {
                                            echo '<img class="img-thumbnail" src="' . base_url() . $principal[0]['Image'] . '">';
                                        } else {
                                            echo '<img src="' . base_url() . 'assets/assets/images/Andy-Hadfield-Profile-SQUARE-Low-Res.jpg" class="img-thumbnail">';
                                        }

                                        ?>

                                    </div>

                                    <div class="col-lg-10">
                                        <p class="font-italic"
                                           style="color: #3a6dac"><?= $principal[0]['Message'] ?></p>
                                        <h5><?= $principal[0]['Name'] ?></h5>
                                        <h6>Principal - SBS Srinagar</h6>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="carousel-caption-testimonials">
                                <div class="row">

                                    <div class="col-lg-2">
                                        <?php

                                        if (!empty($vprincipal[0]['Image'])) {
                                            echo '<img class="img-thumbnail" src="' . base_url() . $vprincipal[0]['Image'] . '">';
                                        } else {
                                            echo '<img src="' . base_url() . 'assets/assets/images/Andy-Hadfield-Profile-SQUARE-Low-Res.jpg" class="img-thumbnail">';
                                        }

                                        ?>

                                    </div>

                                    <div class="col-lg-10">
                                        <p class="font-italic"
                                           style="color: #3a6dac"><?= $vprincipal[0]['Message'] ?></p>
                                        <h5><?= $vprincipal[0]['Name'] ?></h5>
                                        <h6>Vice Principal - SBS Srinagar</h6>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="carousel-caption-testimonials">
                                <div class="row">

                                    <div class="col-lg-2">
                                        <?php

                                        if (!empty($director[0]['Image'])) {
                                            echo '<img class="img-thumbnail" src="' . base_url() . $director[0]['Image'] . '">';
                                        } else {
                                            echo '<img src="' . base_url() . 'assets/assets/images/Andy-Hadfield-Profile-SQUARE-Low-Res.jpg" class="img-thumbnail">';
                                        }

                                        ?>

                                    </div>

                                    <div class="col-lg-10">
                                        <p class="font-italic"
                                           style="color: #3a6dac"><?= $director[0]['Message'] ?></p>
                                        <h5><?= $director[0]['Name'] ?></h5>
                                        <h6>Director - SBS Srinagar</h6>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php
$this->load->view("frontend/footer");
?>

<!--JAVASCRIPT-->
<script src="<?= base_url(); ?>assets/assets/js/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="<?= base_url(); ?>assets/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/scrollreveal.js/3.1.4/scrollreveal.min.js"></script>
<!--JAVASCRIPT-->

<script>


    $(document).ready(function () {


        //Function to animate slider captions
        function doAnimations(elems) {
            //Cache the animationend event in a variable
            var animEndEv = 'webkitAnimationEnd animationend';

            elems.each(function () {
                var $this = $(this),
                    $animationType = $this.data('animation');
                $this.addClass($animationType).one(animEndEv, function () {
                    $this.removeClass($animationType);
                });
            });
        }

        //Variables on page load
        var $myCarousel = $('.carousel'),
            $firstAnimatingElems = $myCarousel.find('.carousel-item:first').find("[data-animation ^= 'animated']");

        //Initialize carousel
        $myCarousel.carousel();

        //Animate captions in first slide on page load
        doAnimations($firstAnimatingElems);

        //Pause carousel
        $myCarousel.carousel('pause');


        //Other slides to be animated on carousel slide event
        $myCarousel.on('slide.bs.carousel', function (e) {
            var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
            doAnimations($animatingElems);
        });


        /***
         * SCROLL ANIMATIONS
         * **/


        window.sr = ScrollReveal({reset: true});

        sr.reveal("#events .card .col-lg-4", {duration: 2000, origin: 'left'});
        sr.reveal("#events .card .col-lg-8", {duration: 2000, origin: 'left'});
        /***
         * SCROLL ANIMATIONS
         * **/


    });


</script>


</body>

</html>