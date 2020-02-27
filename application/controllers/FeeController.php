<?php

class FeeController extends CI_Controller
{

    public function index()
    {
        redirect(site_url() . 'DashboardController/');
    }

    public function payment_demo()
    {

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;
        $this->load->view('fee/PaymentDone2', $data);
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

    public function add_fee_category()
    {
        $this->check_login();

        $data = array();

        $this->load->model('FeeModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Fee Category',
                    'rules' => 'trim|required|is_unique[tbl_fee_categories.Name]'
                ),

                array(
                    'field' => 'details',
                    'label' => 'Fee Details',
                    'rules' => 'trim'
                )

            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $category = array(
                'Name' => $this->input->post('name'),
                'Details' => $this->input->post('details'),
            );

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->FeeModel->add_fee_category($category);
            }

        } else {
            $category = array(
                'Name' => $this->input->post('name'),
                'Details' => $this->input->post('details'),
            );

        }
        $data['category'] = $category;
        $data['categories'] = $this->FeeModel->get_fee_categories();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('fee/AddFeeCategory', $data);

    }

    public function edit_fee_category($id = "")
    {
        $this->check_login();

        if (isset($id) && is_numeric($id)) {

            $data = array();

            $this->load->model('FeeModel');

            $category = $this->FeeModel->get_fee_category_where($id);

            if ($category) {

                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Fee Category',
                            'rules' => 'trim|required'
                        ),

                        array(
                            'field' => 'details',
                            'label' => 'Fee Details',
                            'rules' => 'trim'
                        )

                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $category = array(
                        'Name' => $this->input->post('name'),
                        'Details' => $this->input->post('details'),
                        'CategoryID' => $id
                    );

                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->FeeModel->update_fee_category($category);
                    }

                }
                $category = $this->FeeModel->get_fee_category_where($id);
                $data['category'] = $category;
                $data['categories'] = $this->FeeModel->get_fee_categories();

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('fee/EditFeeCategory', $data);
            } else {
                redirect(site_url("FeeController/add_fee_category"));
            }
        } else {
            redirect(site_url("FeeController/add_fee_category"));
        }
    }

    public function delete_fee_category($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('FeeModel');


            $data['id'] = $id;

            $data['delete'] = $this->FeeModel->delete_fee_category($id);
            redirect(site_url() . 'FeeController/add_fee_category');
        } else {
            redirect(site_url() . 'FeeController/add_fee_category');
        }
    }

    public function allocate_fee()
    {
        $this->check_login();

        $data = array();

        $this->load->model('FeeModel');
        $this->load->model('AcademicModel');
        $this->load->model('TransportModel');
        $this->load->library('form_validation');
        $data['categories'] = $this->FeeModel->get_fee_categories();

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['stops'] = $this->TransportModel->get_stops();

        $data['allocations'] = $this->FeeModel->get_allocated_fee();

        $data['bus_allocations'] = $this->FeeModel->get_allocated_bus_fee();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('fee/AllocateFee', $data);

    }

    public function allocate_bus_fee()
    {
        if ($_POST) {
            $allocate = array(
                'CategoryID' => $this->input->post('CategoryID'),
                'StopID' => $this->input->post('StopID'),
                'Amount' => $this->input->post('Amount'),
                'Type' => $this->input->post('Type'),
            );

            $this->load->model("FeeModel");
            $data['success'] = $this->FeeModel->allocate_bus_fee($allocate);

            if (isset($data['success'])) {
                echo "SUCCESS";
            } else {
                echo "FAILURE";
            }

        }
    }

    public function allocate_other_fee()
    {
        if ($_POST) {
            $allocate = array(
                'CategoryID' => $this->input->post('CategoryID'),
                'ClassID' => $this->input->post('ClassID'),
                'Amount' => $this->input->post('Amount'),
                'Type' => $this->input->post('Type'),
            );

            $this->load->model("FeeModel");
            $data['success'] = $this->FeeModel->allocate_fee($allocate);

            if (isset($data['success'])) {
                echo "SUCCESS";
            } else {
                echo "FAILURE";
            }
        }

    }

    public function allocate_late_fee()
    {
        $this->check_login();

        $data = array();

        $this->load->model('FeeModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'amount',
                    'label' => 'Late Fee Amount',
                    'rules' => 'trim|required|numeric'
                ),

                array(
                    'field' => 'day',
                    'label' => 'Day',
                    'rules' => 'trim|numeric'
                )

            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $fee = array(
                'Amount' => $this->input->post('amount'),
                'Day' => $this->input->post('day'),
            );

            if ($this->form_validation->run() == FALSE) {
            } else {
                $data['success'] = $this->FeeModel->allocate_late_fee($fee);
            }

        }


        $fee = $this->FeeModel->get_late_fee();

        if ($fee) {
            $data['fee'] = $fee;
        } else {
            $fee = array(
                0 => array(
                    "Amount" => 0,
                    "Day" => 1,
                )
            );
            $data['fee'] = $fee;
        }

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('fee/ManageLateFee', $data);

    }

    public function delete_fee_allocate($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('FeeModel');


            $data['id'] = $id;

            $data['delete'] = $this->FeeModel->delete_allocate_fee($id);
            redirect(site_url() . 'FeeController/allocate_fee');
        } else {
            redirect(site_url() . 'FeeController/allocate_fee');
        }
    }

    public function pending_list()
    {
        $this->check_login();

        $data = array();

        $fee = $category = $studentID = $stopID = 0;
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("FeeModel");
        $this->load->model("StudentModel");

        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'category',
                    'label' => 'Fee Category',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'student',
                    'label' => 'Student',
                    'rules' => 'trim|required|numeric'
                )
            );

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $category = $this->input->post('category');
            $studentID = $this->input->post('student');

            if ($this->form_validation->run() == FALSE) {
            } else {
                $lastPayment = $this->FeeModel->get_pending_dues($studentID, $category);
            }

            if ($category == 2) {
                $student = $this->StudentModel->get_student_where_id($studentID);
                $stopID = $student[0]['StopID'];
                if ($stopID > 0)
                    $fee = $this->FeeModel->get_allocated_bus_fee_where($stopID);
            } else {
                $student = $this->StudentModel->get_student_where_id($studentID);
                $classID = $student[0]['ClassID'];
                $fee = $this->FeeModel->get_allocated_fee_where($classID, $category);
            }

        }


        $data['categories'] = $this->FeeModel->get_fee_categories();


        $data['students'] = $this->StudentModel->get_students();

        $data['category'] = $category;
        $data['studentID'] = $studentID;

        if (!$fee)
            $data['fee'] = 0;
        else
            $data['fee'] = $fee[0]['Amount'];


        $data['category'] = $category;

        if (isset($lastPayment) && !empty($lastPayment)) {
            $data['month'] = $lastPayment[0]['Month'];
            $data['year'] = $lastPayment[0]['Year'];

            $data['lastPayment'] = $lastPayment;

        }


        $this->load->view("fee/ListPending", $data);


    }

    public function payments_list($page = 0)
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model("FeeModel");
        $data['payments'] = $this->FeeModel->get_payments($page);

        $this->load->model("StudentModel");
        $data['students'] = $this->StudentModel->get_students();

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "FeeController/payments_list/";
        $config['total_rows'] = $this->FeeModel->get_payments_count();;
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

        $this->load->view('fee/ListPayments', $data);
    }

    public function fee_collection()
    {

        $this->check_login();
        $data = array();


        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        if ($_POST) {
            $month = $this->input->post('month');
            $year = $this->input->post('year');

            $this->load->model("FeeModel");
            $collection = $this->FeeModel->get_payments_where($month, $year);

            $total = 0;
            if (!empty($collection)) {
                foreach ($collection as $c) {
                    $total += $c['Amount'];
                }
            }

            $data['month'] = $month;
            $data['year'] = $year;
            $data['total'] = $total;

            $data['payments'] = $collection;

            $this->load->model("StudentModel");
            $data['students'] = $this->StudentModel->get_students();

        }

        $this->load->view("fee/ListCollections", $data);

    }

    public function check_payments($student = 0, $page = 0)
    {

        $this->check_login();
        $data = array();


        $student = $student > 0 ? $student : $this->input->get('student');
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;
        $this->load->model("StudentModel");

        $data['students'] = $this->StudentModel->get_students();


        $data['student'] = $this->StudentModel->get_student_where_id($student);

        if ($student > 0) {


            $this->load->model("FeeModel");
            $collection = $this->FeeModel->get_student_payments($student, $page);

            $total = 0;
            if (!empty($collection)) {
                foreach ($collection as $c) {
                    $total += $c['Amount'];
                }
            }

            $this->load->library('pagination');
            $config['base_url'] = base_url() . "FeeController/check_payments/" . $student . "/";
            $config['total_rows'] = $this->FeeModel->get_student_payments_count($student);
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


            $data['total'] = $total;

            $data['payments'] = $collection;
        }

        $this->load->view("fee/CheckPayments", $data);

    }


}
