<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Student | Mailbox</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fullcalendar/fullcalendar.print.css" media="print">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/iCheck/flat/blue.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php $this->load->view("student_sidebar"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mailbox
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Mailbox</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Inbox</h3>


                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <!-- /.pull-right -->
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">


                                <?php if (count($messages) > 0) {
                                ?>
                                <thead>

                                <th></th>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Dated</th>
                                </thead>

                                <tbody>

                                <?php

                                foreach ($messages as $m) {
                                    $reading = site_url('StudentMessageController/read_mail/' . $m['MessageID']);

                                    ?>
                                    <tr>
                                        <td class="mailbox-star"><a href="#"></a></td>

                                        <td class="mailbox-name"><a href="<?= $reading ?>">
                                                <?php

                                                if ($m['AdminID'] != '0')
                                                    echo $m['AdminID'];
                                                elseif ($m['SenderTeacherID'] != '0')
                                                    echo $m['SenderTeacherID'];
                                                elseif ($m['SenderStudentID'] != '0')
                                                    echo $m['SenderStudentID'];
                                                elseif ($m['SenderParentID'] != '0')
                                                    echo $m['SenderParentID'];
                                                else
                                                    echo "Anonymous";

                                                ?></a></td>
                                        <td class="mailbox-subject"><b><?= $m['Subject'] ?></b></td>

                                        <td class="mailbox-date"><?= $m['Date'] ?></td>
                                    </tr>

                                <?php }
                                } else {
                                    ?>
                                    <tr>
                                        <td><h3>No Messages</h3></td>
                                    </tr>
                                    <?php
                                }
                                ?>

                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.box-body -->

                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
    </div>
    <!-- /.row -->
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
<script src="<?= base_url() ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="<?= base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url() ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>assets/dist/js/demo.js"></script>
<!-- iCheck -->
<script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Page Script -->
</body>
</html>