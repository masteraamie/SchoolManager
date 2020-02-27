<?php

class VisitController extends CI_Controller
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

    public function add_visit()
    {
        $this->check_login();
        $data = array();

        if (!is_dir("./uploads/Visits"))
            mkdir("./uploads/Visits", 0777, TRUE);


        $this->load->model('VisitModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'title',
                    'label' => 'Visit Title',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'designation',
                    'label' => 'Designation',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'visit_by',
                    'label' => 'Visit By',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'date',
                    'label' => 'Visit Date',
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


            $visit = array(
                'Title' => $this->input->post('title'),
                'VisitBy' => $this->input->post('visit_by'),
                'Date' => $this->input->post('date'),
                'Designation' => $this->input->post('designation'),
                'Details' => $this->input->post('details')

            );
            $data['visit'] = $visit;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->VisitModel->add_visit($visit);

                if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {

                    $config = array(

                        'file_name' => "Visit_" . $data['success'],
                        'upload_path' => './uploads/Visits/',
                        'allowed_types' => 'png|jpg',
                        'overwrite' => TRUE,
                        'max_size' => '1024000'

                    );

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('photo')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->VisitModel->add_visit_photo($data['success'], $config['upload_path'] . $upload_data['file_name']);
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
            $visit = array(
                'Title' => "",
                'VisitBy' => "",
                "Designation" => "",
                'Date' => "",
                'Details' => ""
            );
            $data['visit'] = $visit;
        }


        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('visits/AddVisit', $data);

    }

    public function edit_visit($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/Visits"))
                mkdir("./uploads/Visits", 0777, TRUE);


            $this->load->model('VisitModel');

            $data['visit'] = $this->VisitModel->get_Visit_where($id);

            if ($data['visit']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'title',
                            'label' => 'Visit Title',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'designation',
                            'label' => 'Designation Title',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'visit_by',
                            'label' => 'Visit By',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'date',
                            'label' => 'visit Date',
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


                    $visit = array(
                        'Title' => $this->input->post('title'),
                        'VisitBy' => $this->input->post('visit_by'),
                        'Designation' => $this->input->post('designation'),
                        'Date' => $this->input->post('date'),
                        'Details' => $this->input->post('details')

                    );
                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->VisitModel->update_visit($visit, $id);

                        if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {

                            $config = array(

                                'file_name' => "Visit_" . $id,
                                'upload_path' => './uploads/Visits/',
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
                                    $this->VisitModel->add_visit_photo($id, $config['upload_path'] . $upload_data['file_name']);
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
                $data['visit'] = $this->VisitModel->get_Visit_where($id);

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('visits/EditVisit', $data);
            } else {
                redirect(site_url("VisitController/add_Visit"));
            }

        } else {
            redirect(site_url("VisitController/add_Visit"));
        }
    }

    public function view_visit($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/Visits"))
                mkdir("./uploads/Visits", 0777, TRUE);


            $this->load->model('VisitModel');

            $data['visit'] = $this->VisitModel->get_Visit_where($id);;

            if ($data['visit']) {
                $this->load->library('form_validation');


                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('visits/ViewVisit', $data);
            } else {
                redirect(site_url("DashboardController/"));
            }

        } else {
            redirect(site_url("DashboardController/"));
        }
    }

    public function delete_Visit($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('VisitModel');


            $data['id'] = $id;

            $data['delete'] = $this->VisitModel->delete_Visit($id);
            redirect(site_url() . 'VisitController/Visit_list');
        } else {
            redirect(site_url() . 'VisitController/Visit_list');
        }
    }


    public function visit_list($page = 0)
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("VisitModel");
        $data['visits'] = $this->VisitModel->get_visits($page);

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "VisitController/visit_list/";
        $config['total_rows'] = $this->VisitModel->get_visit_count();;
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

        $this->load->view('visits/VisitList', $data);
    }

}
