<?php

/**
 * Created by PhpStorm.
 * User: Master Aamir
 * Date: 05/19/2017
 * Time: 11:12 AM
 */
class PaymentController extends CI_Controller
{
    public function index()
    {
        redirect(site_url() . 'DashboardController/');
    }

    public function check_login()
    {
        if ($this->session->has_userdata('admin_username') && $this->session->has_userdata('admin_login_time')) {
            $this->load->model("LoginModel");
            $admin = $this->LoginModel->check_session_username($_SESSION['admin_username']);

            if (!$admin)
                redirect(site_url("Login/"));

        } else {
            redirect(site_url("Login/"));
        }
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
                    echo "<script>alert('Payment  Un-Successful . Receipt ID already exists');                                window.location = 'deposit_fee';</script>";

                }elseif ($result == 1)
                {
                    echo "<script>alert('Payment  Un-Successful . Payment For this month already made');
                                window.location = 'deposit_fee';</script>";
                }
                else {
                    echo "<script>alert('Receipt Created  Successful . Receipt ID is '+" . $receiptID . ");</script>";

                }


                $data['total'] = $total;
                $data['latefee'] = $latefee;

                //echo "<script>alert('Class Added Successfully')   </script>";
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
                $data['Redirect_Url'] = base_url("PaymentController/payment_validate");
                $data['Checksum'] = $this->getCheckSum($data['Merchant_Id'], $data['Amount'], $data['Order_Id'], $data['Redirect_Url'], $data['WorkingKey']);

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


                $data['payment'] = $payment;
                $this->load->view("fee/CCPayment", $data);
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
            $this->load->view("fee/CCAvenueResponse");
        }

    }


    public function confirm_payment()
    {
        $this->check_login();
        if (isset($_SESSION['receipt_id'])) {
            $receipt = $_SESSION['receipt_id'];

            $this->load->model("FeeModel");
            if ($this->FeeModel->confirm_payment_receipt($receipt)) {
                echo "<script>alert('Payment Confirmed . Receipt ID '+" . $receipt . ");</script>";

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


                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


                $this->load->view('fee/PaymentDone', $data);


            } else {
                echo "<script>alert('Payment Not Confirmed . Invalid Receipt ID');
                                window.location='http://www.sbssrinagar.com'</script>";
            }
        }
    }


    public function deposit_fee()
    {

        $this->check_login();
        $data = array();

        $this->load->library('form_validation');

        $this->load->model('StudentModel');
        $data['students'] = $this->StudentModel->get_students();
        $this->load->model('FeeModel');
        $data['categories'] = $this->FeeModel->get_fee_categories();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view("fee/FeePayment", $data);


    }


    public function deposit_last_fee()
    {

        $this->check_login();
        $data = array();

        $this->load->library('form_validation');


        $this->load->model('StudentModel');
        $data['students'] = $this->StudentModel->get_students();
        $this->load->model('FeeModel');
        $data['categories'] = $this->FeeModel->get_fee_categories();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view("fee/LastFeePayment", $data);


    }

    public function last_payment_confirmation()
    {
        $this->check_login();


        $data = array();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        if ($_POST) {

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

                redirect(site_url("PaymentController/deposit_last_fee"));

            } else {

                $id = $this->input->post('student');

                $this->load->model('StudentModel');
                $student = $this->StudentModel->get_student_where_id($id);

                $classID = $student[0]['ClassID'];
                $sectionID = $student[0]['SectionID'];

                $payment = array(
                    "StudentID" => $id,
                    "CategoryID" => $this->input->post('category'),
                    "Date" => date("Y-m-d"),
                    "ClassID" => $classID,
                    "SectionID" => $sectionID,
                    "Month" => $this->input->post('month'),
                    "Year" => $this->input->post('year'),
                    "Amount" => $this->input->post('amount'),
                    "LateFee" => 0,
                    "Status" => 1
                );

                $this->load->model('FeeModel');
                $lastID = $this->FeeModel->get_last_payment();
                $data['categories'] = $this->FeeModel->get_fee_categories();
                if (isset($lastID[0]['PaymentID']))
                    $lastID = $lastID[0]['PaymentID'] + 1;
                else
                    $lastID = 1;

                $receipt = date("Y") . $payment['Month'] . $payment['StudentID'] . $lastID;

                $payment['ReceiptID'] = $receipt;

                $result = $this->FeeModel->add_last_payment($payment);


                if ($result == 0) {
                    echo "<script>alert('Payment  Un-Successful . Receipt ID already exists');
                                window.location = 'deposit_last_fee';</script>";

                } elseif ($result == 1) {
                    echo "<script>alert('Payment  Un-Successful . Payment for this student for this month already made');
                            window.location = 'deposit_last_fee';</script>";
                } else {
                    echo "<script>alert('Payment  Successful . Receipt ID is '+" . $payment['ReceiptID'] . ");</script>";
                    $data['success'] = TRUE;
                    $data['payment'] = $payment;
                    $data['categories'] = $this->FeeModel->get_fee_categories();
                    $this->load->model("StudentModel");
                    $data['student'] = $this->StudentModel->get_student_where_id($payment['StudentID']);


                    $data['receipt'] = $payment['ReceiptID'];

                    $this->load->model("AcademicModel");
                    $data['classes'] = $this->AcademicModel->get_classes();
                    $data['sections'] = $this->AcademicModel->get_sections();

                    $this->load->view("fee/PaymentDone2", $data);
                }

            }

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

    public function get_last_deposit()
    {
        if ($_POST) {
            $studentID = $this->input->post('StudentID');

            $categoryID = $this->input->post('CategoryID');
            $column = $this->input->post('Column');

            $this->load->model("FeeModel");
            $student = $this->FeeModel->get_payment_where($studentID, $categoryID);

            if ($student && $column == 'Month')
                echo $student[0]['Month'];
            elseif ($student && $column == 'Year')
                echo $student[0]['Year'];
            else
                echo "ERROR";
        }
    }

    public function get_stop()
    {
        if ($_POST) {
            $studentID = $this->input->post('StudentID');

            $this->load->model("StudentModel");
            $student = $this->StudentModel->get_student_where_id($studentID);

            if (isset($student))
                echo $student[0]['StopID'];
            else
                echo "ERROR";
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
            $routeID = $this->input->post('StopID');

            $this->load->model("FeeModel");
            $fee = $this->FeeModel->get_allocated_bus_fee_where($routeID);

            if (isset($fee[0]['Amount']))
                echo $fee[0]['Amount'];
            else
                echo "ERROR";
        }
    }

}