<?php

class EventController extends CI_Controller
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

    public function add_event_type()
    {
        $this->check_login();

        $data = array();

        $this->load->model('EventModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'type',
                    'label' => 'Event Type',
                    'rules' => 'trim|required|is_unique[tbl_event_type.Type]'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $event = array(
                'Type' => $this->input->post('type'),
            );

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->EventModel->add_event_type($event);
            }

        } else {
            $event['Type'] = "";
        }

        $data['types'] = $this->EventModel->get_event_types();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('events/AddEventType', $data);

    }

    public function edit_event_type($id = "")
    {
        $this->check_login();

        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('EventModel');

            $data['type'] = $this->EventModel->get_event_type_where($id);

            if ($data['type']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'type',
                            'label' => 'Event Type',
                            'rules' => 'trim|required|is_unique[tbl_event_type.Type]'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $event = array(
                        'EventTypeID' => $id,
                        'Type' => $this->input->post('type'),
                    );

                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->EventModel->update_event_type($event);
                    }

                } else {
                    $event['Type'] = "";
                }

                $data['types'] = $this->EventModel->get_event_types();

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('events/EditEventType', $data);
            } else {
                redirect(site_url("EventController/add_event_type"));
            }
        } else {
            redirect(site_url("EventController/add_event_type"));
        }

    }

    public function delete_event_type($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('EventModel');


            $data['id'] = $id;

            $data['delete'] = $this->EventModel->delete_event_type($id);
            redirect(site_url() . 'EventController/add_event_type');
        } else {
            redirect(site_url() . 'EventController/add_event_type');
        }
    }

    public function add_event()
    {
        $this->check_login();
        $data = array();

        $this->load->model('EventModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Event Name',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'organiser',
                    'label' => 'Organiser Name',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'type',
                    'label' => 'Event Type',
                    'rules' => 'trim|required|greater_than[0]'
                ),
                array(
                    'field' => 'start_date',
                    'label' => 'Event Start Date',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'end_date',
                    'label' => 'Event End Date',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'event_for',
                    'label' => 'Event For',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'description',
                    'label' => 'Description',
                    'rules' => 'trim|required'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_message('greater_than', "Select a valid event type");
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');


            $event = array(
                'Name' => $this->input->post('name'),
                'EventTypeID' => $this->input->post('type'),
                'StartDate' => $this->input->post('start_date'),
                'EndDate' => $this->input->post('end_date'),
                'Description' => $this->input->post('description'),
                'Organiser' => $this->input->post('organiser'),
                'EventFor' => $this->input->post('event_for')
            );
            $data['event'] = $event;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->EventModel->add_event($event);
            }

        } else {
            $event = array(
                'Name' => "",
                'EventTypeID' => "",
                'StartDate' => "",
                'EndDate' => "",
                'Description' => "",
                'Organiser' => ''
            );
            $data['event'] = $event;
        }


        $data['types'] = $this->EventModel->get_event_types();

        $this->load->model('AcademicModel');
        $data['classes'] = $this->AcademicModel->get_classes();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('events/AddEvent', $data);

    }

    public function edit_event($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('EventModel');

            $data['event'] = $this->EventModel->get_event_where($id);
            if ($data['event']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Event Name',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'organiser',
                            'label' => 'Organiser Name',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'type',
                            'label' => 'Event Type',
                            'rules' => 'trim|required|greater_than[0]'
                        ),
                        array(
                            'field' => 'start_date',
                            'label' => 'Event Start Date',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'end_date',
                            'label' => 'Event End Date',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'event_for',
                            'label' => 'Event For',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'description',
                            'label' => 'Description',
                            'rules' => 'trim|required'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_message('greater_than', "Select a valid event type");
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');


                    $event = array(
                        'Name' => $this->input->post('name'),
                        'EventTypeID' => $this->input->post('type'),
                        'StartDate' => $this->input->post('start_date'),
                        'EndDate' => $this->input->post('end_date'),
                        'Description' => $this->input->post('description'),
                        'Organiser' => $this->input->post('organiser'),
                        'EventFor' => $this->input->post('event_for')

                    );
                    $data['event'] = $event;

                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->EventModel->update_event($event, $id);
                    }

                }


                $data['event'] = $this->EventModel->get_event_where($id);
                $data['types'] = $this->EventModel->get_event_types();

                $this->load->model('AcademicModel');
                $data['classes'] = $this->AcademicModel->get_classes();

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('events/EditEvent', $data);
            } else {
                redirect(site_url("EventController/add_event"));
            }
        } else {
            redirect(site_url("EventController/add_event"));
        }
    }

    public function delete_event($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('EventModel');


            $data['id'] = $id;

            $data['delete'] = $this->EventModel->delete_event($id);
            redirect(site_url() . 'EventController/events_list');
        } else {
            redirect(site_url() . 'EventController/add_event');
        }
    }

    public function events_list($page = 0)
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("EventModel");
        $data['events'] = $this->EventModel->get_events_pagination($page);
        $data['types'] = $this->EventModel->get_event_types();

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "EventController/events_list/";
        $config['total_rows'] = $this->EventModel->get_event_count();;
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

        $this->load->view('events/EventsList', $data);
    }


}
