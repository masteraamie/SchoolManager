<header class="main-header">
    <!-- Logo -->
    <a href="<?= site_url('AccountantController/'); ?>" class="logo">
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
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= base_url(); ?>assets/dist/img/avatar5.png" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= $_SESSION['AccountantName']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= base_url(); ?>assets/dist/img/avatar5.png" class="img-circle"
                                 alt="User Image">

                            <p>
                                <?= $_SESSION['AccountantName']; ?>
                                <small><?= $_SESSION['accountant_login_time'] ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= site_url('AccountantDashboard/settings') ?>"
                                   class="btn btn-default btn-flat">Settings</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= site_url('AccountantLogin/sign_out'); ?>" class="btn btn-default btn-flat">Sign
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
                <p><?= $_SESSION['AccountantName']; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <li class="treeview">
                <a href="<?= site_url('AccountantController/ '); ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-money"></i> <span>Fee Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('AccountantController/add_fee_category'); ?>"><i
                                    class="fa fa-circle-o"></i>Fee
                            Categories</a>
                    </li>
                    <li><a href="<?= site_url('AccountantController/allocate_fee'); ?>"><i class="fa fa-circle-o"></i>Fee
                            Allocation</a>
                    </li>
                    <li><a href="<?= site_url('AccountantController/deposit_fee'); ?>"><i class="fa fa-circle-o"></i>Deposit
                            Fee</a>

                    <li><a href="<?= site_url('AccountantController/deposit_last_fee'); ?>"><i
                                    class="fa fa-circle-o"></i>Last
                            Fee Deposit</a>
                    </li>
                    <li><a href="<?= site_url('AccountantController/allocate_late_fee'); ?>"><i
                                    class="fa fa-circle-o"></i>Manage
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
                            <li><a href="<?= site_url('AccountantController/payments_list'); ?>"><i
                                            class="fa fa-circle-o"></i>Payments
                                    List</a>


                            <li><a href="<?= site_url('AccountantController/pending_list'); ?>"><i
                                            class="fa fa-circle-o"></i>Pending
                                    List</a>

                            <li><a href="<?= site_url('AccountantController/fee_collection'); ?>"><i
                                            class="fa fa-circle-o"></i>Fee
                                    Collections</a>

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
                    <li><a href="<?= site_url('AccountantController/add_expenditure'); ?>"><i
                                    class="fa fa-circle-o"></i>Add Expenditure</a></li>
                    <li><a href="<?= site_url('AccountantController/expenditure_list'); ?>"><i
                                    class="fa fa-circle-o"></i>Expenditure List</a></li>
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
                    <li><a href="<?= site_url('AccountantDashboard/settings') ?>">
                            </i>Change Password</a></li>
                </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>