<div id="header" class="hidden-print">

    <div class="top-header-section" style="padding: 10px 0;border-bottom: thin #eaeaf1 solid">
        <div class="container">
            <div class="row">
                <div class="col-lg-6"
                     style="color: #969696;font-size: 13px;font-weight: 500;letter-spacing: 1px;padding-top: 10px">
                    <i class="fa fa-phone"></i> +91 0194 2315152
                </div>
                <!-- <div class="col-lg-6 text-right">
                     <div class="input-group" style="border: thin #d8d8df solid">
                         <input type="text" class="form-control" placeholder="Search here.." style="border: 0;font-weight: 300">
                         <span class="input-group-btn">
                         <button style="border: 0" class="btn btn-secondary" type="button">
                             <i class="fa fa-search"></i>
                         </button>
                         </span>
                     </div>
                 </div>-->
            </div>
        </div>
    </div>

    <div class="top-links" style="border-bottom: thin #f1f1f1 solid;">

        <div class="container pb-0">

            <div class="row pb-0">

                <div class="col-lg-3">
                    <a class="d-block" href="<?= base_url(); ?>"><img
                                src="<?= base_url(); ?>assets/assets/images/logo.png" id="logo"></a>
                </div>

                <div class="col-lg-9 text-right">

                    <a class="toplink-item" href="<?= base_url('FrontendController/pay_fee') ?>">
                        <span class="badge badge-success"><i class="fa fa-dollar"></i> Pay Fee</span>
                    </a>
                    <a class="toplink-item" href="<?= base_url("StudentLogin/") ?>">
                        <span class="badge badge-danger">
                            <i class="fa fa-building-o"></i> Student Login
                        </span>
                    </a>
                    <a class="toplink-item" href="<?= base_url("TeacherLogin/") ?>">
                        <span class="badge badge-info">
                            <i class="fa fa-key"></i> Staff Login
                        </span>
                    </a>

                </div>

            </div>

        </div>

    </div>

    <div class="container">
        <div class="row pt-2 pb-2">
            <div class="col-lg-10 pl-0">
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded mt-2" style="background: transparent">
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                            data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <i class="fa fa-bars" style="color: #000;padding: 10px 20px"></i>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                        <ul class="navbar-nav" style="width: 100%;margin-top: -10px">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    School
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item"
                                       href="<?= base_url() . 'FrontendController/about_school' ?>">About School</a>
                                    <a class="dropdown-item"
                                       href="<?= base_url() . 'FrontendController/school_song' ?>">School Song</a>
                                    <a class="dropdown-item" href="#">Privacy Policy</a>
                                    <!-- <a class="dropdown-item" href="#">Parent Teacher Body</a>-->
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink2"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Activities
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                    <a class="dropdown-item"
                                       href="<?= base_url() . 'FrontendController/achievements' ?>">Achievements</a>
                                    <a class="dropdown-item" href="<?= base_url('FrontendController/news') ?>">News</a>
                                    <a class="dropdown-item"
                                       href="<?= base_url('FrontendController/visits') ?>">Visits</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink3"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Downloads
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink3">
                                    <a class="dropdown-item" href="<?= base_url('FrontendController/assignments') ?>">Assignment</a>
                                    <a class="dropdown-item" href="<?= base_url('FrontendController/datesheets') ?>">Date
                                        Sheet</a>
                                    <a class="dropdown-item" href="<?= base_url('FrontendController/syllabi') ?>">Syllabus</a>
                                    <a class="dropdown-item" href="<?= base_url('FrontendController/planners') ?>">Academic
                                        Planners</a>
                                    <a class="dropdown-item" href="#">E-Lessons</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url() . 'FrontendController/events' ?>">Events</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink4"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Libraries
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink4">
                                    <a class="dropdown-item" href="#">Latest Arrivals</a>
                                    <a class="dropdown-item" href="#">E-Resources</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink5"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Careers
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink5">
                                    <a class="dropdown-item" href="<?= base_url() . 'FrontendController/careers' ?>">Register</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url() . 'FrontendController/contact' ?>">Contact</a>
                            </li>
                        </ul>
                    </div>
                </nav>

            </div>
            <div class="col-lg-2 text-right sociallinks-top">
                <a href="https://www.facebook.com/srinagarbritishschool" class="sociallink-top">
                    <i class="fa fa-facebook-square"></i> Follow us
                </a>
            </div>
        </div>
    </div>
</div>