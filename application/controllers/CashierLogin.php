<?php

class CashierLogin extends CI_Controller
{

    public function index()
    {

        $this->cashier_login();
    }


    public function cashier_login()
    {

        if (!($this->session->has_userdata('cashier_username') && $this->session->has_userdata('cashier_login_time'))) {
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


                $cashier = array(

                    'LoginID' => $this->input->post('username'),
                    'Password' => $this->input->post('password'),
                );

                if ($this->form_validation->run() == FALSE) {
                } else {

                    $login = $this->LoginModel->employee_login($cashier);
                    if ($login) {
                        $logon = array(
                            'cashier_username' => $cashier['LoginID'],
                            'cashier_login_time' => date("h:i:sa")
                        );

                        $employee = $this->LoginModel->get_employee($logon['cashier_username']);

                        $this->load->model("HRModel");

                        if ($employee[0]['DesignationID'] == 7) {
                            $logon['CashierName'] = $employee[0]['FirstName'] . " " . $employee[0]['MiddleName'] . " " . $employee[0]['LastName'];
                            $logon['EmployeeID'] = $employee[0]['EmployeeID'];
                            if (file_exists($employee[0]['Photo']))
                                $logon['CashierPhoto'] = $employee[0]['Photo'];
                            else
                                $logon['CashierPhoto'] = "./assets/dist/img/avatar5.png";
                            $logon['CashierContact'] = $employee[0]['Contact'];
                            $this->session->set_userdata($logon);


                            $this->session->set_userdata($logon);

                            if ($cashier['Password'] == 'password') {
                                $this->session->sess_destroy();
                                redirect(base_url("CashierLogin/change_password/" . $logon['EmployeeID']));
                            } else {
                                redirect(site_url("CashierDashboard/"));
                            }
                        } else {
                            echo "<script>alert('Invalid Cashier Credentials');</script>";
                        }
                    } else {
                        $data['error'] = "Invalid Credentials";
                        echo "<script>alert('Invalid Credentials')</script>";
                    }


                    //echo "<script>alert('Class Added Successfully')   </script>";
                }

            }
            $this->load->view("cashier/CashierLogin", $data);
        } else {
            redirect(site_url("CashierDashboard/"));
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
                    $i = $this->LoginModel->get_employee_id($_SESSION['forgot_cashier_username']);

                    $id = $i[0]['EmployeeID'];
                    $newPass = $this->input->post('new_pass');

                    $newPass = $this->LoginModel->encrypt($newPass);

                    $data['success'] = $this->LoginModel->employee_change_password($id, $newPass);
                }
            }
            $this->load->view('cashier/CashierForgot', $data);
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
                $result = $this->LoginModel->send_employee_link($username);


                if ($result) {
                    echo "<script>alert('Link Send via Email and SMS');</script>";
                } else {
                    echo "<script>alert('Invalid Login ID');</script>";
                }
            }
        }
        $this->load->view('cashier/CashierForgotPassword');
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

                    redirect(base_url("CashierLogin/sign_out"));


                }
            }

            $this->load->view('cashier/CashierChangePassword');
        } else {
            redirect(base_url("CashierLogin/sign_out"));
        }
    }

    public function sign_out()
    {
        $this->session->sess_destroy();
        redirect(site_url("CashierLogin/"));
    }

}
