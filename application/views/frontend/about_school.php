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

                <h3>About The School</h3>

            </div>

        </div>

        <div class="row">

            <img src="<?= base_url(); ?>assets/images/about.jpg"/><br><br><br><br>
            <p>
                Srinagar British School is one of the pioneers in the school education in the valley of Kashmir.
                The school has been imparting the quality education to the students for more than two decades now.

                Srinagar British School has been functioning under the aegis of Srinagar Group of Schools since
                November, 1995 offering education imparting services since then, defying all odds.

                The school was initially established in the Raj Bagh vicinity of the Srinagar, J&K. Keeping pace with
                the growing demands in the field of education the school shifted its campus later on to the Nowgam
                Byepass, South City, Srinagar. The new campus provided students the modern high-class, earthquake
                resistant, infrastructure to the students at a serene location, away from the chaos of the city. In
                spite of being in a serene area, the new campus is on national highway NH1A that connects it to the city
                and across districts. The connectivity is reinforced by the transport section of the school; our school
                buses ply on almost every main route of the city and across districts. The school provides all
                fundamental facilities to the enrolled students and is
                committed to the mission under the able chairpersonship of Dr Nusrat Jahan.</p>

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