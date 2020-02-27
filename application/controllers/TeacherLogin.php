<?php

class TeacherLogin extends CI_Controller
{

    public function index()
    {

        $this->teacher_login();
    }


    public function teacher_login()
    {

        if (!($this->session->has_userdata('teacher_username') && $this->session->has_userdata('teacher_login_time'))) {
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


                $teacher = array(

                    'LoginID' => $this->input->post('username'),
                    'Password' => $this->input->post('password'),
                );

                if ($this->form_validation->run() == FALSE) {
                } else {

                    $login = $this->LoginModel->employee_login($teacher);
                    if ($login) {
                        $logon = array(
                            'teacher_username' => $teacher['LoginID'],
                            'teacher_login_time' => date("h:i:sa")
                        );

                        $employee = $this->LoginModel->get_employee($logon['teacher_username']);

                        $this->load->model("HRModel");

                        if ($employee[0]['DesignationID'] == 2) {
                            $logon['TeacherName'] = $employee[0]['FirstName'] . " " . $employee[0]['MiddleName'] . " " . $employee[0]['LastName'];
                            $logon['EmployeeID'] = $employee[0]['EmployeeID'];
                            if (file_exists($employee[0]['Photo']))
                                $logon['TeacherPhoto'] = $employee[0]['Photo'];
                            else
                                $logon['TeacherPhoto'] = "./assets/dist/img/avatar5.png";
                            $logon['TeacherContact'] = $employee[0]['Contact'];
                            $this->session->set_userdata($logon);


                            $this->session->set_userdata($logon);

                            if ($teacher['Password'] == 'password') {
                                $this->session->sess_destroy();
                                redirect(base_url("TeacherLogin/change_password/" . $logon['EmployeeID']));
                            } else {

                                echo "<script>alert('Login Successful')</script>";
                                redirect(site_url("TeacherDashboard/"));
                            }
                        } else {
                            $data['error'] = "Invalid Credentials";
                            echo "<script>alert('Invalid Credentials')</script>";
                        }

                    } else {
                        $data['error'] = "Invalid Credentials";
                        echo "<script>alert('Invalid Credentials')</script>";
                    }


                    //echo "<script>alert('Class Added Successfully')   </script>";
                }
                /*else
                {
                    echo "<script>alert('Invalid Accountant Credentials');</script>";
                }*/

            }
            $this->load->view("teacher/TeacherLogin", $data);
        } else {
            redirect(site_url("TeacherDashboard/"));
        }

    }

    public function forgot_password($id = "")
    {
        if (isset($id) && is_numeric($id) && ($id == $_SESSION['employee_forgot'])) {
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
                    $i = $this->LoginModel->get_employee_id($_SESSION['forgot_teacher_username']);

                    $id = $i[0]['EmployeeID'];
                    $newPass = $this->input->post('new_pass');

                    $newPass = $this->LoginModel->encrypt($newPass);

                    $data['success'] = $this->LoginModel->employee_change_password($id, $newPass);
                }
            }
            $this->load->view('teacher/TeacherForgot', $data);
        } else
            redirect(site_url());
    }


    public
    function send_forgot_link()
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
                $result = $this->LoginModel->send_employee_link($username);


                if ($result) {
                    echo "<script>alert('Link Send via Email and SMS');</script>";
                } else {
                    echo "<script>alert('Invalid Login ID');</script>";
                }
            }
        }
        $this->load->view('teacher/TeacherForgotPassword');
    }

    public function change_password($id)
    {
        $data = array();

        if (isset($id)) {
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


                    $newPass = $this->input->post('new_pass');

                    $newPass = $this->LoginModel->encrypt($newPass);

                    $data['success'] = $this->LoginModel->employee_change_password($id, $newPass);

                    redirect(base_url("TeacherLogin/sign_out"));


                }
            }

            $this->load->view('teacher/TeacherChangePassword');
        } else {
            redirect(base_url("TeacherLogin/sign_out"));
        }
    }

    public function sign_out()
    {
        $this->session->sess_destroy();
        redirect(site_url("TeacherLogin/"));
    }

}
