<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentDashboard extends CI_Controller
{

    public function index()
    {

        $this->check_login();
        $this->load->model("HRModel");
        $this->load->model("AcademicModel");
        $this->load->model("StudentModel");
        $this->load->model("EventModel");
        $data['events'] = $this->EventModel->get_events(0, 4);


        $this->load->model("VisitModel");
        $data['visits'] = $this->VisitModel->get_visits(0, 4);


        $month = array(
            "Month" => date('m')
        );

        $data['presents'] = $this->StudentModel->get_attendance_where($month, "P");

        $data['absents'] = $this->StudentModel->get_attendance_where($month, "A");

        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;
        $this->load->model("NewsModel");
        $data['news'] = $this->NewsModel->get_news();

        $this->load->view('student/StudentDashboard', $data);

    }

    public function check_login()
    {
        if ($this->session->has_userdata('student_username') && $this->session->has_userdata('student_login_time')) {
        } else {
            redirect(site_url("StudentLogin/"));
        }
    }


    public function view_news($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/news"))
                mkdir("./uploads/news", 0777, TRUE);


            $this->load->model('NewsModel');

            $data['news'] = $this->NewsModel->get_news_where($id);;

            if ($data['news']) {
                $this->load->library('form_validation');


                $this->load->model("StudentMessageModel");
                $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('news/StudentViewNews', $data);
            } else {
                redirect(site_url("StudentDashboard/"));
            }

        } else {
            redirect(site_url("StudentDashboard/"));
        }
    }

    public function news_list()
    {
        $this->check_login();
        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("NewsModel");
        $data['newses'] = $this->NewsModel->get_news();
        $this->load->view('news/StudentNewsList', $data);
    }

    public function settings()
    {

        $this->check_login();
        $data = array();
        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'old_pass',
                    'label' => 'Old Password',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'new_pass',
                    'label' => 'New Password',
                    'rules' => 'trim|required|max_length[30]|min_length[6]'
                ),
                array(
                    'field' => 'confirm_pass',
                    'label' => 'Confirm Password',
                    'rules' => 'trim|required|max_length[30]|min_length[6]|matches[new_pass]'
                )
            );

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');
            if ($this->form_validation->run() == FALSE) {
            } else {
                $this->load->model('LoginModel');

                $oldPass = $this->input->post('old_pass');

                //$oldPass = $this->LoginModel->encrypt($oldPass);

                $admin = array(
                    "LoginID" => $_SESSION['student_username'],
                    "Password" => $oldPass
                );
                $login = $this->LoginModel->student_login($admin);
                if ($login) {
                    $i = $this->LoginModel->get_student_id($_SESSION['student_username']);

                    $id = $i[0]['StudentID'];
                    $newPass = $this->input->post('new_pass');

                    $newPass = $this->LoginModel->encrypt($newPass);

                    $data['success'] = $this->LoginModel->student_change_password($id, $newPass);

                } else {
                    echo "<script>alert('Invalid Credentials')</script>";
                    $data['error'] = "Invalid Credentials";
                }


            }
        }
        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $data['sections'] = $this->AcademicModel->get_sections();

        $this->load->view('student/student_settings', $data);
    }

    public function view_assignments()
    {
        $this->check_login();

        $data[] = array();

        $this->load->model('AcademicModel');

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['assignments'] = $this->AcademicModel->get_assignments();
        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['sections'] = $this->AcademicModel->get_sections();
        $this->load->view("academic/StudentViewAssignments", $data);

    }

    public function get_sections()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");
            $sections = $this->AcademicModel->get_section_where_class($classID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }


    public function view_assignment($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/news"))
                mkdir("./uploads/news", 0777, TRUE);


            $this->load->model('AcademicModel');

            $data['assignment'] = $this->AcademicModel->get_assignment_where($id);;

            if ($data['assignment']) {
                $this->load->library('form_validation');
                $this->load->model("StudentMessageModel");
                $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('academic/StudentViewAssignment', $data);
            } else {
                redirect(site_url("StudentDashboard/"));
            }

        } else {
            redirect(site_url("StudentDashboard/"));
        }
    }


    public function get_assignments()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $sectionID = $this->input->post("SectionID");
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");

            $sections = $this->AcademicModel->get_assignment_where_class($classID, $sectionID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function view_student_result()
    {
        $this->check_login();
        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $this->load->model("StudentModel");
        $data['students'] = $this->StudentModel->get_students();
        $this->load->view("student/ViewResult", $data);
    }

    public function check_attendance()
    {
        $this->check_login();
        $data = array();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model('StudentModel');
        $data['students'] = $this->StudentModel->get_students();

        $this->load->model('AcademicModel');
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $this->load->view("student/ViewAttendance", $data);
    }

    public function get_student_attendance()
    {
        if ($_POST) {
            $ID = $this->input->post("id");
            $day = $this->input->post("day");
            $month = $this->input->post("month");
            $year = $this->input->post("year");
            $type = $this->input->post("type");

            if ($type == "daily") {
                $data = array(
                    "StudentID" => $ID,
                    "Day" => $day,
                    "Month" => $month,
                    "Year" => $year
                );
            } else {
                $data = array(
                    "StudentID" => $ID,
                    "Month" => $month,
                    "Year" => $year
                );
            }

            $this->load->model("StudentModel");
            $attendance = $this->StudentModel->get_student_attendance($data);


            if ($attendance) {
                echo '<thead>
                               <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>';

                echo '<tbody>';

                foreach ($attendance as $a) {
                    echo "<tr>";
                    echo "<td>" . $a['Date'] . "</td>";
                    echo "<td><label>";
                    if ($a['Status'] == "P")
                        echo "<label class='label label-success'>Present</label>";
                    elseif ($a['Status'] == "A")
                        echo "<label class='label label-danger'>Absent</label>";
                    echo '</label></td>';
                    echo '</tr>';
                }
            } else {
                echo "";
            }
        }
    }


    public function get_student_result()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $studentID = $this->input->post("StudentID");
            $column = $this->input->post("Column");
            $this->load->model("StudentModel");
            $sections = $this->StudentModel->get_student_result($classID, $studentID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function get_subject_name()
    {
        if ($_POST) {
            $subjectID = $this->input->post("SubjectID");
            $this->load->model("AcademicModel");
            $subject = $this->AcademicModel->get_subject_where($subjectID);


            echo json_encode($subject[0]['Name']);
        }
    }

    public function get_exam_name()
    {
        if ($_POST) {
            $examID = $this->input->post("ExamID");
            $this->load->model("AcademicModel");
            $exam = $this->AcademicModel->get_exam_where($examID);


            echo json_encode($exam[0]['Name']);
        }
    }

    public function get_subjects()
    {
        if ($_POST) {
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");

            $sections = $this->AcademicModel->get_subjects();

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function get_last_deposit()
    {
        if ($_POST) {
            $studentID = $this->input->post('StudentID');
            $categoryID = $this->input->post('CategoryID');

            $this->load->model("FeeModel");
            $student = $this->FeeModel->get_payment_where($studentID, $categoryID);

            if ($student)
                echo $student[0]['Month'];
            else
                echo "ERROR";
        }
    }

    public function get_presents()
    {
        if ($_POST) {
            $studentID = $_SESSION['StudentID'];

            $this->load->model("FeeModel");
            $student = $this->FeeModel->get_payment_where($studentID);

            if ($student)
                echo $student[0]['Month'];
            else
                echo "ERROR";
        }
    }

    public function get_exams()
    {
        if ($_POST) {
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");

            $sections = $this->AcademicModel->get_exams();

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function get_timetable()
    {
        $this->check_login();
        $this->load->model("AcademicModel");
        $data['class'] = $this->AcademicModel->get_classes();
        $this->load->model("HRModel");
        $data['teachers'] = $this->HRModel->get_teachers();
        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view("academic/GetTimeTable", $data);
    }

    public function get_periods()
    {
        if ($_POST) {

            $data = array(
                "ClassID" => $this->input->post("ClassID"),
                "SectionID" => $this->input->post("SectionID"),
                "Day" => $this->input->post("Day"),

            );

            $column = $this->input->post("Column");

            $this->load->model("AcademicModel");
            $result = $this->AcademicModel->get_periods($data);

            $data = array();
            foreach ($result as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function get_subject()
    {
        if ($_POST) {
            $subjectID = $this->input->post("SubjectID");
            $this->load->model("AcademicModel");
            $name = $this->AcademicModel->get_subject_where($subjectID);

            if (isset($name[0]['Name']))
                echo json_encode($name[0]['Name']);
            else
                echo json_encode("Error");
        }
    }

    public function get_teacher()
    {
        if ($_POST) {
            $teacherID = $this->input->post("EmployeeID");
            $this->load->model("HRModel");
            $name = $this->HRModel->get_employee_where_id($teacherID);

            if (isset($name[0]['FirstName']))
                echo json_encode($name[0]['FirstName'] . " " . $name[0]['MiddleName'] . " " . $name[0]['LastName']);
            else
                echo json_encode("Error");
        }
    }


    public function view_datesheet()
    {
        $this->check_login();

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();

        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $data['sections'] = $this->AcademicModel->get_sections();
        $this->load->view('academic/StudentViewDatesheet', $data);
    }

    public function get_datesheets()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $sectionID = $this->input->post("SectionID");
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");

            $sections = $this->AcademicModel->get_datesheet_where_class($classID, $sectionID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function get_url()
    {
        if ($_POST) {

            $type = $this->input->post("Type");

            if ($type == 1)
                echo json_encode(base_url("DownloadFiles/download_assignment/"));
            elseif ($type == 2)
                echo json_encode(base_url("DownloadFiles/download_datesheet/"));
            elseif ($type == 3)
                echo json_encode(site_url("StudentDashboard/view_assignment/"));
            elseif ($type == 4)
                echo base_url("DownloadFiles/download_assignment");
            elseif ($type == 5)
                echo base_url("DownloadFiles/download_assignment");
            else
                echo base_url("DownloadFiles/download_assignment");
        }
    }

    public function forgot_password()
    {

        $this->check_login();
        $data = array();
        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(


                array(
                    'field' => 'new_pass',
                    'label' => 'New Password',
                    'rules' => 'trim|required|max_length[30]|min_length[6]'
                ),
                array(
                    'field' => 'confirm_pass',
                    'label' => 'Confirm Password',
                    'rules' => 'trim|required|max_length[30]|min_length[6]|matches[new_pass]'
                )
            );

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');
            if ($this->form_validation->run() == FALSE) {
            } else {
                $this->load->model('LoginModel');
                $i = $this->LoginModel->get_student_id($_SESSION['student_username']);

                $id = $i[0]['StudentID'];
                $newPass = $this->input->post('new_pass');

                $newPass = $this->LoginModel->encrypt($newPass);

                $data['success'] = $this->LoginModel->student_change_password($id, $newPass);
            }
        }
        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('student_forgot', $data);
    }


    public function payment_confirmation()
    {
        $this->check_login();
        if ($_POST) {


            $data = array();

            $this->load->library('form_validation');
            $rules = array(

                array(
                    'field' => 'student',
                    'label' => 'Student',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'category',
                    'label' => 'Fee Category',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'amount',
                    'label' => 'Fee Amount',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'month',
                    'label' => 'Month',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'year',
                    'label' => 'Year',
                    'rules' => 'trim|required|numeric'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');

            if ($this->form_validation->run() == FALSE) {

                redirect(site_url("PaymentController/deposit_fee"));

            } else {

                $this->load->model('FeeModel');
                $latefee = $this->FeeModel->calculate_late_fee();


                $id = $this->input->post('student');

                $this->load->model('StudentModel');
                $student = $this->StudentModel->get_student_where_id($id);

                $classID = $student[0]['ClassID'];
                $sectionID = $student[0]['SectionID'];
                $total = $this->input->post('amount') + $latefee;

                $payment = array(
                    "StudentID" => $id,
                    "CategoryID" => $this->input->post('category'),
                    "ClassID" => $classID,
                    "SectionID" => $sectionID,
                    "Date" => date("Y-m-d"),
                    "Month" => $this->input->post('month'),
                    "Year" => $this->input->post('year'),
                    "Amount" => $total,
                    "LateFee" => $latefee
                );


                $lastID = $this->FeeModel->get_last_payment();
                $data['categories'] = $this->FeeModel->get_fee_categories();
                $this->load->model('StudentModel');
                $this->load->model('AcademicModel');
                $data['classes'] = $this->AcademicModel->get_classes();
                $data['sections'] = $this->AcademicModel->get_sections();
                $data['student'] = $student;


                if (isset($lastID[0]['PaymentID']))
                    $lastID = $lastID[0]['PaymentID'] + 1;
                else
                    $lastID = 1;
                $receiptID = date("Y") . $payment['Month'] . $lastID;


                $this->load->model("StudentModel");
                $data['student'] = $this->StudentModel->get_student_where_id($payment['StudentID']);

                $payment['ReceiptID'] = $receiptID;

                $result = $this->FeeModel->add_payment($payment);


                if ($result == 0) {
                    echo "<script>alert('Payment  Un-Successful . Receipt ID already exists');
                                window.location = 'deposit_fee';</script>";

                } elseif ($result == 1) {
                    echo "<script>alert('Payment  Un-Successful . Payment for this student for this month already made');
                            window.location = 'deposit_fee';</script>";
                } else {
                    echo "<script>alert('Payment  Successful . Receipt ID is '+" . $receiptID . ");</script>";

                }

                $data['total'] = $total;
                $data['latefee'] = $latefee;


                $data['receipt'] = $receiptID;
                // Merchant id provided by CCAvenue
                $data['Merchant_Id'] = "133655";
                // Item amount for which transaction perform
                $data['Amount'] = $payment['Amount'];
                // Unique OrderId that should be passed to payment gateway
                $data['Order_Id'] = $payment['ReceiptID'];


                $_SESSION['receipt_id'] = $payment['ReceiptID'];

                // Unique Key provided by CCAvenue
                $data['WorkingKey'] = "34888D62335F2DA0C626BAA17EB04335";
                // Success page URL
                $data['Redirect_Url'] = base_url("StudentDashboard/payment_validate");
                $data['Checksum'] = $this->getCheckSum($data['Merchant_Id'], $data['Amount'], $data['Order_Id'], $data['Redirect_Url'], $data['WorkingKey']);

                $this->load->model("StudentMessageModel");
                $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


                $data['payment'] = $payment;
                $this->load->view("fee/StudentCCPayment", $data);
            }

        }
    }

    public function cc_avenue_payment()
    {

        $this->load->view("fee/CCAvenue");

    }

    public function payment_validate()
    {
        if ($_POST) {
            $this->load->view("fee/StudentCCAvenueResponse");
        }

    }


    public function confirm_payment()
    {
        if (isset($_SESSION['receipt_id'])) {
            $receipt = $_SESSION['receipt_id'];
            $this->load->model("FeeModel");
            if ($this->FeeModel->confirm_payment_receipt($receipt)) {
                echo "<script>alert('Payment Confirmed . Receipt ID ' + " . $receipt . ");</script>";

                $receipt = $_SESSION['receipt_id'];

                $this->load->model("FeeModel");
                $this->load->model("AcademicModel");
                $this->load->model("StudentModel");

                $payment = $this->FeeModel->get_payment_where_receipt($receipt);

                $data = array();


                $data['payment'] = $payment;

                $data['classes'] = $this->AcademicModel->get_classes();
                $data['sections'] = $this->AcademicModel->get_sections();
                $data['student'] = $this->StudentModel->get_student_where_id($payment[0]['StudentID']);
                $data['categories'] = $this->FeeModel->get_fee_categories();


                $this->load->model("StudentMessageModel");
                $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('fee/StudentPaymentDone', $data);
            } else {
                echo "<script>alert('Payment Not Confirmed . Invalid Receipt ID');</script>";
            }
        }
    }


    public function deposit_fee()
    {

        $this->check_login();
        $data = array();

        $this->load->library('form_validation');


        $this->load->model('FeeModel');
        $data['categories'] = $this->FeeModel->get_fee_categories();
        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view("fee/StudentFeePayment", $data);


    }

    public function payments_list($page = 0)
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model("FeeModel");
        $data['payments'] = $this->FeeModel->get_student_payments($_SESSION['StudentID'], $page);


        $this->load->library('pagination');
        $config['base_url'] = base_url() . "StudentDashboard/payments_list/";
        $config['total_rows'] = $this->FeeModel->get_student_payments_count($_SESSION['StudentID']);;
        $config['per_page'] = 6;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';


        $this->pagination->initialize($config);

        $data['pages'] = $this->pagination->create_links();

        $this->load->view('fee/StudentListPayments', $data);
    }

    public function get_class()
    {
        if ($_POST) {
            $studentID = $this->input->post('StudentID');

            $this->load->model("StudentModel");
            $student = $this->StudentModel->get_student_where_id($studentID);

            if (isset($student))
                echo $student[0]['ClassID'];
            else
                echo "ERROR";
        }
    }

    public function get_route()
    {
        if ($_POST) {
            $studentID = $this->input->post('StudentID');

            $this->load->model("StudentModel");
            $student = $this->StudentModel->get_student_where_id($studentID);

            if (isset($student))
                echo $student[0]['RouteID'];
            else
                echo "ERROR";
        }
    }


    public function pending_list()
    {
        if (isset($_SESSION['StudentID'])) {

            $data = array();

            $fee = 0;
            $this->load->model("StudentMessageModel");
            $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
            $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

            $this->load->model("FeeModel");

            $category = 1;

            $lastPayment = $this->FeeModel->get_pending_dues($_SESSION['StudentID'], $category);


            $this->load->library('form_validation');
            if ($_POST) {
                $rules = array(

                    array(
                        'field' => 'category',
                        'label' => 'Fee Category',
                        'rules' => 'trim|required|numeric'
                    )
                );

                $this->form_validation->set_rules($rules);
                $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                $category = $this->input->post('category');

                if ($this->form_validation->run() == FALSE) {
                } else {
                    $lastPayment = $this->FeeModel->get_pending_dues($_SESSION['StudentID'], $category);


                }

            }

            if ($category == 2) {
                if (isset($_SESSION['StopID']))
                    $fee = $this->FeeModel->get_allocated_bus_fee_where($_SESSION['StopID']);
            } else
                $fee = $this->FeeModel->get_allocated_fee_where($_SESSION['ClassID'], $category);


            $data['categories'] = $this->FeeModel->get_fee_categories();

            if (!$fee)
                $data['fee'] = 0;
            else
                $data['fee'] = $fee[0]['Amount'];


            $data['category'] = $category;

            if ($lastPayment) {
                $data['month'] = $lastPayment[0]['Month'];
                $data['year'] = $lastPayment[0]['Year'];
            }


            $this->load->view("fee/StudentListPending", $data);

        } else {
            redirect(site_url() . 'StudentDashboard/payments_list');
        }

    }


    public function get_fee()
    {
        if ($_POST) {
            $classID = $this->input->post('ClassID');
            $categoryID = $this->input->post('CategoryID');

            $this->load->model("FeeModel");
            $fee = $this->FeeModel->get_allocated_fee_where($classID, $categoryID);

            if (isset($fee[0]['Amount']))
                echo $fee[0]['Amount'];
            else
                echo "ERROR";
        }
    }

    public function get_bus_fee()
    {
        if ($_POST) {
            $routeID = $this->input->post('RouteID');

            $this->load->model("FeeModel");
            $fee = $this->FeeModel->get_allocated_bus_fee_where($routeID);

            if (isset($fee[0]['Amount']))
                echo $fee[0]['Amount'];
            else
                echo "ERROR";
        }
    }


    // Get the checksum
    function getCheckSum($MerchantId, $Amount, $OrderId, $URL, $WorkingKey)
    {
        $str = "$MerchantId|$OrderId|$Amount|$URL|$WorkingKey";
        $adler = 1;
        $adler = $this->adler32($adler, $str);
        return $adler;
    }

    function cdec($num)
    {
        $dec = '';
        for ($n = 0; $n < strlen($num); $n++) {
            $temp = $num[$n];
            $dec = $dec + $temp * pow(2, strlen($num) - $n - 1);
        }
        return $dec;
    }

    function adler32($adler, $str)
    {
        $BASE = 65521;
        $s1 = $adler & 0xffff;
        $s2 = ($adler >> 16) & 0xffff;
        for ($i = 0; $i < strlen($str); $i++) {
            $s1 = ($s1 + Ord($str[$i])) % $BASE;
            $s2 = ($s2 + $s1) % $BASE;
        }
        return $this->leftshift($s2, 16) + $s1;
    }

    function leftshift($str, $num)
    {
        $str = DecBin($str);
        for ($i = 0; $i < (64 - strlen($str)); $i++)
            $str = "0" . $str;
        for ($i = 0; $i < $num; $i++) {
            $str = $str . "0";
            $str = substr($str, 1);
        }
        return $this->cdec($str);
    }

//Verify the the checksum
    function verifychecksum($MerchantId, $OrderId, $Amount, $AuthDesc, $CheckSum, $WorkingKey)
    {
        $str = "$MerchantId|$OrderId|$Amount|$AuthDesc|$WorkingKey";
        $adler = 1;
        $adler = adler32($adler, $str);
        if ($adler == $CheckSum)
            return "true";
        else
            return "false";
    }

}
