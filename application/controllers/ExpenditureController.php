<?php

class ExpenditureController extends CI_Controller
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


    public function add_expenditure()
    {

        $this->check_login();

        $data = array();

        $this->load->model('ExpenditureModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Expenditure Name',
                    'rules' => 'trim|required|min_length[3]|max_length[100]'
                ),

                array(
                    'field' => 'details',
                    'label' => 'Expenditure Details',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'amount',
                    'label' => 'Expenditure Amount',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'date',
                    'label' => 'Expenditure Date',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'receipt',
                    'label' => 'Receipt ID',
                    'rules' => 'trim'
                ),
                array(
                    'field' => 'cheque',
                    'label' => 'Cheque Number',
                    'rules' => 'trim'
                ),
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $expenditure = array(

                'Name' => $this->input->post('name'),
                'Details' => $this->input->post('details'),
                'Amount' => $this->input->post('amount'),
                'Date' => $this->input->post('date'),
                'Mode' => $this->input->post('mode'),
                'ReceiptID' => $this->input->post('receipt'),
                'ChequeNumber' => $this->input->post('cheque')
            );
            $data['expenditure'] = $expenditure;
            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->ExpenditureModel->add_expenditure($expenditure);
                //echo "<script>alert('Expenditure Added Successfully')   </script>";
            }

        } else {
            $expenditure = array(

                'Name' => "",
                'Details' => "",
                'Amount' => "",
                'Date' => ""
            );

            $data['expenditure'] = $expenditure;
        }

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('expenditure/AddExpenditure', $data);

    }

    public function edit_expenditure($id = "", $page = 0)
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $data['id'] = $id;

            $this->load->model('ExpenditureModel');
            $expenditure = $this->ExpenditureModel->get_expenditure_where($id);

            if ($expenditure) {


                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Expenditure Name',
                            'rules' => 'trim|required|min_length[3]|max_length[100]'
                        ),

                        array(
                            'field' => 'details',
                            'label' => 'Expenditure Details',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'amount',
                            'label' => 'Expenditure Amount',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'date',
                            'label' => 'Expenditure Date',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'receipt',
                            'label' => 'Receipt ID',
                            'rules' => 'trim'
                        ),
                        array(
                            'field' => 'cheque',
                            'label' => 'Cheque Number',
                            'rules' => 'trim'
                        ),
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $expenditure = array(

                        'Name' => $this->input->post('name'),
                        'Details' => $this->input->post('details'),
                        'Amount' => $this->input->post('amount'),
                        'Date' => $this->input->post('date'),
                        'Mode' => $this->input->post('mode'),
                        'ReceiptID' => $this->input->post('receipt'),
                        'ChequeNumber' => $this->input->post('cheque')
                    );
                    $data['expenditure'] = $expenditure;
                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->ExpenditureModel->update_expenditure($expenditure, $id);
                        //echo "<script>alert('Expenditure Added Successfully')   </script>";
                    }

                }
                $expenditure = $this->ExpenditureModel->get_expenditure_where($id);

                $data['expenditure'] = $expenditure;

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


                $this->load->view('expenditure/EditExpenditure', $data);
            } else {
                redirect(site_url("ExpenditureController/expenditure_list"));
            }
        } else {
            redirect(site_url("ExpenditureController/expenditure_list"));
        }

    }

    public function delete_expenditure($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('ExpenditureModel');


            $data['id'] = $id;

            $data['delete'] = $this->ExpenditureModel->delete_expenditure($id);
            redirect(site_url() . 'ExpenditureController/expenditure_list');
        } else {
            redirect(site_url() . 'ExpenditureController/expenditure_list');
        }
    }


    public function expenditure_list($page = 0)
    {
        $this->load->model('ExpenditureModel');
        $this->load->library('pagination');

        $data['expenditures'] = $this->ExpenditureModel->get_expenditures($page);

        $config['base_url'] = base_url() . "ExpenditureController/expenditure_list/";
        $config['total_rows'] = $this->ExpenditureModel->get_expenditures_count();;
        $config['per_page'] = 10;

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


        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view("expenditure/ExpenditureList", $data);


    }

    public function get_expenditures()
    {
        if ($_POST) {
            $month = $this->input->post("Month");
            $year = $this->input->post("Year");
            $column = $this->input->post("Column");
            $this->load->model("ExpenditureModel");
            $sections = $this->ExpenditureModel->get_expenditure_where_month($month, $year);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function get_url()
    {
        if ($_POST) {

            $type = $this->input->post('Type');

            if ($type == 1)
                echo json_encode(base_url("ExpenditureController/edit_expenditure/"));
            elseif ($type == 2)
                echo json_encode(base_url("ExpenditureController/delete_expenditure/"));
            else
                echo json_encode("ERROR");
        }
    }

}
