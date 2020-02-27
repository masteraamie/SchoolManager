<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datepicker/datepicker3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
                Edit Expenditure
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Expenditure</a></li>
                <li class="active">Edit Expenditure</li>
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


                    if (isset($success)) {
                        echo '<p class="alert alert-success">';
                        echo '<i class="fa fa-check-circle"></i> Expenditure added successfully.</span>';
                        echo '</p>';
                    }

                    ?>


                </div>

            </div>
            <!-- ERROR SUCCESS MESSAGES-->

            <!--FORM-->
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row mt-4">


                    <div class="box box-success">
                        <div class="box-header"><h3 class="box-title">Expenditure Details</h3></div>


                        <div class="box-body">
                            <div class="col-md-6">

                                <label>Expenditure Name</label>
                                <input type="text" name="name" value="<?= $expenditure[0]['Name'] ?>"
                                       class="form-control">


                                <br/>
                                <label>Expenditure Amount ( in Rupees )</label>
                                <input name="amount" type="number" value="<?= $expenditure[0]['Amount']; ?>"
                                       class="form-control"><br>

                                <label>Receipt ID ( if any )</label>
                                <input name="receipt" type="text" value="<?= $expenditure[0]['ReceiptID'] ?>"
                                       class="form-control"><br>

                            </div>
                            <div class="col-md-6">

                                <label>Date</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" name="date" value="<?= $expenditure[0]['Date'] ?>"
                                           class="form-control">
                                </div>
                                <br>

                                <label>Payment Mode</label>
                                <select name="mode" id="mode" class="form-control">
                                    <?php


                                    $modes = array(1 => "Cash", 2 => "Cheque", 3 => "Card");

                                    foreach ($modes as $k => $m) {
                                        if ($k == $expenditure[0]['Mode'])
                                            echo "<option selected value='" . $k . "'>";
                                        else
                                            echo "<option value='" . $k . "'>";

                                        echo $m . "</option>";
                                    }

                                    ?>
                                    <option value="1">Cash</option>
                                    <option value="2">Cheque</option>
                                    <option value="3">Credit/Debit Card</option>
                                </select><br/>

                                <label>Cheque Number ( if any )</label>
                                <input name="cheque" id="cheque" disabled value="<?= $expenditure[0]['ChequeNumber'] ?>"
                                       type="text" class="form-control"><br>

                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea name="details" placeholder="Expenditure Details" id="compose-textarea"
                                              class="form-control"
                                              style="height: 300px"><?= $expenditure[0]['Details'] ?></textarea>
                                </div>

                                <input type="submit" name="submit" value="Edit Expenditure"
                                       class="btn btn-success pull-right">

                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <!--FORM-->

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
<script src="<?= base_url() ?>assets/js/expenditure.js"></script>

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
        //Edit text editor
        $("#compose-textarea").wysihtml5();
    });
</script>
</body>
</html>
