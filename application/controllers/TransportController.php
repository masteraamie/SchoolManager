<?php

class TransportController extends CI_Controller
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


    public function add_bus()
    {
        $this->check_login();
        $data = array();

        $this->load->model('TransportModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Bus Name',
                    'rules' => 'trim|required|is_unique[tbl_buses.Name]'
                ),
                array(
                    'field' => 'number',
                    'label' => 'Bus Number',
                    'rules' => 'trim|required|is_unique[tbl_buses.Number]'
                ),
                array(
                    'field' => 'driver',
                    'label' => 'Driver',
                    'rules' => 'trim|required|is_unique[tbl_buses.DriverID]'
                )

            );

            $this->form_validation->set_message('is_unique', 'Bus with this {field}  already registered.');

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $bus = array(
                'Name' => $this->input->post('name'),
                'Number' => $this->input->post('number'),
                'DriverID' => $this->input->post('driver')
            );
            $data['bus'] = $bus;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->TransportModel->add_bus($bus);
            }

        } else {
            $bus = array(
                'Name' => "",
                'Number' => ""
            );
            $data['bus'] = $bus;
        }

        $data['buses'] = $this->TransportModel->get_buses();

        $this->load->model("HRModel");
        $data['drivers'] = $this->HRModel->get_drivers();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('transport/AddBus', $data);

    }

    public function edit_bus($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('TransportModel');

            $data['bus'] = $this->TransportModel->get_bus_where($id);


            if ($data['bus']) {

                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Bus Name',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'number',
                            'label' => 'Bus Number',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'driver',
                            'label' => 'Driver',
                            'rules' => 'trim|required'
                        )
                    );

                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $bus = array(
                        'Name' => $this->input->post('name'),
                        'Number' => $this->input->post('number'),
                        'DriverID' => $this->input->post('driver')
                    );
                    $data['bus'] = $bus;

                    if ($this->form_validation->run() == FALSE) {
                    } else {
                        $data['success'] = $this->TransportModel->update_bus($bus, $id);
                    }

                }

                $data['buses'] = $this->TransportModel->get_buses();

                $this->load->model("HRModel");
                $data['drivers'] = $this->HRModel->get_drivers();

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('transport/EditBus', $data);
            } else {
                redirect(site_url("TransportController/add_bus"));
            }
        } else {
            redirect(site_url("TransportController/add_bus"));
        }
    }

    public function delete_bus($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('TransportModel');


            $data['id'] = $id;

            $data['delete'] = $this->TransportModel->delete_bus($id);
            redirect(site_url() . 'TransportController/add_bus');
        } else {
            redirect(site_url() . 'TransportController/add_bus');
        }
    }

    public function add_route()
    {
        $this->check_login();
        $data = array();

        $this->load->model('TransportModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Route Name',
                    'rules' => 'trim|required|is_unique[tbl_routes.Name]'
                ),
                array(
                    'field' => 'stops',
                    'label' => 'Route Stops',
                    'rules' => 'trim|required'
                )
            );

            $this->form_validation->set_message('is_unique', 'Route with this {field}  already registered.');

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $route = array(
                'Name' => $this->input->post('name'),
                'Stops' => $this->input->post('stops')
            );
            $data['route'] = $route;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->TransportModel->add_route($route);
            }

        } else {
            $route = array(
                'Name' => "",
                'Stops' => ""
            );
            $data['route'] = $route;
        }

        $data['routes'] = $this->TransportModel->get_routes();

        $this->load->model("HRModel");
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('transport/AddRoute', $data);

    }

    public function edit_route($id = "")
    {

        $this->check_login();

        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('TransportModel');


            $data['route'] = $this->TransportModel->get_route_where($id);

            if ($data['route']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Route Name',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'stops',
                            'label' => 'Route Stops',
                            'rules' => 'trim|required'
                        )
                    );

                    $this->form_validation->set_message('is_unique', 'Route with this {field}  already registered.');

                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $route = array(
                        'Name' => $this->input->post('name'),
                        'Stops' => $this->input->post('stops')
                    );
                    $data['route'] = $route;

                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->TransportModel->update_route($route, $id);
                    }

                }

                $data['routes'] = $this->TransportModel->get_routes();
                $data['route'] = $this->TransportModel->get_route_where($id);
                $this->load->model("HRModel");
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('transport/EditRoute', $data);
            } else {
                redirect(site_url() . 'TransportController/add_route');
            }
        } else {
            redirect(site_url() . 'TransportController/add_route');
        }
    }

    public function delete_route($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('TransportModel');


            $data['id'] = $id;

            $data['delete'] = $this->TransportModel->delete_route($id);
            redirect(site_url() . 'TransportController/add_route');
        } else {
            redirect(site_url() . 'TransportController/add_route');
        }
    }


    public function allocate_route()
    {
        $this->check_login();
        $data = array();

        $this->load->model('TransportModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'route',
                    'label' => 'Route',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'bus',
                    'label' => 'Bus',
                    'rules' => 'trim|required|numeric'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $route = array(
                'RouteID' => $this->input->post('route'),
                'BusID' => $this->input->post('bus')
            );
            $data['route'] = $route;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->TransportModel->add_route_allocation($route);
            }

        }

        $data['routes'] = $this->TransportModel->get_routes();
        $data['buses'] = $this->TransportModel->get_buses();
        $data['allocations'] = $this->TransportModel->get_route_allocations();
        $this->load->model("HRModel");
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('transport/RouteAllocation', $data);

    }


    public function allocate_bus()
    {
        $this->check_login();
        $data = array();

        $this->load->model('TransportModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'student',
                    'label' => 'Student',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'bus',
                    'label' => 'Bus',
                    'rules' => 'trim|required|numeric'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $route = array(
                'StudentID' => $this->input->post('student'),
                'BusID' => $this->input->post('bus')
            );
            $data['route'] = $route;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->TransportModel->allocate_bus($route);
            }

        }

        $data['routes'] = $this->TransportModel->get_routes();
        $data['buses'] = $this->TransportModel->get_buses();
        $data['allocations'] = $this->TransportModel->get_route_allocations();

        $this->load->model("StudentModel");
        $data['students'] = $this->StudentModel->get_students();


        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('transport/BusAllocation', $data);
    }


    public function allocate_stop()
    {
        $this->check_login();
        $data = array();

        $this->load->model('TransportModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'student',
                    'label' => 'Student',
                    'rules' => 'trim|required|numeric'
                ),
                array(
                    'field' => 'stop',
                    'label' => 'Stop',
                    'rules' => 'trim|required|numeric'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $route = array(
                'StudentID' => $this->input->post('student'),
                'StopID' => $this->input->post('stop')
            );
            $data['route'] = $route;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->TransportModel->allocate_stop($route);
            }

        }

        $data['routes'] = $this->TransportModel->get_routes();
        $data['stops'] = $this->TransportModel->get_stops();
        $data['allocations'] = $this->TransportModel->get_route_allocations();

        $this->load->model("StudentModel");
        $data['students'] = $this->StudentModel->get_students();


        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('transport/StopAllocation', $data);
    }


    public function student_list()
    {
        $this->check_login();
        $this->load->model("AcademicModel");

        $data['classes'] = $this->AcademicModel->get_classes();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("TransportModel");
        $data['buses'] = $this->TransportModel->get_buses();
        $this->load->view("transport/StudentBusList", $data);

    }

    public function add_stop()
    {
        $this->check_login();
        $data = array();

        $this->load->model('TransportModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Stop Name',
                    'rules' => 'trim|required|is_unique[tbl_bus_stops.Name]'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain Alpha characters & White spaces');
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $stop = array(
                'Name' => $this->input->post('name')
            );
            $data['stop'] = $stop;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->TransportModel->add_stop($stop);
            }

        } else {
            $stop = array(
                'Name' => ""
            );
            $data['stop'] = $stop;
        }

        $data['stops'] = $this->TransportModel->get_stops();

        $this->load->model("HRModel");
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('transport/AddStop', $data);

    }

    public function edit_stop($id = "")
    {

        $this->check_login();

        if (isset($id) && is_numeric($id)) {
            $data = array();

            $this->load->model('TransportModel');


            $data['stop'] = $this->TransportModel->get_stop_where($id);

            if ($data['stop']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'name',
                            'label' => 'Stop Name',
                            'rules' => 'trim|required'
                        )
                    );


                    $this->form_validation->set_rules($rules);
                    $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


                    $stop = array(
                        'Name' => $this->input->post('name')
                    );
                    $data['stop'] = $stop;

                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->TransportModel->update_stop($stop, $id);
                    }

                }

                $data['stops'] = $this->TransportModel->get_stops();
                $data['stop'] = $this->TransportModel->get_stop_where($id);
                $this->load->model("HRModel");
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('transport/EditStop', $data);
            } else {
                redirect(site_url() . 'TransportController/add_stop');
            }
        } else {
            redirect(site_url() . 'TransportController/add_stop');
        }
    }

    function alpha_dash_space($name)
    {
        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_stop($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('TransportModel');


            $data['id'] = $id;

            $data['delete'] = $this->TransportModel->delete_stop($id);
            redirect(site_url() . 'TransportController/add_stop');
        } else {
            redirect(site_url() . 'TransportController/add_stop');
        }
    }

    public function get_students()
    {
        if ($_POST) {
            $busID = $this->input->post("BusID");
            $column = $this->input->post("Column");
            $this->load->model("StudentModel");
            $sections = $this->StudentModel->get_student_where_bus($busID);

            $data = array();
            foreach ($sections as $s)
                $data[] = $s[$column];


            echo json_encode($data);
        }
    }


    public function get_class()
    {
        if ($_POST) {
            $classID = $this->input->post("ClassID");
            $this->load->model("AcademicModel");
            $name = $this->AcademicModel->get_class_where($classID);

            if (isset($name[0]['Name']))
                echo json_encode($name[0]['Name']);
            else
                echo json_encode("Error");
        }
    }

    public function get_section()
    {
        if ($_POST) {
            $sectionID = $this->input->post("SectionID");
            $this->load->model("AcademicModel");
            $name = $this->AcademicModel->get_section_where($sectionID);

            if (isset($name[0]['Name']))
                echo json_encode($name[0]['Name']);
            else
                echo json_encode("Error");
        }
    }


}
