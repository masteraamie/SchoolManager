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

        #achievements {
            font-family: "Montserrat", sans-serif;
        }

        #achievements h3 {
            font-size: 35px;
        }

        #achievements .col-lg-4 a {
            display: block;
        }

        #achievements .col-lg-4 p {
            font-family: "Lato", sans-serif;
            color: #3a3839;
        }

        #achievements .col-lg-4 img {
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


<div id="achievements" class="pb-5">

    <div class="container">

        <div class="row">

            <div class="col-lg-12 mt-5 mb-5">

                <h3>Assignment Downloads Section</h3>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-12 pl-4 pr-4" style="padding: 20px 0;background-color: #eeeced">

                <h4 class="mb-3"><i class="fa fa-search"></i> Find Assignment</h4>

                <div class="row">


                    <div class="col-lg-4">

                        Select Class
                        <select id="class" class="form-control">
                            <option value="0">All Classes</option>
                            <?php

                            if (isset($classes)) {
                                foreach ($classes as $c) {
                                    echo '<option value="' . $c["ClassID"] . '">';
                                    echo $c['Name'];
                                    echo "</option>";
                                }
                            }

                            ?>
                        </select>
                        <br>

                    </div>

                    <div class="col-lg-4">
                        Select Section
                        <select id="section" class="form-control">
                            <option value="0">All Sections</option>
                        </select>
                        <br>

                    </div>

                    <div class="col-lg-8">


                        <input id="btn_get" type="button" class="btn btn-primary float-right" value="Search">
                        <br>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-12">

                        <table class="table table-active table-bordered table-hover mt-4">

                            <?php

                            if (!empty($assignments)) {
                            ?>

                            <thead id="table_head">
                            <tr>
                                <td>Date of Submission</td>
                                <td>Title</td>
                                <td>Class</td>
                                <td>Section</td>
                                <td>Subject</td>
                                <td>Action</td>
                            </tr>
                            </thead>

                            <tbody id="table_body">
                            <?php foreach ($assignments as $c) {
                                echo "<tr>";

                                echo "<td>";
                                $date = date_create($c['DOS']);
                                echo date_format($date, "d M Y");
                                echo "</td>";

                                echo "<td><a href='" . base_url("view_assignment/" . $c['AssignmentID']) . "'>";
                                echo $c['Title'];
                                echo "</a></td>";


                                foreach ($classes as $a) {

                                    if ($c['ClassID'] == $a['ClassID']) {
                                        echo "<td>";
                                        echo $a['Name'];
                                        echo "</td>";
                                    }
                                }

                                echo "<td>";
                                foreach ($sections as $a) {

                                    if ($c['SectionID'] == $a['SectionID']) {

                                        echo $a['Name'];

                                    }
                                }

                                echo "</td>";

                                foreach ($subjects as $a) {

                                    if ($c['SubjectID'] == $a['SubjectID']) {
                                        echo "<td>";
                                        echo $a['Name'];
                                        echo "</td>";
                                    }
                                }


                                $url = site_url('DownloadFiles/download_assignment/' . $c["AssignmentID"]);
                                echo '<td><a class="btn btn-sm btn-outline-primary" href="' . $url . '">';
                                echo "SAVE</a></td>";

                                echo "</tr>";
                            }

                            ?>
                            </tbody>
                        </table>

                        <?php } else {
                            echo "<tr>";
                            echo "No Assignment created";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        <div class="row mt-4">

            <div class="col-lg-12">

                <?= $pages; ?>

            </div>

        </div>

    </div>

</div>


<?php
$this->load->view("frontend/footer");
?>

<!--JAVASCRIPT-->
<script src="<?= base_url(); ?>assets/assets/js/jquery.js"></script>
<script src="<?= base_url(); ?>/assets/js/loadSections.js"></script>
<script src="<?= base_url(); ?>/assets/js/getAssignments.js"></script>
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