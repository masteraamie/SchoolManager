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


    <?php $this->load->view('accountant_sidebar'); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Expenditure List
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Expenditure</a></li>
                <li class="active">Expenditure List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!--FORM-->
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row mt-4">

                    <div class="box box-success">
                        <div class="box-header"><h3 class="box-title">Refine List</h3></div>


                        <div class="box-body">

                            <div class="col-md-4">


                                <label>Select Month</label>
                                <select id="month" name="month" class="form-control">
                                    <option value="0">Select a Month</option>
                                    <?php

                                    $months = array(

                                        1 => "January",
                                        2 => "February",
                                        3 => "March",
                                        4 => "April",
                                        5 => "May",
                                        6 => "June",
                                        7 => "July",
                                        8 => "August",
                                        9 => "September",
                                        10 => "October",
                                        11 => "November",
                                        12 => "December",
                                    );


                                    if (isset($months)) {
                                        foreach ($months as $k => $c) {
                                            echo '<option value="' . $k . '">';
                                            echo $c;
                                            echo "</option>";
                                        }
                                    }


                                    ?>

                                </select><br/>
                            </div>

                            <div class="col-md-4">

                                <label>Select Year</label>

                                <select id="year" name="year" class="form-control">

                                    <option value="0">Select a Year</option>
                                    <?php

                                    for ($i = 2017; $i <= date('Y'); $i++) {
                                        echo '<option value="' . $i . '">';
                                        echo $i;
                                        echo "</option>";
                                    }

                                    ?>

                                </select><br/>


                            </div>

                            <div class="col-lg-12 mt-3">

                                <input value="Get Expenditures" type="button" id="btn_get"
                                       class="btn btn-success pull-right">

                            </div>
                        </div>
                    </div>

                    <div id="box_expenditures" class="box box-success">
                        <div class="box-header"><h3 class="box-title">Expenditure List</h3></div>


                        <div class="box-body">

                            <?php

                            if (isset($expenditures)) {

                                echo "<div id='pagination'>";
                                echo $pages;
                                echo "</div>";

                                ?>

                                <table class="table table-striped mt-4">

                                    <thead>
                                    <tr>
                                        <th>Expenditure ID</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>View/Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_body">
                                    <?php

                                    foreach ($expenditures as $e) {
                                        echo "<tr>";


                                        echo "<td>";
                                        echo "EXP-100" . $e['ExpenditureID'];
                                        echo "</td>";

                                        echo "<td>";
                                        echo $e['Name'];
                                        echo "</td>";

                                        echo "<td>";
                                        echo $e['Amount'];
                                        echo "</td>";


                                        echo "<td>";
                                        echo $e['Date'];
                                        echo "</td>";


                                        $url = site_url('ExpenditureController/edit_expenditure/' . $e["ExpenditureID"]);
                                        echo '<td><a href="' . $url . '">';
                                        echo '<i class="fa fa-eye"></i>';
                                        echo "</a></td>";

                                        $url = site_url('ExpenditureController/delete_expenditure/' . $e["ExpenditureID"]);
                                        echo '<td><a name="remove" href="' . $url . '">';
                                        echo '<i class="fa fa-remove"></i>';
                                        echo "</a></td>";

                                        echo "</tr>";
                                    }

                                    ?>


                                    </tbody>

                                </table>

                                <?php
                            }
                            ?>
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
<script src="<?= base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?= base_url() ?>assets/js/getExpenditures.js"></script>
<script src="<?= base_url() ?>assets/js/confirm.js"></script>
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
<!-- Page script -->
</body>
</html>
