<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Compose Message</title>
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

    <?php $this->load->view("sidebar"); ?>

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

            <!-- ERROR SUCCESS MESSAGES-->
            <div class="row mt-3">

                <div class="col-lg-12">


                    <?php

                    $errors = validation_errors();

                    if ($errors) {
                        echo $errors;
                    }

                    if (isset($error)) {
                        echo '<p class="alert alert-danger"><i class="fa fa-warning"></i> ';
                        echo $error;
                        echo '</p>';
                    }


                    if (isset($success)) {
                        echo '<p class="alert alert-success">';
                        echo '<i class="fa fa-check-circle"></i> Message sent successfully </span>';
                        echo '</p>';
                    }
                    ?>


                </div>

            </div>
            <!-- ERROR SUCCESS MESSAGES-->

            <div class="row">

                <form action="" method="post" enctype="multipart/form-data">

                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Compose New Message</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <label>Select Department</label>
                                <select name="department" class="form-control">

                                    <?php

                                    if (isset($departments)) {

                                        echo '<option value="0">';
                                        echo 'Common to All';
                                        echo "</option>";
                                        foreach ($departments as $c) {
                                            echo '<option value="' . $c["DepartmentID"] . '">';
                                            echo $c['Name'];
                                            echo "</option>";
                                        }
                                    }

                                    ?>

                                </select><br/>
                                <br/>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea name="message" class="form-control"
                                              style="height: 300px"><?= $message; ?></textarea>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="pull-right">
                                    <button type="submit" name="submit" class="btn btn-primary"><i
                                                class="fa fa-envelope-o"></i> Send
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /. box -->
                    </div>
                </form>
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
<script>
    $(function () {
        //Add text editor
        $("#compose-textarea").wysihtml5();
    });
</script>
</body>
</html>
