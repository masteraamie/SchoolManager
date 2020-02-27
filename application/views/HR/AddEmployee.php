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
                Add Employee
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">HR</a></li>
                <li class="active">Add Employee</li>
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

                    if (isset($img_error)) {
                        foreach ($img_error as $err) {
                            echo '<p class="alert alert-error">';
                            echo $err;
                            echo '</p>';
                        }
                    }

                    if (isset($id)) {
                        echo '<p class="alert alert-success">';
                        echo '<i class="fa fa-check-circle"></i> Employee added successfully. LoginID is <span class="badge">' . $login['LoginID'] . '</span>';
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
                        <div class="box-header"><h3 class="box-title">Office Details</h3></div>


                        <div class="box-body">
                            <div class="col-md-4">

                                <label>Date of joining</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" name="doj" value="<?= $employee['DOJ'] ?>"
                                           class="form-control pull-right">
                                </div>
                                <br>

                                <label>Salary ( in Rupees )</label>
                                <input name="salary" type="number" value="<?= $employee['Salary']; ?>"
                                       class="form-control"><br>




                            </div>
                            <div class="col-md-4">
                                <label>Select Department</label>
                                <select name="department" class="form-control">
                                    <?php
                                    if (isset($departments)) {
                                        foreach ($departments as $d) {
                                            echo '<option value="' . $d["DepartmentID"] . '">';
                                            echo $d['Name'];
                                            echo "</option>";
                                        }
                                    }

                                    ?>

                                </select><br>

                                <label>Account Number</label>
                                <input name="account" type="number" value="<?= $employee['AccountNumber']; ?>"
                                       class="form-control"><br>
                            </div>
                            <div class="col-md-4">
                                <label>Select Designation</label>
                                <select name="designation" class="form-control">
                                    <?php
                                    if (isset($designations)) {
                                        foreach ($designations as $d) {
                                            echo '<option value="' . $d["DesignationID"] . '">';
                                            echo $d['Name'];
                                            echo "</option>";
                                        }
                                    } else {
                                        echo '<option value="0">';
                                        echo "No Designations Available";
                                        echo "</option>";
                                    }

                                    ?>


                                </select><br/>

                            </div>
                        </div>
                    </div>


                    <div class="box box-info">
                        <div class="box-header"><h3 class="box-title">Personal Details</h3></div>


                        <div class="box-body">
                            <div class="col-md-4">


                                <label>Title</label>
                                <select name="title" type="text"
                                        class="form-control">
                                    <option>Mr.</option>
                                    <option>Mrs.</option>
                                    <option>Ms.</option>
                                    <option>Dr.</option>
                                </select><br>

                                <label>Date of birth</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" name="dob" value="<?= $employee['DOB'] ?>"
                                           class="form-control pull-right">
                                </div>
                                <br>

                                <label>Parentage / Wife Of</label>
                                <input name="parentage" type="text" value="<?= $employee['Parentage']; ?>"
                                       class="form-control"><br>

                                <label>Qualification</label>
                                <input name="qualification" type="text" value="<?= $employee['Qualification']; ?>"
                                       class="form-control"><br>


                            </div>
                            <div class="col-md-4">
                                <label>First Name</label>
                                <input name="fname" type="text" value="<?= $employee['FirstName']; ?>"
                                       class="form-control"><br>

                                <label>Total Experience</label>
                                <input name="experience" type="text" value="<?= $employee['Experience']; ?>"
                                       class="form-control"><br>


                                <label>Select Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select><br/>

                                <div class="form-group">
                                    <label for="exampleInputFile">Qualification Document</label>
                                    <input name="qual" type="file" class="form-control">

                                    <p class="help-block">.pdf only</p>
                                </div>


                            </div>
                            <div class="col-md-4">
                                <label>Last Name</label>
                                <input name="lname" type="text" value="<?= $employee['LastName']; ?>"
                                       class="form-control"><br>

                                <img id="preview" class="img-bordered img-responsive align-center"
                                     style="height: 200px; width: 200px;">


                                <div class="form-group">
                                    <label for="exampleInputFile">Photograph</label>
                                    <input name="photo" type="file" id="photo" class="form-control">

                                    <p class="help-block">.jpg or .png only</p>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header"><h3 class="box-title">Contact Details</h3></div>


                        <div class="box-body">
                            <div class="col-md-4">

                                <label>Contact</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input name="contact" type="number" value="<?= $employee['Contact']; ?>"
                                           class="form-control">
                                </div>
                                <br>
                                <!-- /.input group -->
                            </div>
                            <div class="col-md-4">
                                <label>Email</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" name="email" value="<?= $employee['Email']; ?>"
                                           class="form-control"
                                           placeholder="Email">
                                </div>
                                <br>

                            </div>
                            <div class="col-md-4">
                                <label>Address</label>
                                <textarea name="address" class="form-control"
                                          rows="5"><?= $employee['Address']; ?></textarea><br>


                                <input value="Add Employee" type="submit" class="btn btn-success pull-right">

                            </div>
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
<script src="<?= base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?= base_url(); ?>assets/js/photoLoader.js"></script>
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
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
            showInputs: false
        });
    });
</script>
</body>
</html>
