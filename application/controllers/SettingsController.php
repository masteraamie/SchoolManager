<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SettingsController extends CI_Controller
{

    public function image_settings()
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data = array();


        $this->load->model('SettingsModel');

        if (!is_dir("./uploads/Frontend"))
            mkdir("./uploads/Frontend", 0777, TRUE);

        if ($_POST) {

            $this->load->library('upload');
            if (isset($_FILES['image1']['name']) && !empty($_FILES['image1']['name'])) {

                $config = array(

                    'file_name' => "image_1",
                    'upload_path' => './uploads/Frontend/',
                    'allowed_types' => 'png|jpg',
                    'overwrite' => TRUE,
                    'max_size' => '1024000',
                    'max_height' => '790',
                    'max_width' => '1440'
                );

                $this->upload->initialize($config);
                if ($this->upload->do_upload('image1')) {

                    $upload_data = $this->upload->data();

                    if ($upload_data) {
                        $this->SettingsModel->update_image($config['upload_path'] . $upload_data['file_name'], 1);
                        $data['success'] = True;
                    } else {
                        $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                    }

                } else {
                    $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                }
            }

            if (isset($_FILES['image2']['name']) && !empty($_FILES['image2']['name'])) {

                $config = array(

                    'file_name' => "image_2",
                    'upload_path' => './uploads/Frontend/',
                    'allowed_types' => 'png|jpg',
                    'overwrite' => TRUE,
                    'max_size' => '1024000',
                    'max_height' => '790',
                    'max_width' => '1440'
                );

                $this->upload->initialize($config);
                if ($this->upload->do_upload('image2')) {

                    $upload_data = $this->upload->data();

                    if ($upload_data) {
                        $this->SettingsModel->update_image($config['upload_path'] . $upload_data['file_name'], 2);
                        $data['success'] = True;
                    } else {
                        $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                    }

                } else {
                    $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                }
            }
            if (isset($_FILES['image3']['name']) && !empty($_FILES['image3']['name'])) {

                $config = array(

                    'file_name' => "image_3",
                    'upload_path' => './uploads/Frontend/',
                    'allowed_types' => 'png|jpg',
                    'overwrite' => TRUE,
                    'max_size' => '1024000',
                    'max_height' => '790',
                    'max_width' => '1440'
                );

                $this->upload->initialize($config);
                if ($this->upload->do_upload('image3')) {

                    $upload_data = $this->upload->data();

                    if ($upload_data) {
                        $this->SettingsModel->update_image($config['upload_path'] . $upload_data['file_name'], 3);
                        $data['success'] = True;
                    } else {
                        $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                    }

                } else {
                    $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                }
            }
            if (isset($_FILES['image4']['name']) && !empty($_FILES['image4']['name'])) {

                $config = array(

                    'file_name' => "image_4",
                    'upload_path' => './uploads/Frontend/',
                    'allowed_types' => 'png|jpg',
                    'overwrite' => TRUE,
                    'max_size' => '1024000',
                    'max_height' => '790',
                    'max_width' => '1440'
                );

                $this->upload->initialize($config);
                if ($this->upload->do_upload('image4')) {

                    $upload_data = $this->upload->data();

                    if ($upload_data) {
                        $this->SettingsModel->update_image($config['upload_path'] . $upload_data['file_name'], 4);
                        $data['success'] = True;
                    } else {
                        $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                    }

                } else {
                    $data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-danger"><i class="fa fa-check-circle"></i> ', '</p>'));
                }
            }

        }


        $data['images'] = $this->SettingsModel->get_images();

        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;
        $this->load->view("admin/image_settings", $data);

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


    public function vice_principal_settings()
    {
        $this->check_login();
        $data = array();
        $this->load->model('SettingsModel');
        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'message',
                    'label' => 'Message',
                    'rules' => 'trim|required'
                )
            );


            $principal = array(

                "Name" => $this->input->post("name"),
                "Message" => $this->input->post("message")
            );

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');
            if ($this->form_validation->run() == FALSE) {
            } else {


                $data['success'] = $this->SettingsModel->update_vice_principal($principal);

                $this->load->library('upload');
                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {

                    $config = array(

                        'file_name' => "vice_principal",
                        'upload_path' => './uploads/Frontend/',
                        'allowed_types' => 'png|jpg',
                        'overwrite' => TRUE,
                        'max_size' => '1024000',
                        'max_height' => '600',
                        'max_width' => '600'
                    );

                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('image')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->SettingsModel->update_vice_principal_image($config['upload_path'] . $upload_data['file_name']);
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

        $data['principal'] = $this->SettingsModel->get_vice_principal();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('admin/vice_principal_settings', $data);
    }

    public function principal_settings()
    {
        $this->check_login();
        $data = array();
        $this->load->model('SettingsModel');
        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'message',
                    'label' => 'Message',
                    'rules' => 'trim|required'
                )
            );


            $principal = array(

                "Name" => $this->input->post("name"),
                "Message" => $this->input->post("message")
            );

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');
            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->SettingsModel->update_principal($principal);

                $this->load->library('upload');

                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {

                    $config = array(

                        'file_name' => "principal",
                        'upload_path' => './uploads/Frontend/',
                        'allowed_types' => 'png|jpg',
                        'overwrite' => TRUE,
                        'max_size' => '1024000',
                        'max_height' => '600',
                        'max_width' => '600'
                    );

                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('image')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->SettingsModel->update_principal_image($config['upload_path'] . $upload_data['file_name']);
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

        $data['principal'] = $this->SettingsModel->get_principal();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('admin/principal_settings', $data);
    }

    public function director_settings()
    {
        $this->check_login();
        $data = array();
        $this->load->model('SettingsModel');
        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'message',
                    'label' => 'Message',
                    'rules' => 'trim|required'
                )
            );


            $director = array(

                "Name" => $this->input->post("name"),
                "Message" => $this->input->post("message")
            );

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');
            if ($this->form_validation->run() == FALSE) {
            } else {

                $data['success'] = $this->SettingsModel->update_director($director);

                $this->load->library('upload');

                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {

                    $config = array(

                        'file_name' => "director",
                        'upload_path' => './uploads/Frontend/',
                        'allowed_types' => 'png|jpg',
                        'overwrite' => TRUE,
                        'max_size' => '1024000',
                        'max_height' => '600',
                        'max_width' => '600'
                    );

                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('image')) {

                        $upload_data = $this->upload->data();

                        if ($upload_data) {
                            $this->SettingsModel->update_director_image($config['upload_path'] . $upload_data['file_name']);
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

        $data['director'] = $this->SettingsModel->get_director();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('admin/director_settings', $data);
    }

    public function settings()
    {

        $this->check_login();
        $data = array();
        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'old_pass',
                    'label' => 'Old Password',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'new_pass',
                    'label' => 'New Password',
                    'rules' => 'trim|required|max_length[30]|min_length[6]'
                ),
                array(
                    'field' => 'confirm_pass',
                    'label' => 'Confirm Password',
                    'rules' => 'trim|required|max_length[30]|min_length[6]|matches[new_pass]'
                )
            );

            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');
            if ($this->form_validation->run() == FALSE) {
            } else {
                $this->load->model('LoginModel');

                $oldPass = $this->input->post('old_pass');

                $oldPass = $this->LoginModel->encrypt($oldPass);

                $admin = array(
                    "Username" => $_SESSION['admin_username'],
                    "Password" => $oldPass
                );
                $login = $this->LoginModel->admin_login($admin);
                if ($login) {
                    $i = $this->LoginModel->get_admin_id($_SESSION['admin_username']);

                    $id = $i[0]['AdminID'];
                    $newPass = $this->input->post('new_pass');

                    $newPass = $this->LoginModel->encrypt($newPass);

                    $data['success'] = $this->LoginModel->admin_change_password($id, $newPass);

                } else {
                    echo "<script>alert('Invalid Credentials')</script>";
                    $data['error'] = "Invalid Credentials";
                }


            }
        }
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view('admin/admin_settings', $data);
    }

}
