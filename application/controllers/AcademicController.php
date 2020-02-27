<?php

class AcademicController extends CI_Controller
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


    public function add_class($page = 0)
    {

        $this->check_login();

        $data = array();

        $this->load->model('AcademicModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Class Name',
                    'rules' => 'trim|required|min_length[3]|max_length[25]|is_unique[tbl_classes.name]'
                ),

                array(
                    'field' => 'percent',
                    'label' => 'Attendance Percentage',
                    'rules' => 'trim|required|numeric|min_length[2]|max_length[3]'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $class = array(

                'Name' => $this->input->post('name'),
                'MinAttendance' => $this->input->post('percent'),
            );

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AcademicModel->add_class($class);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $class['Name'] = "";
            $class['MinAttendance'] = "";

        }

        $data['classes'] = $this->AcademicModel->get_classes_pagination($page);

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AcademicController/add_class/";
        $config['total_rows'] = $this->AcademicModel->get_classes_count();;
        $config['per_page'] = 5;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
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

        $this->load->view('academic/AddClass', $data);

    }

    public function edit_class($id = "", $page = 0)
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $data['id'] = $id;

            $this->load->model('AcademicModel');
            $class = $this->AcademicModel->get_class_where($id);

            if ($class) {


                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Class Name',
                            'rules' => 'trim|required|min_length[3]|max_length[25]'
                        ),

                        array(
                            'field' => 'percent',
                            'label' => 'Attendance Percentage',
                            'rules' => 'trim|required|numeric|min_length[2]|max_length[3]'
                        ),
                        array(
                            'field' => 'id',
                            'label' => 'Class ID invalid',
                            'rules' => 'trim|required|numeric'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $class = array(

                        'Name' => $this->input->post('name'),
                        'MinAttendance' => $this->input->post('percent'),
                        'ClassID' => $this->input->post('id')
                    );

                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->AcademicModel->edit_class($class);
                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                } else {
                    $class['Name'] = "";
                    $class['MinAttendance'] = "";

                }
                $class = $this->AcademicModel->get_class_where($id);
                $data['classes'] = $this->AcademicModel->get_classes_pagination($page);
                $data['class'] = $class;


                $this->load->library('pagination');
                $config['base_url'] = base_url() . "AcademicController/edit_class/" . $id . "/";
                $config['total_rows'] = $this->AcademicModel->get_classes_count();;
                $config['per_page'] = 5;

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


                $this->load->view('academic/EditClass', $data);
            } else {
                redirect(site_url("AcademicController/add_class"));
            }
        } else {
            redirect(site_url("AcademicController/add_class"));
        }

    }

    public function delete_class($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_class($id);
            redirect(site_url() . 'AcademicController/add_class');
        } else {
            redirect(site_url() . 'AcademicController/add_class');
        }
    }


    public function add_exam($page = 0)
    {

        $this->check_login();

        $data = array();

        $this->load->model('AcademicModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Exam Name',
                    'rules' => 'trim|required|min_length[3]|max_length[25]|is_unique[tbl_exams.name]'
                ),

                array(
                    'field' => 'marks',
                    'label' => 'Maximum Marks',
                    'rules' => 'trim|required|numeric|min_length[1]|max_length[3]'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $class = array(

                'Name' => $this->input->post('name'),
                'MaxMarks' => $this->input->post('marks'),
            );

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AcademicModel->add_exam($class);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $class['Name'] = "";
            $class['MaxMarks'] = "";

        }

        $data['exams'] = $this->AcademicModel->get_exams($page);

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AcademicController/add_exam/";
        $config['total_rows'] = $this->AcademicModel->get_exams_count();;
        $config['per_page'] = 5;

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

        $this->load->view('academic/AddExam', $data);

    }

    public function edit_exam($id = "", $page = 0)
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $data['id'] = $id;

            $this->load->model('AcademicModel');
            $exam = $this->AcademicModel->get_exam_where($id);

            if ($exam) {


                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Exam Name',
                            'rules' => 'trim|required|min_length[3]|max_length[25]'
                        ),

                        array(
                            'field' => 'marks',
                            'label' => 'Maximum Marks',
                            'rules' => 'trim|required|numeric|min_length[1]|max_length[3]'
                        ),
                        array(
                            'field' => 'id',
                            'label' => 'Exam ID invalid',
                            'rules' => 'trim|required|numeric'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $class = array(

                        'Name' => $this->input->post('name'),
                        'MaxMarks' => $this->input->post('marks'),
                        'ExamID' => $this->input->post('id')
                    );

                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->AcademicModel->edit_exam($class);
                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                } else {
                    $class['Name'] = "";
                    $class['MaxMarks'] = "";

                }

                $exam = $this->AcademicModel->get_exam_where($id);
                $data['exams'] = $this->AcademicModel->get_exams($page);
                $data['exam'] = $exam;
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->library('pagination');
                $config['base_url'] = base_url() . "AcademicController/edit_exam/" . $id . "/";
                $config['total_rows'] = $this->AcademicModel->get_exams_count();;
                $config['per_page'] = 5;

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


                $this->load->view('academic/EditExam', $data);
            } else {
                redirect(site_url("AcademicController/add_exam"));
            }
        } else {
            redirect(site_url("AcademicController/add_exam"));
        }

    }

    public function delete_exam($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_exam($id);
            redirect(site_url() . 'AcademicController/add_exam');
        } else {
            redirect(site_url() . 'AcademicController/add_exam');
        }
    }


    public function add_batch($page = 0)
    {
        $this->check_login();
        $data = array();

        $this->load->model('AcademicModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'year',
                    'label' => 'Batch Year',
                    'rules' => 'trim|required|numeric|exact_length[4]|is_unique[tbl_batches.Year]'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $batch = array(
                'Year' => $this->input->post('year'),
            );

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AcademicModel->add_batch($batch);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $batch['Name'] = "";
            $batch['Year'] = "";

        }

        $data['batches'] = $this->AcademicModel->get_batches($page);
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AcademicController/add_batch/";
        $config['total_rows'] = $this->AcademicModel->get_batches_count();;
        $config['per_page'] = 5;


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

        $this->load->view('academic/AddBatch', $data);

    }

    public function edit_batch($id = "", $page = 0)
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('AcademicModel');
            $data['batch'] = $this->AcademicModel->get_batch_where($id);

            if ($data['batch']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'year',
                            'label' => 'Batch Year',
                            'rules' => 'trim|required|numeric|exact_length[4]'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $batch = array(
                        'Year' => $this->input->post('year'),
                        'BatchID' => $id
                    );

                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->AcademicModel->edit_batch($batch);
                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                } else {
                    $batch['Name'] = "";
                    $batch['Year'] = "";

                }
                $data['batch'] = $this->AcademicModel->get_batch_where($id);
                $data['batches'] = $this->AcademicModel->get_batches($page);

                $this->load->library('pagination');
                $config['base_url'] = base_url() . "AcademicController/edit_batch/" . $id . "/";
                $config['total_rows'] = $this->AcademicModel->get_batches_count();;
                $config['per_page'] = 5;

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


                $this->load->view('academic/EditBatch', $data);
            } else {
                redirect(site_url("AcademicController/add_batch"));
            }
        } else {
            redirect(site_url("AcademicController/add_batch"));
        }

    }

    public function delete_batch($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_batch($id);
            redirect(site_url() . 'AcademicController/add_batch');
        } else {
            redirect(site_url() . 'AcademicController/add_batch');
        }
    }


    public function validate_id($id)
    {
        $this->load->model("StudentModel");
        return $this->StudentModel->validate_student($id);
    }


    public function add_book($page = 0)
    {
        $this->check_login();
        $data = array();

        $this->load->model('AcademicModel');

        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(
                array(
                    'field' => 'id',
                    'label' => 'Book ID',
                    'rules' => 'trim|required|is_unique[tbl_book_details.BookID]'
                ),

                array(
                    'field' => 'name',
                    'label' => 'Book Name',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'dor',
                    'label' => 'Date of Registration',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'category',
                    'label' => 'Book Category',
                    'rules' => 'trim|required'
                )

            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $book = array(
                'BookID' => $this->input->post('id'),
                'Name' => $this->input->post('name'),
                'DOReg' => $this->input->post('dor'),
                'Category' => $this->input->post('category')
            );
            $data['book'] = $book;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AcademicModel->add_book($book);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $book['Name'] = "";
            $book['BookID'] = "";
            $book['DOReg'] = "";
            $data['book'] = $book;
        }
        $data['lastID'] = $this->AcademicModel->get_last_book();
        $data['lastID']++;
        $data['books'] = $this->AcademicModel->get_books($page);
        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AcademicController/add_book/";
        $config['total_rows'] = $this->AcademicModel->get_books_count();;
        $config['per_page'] = 5;

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

        $this->load->view('academic/AddBook', $data);

    }

    public function edit_book($id = "", $page = 0)
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('AcademicModel');
            $data['book'] = $this->AcademicModel->get_book_where($id);

            if ($data['book']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Book Name',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'dor',
                            'label' => 'Date of Registration',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'category',
                            'label' => 'Book Category',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'status',
                            'label' => 'Book Status',
                            'rules' => 'trim|required'
                        )

                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $book = array(
                        'Name' => $this->input->post('name'),
                        'DOReg' => $this->input->post('dor'),
                        'Category' => $this->input->post('category'),
                        'DOIssue' => $this->input->post('doissue'),
                        'DORet' => $this->input->post('doret'),
                        'IssuedTo' => $this->input->post('student'),
                        'Status' => $this->input->post('status')
                    );

                    if ($book['Status'] == 0) {
                        $book['DOIssue'] = "";
                        $book['DORet'] = "";
                        $book['IssuedTo'] = "";
                    }

                    $data['book'] = $book;

                    if ($this->form_validation->run() == FALSE) {
                    } else {
                        $data['success'] = $this->AcademicModel->edit_book($book, $id);
                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                }
                $data['lastID'] = $this->AcademicModel->get_last_book();
                $data['lastID']++;
                $data['books'] = $this->AcademicModel->get_books($page);
                $this->load->library('pagination');
                $config['base_url'] = base_url() . "AcademicController/edit_book/" . $id . "/";
                $config['total_rows'] = $this->AcademicModel->get_books_count();;
                $config['per_page'] = 5;

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

                $this->load->model("StudentModel");
                $data['students'] = $this->StudentModel->get_students();
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;
                $this->load->view('academic/EditBook', $data);
            } else {
                redirect(site_url("AcademicController/add_book"));
            }
        } else {
            redirect(site_url("AcademicController/add_book"));
        }

    }

    public function delete_book($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_book($id);
            redirect(site_url() . 'AcademicController/add_book');
        } else {
            redirect(site_url() . 'AcademicController/add_book');
        }
    }


    public function issue_book()
    {
        $this->check_login();
        $data = array();

        $this->load->model('AcademicModel');

        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(
                array(
                    'field' => 'id',
                    'label' => 'Book ID',
                    'rules' => 'trim|required|callback_validate_book|greater_than[0]'
                ),

                array(
                    'field' => 'doi',
                    'label' => 'Date of Issuance',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'dor',
                    'label' => 'Date of Return',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'student',
                    'label' => 'Student ID',
                    'rules' => 'trim|required|callback_validate_id'
                )
            );


            $this->form_validation->set_message('validate_id', "Student ID is invalid");
            $this->form_validation->set_message('validate_book', "Book already issued");
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $book = array(
                'SerialID' => $this->input->post('id'),
                'DORet' => $this->input->post('dor'),
                'DOIssue' => $this->input->post('doi'),
                'IssuedTo' => $this->input->post('student')
            );

            $data['book'] = $book;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AcademicModel->issue_book($book);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $book['Name'] = "";
            $book['SerialID'] = "";
            $book['DORet'] = "";
            $book['DOIssue'] = "";
            $book['IssuedTo'] = "";
            $data['book'] = $book;
        }

        $data['books'] = $this->AcademicModel->get_books();
        $this->load->model("StudentModel");
        $data['students'] = $this->StudentModel->get_students();


        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;
        $this->load->view('academic/IssueBook', $data);

    }

    public function validate_book($id)
    {
        $this->load->model("AcademicModel");
        return $this->AcademicModel->check_book($id);
    }


    public function add_lecture()
    {

        $this->check_login();

        $data = array();
        $this->load->model('AcademicModel');

        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'title',
                    'label' => 'Assignment Title',
                    'rules' => 'trim|required|min_length[3]|max_length[25]'
                ),

                array(
                    'field' => 'description',
                    'label' => 'Assignment Description',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'class',
                    'label' => 'Class',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'section',
                    'label' => 'Section',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'subject',
                    'label' => 'Subject',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'link',
                    'label' => 'Link',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'dou',
                    'label' => 'Date of Upload',
                    'rules' => 'trim|required'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $lecture = array(
                'Title' => $this->input->post('title'),
                'Description' => $this->input->post('description'),
                'DOU' => $this->input->post('dou'),
                'Link' => $this->input->post('link'),
                'ClassID' => $this->input->post('class'),
                'SectionID' => $this->input->post('section'),
                'SubjectID' => $this->input->post('subject'),
            );

            $data['lecture'] = $lecture;
            if ($this->form_validation->run() == FALSE) {
            } else {
                $valid = $this->isValidYoutubeURL($this->input->post('link'));
                if ($valid)
                    $data['success'] = $this->AcademicModel->add_lecture($lecture);
                else
                    $data['error'] = "Link is not a valid Youtube URL";
            }

        } else {
            $assignment = array(
                'Title' => "",
                'Description' => "",
                'DOU' => "",
                'Link' => "",
                'ClassID' => "",
                'SectionID' => "",
                'SubjectID' => "",
            );
            $data['lecture'] = $assignment;
        }

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $data['lectures'] = $this->AcademicModel->get_lectures();


        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('academic/AddVideoLecture', $data);

    }


    public function edit_lecture($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();


            $this->load->model('AcademicModel');
            $data['lecture'] = $this->AcademicModel->get_lecture_where($id);

            if ($data['lecture']) {

                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'title',
                            'label' => 'Assignment Title',
                            'rules' => 'trim|required|min_length[3]|max_length[25]'
                        ),

                        array(
                            'field' => 'description',
                            'label' => 'Assignment Description',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'class',
                            'label' => 'Class',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'section',
                            'label' => 'Section',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'subject',
                            'label' => 'Subject',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'link',
                            'label' => 'Link',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'dou',
                            'label' => 'Date of Upload',
                            'rules' => 'trim|required'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $lecture = array(
                        'Title' => $this->input->post('title'),
                        'Description' => $this->input->post('description'),
                        'DOU' => $this->input->post('dou'),
                        'Link' => $this->input->post('link'),
                        'ClassID' => $this->input->post('class'),
                        'SectionID' => $this->input->post('section'),
                        'SubjectID' => $this->input->post('subject'),
                    );

                    $data['lecture'] = $lecture;
                    if ($this->form_validation->run() == FALSE) {
                    } else {
                        $valid = $this->isValidYoutubeURL($this->input->post('link'));
                        if ($valid)
                            $data['success'] = $this->AcademicModel->update_lecture($lecture, $id);
                        else
                            $data['error'] = "Link is not a valid Youtube URL";
                    }

                }


                $data['classes'] = $this->AcademicModel->get_classes();
                $data['subjects'] = $this->AcademicModel->get_subjects();
                $data['lectures'] = $this->AcademicModel->get_lectures();

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('academic/EditVideoLecture', $data);
            } else {
                redirect(site_url("AcademicController/add_lecture"));
            }
        } else {
            redirect(site_url("AcademicController/add_lecture"));
        }

    }

    public function delete_lecture($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_lecture($id);
            redirect(site_url() . 'AcademicController/add_lecture');
        } else {
            redirect(site_url() . 'AcademicController/add_lecture');
        }
    }

    function isValidYoutubeURL($url)
    {

        // Let's check the host first
        $parse = parse_url($url);
        $host = $parse['host'];
        if (!in_array($host, array('youtube.com', 'www.youtube.com'))) {
            return false;
        }

        $ch = curl_init();
        $oembedURL = 'www.youtube.com/oembed?url=' . urlencode($url) . '&format=json';
        curl_setopt($ch, CURLOPT_URL, $oembedURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Silent CURL execution
        $output = curl_exec($ch);
        unset($output);

        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] !== 404)
            return true;
        else {
            return false;
        }
    }

    public function add_section($page = 0)
    {
        $this->check_login();
        $data = array();

        $this->load->model('AcademicModel');

        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Section Name',
                    'rules' => 'trim|required|min_length[1]|max_length[25]'
                ),

                array(
                    'field' => 'class',
                    'label' => 'Class',
                    'rules' => 'trim|required'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $section = array(

                'Name' => $this->input->post('name'),
                'ClassID' => $this->input->post('class'),
            );

            if ($this->AcademicModel->check_section($section['ClassID'], $section['Name'])) {
                if ($this->form_validation->run() == FALSE) {
                } else {

                    $data['success'] = $this->AcademicModel->add_section($section);
                    //echo "<script>alert('Class Added Successfully')   </script>";
                }
            } else {
                $data['error'] = "The Section for this Class Already Exists";
            }

        } else {
            $section['Name'] = "";
            $section['Class'] = "";

        }
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['sections'] = $this->AcademicModel->get_sections($page);


        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AcademicController/add_section/";
        $config['total_rows'] = $this->AcademicModel->get_section_count();;
        $config['per_page'] = 5;

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


        $this->load->view('academic/AddSection', $data);

    }

    public function edit_section($id = "", $page = 0)
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('AcademicModel');
            $data['section'] = $this->AcademicModel->get_section_where($id);

            if ($data['section']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Section Name',
                            'rules' => 'trim|required|min_length[1]|max_length[25]'
                        ),

                        array(
                            'field' => 'class',
                            'label' => 'Class',
                            'rules' => 'trim|required'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $section = array(

                        'Name' => $this->input->post('name'),
                        'ClassID' => $this->input->post('class'),
                        'SectionID' => $id
                    );

                    if ($this->AcademicModel->check_section($section['ClassID'], $section['Name'])) {
                        if ($this->form_validation->run() == FALSE) {
                        } else {

                            $data['success'] = $this->AcademicModel->edit_section($section);
                            //echo "<script>alert('Class Added Successfully')   </script>";
                        }
                    } else {
                        $data['error'] = "The Section for this Class Already Exists";
                    }

                } else {
                    $section['Name'] = "";
                    $section['Class'] = "";

                }
                $data['section'] = $this->AcademicModel->get_section_where($id);
                $data['classes'] = $this->AcademicModel->get_classes();
                $data['sections'] = $this->AcademicModel->get_sections($page);
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


                $this->load->library('pagination');
                $config['base_url'] = base_url() . "AcademicController/edit_section/" . $id . "/";
                $config['total_rows'] = $this->AcademicModel->get_section_count();;
                $config['per_page'] = 5;

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


                $this->load->view('academic/EditSection', $data);
            } else {
                redirect(site_url("AcademicController/add_section"));
            }
        } else {
            redirect(site_url("AcademicController/add_section"));
        }
    }

    public function delete_section($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_section($id);
            redirect(site_url() . 'AcademicController/add_section');
        } else {
            redirect(site_url() . 'AcademicController/add_section');
        }
    }

    public function add_circular($page = 0)
    {
        $this->check_login();

        $data = array();

        $this->load->model('AcademicModel');

        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'subject',
                    'label' => 'Circular Subject',
                    'rules' => 'trim|required|min_length[1]|max_length[80]'
                ),

                array(
                    'field' => 'date',
                    'label' => 'Date',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'description',
                    'label' => 'Description',
                    'rules' => 'trim|required|min_length[10]'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $circular = array(

                'Subject' => $this->input->post('subject'),
                'Date' => $this->input->post('date'),
                'Description' => $this->input->post('description')
            );


            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AcademicModel->add_circular($circular);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
        }
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['circulars'] = $this->AcademicModel->get_circulars($page);


        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AcademicController/add_circular/";
        $config['total_rows'] = $this->AcademicModel->get_circular_count();;
        $config['per_page'] = 5;

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


        $this->load->view('academic/AddCircular', $data);

    }

    public function edit_circular($id = "", $page = 0)
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('AcademicModel');
            $data['circular'] = $this->AcademicModel->get_circular_where($id);
            if ($data['circular']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'subject',
                            'label' => 'Circular Subject',
                            'rules' => 'trim|required|min_length[1]|max_length[80]'
                        ),

                        array(
                            'field' => 'date',
                            'label' => 'Date',
                            'rules' => 'trim|required'
                        ),

                        array(
                            'field' => 'description',
                            'label' => 'Description',
                            'rules' => 'trim|required|min_length[10]'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $circular = array(

                        'Subject' => $this->input->post('subject'),
                        'Date' => $this->input->post('date'),
                        'Description' => $this->input->post('description')
                    );


                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->AcademicModel->edit_circular($circular, $id);
                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                } else {
                }
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $data['circulars'] = $this->AcademicModel->get_circulars($page);
                $data['circular'] = $this->AcademicModel->get_circular_where($id);


                $this->load->library('pagination');
                $config['base_url'] = base_url() . "AcademicController/edit_circular/" . $id . "/";
                $config['total_rows'] = $this->AcademicModel->get_circular_count();;
                $config['per_page'] = 5;

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

                $this->load->view('academic/EditCircular', $data);
            } else {
                redirect(site_url("AcademicController/add_circular"));
            }
        } else {
            redirect(site_url("AcademicController/add_circular"));
        }

    }

    public function delete_circular($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_circular($id);
            redirect(site_url() . 'AcademicController/add_circular');
        } else {
            redirect(site_url() . 'AcademicController/add_circular');
        }
    }

    public function allocate_subject()
    {
        $this->check_login();
        $data = array();

        $this->load->model('AcademicModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'class',
                    'label' => 'Class Name',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'subject',
                    'label' => 'Subject',
                    'rules' => 'trim|required|min_length[1]'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $subject = array(
                'ClassID' => $this->input->post('class'),
                'SubjectID' => $this->input->post('subject')
            );

            if ($this->AcademicModel->check_subject($subject['ClassID'], $subject['SubjectID'])) {
                if ($this->form_validation->run() == FALSE) {
                } else {

                    $data['success'] = $this->AcademicModel->allocate_subject($subject);
                    //echo "<script>alert('Class Added Successfully')   </script>";
                }
            } else {
                $data['error'] = "The Subject for this Class Already Exists";
            }

        }
        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['subjectCount'] = $this->AcademicModel->get_allocated_subjects($data['classes']);
        $this->load->view('academic/SubjectAllocation', $data);

    }

    public function edit_allocate_subject($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('AcademicModel');


            $this->load->library('form_validation');
            if ($_POST) {
                $rules = array(

                    array(
                        'field' => 'class',
                        'label' => 'Class Name',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'subject',
                        'label' => 'Subject',
                        'rules' => 'trim|required|min_length[1]'
                    )
                );


                $this->form_validation->set_rules($rules);
                $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                $subject = array(
                    'ClassID' => $this->input->post('class'),
                    'SubjectID' => $this->input->post('subject')
                );

                if ($this->AcademicModel->check_subject($subject['ClassID'], $subject['SubjectID'])) {
                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->AcademicModel->allocate_subject($subject);
                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }
                } else {
                    $data['error'] = "The Subject for this Class Already Exists";
                }

            }
            $data['classes'] = $this->AcademicModel->get_classes();
            $data['subjects'] = $this->AcademicModel->get_subjects();

            $data['subjectCount'] = $this->AcademicModel->get_allocated_subjects($data['classes']);

            $data['subject'] = $this->AcademicModel->get_allocated_subject_where($id);
            $this->load->model("AdminMessageModel");
            $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
            $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

            $this->load->view('academic/EditSubjectAllocation', $data);
        } else {
            redirect(site_url("AcademicController/allocate_subject"));
        }

    }

    public function remove_allocated_subject($classID = "", $subjectID = "")
    {
        $this->check_login();
        $this->load->model("AcademicModel");
        $result = $this->AcademicModel->delete_subject_allocation($classID, $subjectID);
        redirect(site_url("AcademicController/edit_allocate_subject/" . $classID));

    }


    public function allocate_teacher()
    {
        $this->check_login();
        $data = array();

        $this->load->model('AcademicModel');

        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'class',
                    'label' => 'Class',
                    'rules' => 'trim|required|numeric|greater_than[0]'
                ),

                array(
                    'field' => 'section',
                    'label' => 'Section',
                    'rules' => 'trim|required|numeric|greater_than[0]'
                ),
                array(
                    'field' => 'teacher',
                    'label' => 'Teacher',
                    'rules' => 'trim|required|numeric|greater_than[0]'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');


            $class = array(

                'ClassID' => $this->input->post('class'),
                'SectionID' => $this->input->post('section'),
                'TeacherID' => $this->input->post('teacher')
            );

            if ($this->form_validation->run() == FALSE) {
            } else {

                if ($this->AcademicModel->check_teacher_allocation($class)) {

                    $data['success'] = $this->AcademicModel->allocate_teacher($class);
                    //echo "<script>alert('Class Added Successfully')   </script>";
                } else {
                    $data['error'] = "Primary Teacher already Allocated to this Class and Section";
                }
            }

        }

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['sections'] = $this->AcademicModel->get_sections();

        $data['teacher_allocation'] = $this->AcademicModel->get_teacher_allocation();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("HRModel");
        $data['teachers'] = $this->HRModel->get_teachers();
        $this->load->view('academic/TeacherAllocation', $data);

    }

    public function delete_teacher_allocation($classID = "", $sectionID = "", $teacherID = "")
    {
        $this->check_login();
        if ((isset($classID) && is_numeric($classID)) && (isset($sectionID) && is_numeric($sectionID)) &&
            (isset($teacherID) && is_numeric($teacherID))
        ) {
            $this->load->model("AcademicModel");
            $success = $this->AcademicModel->delete_teacher_allocation($classID, $sectionID, $teacherID);
            redirect(site_url("AcademicController/allocate_teacher"));
        } else {
            redirect(site_url("AcademicController/allocate_teacher"));
        }
    }

    public function add_subject($page = 0)
    {
        $this->check_login();
        $data = array();

        $this->load->model('AcademicModel');

        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Subject Name',
                    'rules' => 'trim|required|min_length[1]|max_length[25]|is_unique[tbl_subjects.Name]'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $subject = array(
                'Name' => $this->input->post('name'),
            );

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AcademicModel->add_subject($subject);
                //echo "<script>alert('Subject Added Successfully')   </script>";
            }

        } else {
            $section['Name'] = "";

        }
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['subjects'] = $this->AcademicModel->get_subjects_pagination($page);
        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AcademicController/add_subject/";
        $config['total_rows'] = $this->AcademicModel->get_subjects_count();;
        $config['per_page'] = 5;

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


        $this->load->view('academic/AddSubject', $data);

    }

    public function edit_subject($id = "", $page = 0)
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('AcademicModel');
            $data['subject'] = $this->AcademicModel->get_subject_where($id);

            if ($data['subject']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Subject Name',
                            'rules' => 'trim|required|min_length[1]|max_length[25]|is_unique[tbl_subjects.Name]'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $subject = array(
                        'Name' => $this->input->post('name'),
                        'SubjectID' => $id
                    );

                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->AcademicModel->edit_subject($subject);
                        //echo "<script>alert('Subject Added Successfully')   </script>";
                    }

                }
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $data['subject'] = $this->AcademicModel->get_subject_where($id);
                $data['subjects'] = $this->AcademicModel->get_subjects_pagination($page);

                $this->load->library('pagination');
                $config['base_url'] = base_url() . "AcademicController/edit_subject/" . $id . "/";
                $config['total_rows'] = $this->AcademicModel->get_books_count();;
                $config['per_page'] = 5;

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

                $this->load->view('academic/EditSubject', $data);
            } else {
                redirect(site_url("AcademicController/add_subject"));
            }

        } else {
            redirect(site_url("AcademicController/add_subject"));
        }

    }

    public function delete_subject($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_subject($id);
            redirect(site_url() . 'AcademicController/add_subject');
        } else {
            redirect(site_url() . 'AcademicController/add_subject');
        }
    }

    public function get_sections()
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

    public function add_syllabus()
    {
        $this->check_login();
        $data = array();

        if (!is_dir("./uploads/syllabi"))
            mkdir("./uploads/syllabi", 0777, TRUE);

        $this->load->model('AcademicModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'title',
                    'label' => 'Syllabus Title',
                    'rules' => 'trim|required|min_length[3]|max_length[25]'
                ),


                array(
                    'field' => 'class',
                    'label' => 'Class',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'section',
                    'label' => 'Section',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'subject',
                    'label' => 'Subject',
                    'rules' => 'trim|required|numeric'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $syllabus = array(
                'Title' => $this->input->post('title'),
                'ClassID' => $this->input->post('class'),
                'SectionID' => $this->input->post('section'),
                'SubjectID' => $this->input->post('subject'),
            );

            $data['syllabus'] = $syllabus;
            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AcademicModel->add_syllabus($syllabus);

                if (isset($data['success']) && (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))) {
                    $config = array(

                        'file_name' => $data['success'],
                        'upload_path' => './uploads/syllabi/',
                        'allowed_types' => 'png|jpg|pdf|doc|docx',
                        'overwrite' => TRUE,
                        'max_size' => '1024000',
                        'max_height' => '1024',
                        'max_width' => '768'

                    );

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->AcademicModel->add_syllabus_file($data['success'], $config['upload_path'] . $upload_data['file_name']);
                            $data['success'] = True;
                            $this->AcademicModel->commit();
                        } else {
                            $this->AcademicModel->roll_back();
                            $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                        }

                    } else {
                        $this->AcademicModel->roll_back();
                        $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                    }
                } else {

                    $error = '<p class="alert alert-error"><i class="fa fa-warning"></i> No File Uploaded</p>';

                    $data['img_error'] = array('error' => $error);
                    $this->AcademicModel->roll_back();
                }

                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $syllabus = array(
                'Title' => "",
                'ClassID' => "",
                'SectionID' => "",
                'SubjectID' => "",
            );
            $data['syllabus'] = $syllabus;
        }

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('academic/AddSyllabus', $data);

    }


    public function list_syllabi($page = 0)
    {
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model("AcademicModel");
        $data['syllabi'] = $this->AcademicModel->get_syllabi($page);

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $data['sections'] = $this->AcademicModel->get_sections();

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AcademicController/list_syllabi/";
        $config['total_rows'] = $this->AcademicModel->get_syllabus_count();;
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

        $this->load->view('academic/ListSyllabi', $data);
    }

    public function edit_syllabus($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/syllabi"))
                mkdir("./uploads/syllabi", 0777, TRUE);

            $this->load->model('AcademicModel');
            $data['syllabus'] = $this->AcademicModel->get_syllabus_where($id);

            if ($data['syllabus']) {

                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'title',
                            'label' => 'Assignment Title',
                            'rules' => 'trim|required|min_length[3]|max_length[25]'
                        ),

                        array(
                            'field' => 'class',
                            'label' => 'Class',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'section',
                            'label' => 'Section',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'subject',
                            'label' => 'Subject',
                            'rules' => 'trim|required|numeric'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $syllabus = array(
                        'Title' => $this->input->post('title'),
                        'ClassID' => $this->input->post('class'),
                        'SectionID' => $this->input->post('section'),
                        'SubjectID' => $this->input->post('subject'),
                    );

                    $data['syllabus'] = $syllabus;
                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->AcademicModel->update_syllabus($syllabus, $id);

                        if (isset($data['success']) && (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))) {
                            $config = array(

                                'file_name' => $id,
                                'upload_path' => './uploads/syllabi/',
                                'allowed_types' => 'png|jpg|pdf|doc|docx',
                                'overwrite' => TRUE,
                                'max_size' => '1024000',
                                'max_height' => '1024',
                                'max_width' => '768'

                            );

                            $this->load->library('upload', $config);

                            if ($this->upload->do_upload('file')) {

                                $upload_data = $this->upload->data();

                                if ($upload_data) {
                                    $this->AcademicModel->add_syllabus_file($id, $config['upload_path'] . $upload_data['file_name']);
                                    $data['success'] = True;
                                    $this->AcademicModel->commit();
                                } else {
                                    $this->AcademicModel->roll_back();
                                    $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                                }

                            } else {
                                $this->AcademicModel->roll_back();
                                $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                            }
                        } else {
                            $this->AcademicModel->commit();
                        }

                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                }
                $data['syllabus'] = $this->AcademicModel->get_syllabus_where($id);
                $data['classes'] = $this->AcademicModel->get_classes();
                $data['subjects'] = $this->AcademicModel->get_subjects();

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('academic/EditSyllabus', $data);
            } else {
                redirect("AcademicController/list_syllabi");
            }
        } else {
            redirect("AcademicController/list_syllabi");
        }

    }

    public function delete_syllabus($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_syllabus($id);
            redirect(site_url() . 'AcademicController/list_syllabi');
        } else {
            redirect(site_url() . 'AcademicController/list_syllabi');
        }
    }


    public function add_planner()
    {
        $this->check_login();
        $data = array();

        if (!is_dir("./uploads/planners"))
            mkdir("./uploads/planners", 0777, TRUE);

        $this->load->model('AcademicModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'title',
                    'label' => 'Planner Title',
                    'rules' => 'trim|required|min_length[3]|max_length[25]'
                ),


                array(
                    'field' => 'class',
                    'label' => 'Class',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'section',
                    'label' => 'Section',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'year',
                    'label' => 'Year',
                    'rules' => 'trim|required|numeric'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $planner = array(
                'Title' => $this->input->post('title'),
                'ClassID' => $this->input->post('class'),
                'SectionID' => $this->input->post('section'),
                'Year' => $this->input->post('year'),
            );

            $data['planner'] = $planner;
            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AcademicModel->add_planner($planner);

                if (isset($data['success']) && (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))) {
                    $config = array(

                        'file_name' => $data['success'],
                        'upload_path' => './uploads/planners/',
                        'allowed_types' => 'png|jpg|pdf|doc|docx',
                        'overwrite' => TRUE,
                        'max_size' => '1024000',
                        'max_height' => '1024',
                        'max_width' => '768'

                    );

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->AcademicModel->add_planner_file($data['success'], $config['upload_path'] . $upload_data['file_name']);
                            $data['success'] = True;
                            $this->AcademicModel->commit();
                        } else {
                            $this->AcademicModel->roll_back();
                            $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                        }

                    } else {
                        $this->AcademicModel->roll_back();
                        $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                    }
                } else {

                    $error = '<p class="alert alert-error"><i class="fa fa-warning"></i> No File Uploaded</p>';

                    $data['img_error'] = array('error' => $error);
                    $this->AcademicModel->roll_back();
                }

                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $planner = array(
                'Title' => "",
                'ClassID' => "",
                'SectionID' => "",
                'Year' => "",
            );
            $data['planner'] = $planner;
        }

        $data['classes'] = $this->AcademicModel->get_classes();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('academic/AddPlanner', $data);

    }


    public function list_planners($page = 0)
    {
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model("AcademicModel");
        $data['planners'] = $this->AcademicModel->get_planners($page);

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['sections'] = $this->AcademicModel->get_sections();

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AcademicController/list_planners/";
        $config['total_rows'] = $this->AcademicModel->get_planner_count();;
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

        $this->load->view('academic/ListPlanners', $data);
    }

    public function edit_planner($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/planners"))
                mkdir("./uploads/planners", 0777, TRUE);

            $this->load->model('AcademicModel');
            $data['planner'] = $this->AcademicModel->get_planner_where($id);

            if ($data['planner']) {

                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'title',
                            'label' => 'Assignment Title',
                            'rules' => 'trim|required|min_length[3]|max_length[25]'
                        ),

                        array(
                            'field' => 'class',
                            'label' => 'Class',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'section',
                            'label' => 'Section',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'year',
                            'label' => 'Year',
                            'rules' => 'trim|required|numeric'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $planner = array(
                        'Title' => $this->input->post('title'),
                        'ClassID' => $this->input->post('class'),
                        'SectionID' => $this->input->post('section'),
                        'Year' => $this->input->post('year'),
                    );

                    $data['planner'] = $planner;
                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->AcademicModel->update_planner($planner, $id);

                        if (isset($data['success']) && (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))) {
                            $config = array(

                                'file_name' => $id,
                                'upload_path' => './uploads/planners/',
                                'allowed_types' => 'png|jpg|pdf|doc|docx',
                                'overwrite' => TRUE,
                                'max_size' => '1024000',
                                'max_height' => '1024',
                                'max_width' => '768'

                            );

                            $this->load->library('upload', $config);

                            if ($this->upload->do_upload('file')) {

                                $upload_data = $this->upload->data();

                                if ($upload_data) {
                                    $this->AcademicModel->add_planner_file($id, $config['upload_path'] . $upload_data['file_name']);
                                    $data['success'] = True;
                                    $this->AcademicModel->commit();
                                } else {
                                    $this->AcademicModel->roll_back();
                                    $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                                }

                            } else {
                                $this->AcademicModel->roll_back();
                                $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                            }
                        } else {
                            $this->AcademicModel->commit();
                        }

                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                }
                $data['planner'] = $this->AcademicModel->get_planner_where($id);
                $data['classes'] = $this->AcademicModel->get_classes();

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('academic/EditPlanner', $data);
            } else {
                redirect("AcademicController/list_planners");
            }
        } else {
            redirect("AcademicController/list_planners");
        }

    }

    public function delete_planner($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_planner($id);
            redirect(site_url() . 'AcademicController/list_planners');
        } else {
            redirect(site_url() . 'AcademicController/list_planners');
        }
    }


    public function add_assignment()
    {
        $this->check_login();
        $data = array();

        if (!is_dir("./uploads/assignments"))
            mkdir("./uploads/assignments", 0777, TRUE);

        $this->load->model('AcademicModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'title',
                    'label' => 'Assignment Title',
                    'rules' => 'trim|required|min_length[3]|max_length[25]'
                ),

                array(
                    'field' => 'description',
                    'label' => 'Assignment Description',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'class',
                    'label' => 'Class',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'section',
                    'label' => 'Section',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'subject',
                    'label' => 'Subject',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'dos',
                    'label' => 'Date of Submission',
                    'rules' => 'trim|required'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $assignment = array(
                'Title' => $this->input->post('title'),
                'Description' => $this->input->post('description'),
                'DOS' => $this->input->post('dos'),
                'ClassID' => $this->input->post('class'),
                'SectionID' => $this->input->post('section'),
                'SubjectID' => $this->input->post('subject'),
            );

            $data['assignment'] = $assignment;
            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AcademicModel->add_assignment($assignment);

                if (isset($data['success']) && (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))) {
                    $config = array(

                        'file_name' => $data['success'],
                        'upload_path' => './uploads/assignments/',
                        'allowed_types' => 'png|jpg|pdf|doc|docx',
                        'overwrite' => TRUE,
                        'max_size' => '1024000',
                        'max_height' => '1024',
                        'max_width' => '768'

                    );

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->AcademicModel->add_assignment_file($data['success'], $config['upload_path'] . $upload_data['file_name']);
                            $data['success'] = True;
                            $this->AcademicModel->commit();
                        } else {
                            $this->AcademicModel->roll_back();
                            $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                        }

                    } else {
                        $this->AcademicModel->roll_back();
                        $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                    }
                } else {
                    $this->AcademicModel->commit();
                }

                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $assignment = array(
                'Title' => "",
                'Description' => "",
                'DOS' => "",
                'ClassID' => "",
                'SectionID' => "",
                'SubjectID' => "",
            );
            $data['assignment'] = $assignment;
        }

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('academic/AddAssignment', $data);

    }


    public function list_assignments($page = 0)
    {
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model("AcademicModel");
        $data['assignments'] = $this->AcademicModel->get_assignments($page);

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $data['sections'] = $this->AcademicModel->get_sections();

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AcademicController/list_assignments/";
        $config['total_rows'] = $this->AcademicModel->get_assignment_count();;
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

        $this->load->view('academic/ListAssignments', $data);
    }

    public function edit_assignment($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/assignments"))
                mkdir("./uploads/assignments", 0777, TRUE);

            $this->load->model('AcademicModel');
            $data['datesheet'] = $this->AcademicModel->get_assignment_where($id);

            if ($data['assignment']) {

                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'title',
                            'label' => 'Assignment Title',
                            'rules' => 'trim|required|min_length[3]|max_length[25]'
                        ),

                        array(
                            'field' => 'description',
                            'label' => 'Assignment Description',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'class',
                            'label' => 'Class',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'section',
                            'label' => 'Section',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'subject',
                            'label' => 'Subject',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'dos',
                            'label' => 'Date of Submission',
                            'rules' => 'trim|required'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $assignment = array(
                        'Title' => $this->input->post('title'),
                        'Description' => $this->input->post('description'),
                        'DOS' => $this->input->post('dos'),
                        'ClassID' => $this->input->post('class'),
                        'SectionID' => $this->input->post('section'),
                        'SubjectID' => $this->input->post('subject'),
                    );

                    $data['assignment'] = $assignment;
                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->AcademicModel->update_assignment($assignment, $id);

                        if (isset($data['success']) && (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))) {
                            $config = array(

                                'file_name' => $id,
                                'upload_path' => './uploads/assignments/',
                                'allowed_types' => 'png|jpg|pdf|doc|docx',
                                'overwrite' => TRUE,
                                'max_size' => '1024000',
                                'max_height' => '1024',
                                'max_width' => '768'

                            );

                            $this->load->library('upload', $config);

                            if ($this->upload->do_upload('file')) {

                                $upload_data = $this->upload->data();

                                if ($upload_data) {
                                    $this->AcademicModel->add_assignment_file($id, $config['upload_path'] . $upload_data['file_name']);
                                    $data['success'] = True;
                                    $this->AcademicModel->commit();
                                } else {
                                    $this->AcademicModel->roll_back();
                                    $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                                }

                            } else {
                                $this->AcademicModel->roll_back();
                                $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                            }
                        } else {
                            $this->AcademicModel->commit();
                        }

                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                }
                $data['assignment'] = $this->AcademicModel->get_assignment_where($id);
                $data['classes'] = $this->AcademicModel->get_classes();
                $data['subjects'] = $this->AcademicModel->get_subjects();

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('academic/EditAssignment', $data);
            } else {
                redirect("AcademicController/list_assignments");
            }
        } else {
            redirect("AcademicController/list_assignments");
        }

    }

    public function delete_assignment($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_assignment($id);
            redirect(site_url() . 'AcademicController/list_assignments');
        } else {
            redirect(site_url() . 'AcademicController/list_assignments');
        }
    }


    public function set_timetable()
    {
        $this->check_login();
        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();

        $this->load->model("HRModel");
        $data['teachers'] = $this->HRModel->get_teachers();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view("academic/SetTimeTable", $data);
    }


    public function add_datesheet()
    {
        $this->check_login();
        $data = array();

        if (!is_dir("./uploads/datesheets"))
            mkdir("./uploads/datesheets", 0777, TRUE);

        $this->load->model('AcademicModel');
        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'title',
                    'label' => 'Date Sheet Title',
                    'rules' => 'trim|required|min_length[3]|max_length[25]'
                ),

                array(
                    'field' => 'description',
                    'label' => 'Date Sheet Description',
                    'rules' => 'trim'
                ),
                array(
                    'field' => 'class',
                    'label' => 'Class',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'doe',
                    'label' => 'Date of Exam',
                    'rules' => 'trim|required'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $datesheet = array(
                'Title' => $this->input->post('title'),
                'DOE' => $this->input->post('doe'),
                'Description' => $this->input->post('description'),
                'ClassID' => $this->input->post('class')
            );

            $data['datesheet'] = $datesheet;
            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AcademicModel->add_datesheet($datesheet);

                if (isset($data['success']) && (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))) {
                    $config = array(

                        'file_name' => $data['success'],
                        'upload_path' => './uploads/datesheets/',
                        'allowed_types' => 'png|jpg|pdf|doc|docx',
                        'overwrite' => TRUE,
                        'max_size' => '1024000',
                        'max_height' => '1024',
                        'max_width' => '768'

                    );

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->AcademicModel->add_datesheet_file($data['success'], $config['upload_path'] . $upload_data['file_name']);
                            $data['success'] = True;
                            $this->AcademicModel->commit();
                        } else {
                            $this->AcademicModel->roll_back();
                            $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                        }

                    } else {
                        $this->AcademicModel->roll_back();
                        $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                    }
                } else {
                    $this->AcademicModel->commit();
                }

                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $datesheet = array(
                'Title' => "",
                'Description' => "",
                'DOE' => "",
                'ClassID' => ""
            );
            $data['datesheet'] = $datesheet;
        }

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('academic/AddDatesheet', $data);

    }

    public function list_datesheets($page = 0)
    {

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model("AcademicModel");
        $data['datesheets'] = $this->AcademicModel->get_datesheets($page);

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['sections'] = $this->AcademicModel->get_sections();

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AcademicController/list_datesheets/";
        $config['total_rows'] = $this->AcademicModel->get_datesheet_count();;
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

        $this->load->view('academic/ListDatesheets', $data);
    }

    public function edit_datesheet($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/datesheets"))
                mkdir("./uploads/datesheets", 0777, TRUE);

            $this->load->model('AcademicModel');
            $data['datesheet'] = $this->AcademicModel->get_datesheet_where($id);

            if ($data['datesheet']) {

                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'title',
                            'label' => 'Date Sheet Title',
                            'rules' => 'trim|required|min_length[3]|max_length[100]'
                        ),

                        array(
                            'field' => 'description',
                            'label' => 'Date Sheet Description',
                            'rules' => 'trim'
                        ),
                        array(
                            'field' => 'class',
                            'label' => 'Class',
                            'rules' => 'trim|required|numeric'
                        ),
                        array(
                            'field' => 'doe',
                            'label' => 'Date of Exam',
                            'rules' => 'trim|required'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $datesheet = array(
                        'Title' => $this->input->post('title'),
                        'Description' => $this->input->post('description'),
                        'DOE' => $this->input->post('doe'),
                        'ClassID' => $this->input->post('class')
                    );

                    $data['datesheet'] = $datesheet;
                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->AcademicModel->update_datesheet($datesheet, $id);

                        if (isset($data['success']) && (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))) {
                            $config = array(

                                'file_name' => $id,
                                'upload_path' => './uploads/datesheets/',
                                'allowed_types' => 'png|jpg|pdf|doc|docx',
                                'overwrite' => TRUE,
                                'max_size' => '1024000',
                                'max_height' => '1024',
                                'max_width' => '768'

                            );

                            $this->load->library('upload', $config);

                            if ($this->upload->do_upload('file')) {

                                $upload_data = $this->upload->data();

                                if ($upload_data) {
                                    $this->AcademicModel->add_datesheet_file($id, $config['upload_path'] . $upload_data['file_name']);
                                    $data['success'] = True;
                                    $this->AcademicModel->commit();
                                } else {
                                    $this->AcademicModel->roll_back();
                                    $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                                }

                            } else {
                                $this->AcademicModel->roll_back();
                                $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>'));
                            }
                        } else {
                            $this->AcademicModel->commit();
                        }

                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                }
                $data['datesheet'] = $this->AcademicModel->get_datesheet_where($id);
                $data['classes'] = $this->AcademicModel->get_classes();
                $data['subjects'] = $this->AcademicModel->get_subjects();

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('academic/EditDatesheet', $data);
            } else {
                redirect("AcademicController/list_datesheets");
            }
        } else {
            redirect("AcademicController/list_datesheets");
        }

    }

    public function delete_datesheet($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AcademicModel');


            $data['id'] = $id;

            $data['delete'] = $this->AcademicModel->delete_datesheet($id);
            redirect(site_url() . 'AcademicController/list_datesheets');
        } else {
            redirect(site_url() . 'AcademicController/list_datesheets');
        }
    }

    public function add_period()
    {
        if ($_POST) {

            $data = array(
                "ClassID" => $this->input->post("ClassID"),
                "SectionID" => $this->input->post("SectionID"),
                "SubjectID" => $this->input->post("SubjectID"),
                "TeacherID" => $this->input->post("TeacherID"),
                "StartTime" => $this->input->post("StartTime"),
                "EndTime" => $this->input->post("EndTime"),
                "Day" => $this->input->post("Day")
            );


            $this->load->model("AcademicModel");
            $result = $this->AcademicModel->add_period($data);

            echo json_encode($result);
        }
    }


    public function get_periods()
    {
        if ($_POST) {

            $data = array(
                "ClassID" => $this->input->post("ClassID"),
                "SectionID" => $this->input->post("SectionID"),
                "Day" => $this->input->post("Day"),

            );

            $column = $this->input->post("Column");

            $this->load->model("AcademicModel");
            $result = $this->AcademicModel->get_periods($data);

            $data = array();
            foreach ($result as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function get_subject()
    {
        if ($_POST) {
            $subjectID = $this->input->post("SubjectID");
            $this->load->model("AcademicModel");
            $name = $this->AcademicModel->get_subject_where($subjectID);

            if (isset($name[0]['Name']))
                echo json_encode($name[0]['Name']);
            else
                echo json_encode("Error");
        }
    }

    public function get_teacher()
    {
        if ($_POST) {
            $teacherID = $this->input->post("EmployeeID");
            $this->load->model("HRModel");
            $name = $this->HRModel->get_employee_where_id($teacherID);

            if (isset($name[0]['FirstName']))
                echo json_encode($name[0]['FirstName'] . " " . $name[0]['MiddleName'] . " " . $name[0]['LastName']);
            else
                echo json_encode("Error");
        }
    }


    public function view_datesheet()
    {
        $this->check_login();

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('academic/ViewDatesheet', $data);
    }

    public function get_date_sheet()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $date = $this->input->post("Date");
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");

            $result = $this->AcademicModel->get_date_sheet($classID, $date);

            $data = array();
            foreach ($result as $s)
                $data[] = $s[$column];


            echo json_encode($data);

        }
    }

    public function get_subject_name()
    {
        if ($_POST) {
            $subjectID = $this->input->post("SubjectID");
            $this->load->model("AcademicModel");
            $sections = $this->AcademicModel->get_subject_where($subjectID);


            echo json_encode($sections[0]['Name']);
        }
    }


}
