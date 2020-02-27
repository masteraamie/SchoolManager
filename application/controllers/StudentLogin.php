<?php

class StudentLogin extends CI_Controller
{

    public function index()
    {

        $this->student_login();
    }


    public function student_login()
    {

        if (!($this->session->has_userdata('student_username') && $this->session->has_userdata('student_login_time'))) {
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
                $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                $student = array(

                    'LoginID' => $this->input->post('username'),
                    'Password' => $this->input->post('password'),
                );

                if ($this->form_validation->run() == FALSE) {
                } else {

                    $login = $this->LoginModel->student_login($student);
                    if ($login) {
                        $logon = array(
                            'student_username' => $student['LoginID'],
                            'student_login_time' => date("h:i:sa")
                        );


                        $student = $this->LoginModel->get_student_id($logon['student_username']);


                        $logon['StudentName'] = $student[0]['FirstName'] . " " . $student[0]['MiddleName'] . " " . $student[0]['LastName'];
                        $logon['StudentID'] = $student[0]['StudentID'];
                        $logon['StudentContact'] = $student[0]['Contact'];
                        $logon['ClassID'] = $student[0]['ClassID'];
                        $logon['StopID'] = $student[0]['StopID'];
                        $logon['SectionID'] = $student[0]['SectionID'];

                        if (file_exists($student[0]['Photo']))
                            $logon['StudentPhoto'] = $student[0]['Photo'];
                        else
                            $logon['StudentPhoto'] = "./assets/dist/img/avatar5.png";

                        $this->session->set_userdata($logon);

                        echo "<script>alert('Login Successful')</script>";
                        redirect(site_url("StudentDashboard/"));

                    } else {
                        $data['error'] = "Invalid Credentials";
                        echo "<script>alert('Invalid Credentials')</script>";
                    }


                    //echo "<script>alert('Class Added Successfully')   </script>";
                }

            }
            $this->load->view("student/StudentLogin", $data);
        } else {
            redirect(site_url("student/StudentDashboard/"));
        }

    }

    public function forgot_password($id = "")
    {
        if (isset($id) && is_numeric($id) && ($id == $_SESSION['student_forgot'])) {
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
                    $i = $this->LoginModel->get_student_id($_SESSION['forgot_student_username']);

                    $id = $i[0]['StudentID'];
                    $newPass = $this->input->post('new_pass');

                    $newPass = $this->LoginModel->encrypt($newPass);

                    $data['success'] = $this->LoginModel->student_change_password($id, $newPass);

                }
            }
            $this->load->view('student/StudentForgot', $data);
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
                    'label' => 'Login ID',
                    'rules' => 'trim|required'
                )
            );

            $username = $this->input->post('username');

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');
            if ($this->form_validation->run() == FALSE) {
            } else {

                $this->load->model("LoginModel");
                $result = $this->LoginModel->send_student_link($username);


                if ($result) {
                    echo "<script>alert('Link Send via Email and SMS');</script>";
                } else {
                    echo "<script>alert('Invalid Login ID');</script>";
                }
            }
        }
        $this->load->view('student/StudentForgotPassword');
    }

    public function sign_out()
    {
        $this->session->sess_destroy();
        redirect(site_url("StudentLogin/"));
    }

}
