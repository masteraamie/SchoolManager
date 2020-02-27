<?php

class FrontendController extends CI_Controller
{

    public function index()
    {
        $data = array();

        $this->load->model("EventModel");
        $data['events'] = $this->EventModel->get_events(0, 4);


        $this->load->model("NewsModel");
        $data['news'] = $this->NewsModel->get_news(0, 4);


        $this->load->model("AchievementModel");
        $data['achievements'] = $this->AchievementModel->get_achievements(0, 4);


        $this->load->model("VisitModel");
        $data['visits'] = $this->VisitModel->get_visits(0, 4);


        $this->load->model("SettingsModel");
        $data['images'] = $this->SettingsModel->get_images();

        $data['principal'] = $this->SettingsModel->get_principal();

        $data['vprincipal'] = $this->SettingsModel->get_vice_principal();


        $data['director'] = $this->SettingsModel->get_director();

        $this->load->model("AcademicModel");
        $data['classes'] = $this->AcademicModel->get_classes();

        $this->load->view("frontend/index", $data);
    }

    public function check_login()
    {
        if ($this->session->has_userdata('std_username')) {
        } else {
            redirect(site_url("StudentLogin/"));
        }
    }


    public function achievements($page = 0)
    {

        $data = array();

        $this->load->model("AchievementModel");
        $data['achievements'] = $this->AchievementModel->get_achievements($page);


        $this->load->library('pagination');
        $config['base_url'] = base_url() . "FrontendController/achievements/";
        $config['total_rows'] = $this->AchievementModel->get_achievement_count();;
        $config['per_page'] = 6;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $data['pages'] = $this->pagination->create_links();

        $this->load->view("frontend/achievements", $data);
    }

    public function events($page = 0)
    {
        $data = array();

        $this->load->model("EventModel");
        $data['achievements'] = $this->EventModel->get_events_pagination($page);


        $this->load->library('pagination');
        $config['base_url'] = base_url() . "FrontendController/events/";
        $config['total_rows'] = $this->EventModel->get_event_count($page);;
        $config['per_page'] = 6;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $data['pages'] = $this->pagination->create_links();

        $this->load->view("frontend/events", $data);
    }


    public function assignments($page = 0)
    {

        $data = array();

        $this->load->model("AcademicModel");
        $data['assignments'] = $this->AcademicModel->get_assignments($page);

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $data['sections'] = $this->AcademicModel->get_sections();

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "FrontendController/assignments/";
        $config['total_rows'] = $this->AcademicModel->get_assignment_count();;
        $config['per_page'] = 6;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $data['pages'] = $this->pagination->create_links();

        $this->load->view("frontend/assignments", $data);
    }


    public function syllabi($page = 0)
    {

        $data = array();

        $this->load->model("AcademicModel");
        $data['syllabi'] = $this->AcademicModel->get_syllabi($page);

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['subjects'] = $this->AcademicModel->get_subjects();
        $data['sections'] = $this->AcademicModel->get_sections();

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "FrontendController/syllabi/";
        $config['total_rows'] = $this->AcademicModel->get_syllabus_count();;
        $config['per_page'] = 6;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $data['pages'] = $this->pagination->create_links();

        $this->load->view("frontend/syllabi", $data);
    }

    public function datesheets($page = 0)
    {

        $data = array();

        $this->load->model("AcademicModel");
        $data['datesheets'] = $this->AcademicModel->get_datesheets($page);

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['sections'] = $this->AcademicModel->get_sections();

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "FrontendController/datesheets/";
        $config['total_rows'] = $this->AcademicModel->get_datesheet_count();;
        $config['per_page'] = 6;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $data['pages'] = $this->pagination->create_links();

        $this->load->view("frontend/datesheets", $data);
    }

    public function news($page = 0)
    {

        $data = array();

        $this->load->model("NewsModel");
        $data['news'] = $this->NewsModel->get_news($page);


        $this->load->library('pagination');
        $config['base_url'] = base_url() . "FrontendController/news/";
        $config['total_rows'] = $this->NewsModel->get_news_count();;
        $config['per_page'] = 6;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $data['pages'] = $this->pagination->create_links();

        $this->load->view("frontend/news", $data);
    }

    public function visits($page = 0)
    {

        $data = array();

        $this->load->model("VisitModel");
        $data['visits'] = $this->VisitModel->get_visits($page);


        $this->load->library('pagination');
        $config['base_url'] = base_url() . "FrontendController/visits/";
        $config['total_rows'] = $this->VisitModel->get_visit_count();;
        $config['per_page'] = 6;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $data['pages'] = $this->pagination->create_links();

        $this->load->view("frontend/visits", $data);
    }


    public function planners($page = 0)
    {

        $data = array();

        $this->load->model("AcademicModel");
        $data['planners'] = $this->AcademicModel->get_planners($page);

        $data['classes'] = $this->AcademicModel->get_classes();
        $data['sections'] = $this->AcademicModel->get_sections();


        $this->load->library('pagination');
        $config['base_url'] = base_url() . "FrontendController/visits/";
        $config['total_rows'] = $this->AcademicModel->get_planner_count();;
        $config['per_page'] = 6;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<nav aria-label="..."><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $data['pages'] = $this->pagination->create_links();

        $this->load->view("frontend/planners", $data);
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

    public function get_url()
    {
        if ($_POST) {

            $type = $this->input->post("Type");

            if ($type == 1)
                echo json_encode(base_url("DownloadFiles/download_assignment/"));
            elseif ($type == 2)
                echo json_encode(base_url("DownloadFiles/download_datesheet/"));
            elseif ($type == 3)
                echo json_encode(base_url("DownloadFiles/download_syllabus/"));
            elseif ($type == 4)
                echo json_encode(base_url("DownloadFiles/download_planner/"));
            elseif ($type == 5)
                echo base_url("DownloadFiles/download_assignment");
            else
                echo base_url("DownloadFiles/download_assignment");
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

    public function get_assignments()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $sectionID = $this->input->post("SectionID");
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");

            $sections = $this->AcademicModel->get_assignment_where_class($classID, $sectionID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function get_syllabi()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $sectionID = $this->input->post("SectionID");
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");

            $sections = $this->AcademicModel->get_syllabus_where_class($classID, $sectionID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function get_datesheets()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");

            $sections = $this->AcademicModel->get_datesheet_where_class($classID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }

    public function get_planners()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $sectionID = $this->input->post("SectionID");
            $column = $this->input->post("Column");
            $this->load->model("AcademicModel");

            $sections = $this->AcademicModel->get_planner_where_class($classID, $sectionID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }



    /*public function school_song()
    {
        $this->load->view("frontend/school_song");
    }*/

    public function about_school()
    {
        $this->load->view("frontend/about_school");
    }

    public function contact()
    {
        $this->load->library('form_validation');
        if ($_POST) {

            $rules = array(

                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'trim|required|valid_email'
                ),

                array(
                    'field' => 'username',
                    'label' => 'Name',
                    'rules' => 'trim|required|alpha'
                ),
                array(
                    'field' => 'subject',
                    'label' => 'Subject',
                    'rules' => 'trim|required|alpha'
                ),
                array(
                    'field' => 'message',
                    'label' => 'Message',
                    'rules' => 'trim|required'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');

            if ($this->form_validation->run() == FALSE) {
            } else {
                $em = $this->input->post('email');

                $un = $this->input->post('username');

                $sub = $this->input->post('subject');

                $message = $this->input->post('message');

                $from_email = $em;
                $to_email = "vp@sbssrinagar.com";
                $message = "    <html>
                                        <head>
                                        <title>Enquiry from $un</title>
                                        </head>
                                        <body>
                                        <table>
                                        <tr>
                                        <th>Subject : $sub</th>
                                        <th>Message : $message</th>
                                        </tr>
                                        <tr>
                                     
                                        </tr>
                                        </table>
                                        </body>
                                        </html>";
                //Load email library
                $this->load->library('email');
                $this->email->set_mailtype("html");
                $this->email->from($from_email, 'SBS MANAGER');
                $this->email->to($to_email);
                $this->email->subject($sub);
                $this->email->message($message);

                //Send mail
                $this->email->send();


                echo "<script>alert('Enquiry Sent Successfully');</script>";

            }

        }


        $this->load->view('frontend/contact');
    }


    public function admission_contact()
    {
        $this->load->library('form_validation');
        if ($_POST) {

            $rules = array(

                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'trim|valid_email'
                ),

                array(
                    'field' => 'username',
                    'label' => 'Name',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'subject',
                    'label' => 'Contact',
                    'rules' => 'trim|required|numeric'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');

            if ($this->form_validation->run() == FALSE) {
            } else {
                $em = $this->input->post('email');

                $un = $this->input->post('username');

                $sub = $this->input->post('subject');

                $from_email = $em;
                $to_email = "aahmedhussain76@gmail.com";
                $message = "    <html>
                                        <head>
                                        <title>Admission Enquiry from $un</title>
                                        </head>
                                        <body>
                                        <table>
                                        <tr>
                                        <th>Name : $un</th>                                    
                                        </tr>
                                        <tr>
                                        <th>Contact : $sub</th>
                                        </tr>
                                       </table>
                                        </body>
                                        </html>";
                //Load email library
                $this->load->library('email');
                $this->email->set_mailtype("html");
                $this->email->from($from_email, 'SBS MANAGER');
                $this->email->to($to_email);
                $this->email->subject($sub);
                $this->email->message($message);

                //Send mail
                $this->email->send();



                $this->load->helper('download');


                $file = "./uploads/AdmissionForm.pdf";
                // check file exists
                if (file_exists($file)) {
                    // get file content
                    $data = file_get_contents($file);
                    //force download
                    force_download($file, $data);

                } else {
                    // Redirect to base url
                    echo "<script>alert('File Does Not Exist');   
                            window.history.back();</script>";
                }


                echo "<script>alert('Enquiry Sent Successfully');</script>";

            }

        }


        $this->load->view('frontend/admission_contact');
    }

    public function view_achievement($id = "")
    {
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('AchievementModel');
            $data['achievement'] = $this->AchievementModel->get_achievement_where($id);

            if ($data['achievement']) {
                $this->load->view('frontend/view_achievement', $data);
            } else {
                redirect(base_url("FrontendController/achievements"));
            }

        }
    }

    public function view_assignment($id = "")
    {
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('AcademicModel');
            $data['assignment'] = $this->AcademicModel->get_assignment_where($id);

            if ($data['assignment']) {
                $this->load->view('frontend/view_assignment', $data);
            } else {
                redirect(base_url("FrontendController/assignments"));
            }

        }
    }

    public function view_datesheet($id = "")
    {
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('AcademicModel');
            $data['datesheet'] = $this->AcademicModel->get_datesheet_where($id);

            if ($data['datesheet']) {
                $this->load->view('frontend/view_datesheet', $data);
            } else {
                redirect(base_url("FrontendController/datesheets"));
            }

        }
    }

    public function view_news($id = "")
    {
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('NewsModel');
            $data['news'] = $this->NewsModel->get_news_where($id);

            if ($data['news']) {
                $this->load->view('frontend/view_news', $data);
            } else {
                redirect(base_url("FrontendController/news"));
            }

        }
    }

    public function view_event($id = "")
    {
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('EventModel');
            $data['event'] = $this->EventModel->get_event_where($id);

            if ($data['event']) {
                $this->load->view('frontend/view_event', $data);
            } else {
                redirect(base_url("FrontendController/events"));
            }

        }
    }

    public function view_visit($id = "")
    {
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('VisitModel');
            $data['visit'] = $this->VisitModel->get_visit_where($id);

            if ($data['visit']) {
                $this->load->view('frontend/view_visit', $data);
            } else {
                redirect(base_url("FrontendController/visits"));
            }

        }
    }

    public function careers()
    {
        $this->load->view('frontend/careers');
    }


    public function payment_confirmation()
    {
        $this->check_login();
        if ($_POST) {


            $data = array();

            $this->load->library('form_validation');
            $rules = array(

                array(
                    'field' => 'student',
                    'label' => 'Student',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'category',
                    'label' => 'Fee Category',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'amount',
                    'label' => 'Fee Amount',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'month',
                    'label' => 'Month',
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

            if ($this->form_validation->run() == FALSE) {

                redirect(site_url("FrontendController/deposit_fee"));

            } else {

                $this->load->model('FeeModel');
                $latefee = $this->FeeModel->calculate_late_fee();


                $id = $this->input->post('student');

                $this->load->model('StudentModel');
                $student = $this->StudentModel->get_student_where_id($id);

                $classID = $student[0]['ClassID'];
                $sectionID = $student[0]['SectionID'];
                $total = $this->input->post('amount') + $latefee;

                $payment = array(
                    "StudentID" => $id,
                    "CategoryID" => $this->input->post('category'),
                    "ClassID" => $classID,
                    "SectionID" => $sectionID,
                    "Date" => date("Y-m-d"),
                    "Month" => $this->input->post('month'),
                    "Year" => $this->input->post('year'),
                    "Amount" => $total,
                    "LateFee" => $latefee
                );


                $lastID = $this->FeeModel->get_last_payment();
                $data['categories'] = $this->FeeModel->get_fee_categories();
                $this->load->model('StudentModel');
                $this->load->model('AcademicModel');
                $data['classes'] = $this->AcademicModel->get_classes();
                $data['sections'] = $this->AcademicModel->get_sections();
                $data['student'] = $student;


                if (isset($lastID[0]['PaymentID']))
                    $lastID = $lastID[0]['PaymentID'] + 1;
                else
                    $lastID = 1;
                $receiptID = date("Y") . $payment['Month'] . $lastID;


                $this->load->model("StudentModel");
                $data['student'] = $this->StudentModel->get_student_where_id($payment['StudentID']);

                $payment['ReceiptID'] = $receiptID;

                $result = $this->FeeModel->add_payment($payment);


                if ($result == 0) {
                    echo "<script>alert('Payment  Un-Successful . Receipt ID already exists');
                                window.location = 'deposit_fee';</script>";

                } elseif ($result == 1) {
                    echo "<script>alert('Payment  Un-Successful . Payment for this student for this month already made');
                            window.location = 'deposit_fee';</script>";
                } else {
                    echo "<script>alert('Receipt Created  Successful . Receipt ID is '+" . $receiptID . ");</script>";

                }


                $data['total'] = $total;
                $data['latefee'] = $latefee;

                //echo "<script>alert('Class Added Successfully')   </script>";
                $data['receipt'] = $receiptID;
                // Merchant id provided by CCAvenue
                $data['Merchant_Id'] = "133655";
                // Item amount for which transaction perform
                $data['Amount'] = $payment['Amount'];
                // Unique OrderId that should be passed to payment gateway
                $data['Order_Id'] = $payment['ReceiptID'];


                $_SESSION['receipt_id'] = $payment['ReceiptID'];

                // Unique Key provided by CCAvenue
                $data['WorkingKey'] = "34888D62335F2DA0C626BAA17EB04335";
                // Success page URL
                $data['Redirect_Url'] = base_url("FrontendController/payment_validate");
                $data['Checksum'] = $this->getCheckSum($data['Merchant_Id'], $data['Amount'], $data['Order_Id'], $data['Redirect_Url'], $data['WorkingKey']);


                $data['payment'] = $payment;
                $this->load->view("frontend/CCPayment", $data);
            }

        }
    }

    public function cc_avenue_payment()
    {

        $this->load->view("frontend/CCAvenue");

    }

    public function payment_validate()
    {
        if ($_POST) {
            $this->load->view("frontend/CCAvenueResponse");
        }

    }

    public function pay_fee()
    {


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

                $this->load->model('LoginModel');

                $login = $this->LoginModel->student_login($student);
                if ($login) {

                    $logon = array(
                        'std_username' => $student['LoginID']
                    );

                    $student = $this->LoginModel->get_student_id($logon['std_username']);

                    $logon['std_ID'] = $student[0]['StudentID'];
                    $logon['std_Name'] = $student[0]['FirstName'] . " " . $student[0]['MiddleName'] . " " . $student[0]['LastName'];
                    $this->session->set_userdata($logon);

                    $url = base_url("FrontendController/deposit_fee");

                    echo "<script>alert('Credentials Accepted');
                            window.location.href = '" . $url . "';</script>";


                } else {
                    $data['error'] = "Invalid Credentials";
                    echo "<script>alert('Invalid Credentials')</script>";
                }
            }
        }

        $this->load->view('frontend/PayFee');
    }

    public function deposit_fee()
    {

        if (isset($_SESSION['std_username']) && isset($_SESSION['std_ID'])) {
            $data = array();

            $this->load->library('form_validation');

            $this->load->model('StudentModel');
            $data['students'] = $this->StudentModel->get_students();
            $this->load->model('FeeModel');
            $data['categories'] = $this->FeeModel->get_fee_categories();

            $this->load->view("frontend/FeePayment", $data);
        } else {
            redirect(base_url("FrontendController/pay_fee"));
        }

    }


    // Get the checksum
    function getCheckSum($MerchantId, $Amount, $OrderId, $URL, $WorkingKey)
    {
        $str = "$MerchantId|$OrderId|$Amount|$URL|$WorkingKey";
        $adler = 1;
        $adler = $this->adler32($adler, $str);
        return $adler;
    }

    function cdec($num)
    {
        $dec = '';
        for ($n = 0; $n < strlen($num); $n++) {
            $temp = $num[$n];
            $dec = $dec + $temp * pow(2, strlen($num) - $n - 1);
        }
        return $dec;
    }

    function adler32($adler, $str)
    {
        $BASE = 65521;
        $s1 = $adler & 0xffff;
        $s2 = ($adler >> 16) & 0xffff;
        for ($i = 0; $i < strlen($str); $i++) {
            $s1 = ($s1 + Ord($str[$i])) % $BASE;
            $s2 = ($s2 + $s1) % $BASE;
        }
        return $this->leftshift($s2, 16) + $s1;
    }

    function leftshift($str, $num)
    {
        $str = DecBin($str);
        for ($i = 0; $i < (64 - strlen($str)); $i++)
            $str = "0" . $str;
        for ($i = 0; $i < $num; $i++) {
            $str = $str . "0";
            $str = substr($str, 1);
        }
        return $this->cdec($str);
    }

//Verify the the checksum
    function verifychecksum($MerchantId, $OrderId, $Amount, $AuthDesc, $CheckSum, $WorkingKey)
    {
        $str = "$MerchantId|$OrderId|$Amount|$AuthDesc|$WorkingKey";
        $adler = 1;
        $adler = adler32($adler, $str);
        if ($adler == $CheckSum)
            return "true";
        else
            return "false";
    }


    public function get_class()
    {
        if ($_POST) {
            $studentID = $this->input->post('StudentID');

            $this->load->model("StudentModel");
            $student = $this->StudentModel->get_student_where_id($studentID);

            if (isset($student))
                echo $student[0]['ClassID'];
            else
                echo "ERROR";
        }
    }

    public function get_route()
    {
        if ($_POST) {
            $studentID = $this->input->post('StudentID');

            $this->load->model("StudentModel");
            $student = $this->StudentModel->get_student_where_id($studentID);

            if (isset($student))
                echo $student[0]['RouteID'];
            else
                echo "ERROR";
        }
    }

    public function get_fee()
    {
        if ($_POST) {
            $classID = $this->input->post('ClassID');
            $categoryID = $this->input->post('CategoryID');

            $this->load->model("FeeModel");
            $fee = $this->FeeModel->get_allocated_fee_where($classID, $categoryID);

            if (isset($fee[0]['Amount']))
                echo $fee[0]['Amount'];
            else
                echo "ERROR";
        }
    }

    public function get_bus_fee()
    {
        if ($_POST) {
            $routeID = $this->input->post('RouteID');

            $this->load->model("FeeModel");
            $fee = $this->FeeModel->get_allocated_bus_fee_where($routeID);

            if (isset($fee[0]['Amount']))
                echo $fee[0]['Amount'];
            else
                echo "ERROR";
        }
    }

    public function get_last_deposit()
    {
        if ($_POST) {
            $studentID = $this->input->post('StudentID');

            $categoryID = $this->input->post('CategoryID');

            $this->load->model("FeeModel");
            $student = $this->FeeModel->get_payment_where($studentID, $categoryID);

            if ($student)
                echo $student[0]['Month'];
            else
                echo "ERROR";
        }
    }

    public function confirm_payment()
    {
        if (isset($_SESSION['receipt_id'])) {
            $receipt = $_SESSION['receipt_id'];
            $this->load->model("FeeModel");
            if ($this->FeeModel->confirm_payment_receipt($receipt)) {
                echo "<script>alert('Payment Confirmed . Receipt ID '+" . $receipt . ");</script>";

                $receipt = $_SESSION['receipt_id'];

                $this->load->model("FeeModel");
                $this->load->model("AcademicModel");
                $this->load->model("StudentModel");

                $payment = $this->FeeModel->get_payment_where_receipt($receipt);

                $data = array();


                $data['payment'] = $payment;

                $data['classes'] = $this->AcademicModel->get_classes();
                $data['sections'] = $this->AcademicModel->get_sections();
                $data['student'] = $this->StudentModel->get_student_where_id($payment[0]['StudentID']);
                $data['categories'] = $this->FeeModel->get_fee_categories();


                $this->load->view('frontend/PaymentDone', $data);


            } else {
                echo "<script>alert('Payment Not Confirmed . Invalid Receipt ID');
                                window.location='http://www.sbssrinagar.com'</script>";
            }
        }
    }

}
