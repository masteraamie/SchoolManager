<?php

class StudentController extends CI_Controller
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


    public function copy_table()
    {
        $data = array();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        if ($_POST) {
            $this->load->model("StudentModel");
            $data['id'] = $this->StudentModel->loginid();

            //echo "<script>alert('Count ".$data['id']."');</script>";
        }
        /* $this->load->model("StudentModel");

        $data['students'] = $this->StudentModel->get_data();*/

        $this->load->view('student/Copy', $data);
    }

    public function add_student()
    {
        $this->check_login();
        $data = array();
        if (!is_dir("./uploads/students"))
            mkdir("./uploads/students", 0777, TRUE);


        if (!is_dir("./uploads/parents"))
            mkdir("./uploads/parents", 0777, TRUE);

        $this->load->model('StudentModel');

        $this->load->library('form_validation');
        if ($_POST) {


            $rules = array(array(
                    'field' => 'fname',
                    'label' => 'Student First Name',
                    'rules' => 'trim|required|min_length[1]|max_length[25]|alpha'
                )/*,

                array(
                    'field' => 'mname',
                    'label' => 'Student Middle Name',
                    'rules' => 'trim|alpha'
                ),

                array(
                    'field' => 'lname',
                    'label' => 'Student Last Name',
                    'rules' => 'trim|alpha'
                ),

                array(
                    'field' => 'p_fname',
                    'label' => 'Parent First Name',
                    'rules' => 'trim|required|min_length[1]|max_length[25]|alpha'
                ),

                array(
                    'field' => 'p_mname',
                    'label' => 'Parent Middle Name',
                    'rules' => 'trim|alpha'
                ),

                array(
                    'field' => 'p_lname',
                    'label' => 'Parent Last Name',
                    'rules' => 'trim|alpha'
                ),

                array(
                    'field' => 'profession',
                    'label' => 'Parent Profession',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'qualification',
                    'label' => 'Parent Qualification',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'registration',
                    'label' => 'Registration Number',
                    'rules' => 'trim|required|min_length[3]|is_unique[tbl_student_details.RegistrationNumber]'
                ),

                array(
                    'field' => 'roll',
                    'label' => 'Roll Number',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'section',
                    'label' => 'Section',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'class',
                    'label' => 'Class',
                    'rules' => 'trim|required|numeric'
                ),

                array(
                    'field' => 'gender',
                    'label' => 'Gender',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'batch',
                    'label' => 'Batch',
                    'rules' => 'trim|required|numeric'
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
                    'field' => 'address',
                    'label' => 'Address',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'email',
                    'label' => 'Student Email',
                    'rules' => 'trim|valid_email|is_unique[tbl_student_details.Email]|required'
                ),


                array(
                    'field' => 'contact',
                    'label' => 'Student Contact',
                    'rules' => 'trim|numeric|required'
                )*/
            );

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>');


            $student = array(

                'FirstName' => $this->input->post('fname'),
                'LastName' => $this->input->post('lname'),
                'MiddleName' => $this->input->post('mname'),
                'Batch' => $this->input->post('batch'),
                'RegistrationNumber' => $this->input->post('registration'),
                'Roll' => $this->input->post('roll'),
                'Address' => $this->input->post('address'),
                'DOB' => $this->input->post('dob'),
                'DOJ' => $this->input->post('doj'),
                'Gender' => $this->input->post('gender'),
                'Contact' => '91' . $this->input->post('contact'),
                'Email' => $this->input->post('email'),
                'ClassID' => $this->input->post('class'),
                'SectionID' => $this->input->post('section'),
                'PFirstName' => $this->input->post('p_fname'),
                'PLastName' => $this->input->post('p_lname'),
                'PMiddleName' => $this->input->post('p_mname'),
                'PRelation' => $this->input->post('relation'),
                'PQualification' => $this->input->post('qualification'),
                'PProfession' => $this->input->post('profession'),
                'PrevClass' => $this->input->post('p_class'),
                'PrevSchool' => $this->input->post('p_school'),
                'PrevPercentage' => $this->input->post('percent'),
            );

            $reg = $this->StudentModel->get_last_student();

            $length = strlen($reg);

            if ($length == 1)
                $reg = "100" . $reg;
            elseif ($length == 2)
                $reg = "10" . $reg;
            elseif ($length == 3)
                $reg = "1" . $reg;
            else
                $reg = $reg;

            $loginID = "SBS" . $reg;
            $this->load->model('LoginModel');

            $student["LoginID"] = $loginID;
            $student["Password"] = $this->LoginModel->encrypt($loginID);
            $data['student'] = $student;

            if ($this->form_validation->run() == FALSE) {
            } else {


                if ($this->StudentModel->check_student_where($student['ClassID'], $student['SectionID'], $student['Roll'])) {

                    $data['id'] = $this->StudentModel->add_student($student);

                    if ((isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name']))) {


                        $config = array(

                            'file_name' => $student['FirstName'] . $data['id'],
                            'upload_path' => './uploads/students/',
                            'allowed_types' => 'png|jpg',
                            'overwrite' => TRUE,
                            'max_size' => '1024000'

                        );

                        $this->load->library('upload');
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('photo')) {

                            $upload_data = $this->upload->data();

                            if ($upload_data) {
                                $this->StudentModel->add_student_photo($data['id'], $config['upload_path'] . $upload_data['file_name']);
                            } else {
                                $this->StudentModel->roll_back();
                                $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                            }

                        } else {
                            $this->StudentModel->roll_back();
                            $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                        }
                    } else {
                        $this->StudentModel->roll_back();
                        $data['img_error'] = array(
                            "error" => "Student Image is Required "
                        );
                    }
                    if ((isset($_FILES['p_photo']['name']) && !empty($_FILES['p_photo']['name']))) {


                        $config = array(

                            'file_name' => $student['PFirstName'] . $data['id'],
                            'upload_path' => './uploads/parents/',
                            'allowed_types' => 'png|jpg',
                            'overwrite' => TRUE,
                            'max_size' => '1024000'
                        );

                        $this->load->library('upload', $config);

                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('p_photo')) {

                            $upload_data = $this->upload->data();

                            if ($upload_data) {
                                $this->StudentModel->add_parent_photo($data['id'], $config['upload_path'] . $upload_data['file_name']);
                                $data['full_success'] = True;
                            } else {
                                $this->StudentModel->roll_back();
                                $data['p_img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                            }

                        } else {
                            $this->StudentModel->roll_back();
                            $data['p_img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                        }
                    } else {
                        $this->StudentModel->roll_back();
                        $data['p_img_error'] = array(
                            "error" => "Parent Image is Required "
                        );
                    }
                    $docs = $this->upload_documents($student['FirstName'], $data['id']);
                    $data['birth_img_error'] = isset($docs['birth_img_error']) ? $docs['birth_img_error'] : NULL;
                    $data['migration_img_error'] = isset($docs['migration_img_error']) ? $docs['migration_img_error'] : NULL;
                    $data['state_img_error'] = isset($docs['state_img_error']) ? $docs['state_img_error'] : NULL;

                    $data['succeed'] = $docs['succeed'];
                    if ($docs['succeed'] == TRUE) {
                        $this->StudentModel->commit();
                        $from_email = "www.sbssrinagar.com";
                        $to_email = $student['Email'];
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
                                    <td>" . $student['LoginID'] . "</td>
                                    <td>" . $loginID . "</td>
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
                        $message = "LoginID is " . $student['LoginID'] . " Password is : " . $loginID;
                        $this->LoginModel->send_sms($student['Contact'], $message);

                        $data['full_success'] = TRUE;
                    }
                } else {
                    $data['error'] = "Student With This Roll Number Already Present in this Class and Section";
                }
            }
        } else {

            $student = array(

                'FirstName' => $this->input->post('fname'),
                'LastName' => $this->input->post('lname'),
                'MiddleName' => $this->input->post('mname'),
                'Batch' => $this->input->post('batch'),
                'RegistrationNumber' => $this->input->post('registration'),
                'Roll' => $this->input->post('roll'),
                'Address' => $this->input->post('p_address'),
                'DOB' => $this->input->post('dob'),
                'DOJ' => $this->input->post('doj'),
                'Gender' => $this->input->post('gender'),
                'Contact' => $this->input->post('contact'),
                'Email' => $this->input->post('email'),
                'ClassID' => $this->input->post('class'),
                'SectionID' => $this->input->post('section'),
                'PFirstName' => $this->input->post('p_fname'),
                'PLastName' => $this->input->post('p_lname'),
                'PMiddleName' => $this->input->post('p_mname'),
                'PRelation' => $this->input->post('relation'),
                'PQualification' => $this->input->post('qualification'),
                'PProfession' => $this->input->post('profession'),
                'PrevClass' => $this->input->post('p_class'),
                'PrevSchool' => $this->input->post('p_school'),
                'PrevPercentage' => $this->input->post('percent'),
            );

            $data['student'] = $student;
        }
        $this->load->model("AcademicModel");

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['batches'] = $this->AcademicModel->get_batches();
        $reg = $this->StudentModel->get_last_student() + 1;

        $length = strlen($reg);

        if ($length == 1)
            $reg = "100" . $reg;
        elseif ($length == 2)
            $reg = "10" . $reg;
        elseif ($length == 3)
            $reg = "1" . $reg;
        else
            $reg = $reg;

        $data['reg'] = $reg;
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view("student/AddStudent", $data);
    }


    public function edit_student($id = "")
    {

        $this->check_login();
        $data = array();
        if (!is_dir("./uploads/students"))
            mkdir("./uploads/students", 0777, TRUE);


        if (!is_dir("./uploads/parents"))
            mkdir("./uploads/parents", 0777, TRUE);

        $this->load->model('StudentModel');


        $student = $this->StudentModel->get_student_where_id($id);


        $this->load->library('form_validation');

        if ($student) {

            $password = $student[0]['Password'];

            if ($_POST) {


                $rules = array(

                    array(
                        'field' => 'fname',
                        'label' => 'Student First Name',
                        'rules' => 'trim|required|min_length[1]|max_length[25]'
                    )/*,

                    array(
                        'field' => 'mname',
                        'label' => 'Student Middle Name',
                        'rules' => 'trim|alpha'
                    ),

                    array(
                        'field' => 'lname',
                        'label' => 'Student Last Name',
                        'rules' => 'trim|alpha'
                    ),

                    array(
                        'field' => 'p_fname',
                        'label' => 'Parent First Name',
                        'rules' => 'trim|required|min_length[1]|max_length[25]|alpha'
                    ),

                    array(
                        'field' => 'p_mname',
                        'label' => 'Parent Middle Name',
                        'rules' => 'trim|alpha'
                    ),

                    array(
                        'field' => 'p_lname',
                        'label' => 'Parent Last Name',
                        'rules' => 'trim|alpha'
                    ),

                    array(
                        'field' => 'profession',
                        'label' => 'Parent Profession',
                        'rules' => 'trim|required'
                    ),

                    array(
                        'field' => 'qualification',
                        'label' => 'Parent Qualification',
                        'rules' => 'trim|required'
                    ),

                    array(
                        'field' => 'registration',
                        'label' => 'Registration Number',
                        'rules' => 'trim|required|min_length[3]'
                    ),

                    array(
                        'field' => 'roll',
                        'label' => 'Roll Number',
                        'rules' => 'trim|required'
                    ),

                    array(
                        'field' => 'section',
                        'label' => 'Section',
                        'rules' => 'trim|required|numeric'
                    ),
                    array(
                        'field' => 'class',
                        'label' => 'Class',
                        'rules' => 'trim|required|numeric'
                    ),

                    array(
                        'field' => 'gender',
                        'label' => 'Gender',
                        'rules' => 'trim|required'
                    ),

                    array(
                        'field' => 'batch',
                        'label' => 'Batch',
                        'rules' => 'trim|required|numeric'
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
                        'field' => 'address',
                        'label' => 'Address',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'email',
                        'label' => 'Student Email',
                        'rules' => 'trim|valid_email|required'
                    ),


                    array(
                        'field' => 'contact',
                        'label' => 'Student Contact',
                        'rules' => 'trim|numeric|required'
                    )*/
                );

                $this->form_validation->set_rules($rules);
                $this->form_validation->set_error_delimiters('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>');


                $student = array(
                    'FirstName' => $this->input->post('fname'),
                    'LastName' => $this->input->post('lname'),
                    'MiddleName' => $this->input->post('mname'),
                    'Batch' => $this->input->post('batch'),
                    'RegistrationNumber' => $this->input->post('registration'),
                    'Roll' => $this->input->post('roll'),
                    'Address' => $this->input->post('address'),
                    'DOB' => $this->input->post('dob'),
                    'DOJ' => $this->input->post('doj'),
                    'Gender' => $this->input->post('gender'),
                    'Contact' => $this->input->post('contact'),
                    'Email' => $this->input->post('email'),
                    'ClassID' => $this->input->post('class'),
                    'SectionID' => $this->input->post('section'),
                    'PFirstName' => $this->input->post('p_fname'),
                    'PLastName' => $this->input->post('p_lname'),
                    'PMiddleName' => $this->input->post('p_mname'),
                    'PRelation' => $this->input->post('relation'),
                    'PQualification' => $this->input->post('qualification'),
                    'PProfession' => $this->input->post('profession'),
                    'PrevClass' => $this->input->post('p_class'),
                    'PrevSchool' => $this->input->post('p_school'),
                    'PrevPercentage' => $this->input->post('percent'),
                );


                if ($password != $this->input->post('password')) {
                    $this->load->model('LoginModel');
                    $student['Password'] = $this->LoginModel->encrypt($this->input->post('password'));
                }

                $data['student'] = $student;

                if ($this->form_validation->run() == FALSE) {
                } else {


                    $data['id'] = $this->StudentModel->update_student($student, $id);
                    if ((isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name']))) {

                        $config = array(

                            'file_name' => $student['FirstName'] . $data['id'],
                            'upload_path' => './uploads/students/',
                            'allowed_types' => 'png|jpg',
                            'overwrite' => TRUE,
                            'max_size' => '1024000'

                        );

                        $this->load->library('upload');
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('photo')) {

                            $upload_data = $this->upload->data();

                            if ($upload_data) {
                                $this->StudentModel->add_student_photo($data['id'], $config['upload_path'] . $upload_data['file_name']);
                            } else {

                                $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                            }

                        } else {
                            $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                        }
                    }
                    if ((isset($_FILES['p_photo']['name']) && !empty($_FILES['p_photo']['name']))) {


                        $config = array(

                            'file_name' => $student['PFirstName'] . $data['id'],
                            'upload_path' => './uploads/parents/',
                            'allowed_types' => 'png|jpg',
                            'overwrite' => TRUE,
                            'max_size' => '1024000'
                        );

                        $this->load->library('upload', $config);

                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('p_photo')) {

                            $upload_data = $this->upload->data();

                            if ($upload_data) {
                                $this->StudentModel->add_parent_photo($data['id'], $config['upload_path'] . $upload_data['file_name']);
                                $data['full_success'] = True;
                            } else {

                                $data['p_img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                            }

                        } else {

                            $data['p_img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                        }
                    }
                    $docs = $this->upload_documents($student['FirstName'], $data['id']);
                    $data['birth_img_error'] = isset($docs['birth_img_error']) ? $docs['birth_img_error'] : NULL;
                    $data['migration_img_error'] = isset($docs['migration_img_error']) ? $docs['migration_img_error'] : NULL;
                    $data['state_img_error'] = isset($docs['state_img_error']) ? $docs['state_img_error'] : NULL;

                    $data['succeed'] = $docs['succeed'];
                    if ($docs['succeed'] == TRUE) {
                        $data['full_success'] = TRUE;
                    }
                }
            }


            $this->load->model("AcademicModel");


            $this->load->model("TransportModel");
            $data['routes'] = $this->TransportModel->get_routes();
            $data['stops'] = $this->TransportModel->get_stops();
            $data['buses'] = $this->TransportModel->get_buses();

            $data['classes'] = $this->AcademicModel->get_classes();
            $data['batches'] = $this->AcademicModel->get_batches();
            $student = $this->StudentModel->get_student_where_id($id);
            $data['student'] = $student;
            $this->load->model("AdminMessageModel");
            $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
            $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

            $this->load->view("student/EditStudent", $data);
        } else {
            $student = array(

                0 => array(
                    'FirstName' => $this->input->post('fname'),
                    'LastName' => $this->input->post('lname'),
                    'MiddleName' => $this->input->post('mname'),
                    'Batch' => $this->input->post('batch'),
                    'RegistrationNumber' => $this->input->post('registration'),
                    'Roll' => $this->input->post('roll'),
                    'Address' => $this->input->post('p_address'),
                    'DOB' => $this->input->post('dob'),
                    'DOJ' => $this->input->post('doj'),
                    'Gender' => $this->input->post('gender'),
                    'Contact' => $this->input->post('contact'),
                    'Email' => $this->input->post('email'),
                    'ClassID' => $this->input->post('class'),
                    'SectionID' => $this->input->post('section'),
                    'PFirstName' => $this->input->post('p_fname'),
                    'PLastName' => $this->input->post('p_lname'),
                    'PMiddleName' => $this->input->post('p_mname'),
                    'PRelation' => $this->input->post('relation'),
                    'PQualification' => $this->input->post('qualification'),
                    'PProfession' => $this->input->post('profession'),
                    'PrevClass' => $this->input->post('p_class'),
                    'PrevSchool' => $this->input->post('p_school'),
                    'PrevPercentage' => $this->input->post('percent'),
                    'LoginID' => $this->input->post('p_school'),
                    'Password' => $this->input->post('percent'),
                    'Photo' => $this->input->post('p_school'),
                    'PPhoto' => $this->input->post('percent'))
            );

            $data['student'] = $student;

            echo "<script>alert('Invalid Student ID');</script>";
            $this->load->model("AdminMessageModel");
            $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
            $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

            $this->load->view("student/EditStudent", $data);
        }
    }


    function upload_documents($fname, $id)
    {

        $data['succeed'] = TRUE;
        if (!is_dir("./uploads/documents"))
            mkdir("./uploads/documents", 0777, TRUE);
        if ((isset($_FILES['certificate_birth']['name']) && !empty($_FILES['certificate_birth']['name']))) {
            if (!is_dir("./uploads/documents/birth_certificates"))
                mkdir("./uploads/documents/birth_certificates", 0777, TRUE);

            $config = array(

                'file_name' => $fname . $id,
                'upload_path' => './uploads/documents/birth_certificates/',
                'allowed_types' => 'png|jpg',
                'overwrite' => TRUE,
                'max_size' => '1024000'

            );

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('certificate_birth')) {

                $upload_data = $this->upload->data();

                if ($upload_data) {
                    $this->StudentModel->add_birth_document($id, $config['upload_path'] . $upload_data['file_name']);
                    $data['succeed'] = TRUE;
                }
            } else {
                $data['succeed'] = FALSE;
                $this->StudentModel->roll_back();
                $data['birth_img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
            }
        }

        if ((isset($_FILES['certificate_migration']['name']) && !empty($_FILES['certificate_migration']['name']))) {
            if (!is_dir("./uploads/documents/migration_certificates"))
                mkdir("./uploads/documents/migration_certificates", 0777, TRUE);

            $config = array(

                'file_name' => $fname . $id,
                'upload_path' => './uploads/documents/migration_certificates/',
                'allowed_types' => 'png|jpg',
                'overwrite' => TRUE,
                'max_size' => '1024000'
            );

            $this->load->library('upload', $config);

            $this->upload->initialize($config);
            if ($this->upload->do_upload('certificate_migration')) {

                $upload_data = $this->upload->data();

                if ($upload_data) {
                    $this->StudentModel->add_migration_document($id, $config['upload_path'] . $upload_data['file_name']);
                    $data['succeed'] = TRUE;
                }
            } else {
                $data['succeed'] = FALSE;
                $this->StudentModel->roll_back();
                $data['migration_img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
            }
        }
        if ((isset($_FILES['certificate_state']['name']) && !empty($_FILES['certificate_state']['name']))) {
            if (!is_dir("./uploads/documents/state_subject_certificates"))
                mkdir("./uploads/documents/state_subject_certificates", 0777, TRUE);

            $config = array(

                'file_name' => $fname . $id,
                'upload_path' => './uploads/documents/state_subject_certificates/',
                'allowed_types' => 'png|jpg',
                'overwrite' => TRUE,
                'max_size' => '1024000'

            );

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('certificate_state')) {

                $upload_data = $this->upload->data();

                if ($upload_data) {
                    $data['succeed'] = TRUE;
                    $this->StudentModel->add_state_document($id, $config['upload_path'] . $upload_data['file_name']);
                }
            } else {
                $data['succeed'] = FALSE;
                $this->StudentModel->roll_back();
                $data['state_img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
            }
        }

        return $data;
    }


    public
    function student_attendance()
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $this->load->view("student/StudentAttendance", $data);
    }

    public
    function check_attendance()
    {
        $this->check_login();
        $data = array();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model('StudentModel');
        $data['students'] = $this->StudentModel->get_students();

        $this->load->model('AcademicModel');
        $data['classes'] = $this->AcademicModel->get_classes();

        $this->load->view("student/StudentCheckAttendance", $data);
    }

    public function get_student_attendance()
    {
        if ($_POST) {

            $classID = $this->input->post("ClassID");
            $sectionID = $this->input->post("SectionID");
            $day = $this->input->post("day");
            $month = $this->input->post("month");
            $year = $this->input->post("year");
            $type = $this->input->post("type");

            if ($type == "daily") {

                $this->load->model('StudentModel');

                $students = $this->StudentModel->get_student_where($classID, $sectionID);

                $data = array(
                    "Day" => $day,
                    "Month" => $month,
                    "Year" => $year
                );

                if ($students) {

                    echo '<thead>
                               <tr>
                                    <th>Roll Number</th>
                                    <th>Student Name</th>
                                    <th>Status</th>

                                </tr>
                                </thead>';

                    echo '<tbody>';
                    foreach ($students as $s) {

                        $data['StudentID'] = $s['StudentID'];

                        $attendance = $this->StudentModel->get_student_attendance($data);

                        if ($attendance) {

                            foreach ($attendance as $a) {
                                echo "<tr>";
                                echo "<td>" . $s['Roll'] . "</td>";
                                echo "<td>" . $s['FirstName'] . " " . $s['MiddleName'] . " " . $s['LastName'] . "</td>";
                                echo "<td><label>";
                                if ($a['Status'] == "P")
                                    echo "<label class='label label-success'>Present</label>";
                                elseif ($a['Status'] == "A")
                                    echo "<label class='label label-danger'>Absent</label>";
                                echo '</label></td>';
                                echo '</tr>';
                            }

                        } else {
                            echo "";
                        }
                    }
                    echo '</tbody>';
                } else
                    echo "";

            } else {
                $this->load->model('StudentModel');

                $students = $this->StudentModel->get_student_where($classID, $sectionID);

                $data = array(
                    "Month" => $month,
                    "Year" => $year
                );


                if ($students) {
                    echo '<thead>
                               <tr>
                                    <th>Roll Number</th>
                                    <th>Student Name</th>
                                    <th>Days Present</th>
                                    <th>Days Absent</th>
                                </tr>
                                </thead>';

                    echo '<tbody>';
                    foreach ($students as $s) {

                        $data['StudentID'] = $s['StudentID'];

                        $attendance = $this->StudentModel->get_student_attendance($data);

                        $presents = $this->StudentModel->get_attendance_where($data, 'P');
                        $absents = $this->StudentModel->get_attendance_where($data, 'A');

                        if ($attendance) {


                            echo "<tr>";
                            echo "<td>" . $s['Roll'] . "</td>";
                            echo "<td>" . $s['FirstName'] . " " . $s['MiddleName'] . " " . $s['LastName'] . "</td>";
                            echo "<td><h2></h2><label class='label label-success'>$presents</label></td>";
                            echo "<td><label class='label label-danger'>$absents</label></td>";
                            echo '</label></td>';
                            echo '</tr>';

                        } else {
                            echo "";
                        }
                    }
                } else
                    echo "";

            }
        }
    }

    public function student_upgrade()
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $this->load->view("student/StudentUpgrade", $data);
    }


    public
    function upgrade_students()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $sectionID = $this->input->post("SectionID");
            $studentID = $this->input->post("StudentID");
            $this->load->model("StudentModel");

            $data = array(
                "StudentID" => $studentID,
                "ClassID" => $classID,
                "SectionID" => $sectionID
            );
            $result = $this->StudentModel->upgrade_student($data);

            if (isset($result))
                echo "success";

            else
                echo "failure";
        }
    }


    public
    function get_max_marks()
    {
        if ($_POST) {
            $examID = $this->input->post("ExamID");
            $this->load->model("AcademicModel");
            $max = $this->AcademicModel->get_exam_where($examID);

            $marks = $max[0]['MaxMarks'];

            echo json_encode($marks);
        }
    }


    public
    function get_sections()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");
            $sections = $this->AcademicModel->get_section_where_class($classID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }


    public
    function get_url()
    {
        echo json_encode(site_url("StudentController/edit_student/"));
    }


    public
    function get_marks_url()
    {
        echo json_encode(site_url("StudentController/set_marks/"));
    }

    public
    function student_list()
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $this->load->view("student/StudentList", $data);
    }


    public
    function get_controller_url()
    {
        echo json_encode(site_url("StudentController/"));
    }

    public
    function student_result()
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $this->load->view("student/StudentResult", $data);
    }


    public
    function view_student_result()
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $this->load->model("StudentModel");
        $data['students'] = $this->StudentModel->get_students();
        $this->load->view("student/ViewStudentResult", $data);
    }


    public
    function set_marks($classID = 0, $studentID = 0)
    {
        $this->check_login();

        if ($classID != 0 && $studentID != 0) {

            $data = array();
            $this->load->model("AcademicModel");
            $this->load->model("StudentModel");
            $this->load->library("form_validation");

            if ($_POST) {


                $rules = array(

                    array(
                        'field' => 'marks',
                        'label' => 'Marks',
                        'rules' => 'trim|required|numeric|max_length[3]'
                    ),

                    array(
                        'field' => 'subject',
                        'label' => 'Subject',
                        'rules' => 'trim|required|numeric|max_length[3]'
                    ),

                    array(
                        'field' => 'exam',
                        'label' => 'Exam',
                        'rules' => 'trim|required|numeric|max_length[3]'
                    )
                );


                $this->form_validation->set_rules($rules);
                $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                $result = array(

                    'ExamID' => $this->input->post('exam'),
                    'SubjectID' => $this->input->post('subject'),
                    'ClassID' => $classID,
                    'Marks' => $this->input->post('marks'),
                    'StudentID' => $studentID
                );

                if ($this->form_validation->run() == FALSE) {
                } else {

                    $data['success'] = $this->StudentModel->add_result($result);
                    //echo "<script>alert('Class Added Successfully')   </script>";
                }

            }


            $data['subjectIDs'] = $this->AcademicModel->get_allocated_subject_where($classID);
            $data['subjects'] = $this->AcademicModel->get_subjects();
            $data['classes'] = $this->AcademicModel->get_classes();
            $data['exams'] = $this->AcademicModel->get_exams();


            $data['student'] = $this->StudentModel->get_student_where_id($studentID);
            $this->load->model("AdminMessageModel");
            $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
            $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


            $data['classID'] = $classID;
            $data['studentID'] = $studentID;
            $this->load->view("student/SetMarks", $data);
        } else {
            redirect(site_url("StudentController/student_result"));
        }
    }


    public
    function get_students()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $sectionID = $this->input->post("SectionID");
            $column = $this->input->post("Column");
            $this->load->model("StudentModel");
            $sections = $this->StudentModel->get_student_where($classID, $sectionID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }


    public
    function get_student_result()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $studentID = $this->input->post("StudentID");
            $column = $this->input->post("Column");
            $this->load->model("StudentModel");
            $sections = $this->StudentModel->get_student_result($classID, $studentID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public
    function get_subject_name()
    {
        if ($_POST) {
            $subjectID = $this->input->post("SubjectID");
            $this->load->model("AcademicModel");
            $sections = $this->AcademicModel->get_subject_where($subjectID);


            echo json_encode($sections[0]['Name']);
        }
    }


    public
    function get_subjects()
    {
        if ($_POST) {
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");

            $sections = $this->AcademicModel->get_subjects();

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public
    function get_exams()
    {
        if ($_POST) {
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");

            $sections = $this->AcademicModel->get_exams();

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }


    public
    function get_exam_name()
    {
        if ($_POST) {
            $examID = $this->input->post("ExamID");
            $this->load->model("AcademicModel");
            $sections = $this->AcademicModel->get_exam_where($examID);


            echo json_encode($sections[0]['Name']);
        }
    }

    public
    function do_attendance()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $sectionID = $this->input->post("SectionID");
            $studentID = $this->input->post("StudentID");
            $date = $this->input->post("Date");
            $status = $this->input->post("Status");
            $this->load->model("StudentModel");


            $date_format = DateTime::createFromFormat("Y-m-d", $date);

            $day = $date_format->format('d');
            $month = $date_format->format('m');
            $year = $date_format->format('Y');

            $data = array(

                "StudentID" => $studentID,
                "ClassID" => $classID,
                "SectionID" => $sectionID,
                "Date" => $date,
                'Day' => $day,
                "Month" => $month,
                "Year" => $year,
                "Status" => $status
            );
            $result = $this->StudentModel->do_student_attendance($data);

            echo $result;
        }
    }

}
