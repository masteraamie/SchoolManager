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
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/select2/select2.min.css">
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
                Add Batch
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
                <li><a href="#">Academic</a></li>
                <li class="active">Add Batch</li>
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
                        echo '<i class="fa fa-check-circle"></i> Batch added successfully';
                        echo '</p>';
                    }

                    ?>


                </div>

            </div>
            <!-- ERROR SUCCESS MESSAGES-->

            <!--FORM-->
            <form action="" method="post">
                <div class="row mt-4">


                    <div class="col-lg-6">

                        <label>Batch Year</label>
                        <input name="year" type="number" class="form-control"><br>

                        <input value="Add Batch" type="submit" class="btn btn-success pull-right">
                    </div>

                </div>
            </form>
            <!--FORM-->


            <!--TABLE-->
            <div class="row">

                <div class="col-lg-12">


                    <?php
                    if (!empty($batches)) {
                        echo $pages; ?>

                        <table id="table2excel" class="table table-striped mt-4">
                            <thead>
                            <tr>
                                <th>Batch ID</th>
                                <th>Year</th>
                                <th class="noExl">View/Edit</th>
                                <th class="noExl">Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($batches as $c) {
                                echo "<tr>";

                                echo "<td>";
                                echo $c['BatchID'];
                                echo "</td>";

                                echo "<td>";
                                echo $c['Year'];
                                echo "</td>";

                                $url = site_url('AcademicController/edit_batch/' . $c["BatchID"] . '/0');
                                echo '<td class="noExl"><a href="' . $url . '">';
                                echo '<i class="fa fa-eye"></i>';
                                echo "</a></td>";

                                $url = site_url('AcademicController/delete_batch/' . $c["BatchID"]);
                                echo '<td class="noExl"><a name="remove" href="' . $url . '">';
                                echo '<i class="fa fa-remove"></i>';
                                echo "</a></td>";

                                echo "</tr>";
                            }

                            ?>
                            </tbody>
                        </table>

                        <button id="export" class="btn btn-primary pull-right">Export</button>


                    <?php } else {
                        echo "<tr>";
                        echo "No batches created";
                        echo "</tr>";
                    }
                    ?>


                </div>

            </div>
            <!--TABLE-->

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
<script src="<?= base_url(); ?>assets/js/confirm.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?= base_url(); ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?= base_url(); ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?= base_url(); ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?= base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?= base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?= base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?= base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?= base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url(); ?>assets/dist/js/demo.js"></script>
<script src="<?= base_url(); ?>assets/tableExport/dist/jquery.table2excel.js"></script>

<!-- Page script -->
<script>

    $("#export").click(function () {

        $("#table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name",
            filename: "batches",
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
        });

    });


</script>
</body>
</html>
