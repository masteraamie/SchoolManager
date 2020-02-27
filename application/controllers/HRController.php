<?php

class HRController extends CI_Controller
{

    public function index()
    {
        redirect(site_url() . 'DashboardController/');
    }

    public function add_department()
    {
        $this->check_login();
        $data = array();

        $this->load->model('HRModel');
        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Department Name',
                    'rules' => 'trim|required|min_length[1]|max_length[80]|is_unique[tbl_departments.name]'
                ),
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $department = array(

                'Name' => $this->input->post('name'),
            );


            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->HRModel->add_department($department);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $data['name'] = "";
        }
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['departments'] = $this->HRModel->get_departments();
        $this->load->view('HR/AddDepartment', $data);
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

    public function edit_department($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('HRModel');

            $department = $this->HRModel->get_department_where($id);

            if ($department) {
                $this->load->library('form_validation');


                $data['id'] = $id;


                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Department Name',
                            'rules' => 'trim|required|min_length[1]|max_length[80]|is_unique[tbl_departments.name]'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $department = array(

                        'Name' => $this->input->post('name'),
                        'DepartmentID' => $id
                    );


                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->HRModel->update_department($department);
                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                }

                $department = $this->HRModel->get_department_where($id);
                $data['name'] = $department[0]['Name'];
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $data['departments'] = $this->HRModel->get_departments();
                $this->load->view('HR/EditDepartment', $data);

            } else {
                redirect(site_url() . 'HRController/add_department');
            }
        } else {
            redirect(site_url() . 'HRController/add_department');
        }
    }

    public function delete_department($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('HRModel');


            $data['id'] = $id;

            $data['delete'] = $this->HRModel->delete_department($id);
            redirect(site_url() . 'HRController/add_department');
        } else {
            redirect(site_url() . 'HRController/add_department');
        }
    }


    public function add_leave_type()
    {
        $this->check_login();
        $data = array();

        $this->load->model('HRModel');

        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'type',
                    'label' => 'Leave Type',
                    'rules' => 'trim|required|alpha_numeric|min_length[1]|max_length[20]|is_unique[tbl_leave_types.Type]'
                ),
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $leave_type = array(

                'Type' => $this->input->post('type'),
            );


            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->HRModel->add_leave_type($leave_type);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $data['type'] = "";
        }
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['leave_types'] = $this->HRModel->get_leave_types();
        $this->load->view('HR/AddLeaveType', $data);
    }

    public function edit_leave_type($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $data['id'] = $id;
            $this->load->model('HRModel');
            $leave_type = $this->HRModel->get_leave_type_where($id);
            $data['leave_type'] = $leave_type;

            if ($leave_type) {

                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'type',
                            'label' => 'Leave Type',
                            'rules' => 'trim|required|alpha_numeric|min_length[1]|max_length[20]'
                        ),
                        array(
                            'field' => 'id',
                            'label' => 'Invalid Leave Type',
                            'rules' => 'trim|required|numeric'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $leave_type = array(

                        'Type' => $this->input->post('type'),
                        'LeaveTypeID' => $this->input->post('id')
                    );


                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->HRModel->update_leave_type($leave_type);
                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                } else {
                    $data['type'] = "";
                }
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $leave_type = $this->HRModel->get_leave_type_where($id);
                $data['leave_type'] = $leave_type;

                $data['leave_types'] = $this->HRModel->get_leave_types();
                $this->load->view('HR/EditLeaveType', $data);
            } else {
                redirect(site_url("HRController/add_leave_type"));
            }
        } else {
            redirect(site_url("HRController/add_leave_type"));
        }
    }

    public function delete_leave_type($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('HRModel');


            $data['id'] = $id;

            $data['delete'] = $this->HRModel->delete_leave_type($id);
            redirect(site_url() . 'HRController/add_leave_type');
        } else {
            redirect(site_url() . 'HRController/add_leave_type');
        }
    }

    public function set_max_leaves()
    {
        $this->check_login();
        $data = array();

        $this->load->model('HRModel');

        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'designation',
                    'label' => 'Designation',
                    'rules' => 'trim|required|is_unique[tbl_max_leaves.DesignationID]'
                ),
                array(
                    'field' => 'leaveCount',
                    'label' => 'Max Leave Count',
                    'rules' => 'trim|required|numeric'
                ),
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $leaves = array(

                'DesignationID' => $this->input->post('designation'),
                'LeaveCount' => $this->input->post('leaveCount')
            );


            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->HRModel->add_max_leaves($leaves);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $data['type'] = "";
        }
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['designations'] = $this->HRModel->get_designations();
        $data['max_leaves'] = $this->HRModel->get_max_leaves();
        $this->load->view('HR/SetMaxLeaves', $data);
    }


    public function edit_max_leaves($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('HRModel');
            $max_leave = $this->HRModel->get_max_leave_where($id);
            $data['max_leave'] = $max_leave;


            if ($max_leave) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(
                        array(
                            'field' => 'leaveCount',
                            'label' => 'Max Leave Count',
                            'rules' => 'trim|required|numeric'
                        ),
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $leaves = array(

                        'DesignationID' => $id,
                        'LeaveCount' => $this->input->post('leaveCount')
                    );


                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->HRModel->update_max_leaves($leaves);
                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                }
                $data['designations'] = $this->HRModel->get_designations();
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $max_leave = $this->HRModel->get_max_leave_where($id);
                $data['max_leave'] = $max_leave;


                $data['max_leaves'] = $this->HRModel->get_max_leaves();
                $this->load->view('HR/EditMaxLeaves', $data);
            } else {
                redirect(site_url("HRController/set_max_leaves"));
            }
        } else {
            redirect(site_url("HRController/set_max_leaves"));
        }
    }

    public function add_designation()
    {
        $this->check_login();
        $data = array();

        $this->load->model('HRModel');

        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Designation Name',
                    'rules' => 'trim|required|min_length[1]|max_length[80]|is_unique[tbl_designations.name]'
                ),
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $designation = array(

                'Name' => $this->input->post('name'),
            );


            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->HRModel->add_designation($designation);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $data['name'] = "";
        }
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['designations'] = $this->HRModel->get_designations();
        $this->load->view('HR/AddDesignation', $data);
    }


    public function edit_designation($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('HRModel');
            $designation = $this->HRModel->get_designation_where($id);
            $data['designation'] = $designation;

            if ($designation) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Designation Name',
                            'rules' => 'trim|required|min_length[1]|max_length[80]|is_unique[tbl_designations.name]'
                        ),
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $designation = array(
                        'Name' => $this->input->post('name'),
                        "DesignationID" => $this->input->post('id'),
                    );


                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->HRModel->update_designation($designation);
                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                } else {
                    $data['name'] = "";
                }
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $designation = $this->HRModel->get_designation_where($id);
                $data['designation'] = $designation;


                $data['designations'] = $this->HRModel->get_designations();
                $this->load->view('HR/EditDesignation', $data);
            } else {
                redirect(base_url() . 'HRController/add_designation');
            }
        } else {
            redirect(base_url() . 'HRController/add_designation');
        }
    }

    public function delete_designation($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('HRModel');


            $data['id'] = $id;

            $data['delete'] = $this->HRModel->delete_designation($id);
            redirect(base_url() . 'HRController/add_designation');
        } else {
            redirect(base_url() . 'HRController/add_designation');
        }
    }

    public function add_employee()
    {
        $this->check_login();
        $data = array();
        if (!is_dir("./uploads/employees"))
            mkdir("./uploads/employees", 0777, TRUE);

        $this->load->model('HRModel');

        $this->load->library('form_validation');
        if ($_POST) {


            $rules = array(

                array(
                    'field' => 'fname',
                    'label' => 'First Name',
                    'rules' => 'trim|required|min_length[1]|max_length[25]'
                )/*,

                array(
                    'field' => 'designation',
                    'label' => 'Designation',
                    'rules' => 'trim|required|numeric'
                ),

                array(
                    'field' => 'department',
                    'label' => 'Department',
                    'rules' => 'trim|required|numeric'
                ),

                array(
                    'field' => 'experience',
                    'label' => 'Experience',
                    'rules' => 'trim|required'
                ),


                array(
                    'field' => 'doj',
                    'label' => 'Date of Joining',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'dob',
                    'label' => 'Date of Birth',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'qualification',
                    'label' => 'Qualification',
                    'rules' => 'trim|required|min_length[1]|max_length[25]'
                ),
                array(
                    'field' => 'address',
                    'label' => 'Address',
                    'rules' => 'trim|required|min_length[1]|max_length[25]'
                ),
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'trim|required|valid_email|is_unique[tbl_employee_details.Email]'
                ),
                array(
                    'field' => 'salary',
                    'label' => 'Salary',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'account',
                    'label' => 'Account Number',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'contact',
                    'label' => 'Contact',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'parentage',
                    'label' => 'Parentage',
                    'rules' => 'trim|required'
                )*/

            );

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $employee = array(
                'AccountNumber' => $this->input->post('account'),
                'FirstName' => $this->input->post('fname'),
                'LastName' => $this->input->post('lname'),
                'Title' => $this->input->post('title'),
                'Address' => $this->input->post('address'),
                'DOB' => $this->input->post('dob'),
                'DOJ' => $this->input->post('doj'),
                'Gender' => $this->input->post('gender'),
                'Contact' => $this->input->post('contact'),
                'Email' => $this->input->post('email'),
                'DepartmentID' => $this->input->post('department'),
                'DesignationID' => $this->input->post('designation'),
                'Qualification' => $this->input->post('qualification'),
                'Parentage' => $this->input->post('parentage'),
                'Experience' => $this->input->post('experience'),
                'Salary' => $this->input->post('salary')
            );


            $last = $this->HRModel->get_last_id();

            $reg = $last[0]['EmployeeID'];

            $length = strlen($reg);

            if ($length == 1)
                $reg = "000" . $reg;
            elseif ($length == 2)
                $reg = "00" . $reg;
            elseif ($length == 3)
                $reg = "0" . $reg;
            else
                $reg = $reg;

            $this->load->model('LoginModel');
            $login = array(
                "LoginID" => "SBS/" . $reg,
                "Password" => $this->LoginModel->encrypt("password")
            );

            $employee['LoginID'] = $login['LoginID'];
            $employee['Password'] = $login['Password'];

            $data['employee'] = $employee;
            if ($this->form_validation->run() == FALSE) {


            } else {

                $data['id'] = $this->HRModel->add_employee($employee);

                $from_email = "www.sbssrinagar.com";
                $to_email = $employee['Email'];
                $message = "    <html>
                                        <head>
                                        <title>Login Details</title>
                                        </head>
                                        <body>
                                        <table>
                                        <tr>
                                        <th>LOGIN ID</th>
                                        <th>PASSWORD</th>
                                        </tr>
                                        <tr>
                                        <td>" . $login['LoginID'] . "</td>
                                        <td>password</td>
                                        </tr>
                                        </table>
                                        </body>
                                        </html>";
                //Load email library
                $this->load->library('email');
                $this->email->set_mailtype("html");
                $this->email->from($from_email, 'SBS MANAGER');
                $this->email->to($to_email);
                $this->email->subject('LOGIN DETAILS');
                $this->email->message($message);

                //Send mail
                $this->email->send();


                $message = "LoginID is " . $login['LoginID'] . " Password is : 123456";


                $this->LoginModel->send_sms($employee['Contact'], $message);

                if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {


                    $config = array(

                        'file_name' => $employee['FirstName'] . $data['id'],
                        'upload_path' => './uploads/employees/',
                        'allowed_types' => 'png|jpg',
                        'overwrite' => TRUE,
                        'max_size' => '1024000'

                    );

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('photo')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->HRModel->add_employee_photo($data['id'], $config['upload_path'] . $upload_data['file_name']);
                            $data['success'] = True;
                        } else {
                            $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                        }

                    } else {
                        $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                    }
                } else {
                    $data['img_error'] = array(
                        "error" => " Image is Required "
                    );
                }

                if (isset($_FILES['qual']['name']) && !empty($_FILES['qual']['name'])) {


                    $config = array(

                        'file_name' => $employee['FirstName'] . $data['id'] . "_QUAL",
                        'upload_path' => './uploads/employees/',
                        'allowed_types' => 'pdf',
                        'overwrite' => TRUE,
                        'max_size' => '1024000'

                    );

                    $this->load->library('upload');

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('qual')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->HRModel->add_employee_doc($data['id'], $config['upload_path'] . $upload_data['file_name']);
                            $data['success'] = True;
                        } else {
                            $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                        }

                    } else {
                        $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                    }
                }

            }

        } else {

            $employee = array(
                'FirstName' => "",
                'LastName' => "",
                'Title' => $this->input->post('title'),
                'Address' => "",
                'DOB' => "",
                'DOJ' => "",
                'Gender' => "",
                'Contact' => "",
                'Email' => "",
                'DepartmentID' => "",
                'Qualification' => "",
                'Experience' => "",
                'Salary' => "",
                'Parentage' => "",
                'AccountNumber' => $this->input->post('account')
            );
            $data['employee'] = $employee;
        }
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['departments'] = $this->HRModel->get_departments();
        $data['designations'] = $this->HRModel->get_designations();
        $this->load->view('HR/AddEmployee', $data);
    }


    public function edit_employee($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $data['id'] = $id;


            if (!is_dir("./uploads/employees"))
                mkdir("./uploads/employees", 0777, TRUE);

            $this->load->model('HRModel');

            $employ = $this->HRModel->get_employee_where_id($id);
            $data['employee'] = $employ;

            if ($employ) {

                $this->load->library('form_validation');
                if ($_POST) {


                    $rules = array(

                        array(
                            'field' => 'fname',
                            'label' => 'First Name',
                            'rules' => 'trim|required|min_length[1]'
                        )/* ,
                        array(
                            'field' => 'mname',
                            'label' => 'Middle Name',
                            'rules' => 'trim|max_length[30]|alpha'
                        ),
                        array(
                            'field' => 'lname',
                            'label' => 'Last Name',
                            'rules' => 'trim|max_length[30]|alpha'
                        ),
                        array(
                            'field' => 'designation',
                            'label' => 'Designation',
                            'rules' => 'trim|required|numeric'
                        ),


                        array(
                            'field' => 'department',
                            'label' => 'Department',
                            'rules' => 'trim|required|numeric'
                        ),

                        array(
                            'field' => 'experience',
                            'label' => 'Experience',
                            'rules' => 'trim|required'
                        ),


                        array(
                            'field' => 'doj',
                            'label' => 'Date of Joining',
                            'rules' => 'trim|required'
                        ),

                        array(
                            'field' => 'dob',
                            'label' => 'Date of Birth',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'parentage',
                            'label' => 'Parentage',
                            'rules' => 'trim|required'
                        ),

                        array(
                            'field' => 'qualification',
                            'label' => 'Qualification',
                            'rules' => 'trim|required|min_length[1]|max_length[25]'
                        ),
                        array(
                            'field' => 'address',
                            'label' => 'Address',
                            'rules' => 'trim|required|min_length[1]|max_length[25]'
                        ),
                        array(
                            'field' => 'email',
                            'label' => 'Email',
                            'rules' => 'trim|required|valid_email'
                        ),

                        array(
                            'field' => 'contact',
                            'label' => 'Contact',
                            'rules' => 'trim|required|numeric'
                        ),

                        array(
                            'field' => 'salary',
                            'label' => 'Salary',
                            'rules' => 'trim|required|numeric'
                        )*/
                    );

                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $employee = array(

                        'AccountNumber' => $this->input->post('account'),
                        'FirstName' => $this->input->post('fname'),
                        'LastName' => $this->input->post('lname'),
                        'Title' => $this->input->post('title'),
                        'Address' => $this->input->post('address'),
                        'DOB' => $this->input->post('dob'),
                        'DOJ' => $this->input->post('doj'),
                        'Gender' => $this->input->post('gender'),
                        'Contact' => $this->input->post('contact'),
                        'Email' => $this->input->post('email'),
                        'DepartmentID' => $this->input->post('department'),
                        'DesignationID' => $this->input->post('designation'),
                        'Qualification' => $this->input->post('qualification'),
                        'Parentage' => $this->input->post('parentage'),
                        'Experience' => $this->input->post('experience'),
                        'DOR' => $this->input->post('dor'),
                        'Salary' => $this->input->post('salary'),
                        'Status' => $this->input->post('status')
                    );

                    if ($employ[0]['Password'] != $this->input->post('password')) {
                        $this->load->model('LoginModel');
                        $employee['Password'] = $this->LoginModel->encrypt($this->input->post('password'));
                    }
                    $data['employee'] = $employee;
                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->HRModel->update_employee($employee, $id);

                        if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {


                            $config = array(

                                'file_name' => $employee['FirstName'] . $id,
                                'upload_path' => './uploads/employees/',
                                'allowed_types' => 'png|jpg',
                                'overwrite' => TRUE,
                                'max_size' => '1024000'
                            );

                            $this->load->library('upload', $config);

                            if ($this->upload->do_upload('photo')) {

                                $upload_data = $this->upload->data();

                                if ($upload_data) {
                                    $this->HRModel->add_employee_photo($id, $config['upload_path'] . $upload_data['file_name']);
                                    $data['success'] = True;
                                } else {
                                    $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                                }

                            } else {
                                $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                            }
                        }
                        if (isset($_FILES['qual']['name']) && !empty($_FILES['qual']['name'])) {


                            $config = array(

                                'file_name' => $employee['FirstName'] . $data['id'] . "_QUAL",
                                'upload_path' => './uploads/employees/',
                                'allowed_types' => 'pdf',
                                'overwrite' => TRUE,
                                'max_size' => '1024000'

                            );

                            $this->load->library('upload');

                            $this->upload->initialize($config);

                            if ($this->upload->do_upload('qual')) {

                                $upload_data = $this->upload->data();

                                if ($upload_data) {
                                    $this->HRModel->add_employee_doc($id, $config['upload_path'] . $upload_data['file_name']);
                                    $data['success'] = True;
                                } else {
                                    $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                                }

                            } else {
                                $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                            }
                        }
                    }

                }
                $employee = $this->HRModel->get_employee_where_id($id);
                $data['employee'] = $employee;
                $data['departments'] = $this->HRModel->get_departments();
                $data['designations'] = $this->HRModel->get_designations();
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('HR/EditEmployee', $data);
            } else {
                redirect(site_url() . 'HRController/add_employee');
            }
        } else {
            redirect(site_url() . 'HRController/add_employee');
        }
    }


    public function view_payroll()
    {

        $this->check_login();
        $data = array();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model('HRModel');
        $data['departments'] = $this->HRModel->get_departments();
        $this->load->view("HR/ViewPayroll", $data);
    }


    public function employee_list()
    {
        $this->check_login();
        $data = array();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model('HRModel');

        $data['departments'] = $this->HRModel->get_departments();
        $this->load->view("HR/EmployeeList", $data);
    }


    public function employee_attendance()
    {
        $this->check_login();
        $data = array();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model('HRModel');
        $data['departments'] = $this->HRModel->get_departments();
        $this->load->view("HR/EmployeeAttendance", $data);
    }


    public function check_attendance()
    {
        $this->check_login();
        $data = array();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model('HRModel');
        $data['employees'] = $this->HRModel->get_employees();
        $this->load->view("HR/EmployeeCheckAttendance", $data);
    }


    public function get_url()
    {
        echo json_encode(site_url("HRController/edit_employee/"));
    }

    public function get_from_employees()
    {
        if ($_POST) {
            $deptID = $this->input->post("DepartmentID");
            $column = $this->input->post("Column");
            $this->load->model("HRModel");
            $employees = $this->HRModel->get_employees_where_dept($deptID);

            $data = array();
            foreach ($employees as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }


    public function get_employees_attendance()
    {
        if ($_POST) {
            $ID = $this->input->post("id");
            $day = $this->input->post("day");
            $month = $this->input->post("month");
            $year = $this->input->post("year");
            $type = $this->input->post("type");

            if ($type == "daily") {
                $data = array(
                    "EmployeeID" => $ID,
                    "Day" => $day,
                    "Month" => $month,
                    "Year" => $year
                );
            } else {
                $data = array(
                    "EmployeeID" => $ID,
                    "Month" => $month,
                    "Year" => $year
                );
            }

            $this->load->model("HRModel");
            $attendance = $this->HRModel->get_employees_attendance($data);

            $presents = $this->HRModel->get_attendance_where($data, 'P');
            $absents = $this->HRModel->get_attendance_where($data, 'A');


            if ($type == "monthly") {
                echo "<tr>";
                echo "<td><label class='label label-info'>Days Present in this Month : $presents</label></td>";
                echo "<td><label class='label label-danger'>Days Absent in this Month : $absents</label></td>";
                echo "</tr>";
            }
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
        }
    }

    public function get_all_employees()
    {
        if ($_POST) {
            $column = $this->input->post("Column");
            $this->load->model("HRModel");
            $employees = $this->HRModel->get_employees();

            $data = array();
            foreach ($employees as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function do_attendance()
    {
        if ($_POST) {
            $departmentID = $this->input->post("DepartmentID");
            $employeeID = $this->input->post("EmployeeID");
            $date = $this->input->post("Date");
            $status = $this->input->post("Status");


            $date_format = DateTime::createFromFormat("Y-m-d", $date);

            $day = $date_format->format('d');
            $month = $date_format->format('m');
            $year = $date_format->format('Y');


            $this->load->model("HRModel");


            $data = array(

                "DepartmentID" => $departmentID,
                "EmployeeID" => $employeeID,
                "Date" => $date,
                "Date" => $date,
                'Day' => $day,
                "Month" => $month,
                "Year" => $year,
                "Status" => $status
            );
            $result = $this->HRModel->do_employee_attendance($data);

            echo $result;
        }
    }

}