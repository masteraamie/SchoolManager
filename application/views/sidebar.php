<header class="main-header">
    <!-- Logo -->
    <a href="<?= site_url('DashboardController/'); ?>" class="logo">
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

                                        echo '<li><a href="' . site_url("AdminMessageController/read_mail/" . $u['MessageID']) . '"><div class="pull-left">';
                                        echo '<img src="' . base_url() . 'assets/dist/img/avatar5.png" class="img-circle" alt="User Image"></div>';
                                        echo '<h4>';
                                        echo $u['Subject'];
                                        echo '<small><i class="fa fa-clock-o"></i>' . $u['Date'] . '</small>';
                                        echo '</h4> From : ';
                                        if ($u['SenderTeacherID'] != '0')
                                            echo $u['SenderTeacherID'];
                                        elseif ($u['SenderStudentID'] != '0')
                                            echo $u['SenderStudentID'];
                                        elseif ($u['SenderParentID'] != '0')
                                            echo $u['SenderParentID'];
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
                        <img src="<?= base_url(); ?>assets/dist/img/avatar5.png" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= $_SESSION['admin_username']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= base_url(); ?>assets/dist/img/avatar5.png" class="img-circle"
                                 alt="User Image">

                            <p>
                                <?= $_SESSION['admin_username']; ?>
                                <small><?= $_SESSION['admin_login_time'] ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= site_url('DashboardController/settings') ?>"
                                   class="btn btn-default btn-flat">Settings</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= site_url('Login/sign_out'); ?>" class="btn btn-default btn-flat">Sign
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
                <img src="<?= base_url(); ?>assets/dist/img/avatar5.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $_SESSION['admin_username'] ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <li class="treeview">
                <a href="<?= site_url('DashboardController/ '); ?>">
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
                    <li><a href="<?= site_url('AcademicController/add_batch'); ?>"><i class="fa fa-circle-o"></i>Batches</a>
                    </li>
                    <li><a href="<?= site_url('AcademicController/add_class'); ?>"><i class="fa fa-circle-o"></i>Classes</a>
                    </li>
                    <li><a href="<?= site_url('AcademicController/add_subject'); ?>"><i class="fa fa-circle-o"></i>Subjects</a>
                    </li>
                    <li><a href="<?= site_url('AcademicController/add_section'); ?>"><i class="fa fa-circle-o"></i>Sections</a>
                    </li>
                    <li><a href="<?= site_url('AcademicController/allocate_subject'); ?>"><i class="fa fa-circle-o"></i>Allocate
                            Subjects</a></li>
                    <li><a href="<?= site_url('AcademicController/allocate_teacher'); ?>"><i class="fa fa-circle-o"></i>Allocate
                            Primary Teacher</a></li>
                    <li><a href="<?= site_url('AcademicController/set_timetable'); ?>"><i class="fa fa-circle-o"></i>Time
                            Table</a></li>

                    <li class="treeview">

                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>Assignments</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">

                            <li><a href="<?= site_url('AcademicController/add_assignment'); ?>"><i
                                            class="fa fa-circle-o"></i>Add Assignment</a>
                            </li>

                            <li><a href="<?= site_url('AcademicController/list_assignments'); ?>"><i
                                            class="fa fa-circle-o"></i>List Assignment</a>
                            </li>

                        </ul>
                    </li>
                    <li class="treeview">

                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>Syllabi</span>
                            <span class="pull-right-container">
                                               <i class="fa fa-angle-left pull-right"></i>
                                               </span>
                        </a>
                        <ul class="treeview-menu">

                            <li><a href="<?= site_url('AcademicController/add_syllabus'); ?>"><i
                                            class="fa fa-circle-o"></i>Add Syllabus</a>
                            </li>
                            <li><a href="<?= site_url('AcademicController/list_syllabi'); ?>"><i
                                            class="fa fa-circle-o"></i>List Syllabi</a>
                            </li>
                        </ul>
                    </li>

                    <li class="treeview">

                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>Academic Planner</span>
                            <span class="pull-right-container">
                                               <i class="fa fa-angle-left pull-right"></i>
                                               </span>
                        </a>
                        <ul class="treeview-menu">

                            <li><a href="<?= site_url('AcademicController/add_planner'); ?>"><i
                                            class="fa fa-circle-o"></i>Add Planner</a>
                            </li>
                            <li><a href="<?= site_url('AcademicController/list_planners'); ?>"><i
                                            class="fa fa-circle-o"></i>List Planners</a>
                            </li>
                        </ul>
                    </li>

                    <li class="treeview">

                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>Exams</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">

                            <li><a href="<?= site_url('AcademicController/add_exam'); ?>"><i class="fa fa-circle-o"></i>Add
                                    Exam</a>
                            </li>

                            <li><a href="<?= site_url('AcademicController/add_datesheet'); ?>"><i
                                            class="fa fa-circle-o"></i>Add Date Sheet</a>
                            </li>

                            <li><a href="<?= site_url('AcademicController/list_datesheets'); ?>"><i
                                            class="fa fa-circle-o"></i>View Date Sheet</a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="<?= site_url('AcademicController/add_lecture'); ?>"><i class="fa fa-circle-o"></i>Add
                            Video Lectures</a></li>

                    <li><a href="<?= site_url('AcademicController/add_circular'); ?>"><i class="fa fa-circle-o"></i>Circulars</a>
                    </li>

                </ul>
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Library</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('AcademicController/add_book'); ?>"><i
                                    class="fa fa-circle-o"></i>Books</a></li>
                    <li><a href="<?= site_url('AcademicController/issue_book'); ?>"><i class="fa fa-circle-o"></i>Issue
                            Book</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Human Resources</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('HRController/add_department'); ?>"><i class="fa fa-circle-o"></i>Departments</a>
                    </li>
                    <li><a href="<?= site_url('HRController/add_designation'); ?>"><i class="fa fa-circle-o"></i>Designations</a>
                    </li>
                    <li><a href="<?= site_url('HRController/add_employee'); ?>"><i class="fa fa-circle-o"></i>Add
                            Employee</a></li>


                    <li class="treeview">

                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>Attendance</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">

                            <li><a href="<?= site_url('HRController/employee_attendance'); ?>"><i
                                            class="fa fa-circle-o"></i>Employee
                                    Attendance</a></li>
                            <li><a href="<?= site_url('HRController/check_attendance'); ?>"><i
                                            class="fa fa-circle-o"></i>Check
                                    Attendance</a></li>
                        </ul>
                    </li>

                    <li><a href="<?= site_url('HRController/employee_list'); ?>"><i class="fa fa-circle-o"></i>Employee
                            List</a></li>
                    <li><a href="<?= site_url('HRController/add_leave_type'); ?>"><i class="fa fa-circle-o"></i>Leave
                            Types</a></li>
                    <li><a href="<?= site_url('HRController/set_max_leaves'); ?>"><i class="fa fa-circle-o"></i>Set Max
                            Leaves</a></li>
                    <li><a href="<?= site_url('HRController/view_payroll'); ?>"><i class="fa fa-circle-o"></i>View
                            Payroll</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Student Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('StudentController/add_student'); ?>"><i class="fa fa-circle-o"></i>Add
                            Student</a></li>
                    <li><a href="<?= site_url('StudentController/student_list'); ?>"><i class="fa fa-circle-o"></i>Student
                            List</a></li>

                    <li class="treeview">

                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>Attendance</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">

                            <li><a href="<?= site_url('StudentController/student_attendance'); ?>"><i
                                            class="fa fa-circle-o"></i>Student Attendance</a></li>
                            <li><a href="<?= site_url('StudentController/check_attendance'); ?>"><i
                                            class="fa fa-circle-o"></i>
                                    Check Attendance</a></li>
                        </ul>
                    </li>


                    <li><a href="<?= site_url('StudentController/student_upgrade'); ?>"><i class="fa fa-circle-o"></i>Student
                            Upgrade</a></li>
                    <li><a href="<?= site_url('StudentController/student_result'); ?>"><i class="fa fa-circle-o"></i>Student
                            Results</a></li>
                    <li><a href="<?= site_url('StudentController/view_student_result'); ?>"><i
                                    class="fa fa-circle-o"></i>View
                            Results</a></li>
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
                    <li><a href="<?= site_url('FeeController/add_fee_category'); ?>"><i class="fa fa-circle-o"></i>Fee
                            Categories</a>
                    </li>
                    <li><a href="<?= site_url('FeeController/allocate_fee'); ?>"><i class="fa fa-circle-o"></i>Fee
                            Allocation</a>
                    </li>
                    <li><a href="<?= site_url('PaymentController/deposit_fee'); ?>"><i class="fa fa-circle-o"></i>Deposit
                            Fee</a>

                    <li><a href="<?= site_url('PaymentController/deposit_last_fee'); ?>"><i class="fa fa-circle-o"></i>Last
                            Fee Deposit</a>
                    </li>
                    <li><a href="<?= site_url('FeeController/allocate_late_fee'); ?>"><i class="fa fa-circle-o"></i>Manage
                            Late Fee</a>
                    </li>

                    <li class="treeview">

                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>Payments</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= site_url('FeeController/payments_list'); ?>"><i class="fa fa-circle-o"></i>Payments
                                    List</a></li>


                            <li><a href="<?= site_url('FeeController/pending_list'); ?>"><i class="fa fa-circle-o"></i>Pending
                                    List</a></li>

                            <li><a href="<?= site_url('FeeController/fee_collection'); ?>"><i
                                            class="fa fa-circle-o"></i>Fee
                                    Collections</a></li>

                            <li><a href="<?= site_url('FeeController/check_payments'); ?>"><i
                                            class="fa fa-circle-o"></i>Check Student
                                    Payments</a></li>

                        </ul>
                    </li>

                </ul>
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-rupee"></i> <span>Expenditure</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('ExpenditureController/add_expenditure'); ?>"><i
                                    class="fa fa-circle-o"></i>Add Expenditure</a></li>
                    <li><a href="<?= site_url('ExpenditureController/expenditure_list'); ?>"><i
                                    class="fa fa-circle-o"></i>Expenditure List</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-newspaper-o"></i> <span>News Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('NewsController/add_news'); ?>"><i class="fa fa-circle-o"></i>Add News</a>
                    </li>
                    <li><a href="<?= site_url('NewsController/news_list'); ?>"><i class="fa fa-circle-o"></i>News
                            List</a></li>

                </ul>
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-trophy"></i> <span>Achievements</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('AchievementController/add_achievement'); ?>"><i
                                    class="fa fa-circle-o"></i>Add Achievement</a>
                    </li>
                    <li><a href="<?= site_url('AchievementController/achievement_list'); ?>"><i
                                    class="fa fa-circle-o"></i>Achievement
                            List</a></li>

                </ul>
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-eye"></i> <span>Visits</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('VisitController/add_visit'); ?>"><i class="fa fa-circle-o"></i>Add Visit</a>
                    </li>
                    <li><a href="<?= site_url('VisitController/visit_list'); ?>"><i class="fa fa-circle-o"></i>Visits
                            List</a></li>

                </ul>
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-star"></i> <span>Event Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('EventController/add_event'); ?>"><i class="fa fa-circle-o"></i>Add Events</a>
                    </li>
                    <li><a href="<?= site_url('EventController/add_event_type'); ?>"><i class="fa fa-circle-o"></i>Event
                            Types</a></li>
                    <li><a href="<?= site_url('EventController/events_list'); ?>"><i class="fa fa-circle-o"></i>List
                            Events</a>
                    </li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bus"></i> <span>Transport Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('TransportController/add_bus'); ?>"><i
                                    class="fa fa-circle-o"></i>Buses</a></li>
                    <li><a href="<?= site_url('TransportController/add_route'); ?>"><i class="fa fa-circle-o"></i>Routes</a>
                    </li>
                    <li><a href="<?= site_url('TransportController/add_stop'); ?>"><i
                                    class="fa fa-circle-o"></i>Stops</a>
                    </li>
                    <li><a href="<?= site_url('TransportController/allocate_route'); ?>"><i class="fa fa-circle-o"></i>Bus
                            Route Allocation</a></li>
                    <li><a href="<?= site_url('TransportController/allocate_bus'); ?>"><i class="fa fa-circle-o"></i>Student
                            Bus Allocation</a></li>
                    <li><a href="<?= site_url('TransportController/allocate_stop'); ?>"><i class="fa fa-circle-o"></i>Student
                            Stop Allocation</a></li>
                    <li><a href="<?= site_url('TransportController/student_list'); ?>"><i class="fa fa-circle-o"></i>Student
                            Bus List</a></li>

                </ul>
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-envelope"></i> <span>Bulk SMS</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('SMSController/sms_students'); ?>"><i
                                    class="fa fa-circle-o"></i>SMS Students</a></li>

                    <li><a href="<?= site_url('SMSController/sms_employees'); ?>"><i
                                    class="fa fa-circle-o"></i>SMS Employees</a></li>

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-inbox"></i> <span>Mail Box</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('AdminMessageController/teacher_inbox'); ?>"><i
                                    class="fa fa-circle-o"></i>Teacher Inbox</a></li>
                    <li><a href="<?= site_url('AdminMessageController/student_inbox'); ?>"><i
                                    class="fa fa-circle-o"></i>Student Inbox</a></li>

                    <li><a href="<?= site_url('AdminMessageController/admin_compose'); ?>"><i
                                    class="fa fa-circle-o"></i>Compose</a></li>

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gear"></i> <span>Settings</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('SettingsController/image_settings') ?>">
                            </i>Change Images</a></li>
                    <li><a href="<?= site_url('SettingsController/principal_settings') ?>">
                            </i>Principal Settings</a></li>
                    <li><a href="<?= site_url('SettingsController/vice_principal_settings') ?>">
                            </i>Vice Principal Settings</a></li>
                    <li><a href="<?= site_url('SettingsController/director_settings') ?>">
                            </i>Director Settings</a></li>
                    <li><a href="<?= site_url('SettingsController/settings') ?>">
                            </i>Change Password</a></li>

                </ul>
            </li>


            <li class="treeview">

            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>