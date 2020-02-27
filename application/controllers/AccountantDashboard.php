<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccountantDashboard extends CI_Controller
{

    public function index()
    {

        $this->check_login();
        $this->load->model("HRModel");
        $this->load->model("AcademicModel");
        $this->load->model("StudentModel");
        $this->load->model("ExpenditureModel");
        $this->load->model("FeeModel");

        $data['employees'] = $this->HRModel->get_employees_count();
        $data['students'] = $this->StudentModel->get_students_count();

        $data['expenses'] = $this->ExpenditureModel->get_expenditure_month();
        $data['fees'] = $this->FeeModel->get_fees_month();

        $this->load->model("NewsModel");
        $data['news'] = $this->NewsModel->get_news();

        $this->load->model("EventModel");
        $data['events'] = $this->EventModel->get_events(0, 4);


        $this->load->model("VisitModel");
        $data['visits'] = $this->VisitModel->get_visits(0, 4);

        $this->load->view('accountant/AccountantDashboard', $data);

    }

    public function check_login()
    {
        if ($this->session->has_userdata('accountant_username') && $this->session->has_userdata('accountant_login_time')) {
        } else {
            redirect(site_url("AccountantLogin/"));
        }
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


                $admin = array(
                    "LoginID" => $_SESSION['accountant_username'],
                    "Password" => $oldPass
                );
                $login = $this->LoginModel->employee_login($admin);
                if ($login) {
                    $i = $this->LoginModel->get_employee_id($_SESSION['accountant_username']);

                    $id = $i[0]['EmployeeID'];
                    $newPass = $this->input->post('new_pass');

                    $newPass = $this->LoginModel->encrypt($newPass);

                    $data['success'] = $this->LoginModel->employee_change_password($id, $newPass);

                } else {
                    echo "<script>alert('Invalid Credentials')</script>";
                    $data['error'] = "Invalid Credentials";
                }


            }
        }

        $this->load->view('accountant/accountant_settings', $data);
    }


}
