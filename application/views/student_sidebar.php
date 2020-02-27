<header class="main-header">
    <!-- Logo -->
    <a href="<?= site_url('StudentDashboard/'); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>SB</b>S</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>SBS</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success"><?= $unread_count ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?= $unread_count ?> messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">

                                <!-- end message -->

                                <?php

                                if ($unread_messages) {
                                    foreach ($unread_messages as $u) {

                                        echo '<li><a href="' . site_url("StudentMessageController/read_mail/" . $u['MessageID']) . '"><div class="pull-left">';
                                        echo '<img src="' . base_url() . 'assets/dist/img/avatar5.png" class="img-circle" alt="User Image"></div>';
                                        echo '<h4>';
                                        echo $u['Subject'];
                                        echo '<small><i class="fa fa-clock-o"></i>' . $u['Date'] . '</small>';
                                        echo '</h4> From : ';
                                        if ($u['SenderTeacherID'] != '0')
                                            echo $u['SenderTeacherID'];
                                        elseif ($u['AdminID'] != '0')
                                            echo $u['AdminID'];
                                        elseif ($u['SenderStudentID'] != '0')
                                            echo $u['SenderStudentID'];
                                        else
                                            echo "Anonymous";
                                        echo '</a></li>';

                                    }
                                }
                                ?>

                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= base_url() . $_SESSION['StudentPhoto']; ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= $_SESSION['StudentName']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= base_url() . $_SESSION['StudentPhoto']; ?>" class="img-circle"
                                 alt="User Image">

                            <p>
                                <?= $_SESSION['StudentName']; ?>
                                <small><?= $_SESSION['student_login_time'] ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= site_url('StudentDashboard/settings') ?>" class="btn btn-default btn-flat">Settings</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= site_url('StudentLogin/sign_out'); ?>" class="btn btn-default btn-flat">Sign
                                    out</a>
                            </div>
                        </li>
                    </ul>
                </li>


                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= base_url() . $_SESSION['StudentPhoto']; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $_SESSION['StudentName'] ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <li class="treeview">
                <a href="<?= site_url('StudentDashboard/ '); ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>

            <li class="treeview">

                <a href="#">
                    <i class="fa fa-building"></i> <span>Academic</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('StudentDashboard/view_assignments'); ?>"><i class="fa fa-circle-o"></i>Assignments</a>
                    </li>
                    <li><a href="<?= site_url('StudentDashboard/view_student_result'); ?>"><i
                                    class="fa fa-circle-o"></i>View Results</a></li>
                    <li><a href="<?= site_url('StudentDashboard/get_timetable'); ?>"><i class="fa fa-circle-o"></i>View
                            Timetable</a></li>
                    <li><a href="<?= site_url('StudentDashboard/view_datesheet'); ?>"><i class="fa fa-circle-o"></i>View
                            Date Sheet</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i> <span>Fee Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">

                    <li><a href="<?= site_url('StudentDashboard/deposit_fee'); ?>"><i class="fa fa-circle-o"></i>Deposit
                            Fee</a>
                    </li>


                    <li><a href="<?= site_url('StudentDashboard/payments_list'); ?>"><i class="fa fa-circle-o"></i>Payments
                            List</a>


                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Student</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('StudentDashboard/check_attendance'); ?>"><i class="fa fa-circle-o"></i>
                            Check Attendance</a></li>
                    <li><a href="<?= site_url('StudentDashboard/view_student_result'); ?>"><i
                                    class="fa fa-circle-o"></i>View
                            Results</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-newspaper-o"></i> <span>News</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">

                    <li><a href="<?= site_url('StudentDashboard/news_list'); ?>"><i class="fa fa-circle-o"></i>News
                            List</a></li>

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-envelope"></i> <span>Mail Box</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('StudentMessageController/admin_inbox'); ?>"><i
                                    class="fa fa-circle-o"></i>Admin Inbox</a></li>
                    <li><a href="<?= site_url('StudentMessageController/teacher_inbox'); ?>"><i
                                    class="fa fa-circle-o"></i>Teacher Inbox</a></li>
                    <li><a href="<?= site_url('StudentMessageController/student_inbox'); ?>"><i
                                    class="fa fa-circle-o"></i>Student Inbox</a></li>
                    <li><a href="<?= site_url('StudentMessageController/student_compose'); ?>"><i
                                    class="fa fa-circle-o"></i>Compose</a></li>

                </ul>
            </li>

            <li class="treeview">
                <a href="<?= site_url('StudentDashboard/settings') ?>">
                    <i class="fa fa-gear"></i> <span>Settings</span>
                </a>
            </li>


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>