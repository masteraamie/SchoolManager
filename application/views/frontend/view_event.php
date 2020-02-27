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
    <link rel="stylesheet" href="<?= base_url(); ?>assets/assets/css/master.css">


    <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Source+Sans+Pro" rel="stylesheet">


    <style>

        #news {
            font-family: "Montserrat", sans-serif;
        }

        #news h3 {
            font-size: 35px;
        }

        #news .col-lg-4 a {
            display: block;
        }

        #news .col-lg-4 p {
            font-family: "Lato", sans-serif;
            color: #3a3839;
        }

        #news .col-lg-4 img {
            width: 100%;
        }

    </style>


</head>

<body>


<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8&appId=1847243852190281";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>


<?php
$this->load->view('frontend/header');
?>


<div id="news" class="pb-5">

    <div class="container">

        <div class="row">

            <div class="col-lg-12 mt-5 mb-5">

                <h3>Events</h3>

            </div>

        </div>


        <div class="row">

            <?php

            if (isset($event)) {

                ?>

                <div class="col-lg-12 mt-5 mb-5">

                    <?php
                    if (!empty($event[0]['Image'])) {
                        echo '<img src="' . base_url() . $event[0]['Image'] . '" class="img-fluid">';
                    } else {
                        echo '<img class="img-fluid" src="' . base_url("assets/assets/images/slide1.jpg") . '">';
                    }
                    ?>

                    <br/>
                    <br/>
                    <a href="" class="mt-3 mb-1"><?= $event[0]['Name'] ?></a>
                    <br/>
                    <br/>
                    <h5>Start Date </h5>
                    <i class="fa fa-calendar"></i> <?php
                    $date = date_create($event[0]['StartDate']);
                    echo date_format($date, "d M Y"); ?>
                    <br/>
                    <br/>
                    <h5>End Date </h5>
                    <i class="fa fa-calendar"></i> <?php
                    $date = date_create($event[0]['EndDate']);
                    echo date_format($date, "d M Y"); ?>

                    <br/>
                    <br/>
                    <br/>
                    <br/>

                    <h5>Description</h5>

                    <p><?= $event[0]['Description'] ?></p>

                </div>
                <?php
            }
            ?>

        </div>


    </div>

</div>
<?php
$this->load->view("frontend/footer");
?>

<!--JAVASCRIPT-->
<script src="<?= base_url(); ?>assets/assets/js/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>assets/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/scrollreveal.js/3.1.4/scrollreveal.min.js"></script>
<!--JAVASCRIPT-->

<script>


    $(document).ready(function () {


        /***
         * SCROLL ANIMATIONS
         * **/


        window.sr = ScrollReveal({reset: true});

        sr.reveal("#events .card .col-lg-4", {duration: 2000, origin: 'left'});
        sr.reveal("#events .card .col-lg-8", {duration: 2000, origin: 'left'});
        sr.reveal("#latest_visits .card", {duration: 2000, origin: 'left'});
        /***
         * SCROLL ANIMATIONS
         * **/


    });


</script>


</body>

</html>