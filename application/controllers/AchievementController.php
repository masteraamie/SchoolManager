<?php

class AchievementController extends CI_Controller
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

    public function add_achievement()
    {
        $this->check_login();
        $data = array();

        if (!is_dir("./uploads/Achievements"))
            mkdir("./uploads/Achievements", 0777, TRUE);


        $this->load->model('AchievementModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'title',
                    'label' => 'Achievement Title',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'achievement_by',
                    'label' => 'Achievement By',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'date',
                    'label' => 'Achievement Date',
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


            $achievement = array(
                'Title' => $this->input->post('title'),
                'AchievementBy' => $this->input->post('achievement_by'),
                'Date' => $this->input->post('date'),
                'Details' => $this->input->post('details')

            );
            $data['Achievement'] = $achievement;

            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->AchievementModel->add_achievement($achievement);

                if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {

                    $config = array(

                        'file_name' => "Achievement_" . $data['success'],
                        'upload_path' => './uploads/Achievements/',
                        'allowed_types' => 'png|jpg',
                        'overwrite' => TRUE,
                        'max_size' => '1024000'
                    );

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('photo')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->AchievementModel->add_achievement_photo($data['success'], $config['upload_path'] . $upload_data['file_name']);
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
            $achievement = array(
                'Title' => "",
                'AchievementBy' => "",
                'Date' => "",
                'Details' => ""
            );
            $data['Achievement'] = $achievement;
        }


        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('achievements/AddAchievement', $data);

    }

    public function edit_achievement($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/Achievements"))
                mkdir("./uploads/Achievements", 0777, TRUE);


            $this->load->model('AchievementModel');

            $data['achievement'] = $this->AchievementModel->get_Achievement_where($id);

            if ($data['achievement']) {
                $this->load->library('form_validation');
                if ($_POST) {
                    $rules = array(

                        array(
                            'field' => 'title',
                            'label' => 'Achievement Title',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'achievement_by',
                            'label' => 'Achievement By',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 'date',
                            'label' => 'Achievement Date',
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


                    $achievement = array(
                        'Title' => $this->input->post('title'),
                        'AchievementBy' => $this->input->post('achievement_by'),
                        'Date' => $this->input->post('date'),
                        'Details' => $this->input->post('details')

                    );
                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->AchievementModel->update_achievement($achievement, $id);

                        if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {

                            $config = array(

                                'file_name' => "Achievement_" . $id,
                                'upload_path' => './uploads/Achievements/',
                                'allowed_types' => 'png|jpg',
                                'overwrite' => TRUE,
                                'max_size' => '1024000'

                            );

                            $this->load->library('upload', $config);
                            if ($this->upload->do_upload('photo')) {

                                $upload_data = $this->upload->data();

                                if ($upload_data) {
                                    $this->AchievementModel->add_achievement_photo($id, $config['upload_path'] . $upload_data['file_name']);
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
                $data['achievement'] = $this->AchievementModel->get_Achievement_where($id);
                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('achievements/EditAchievement', $data);
            } else {
                redirect(site_url("AchievementController/add_achievement"));
            }

        } else {
            redirect(site_url("AchievementController/add_achievement"));
        }
    }

    public function view_achievement($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();

            if (!is_dir("./uploads/Achievements"))
                mkdir("./uploads/Achievements", 0777, TRUE);


            $this->load->model('AchievementModel');

            $data['achievement'] = $this->AchievementModel->get_achievement_where($id);;

            if ($data['Achievement']) {
                $this->load->library('form_validation');


                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('achievements/ViewAchievement', $data);
            } else {
                redirect(site_url("DashboardController/"));
            }

        } else {
            redirect(site_url("DashboardController/"));
        }
    }

    public function delete_achievement($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('AchievementModel');


            $data['id'] = $id;

            $data['delete'] = $this->AchievementModel->delete_achievement($id);
            redirect(site_url() . 'AchievementController/achievement_list');
        } else {
            redirect(site_url() . 'AchievementController/achievement_list');
        }
    }


    public function achievement_list($page = 0)
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AchievementModel");
        $data['achievements'] = $this->AchievementModel->get_achievements($page);

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "AchievementController/achievement_list/";
        $config['total_rows'] = $this->AchievementModel->get_achievement_count();;
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

        $this->load->view('achievements/AchievementList', $data);
    }

}
