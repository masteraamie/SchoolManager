<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller
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
        $data['present'] = $this->StudentModel->get_student_attendance_today();
        $data['classes'] = $this->AcademicModel->get_classes_count();
        $data['expenses'] = $this->ExpenditureModel->get_expenditure_month();
        $data['fees'] = $this->FeeModel->get_fees_month();

        $this->load->model("NewsModel");
        $data['news'] = $this->NewsModel->get_news();


        $this->load->model("AchievementModel");
        $data['achievements'] = $this->AchievementModel->get_achievements();

        $this->load->model("EventModel");
        $data['events'] = $this->EventModel->get_events();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('admin/AdminDashboard', $data);

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


    public function get_presents()
    {

    }

    public function settings()
    {

        $this->check_login();
        $data = array();
        $this->load->library('form_validation');
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

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
                    "Username" => $_SESSION['admin_username'],
                    "Password" => $this->LoginModel->encrypt($oldPass)
                );
                $login = $this->LoginModel->admin_login($admin);
                if ($login) {
                    $i = $this->LoginModel->get_admin_id($_SESSION['admin_username']);

                    $id = $i[0]['AdminID'];
                    $newPass = $this->input->post('new_pass');

                    $newPass = $this->LoginModel->encrypt($newPass);

                    $data['success'] = $this->LoginModel->admin_change_password($id, $newPass);

                } else {
                    echo "<script>alert('Invalid Credentials')</script>";
                    $data['error'] = "Invalid Credentials";
                }


            }
        }

        $this->load->view('admin/admin_settings', $data);
    }


}
