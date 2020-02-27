<?php

class NewsController extends CI_Controller
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
                        'max_size' => '1024000'

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


        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $this->load->view('news/AddNews', $data);

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

                    if ($this->form_validation->run() == FALSE) {
                    } else {

                        $data['success'] = $this->NewsModel->update_news($news, $id);

                        if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {

                            $config = array(

                                'file_name' => "news_" . $id,
                                'upload_path' => './uploads/news/',
                                'allowed_types' => 'png|jpg',
                                'overwrite' => TRUE,
                                'max_size' => '1024000'

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

                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('news/EditNews', $data);
            } else {
                redirect(site_url("NewsController/add_news"));
            }

        } else {
            redirect(site_url("NewsController/add_news"));
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


                $this->load->model("AdminMessageModel");
                $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
                $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

                $this->load->view('news/ViewNews', $data);
            } else {
                redirect(site_url("DashboardController/"));
            }

        } else {
            redirect(site_url("DashboardController/"));
        }
    }

    public function delete_news($id = "NULL")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {
            $data = array();
            $this->load->model('NewsModel');


            $data['id'] = $id;

            $data['delete'] = $this->NewsModel->delete_news($id);
            redirect(site_url() . 'NewsController/news_list');
        } else {
            redirect(site_url() . 'NewsController/news_list');
        }
    }


    public function news_list($page = 0)
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("NewsModel");
        $data['newses'] = $this->NewsModel->get_news($page);

        $this->load->library('pagination');
        $config['base_url'] = base_url() . "NewsController/news_list/";
        $config['total_rows'] = $this->NewsModel->get_news_count();;
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


        $this->load->view('news/NewsList', $data);
    }

}
