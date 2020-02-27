<?php

class TeacherController extends CI_Controller
{

    public function index()
    {
        redirect(site_url() . 'TeacherDashboard/');
    }

    public function check_login()
    {
        if ($this->session->has_userdata('teacher_username') && $this->session->has_userdata('teacher_login_time')) {
        } else {
            redirect(site_url("TeacherLogin/"));
        }
    }


    public function get_max_marks()
    {
        if ($_POST) {
            $examID = $this->input->post("ExamID");
            $this->load->model("AcademicModel");
            $max = $this->AcademicModel->get_exam_where($examID);

            $marks = $max[0]['MaxMarks'];

            echo json_encode($marks);
        }
    }


    public function add_news()
    {
        $this->check_login();
        $data = array();

        if (!is_dir("./uploads/news"))
            mkdir("./uploads/news", 0777, TRUE);


        $this->load->model('NewsModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'title',
                    'label' => 'News Title',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'news_by',
                    'label' => 'News By',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'date',
                    'label' => 'News Date',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'details',
                    'label' => 'Details',
                    'rules' => 'trim|required'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $news = array(
                'Title' => $this->input->post('title'),
                'NewsBy' => $this->input->post('news_by'),
                'Date' => $this->input->post('date'),
                'Details' => $this->input->post('details')

            );
            $data['news'] = $news;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->NewsModel->add_news($news);

                if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {

                    $config = array(

                        'file_name' => "news_" . $data['success'],
                        'upload_path' => './uploads/news/',
                        'allowed_types' => 'png|jpg',
                        'overwrite' => TRUE,
                        'max_size' => '1024000',
                        'max_height' => '1024',
                        'max_width' => '768'

                    );

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('photo')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->NewsModel->add_news_photo($data['success'], $config['upload_path'] . $upload_data['file_name']);
                            $data['success'] = True;
                        } else {
                            $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                        }

                    } else {
                        $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                    }
                }
            }

        } else {
            $news = array(
                'Title' => "",
                'NewsBy' => "",
                'Date' => "",
                'Details' => ""
            );
            $data['news'] = $news;
        }

        $data['newses'] = $this->NewsModel->get_news();
        $this->load->model("TeacherMessageModel");
        $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('news/TeacherAddNews', $data);

    }

    public function edit_news($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/news"))
                mkdir("./uploads/news", 0777, TRUE);


            $this->load->model('NewsModel');

            $data['news'] = $this->NewsModel->get_news_where($id);;

            if ($data['news']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'title',
                            'label' => 'News Title',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'news_by',
                            'label' => 'News By',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'date',
                            'label' => 'News Date',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'details',
                            'label' => 'Details',
                            'rules' => 'trim|required'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');


                    $news = array(
                        'Title' => $this->input->post('title'),
                        'NewsBy' => $this->input->post('news_by'),
                        'Date' => $this->input->post('date'),
                        'Details' => $this->input->post('details')

                    );
                    $data['news'] = $news;

                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->NewsModel->update_news($news, $id);

                        if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {

                            $config = array(

                                'file_name' => "news_" . $id,
                                'upload_path' => './uploads/news/',
                                'allowed_types' => 'png|jpg',
                                'overwrite' => TRUE,
                                'max_size' => '1024000',
                                'max_height' => '1024',
                                'max_width' => '768'

                            );

                            $this->load->library('upload', $config);
                            if ($this->upload->do_upload('photo')) {

                                $upload_data = $this->upload->data();

                                if ($upload_data) {
                                    $this->NewsModel->add_news_photo($id, $config['upload_path'] . $upload_data['file_name']);
                                    $data['success'] = True;
                                } else {
                                    $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                                }

                            } else {
                                $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                            }
                        }
                    }

                }

                $data['newses'] = $this->NewsModel->get_news();

                $this->load->model("TeacherMessageModel");
                $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('news/TeacherEditNews', $data);
            } else {
                redirect(site_url("TeacherController/add_news"));
            }

        } else {
            redirect(site_url("TeacherController/add_news"));
        }
    }


    public function view_news($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/news"))
                mkdir("./uploads/news", 0777, TRUE);


            $this->load->model('NewsModel');

            $data['news'] = $this->NewsModel->get_news_where($id);;

            if ($data['news']) {
                $this->load->library('form_validation');


                $this->load->model("TeacherMessageModel");
                $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('news/TeacherViewNews', $data);
            } else {
                redirect(site_url("TeacherDashboard/"));
            }

        } else {
            redirect(site_url("DashboardController/"));
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
                        'allowed_types' => 'png|jpg|pdf',
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
                            $data['img_error'] = array('error' => $this->upload->display_errors());
                        }

                    } else {
                        $this->AcademicModel->roll_back();
                        $data['img_error'] = array('error' => $this->upload->display_errors());
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

        $this->load->model("TeacherMessageModel");
        $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('academic/TeacherAddAssignment', $data);

    }


    public function edit_assignment($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/assignments"))
                mkdir("./uploads/assignments", 0777, TRUE);

            $this->load->model('AcademicModel');
            $data['assignment'] = $this->AcademicModel->get_assignment_where($id);

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
                                'allowed_types' => 'png|jpg|pdf',
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
                                    $data['img_error'] = array('error' => $this->upload->display_errors());
                                }

                            } else {
                                $this->AcademicModel->roll_back();
                                $data['img_error'] = array('error' => $this->upload->display_errors());
                            }
                        } else {
                            $this->AcademicModel->commit();
                        }

                        //echo "<script>alert('Class Added Successfully')   </script>";
                    }

                }

                $data['classes'] = $this->AcademicModel->get_classes();
                $data['subjects'] = $this->AcademicModel->get_subjects();
                $this->load->model("TeacherMessageModel");
                $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


                $this->load->view('academic/EditAssignment', $data);
            } else {
                redirect("TeacherController/add_assignment");
            }
        } else {
            redirect("TeacherController/add_assignment");
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
            redirect(site_url() . 'TeacherController/add_assignment');
        } else {
            redirect(site_url() . 'TeacherController/add_assignment');
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

    public function student_attendance()
    {
        $this->check_login();
        $this->load->model("TeacherMessageModel");
        $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $this->load->view("student/TeacherStudentAttendance", $data);
    }

    public function student_list()
    {
        $this->check_login();

        $this->load->model("TeacherMessageModel");
        $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $this->load->view("student/StudentList", $data);
    }


    public function student_result()
    {
        $this->check_login();
        $this->load->model("TeacherMessageModel");
        $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $this->load->view("student/TeacherStudentResult", $data);
    }

    public function set_marks($classID = 0, $studentID = 0)
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

            $this->load->model("TeacherMessageModel");
            $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
            $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

            $data['classID'] = $classID;
            $data['studentID'] = $studentID;
            $this->load->view("student/TeacherSetMarks", $data);
        } else {
            redirect(site_url("StudentController/student_result"));
        }
    }


    public function get_students()
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


    public function get_marks_url()
    {
        echo json_encode(site_url("TeacherController/set_marks/"));
    }


    public function view_student_result()
    {
        $this->check_login();
        $this->load->model("TeacherMessageModel");
        $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $this->load->model("StudentModel");
        $data['students'] = $this->StudentModel->get_students();
        $this->load->view("student/TeacherViewStudentResult", $data);
    }

    public function get_student_result()
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

    public function get_subject_name()
    {
        if ($_POST) {
            $subjectID = $this->input->post("SubjectID");
            $this->load->model("AcademicModel");
            $sections = $this->AcademicModel->get_subject_where($subjectID);


            echo json_encode($sections[0]['Name']);
        }
    }

    public function get_exam_name()
    {
        if ($_POST) {
            $examID = $this->input->post("ExamID");
            $this->load->model("AcademicModel");
            $sections = $this->AcademicModel->get_exam_where($examID);


            echo json_encode($sections[0]['Name']);
        }
    }

    public function news_list()
    {
        $this->check_login();
        $this->load->model("TeacherMessageModel");
        $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("NewsModel");
        $data['newses'] = $this->NewsModel->get_news();
        $this->load->view('news/TeacherNewsList', $data);
    }

    public function view_datesheet()
    {
        $this->check_login();

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();

        $this->load->model("TeacherMessageModel");
        $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('academic/TeacherViewDatesheet', $data);
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

    public function get_timetable()
    {
        $this->check_login();
        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();
        $data['sections'] = $this->AcademicModel->get_sections();
        $this->load->model("HRModel");
        $data['teachers'] = $this->HRModel->get_teachers();
        $this->load->model("TeacherMessageModel");
        $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view("academic/TeacherGetTimeTable", $data);
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

    public function check_attendance()
    {
        $this->check_login();
        $data = array();
        $this->load->model("TeacherMessageModel");
        $data['unread_messages'] = $this->TeacherMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->model('StudentModel');
        $data['students'] = $this->StudentModel->get_students();

        $this->load->model('AcademicModel');
        $data['classes'] = $this->AcademicModel->get_classes();
        $this->load->view("student/TeacherCheckAttendance", $data);
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

    public function do_attendance()
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
