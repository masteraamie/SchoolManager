<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php $this->load->view('sidebar'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Version 2.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Students Enrolled</span>
                            <span class="info-box-number"><?= $students ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Employees</span>
                            <span class="info-box-number"><?= $employees ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-building-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Classes</span>
                            <span class="info-box-number"><?= $classes ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-arrow-circle-o-right"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Students Present</span>
                            <span class="info-box-number"><?= $present ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Expenditure For Month</span>
                            <span class="info-box-number"><?= $expenses ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-rupee"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Fee Income For Month</span>
                            <span class="info-box-number"><?= $fees ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">News and Attendance</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>

                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <p class="text-center">
                                        <strong>Student Attendance: 1 Jan, 2017 - 30 Jul, 2017</strong>
                                    </p>

                                    <div class="chart">
                                        <!-- Sales Chart Canvas -->
                                        <canvas id="salesChart" style="height: 180px;"></canvas>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                                <!-- /.col -->
                                <div class="col-lg-6">
                                    <p class="text-center">
                                        <strong>News</strong>
                                    </p>

                                    <div class="column-1_3 sc_column_item sc_column_item_1 odd first text_center">
                                        <div class="sc_price_block sc_price_block_style_2 width_100per">
                                            <marquee direction="up" onmouseover="stop();" onmouseout="start();"
                                                     scrollamount="3">
                                                <ul>

                                                    <?php

                                                    if (isset($news)) {
                                                        foreach ($news as $e) {
                                                            echo '<li class="btn btn-block"><h4><a href="' . base_url() . 'NewsController/view_news/' . $e["NewsID"] . '">';
                                                            echo $e['Title'] . " on " . $e['Date'];
                                                            echo "</a></h4></li>";
                                                        }
                                                    } else {
                                                        echo "<li>";
                                                        echo "No News Available";
                                                        echo "</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </marquee>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Events and Achievements</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>

                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <!-- /.col -->
                                <div class="col-lg-6">
                                    <p class="text-center">
                                        <strong>Achievements</strong>
                                    </p>

                                    <div class="column-1_3 sc_column_item sc_column_item_1 odd first text_center">
                                        <div class="sc_price_block sc_price_block_style_2 width_100per">
                                            <marquee direction="up" onmouseover="stop();" onmouseout="start();"
                                                     scrollamount="3">
                                                <ul>

                                                    <?php

                                                    if (isset($achievements)) {
                                                        foreach ($achievements as $e) {
                                                            echo '<li class="btn btn-block"><h4><a  href="' . base_url() . 'AchievementController/view_achievement/' . $e["AchievementID"] . '">';
                                                            echo $e['Title'] . " on " . $e['Date'];
                                                            echo "</a></h4></li>";
                                                        }
                                                    } else {
                                                        echo "<li>";
                                                        echo "No Achievements Available";
                                                        echo "</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </marquee>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-lg-6">
                                    <p class="text-center">
                                        <strong>Events</strong>
                                    </p>

                                    <div class="text_center">
                                        <div>
                                            <marquee direction="up" onmouseover="stop();" onmouseout="start();"
                                                     scrollamount="3">
                                                <ul>

                                                    <?php

                                                    if (isset($events)) {
                                                        foreach ($events as $e) {
                                                            echo '<li  class="btn btn-block"><h4><a href="' . base_url() . 'EventController/view_event/' . $e["EventID"] . '">';
                                                            echo $e['Name'] . " on " . $e['StartDate'];
                                                            echo "</a></h4></li>";
                                                        }
                                                    } else {
                                                        echo "<li>";
                                                        echo "No Events Available";
                                                        echo "</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </marquee>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    $this->load->view('footer');
    $this->load->view('settings');
    ?>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?= base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?= base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?= base_url(); ?>assets/plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url(); ?>assets/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url(); ?>assets/dist/js/demo.js"></script>
</body>
</html>
