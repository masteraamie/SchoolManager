<?php

class Login extends CI_Controller
{

    public function index()
    {
        $this->admin_login();
    }


    public function admin_login()
    {

        if (!($this->session->has_userdata('admin_username') && $this->session->has_userdata('admin_login_time'))) {
            $data = array();
            $this->load->model('LoginModel');

            $this->load->library('form_validation');
            if ($_POST) {
                $rules = array(

                    array(
                        'field' => 'username',
                        'label' => 'Username',
                        'rules' => 'trim|required'
                    ),

                    array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required'
                    )
                );


                $this->form_validation->set_rules($rules);
                $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');


                if ($this->form_validation->run() == FALSE) {
                } else {


                    $p = $this->input->post('password');
                    $pass = $this->LoginModel->encrypt($p);

                    $admin = array(

                        'Username' => $this->input->post('username'),
                        'Password' => $pass,
                    );

                    $login = $this->LoginModel->admin_login($admin);
                    if ($login) {
                        $logon = array(
                            'admin_username' => $admin['Username'],
                            'admin_login_time' => date("h:i:sa")
                        );
                        $this->session->set_userdata($logon);

                        redirect(site_url("DashboardController/"));

                    } else {
                        echo "<script>alert('Invalid Credentials')</script>";
                        $data['error'] = "Invalid Credentials";
                    }


                    //echo "<script>alert('Class Added Successfully')   </script>";
                }

            }
            $this->load->view("admin/AdminLogin", $data);
        } else {
            redirect(site_url("DashboardController/"));
        }

    }


    public function forgot_password($id = "")
    {
        if (isset($id) && is_numeric($id) && ($id == $_SESSION['forgot'])) {
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

                    $i = $this->LoginModel->get_admin_id($_SESSION['forgot_username']);

                    $id = $i[0]['AdminID'];
                    $newPass = $this->input->post('new_pass');

                    $newPass = $this->LoginModel->encrypt($newPass);

                    $data['success'] = $this->LoginModel->admin_change_password($id, $newPass);

                }
            }
            $this->load->view('admin/AdminForgot', $data);
        } else
            redirect(site_url());
    }


    public function send_forgot_link()
    {
        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(
                array(
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'trim|required'
                )
            );

            $username = $this->input->post('username');

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');
            if ($this->form_validation->run() == FALSE) {
            } else {

                $this->load->model("LoginModel");
                $result = $this->LoginModel->send_admin_link($username);


                if ($result) {
                    echo "<script>alert('Link Send via Email and SMS');</script>";
                } else {
                    echo "<script>alert('Invalid Username');</script>";
                }
            }
        }
        $this->load->view('admin/AdminForgotPassword');
    }


    public function sign_out()
    {
        $this->session->sess_destroy();
        redirect(site_url("Login/admin_login"));
    }

}
