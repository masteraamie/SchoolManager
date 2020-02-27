<?php

class AdminMessageController extends CI_Controller
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

    public function admin_compose()
    {
        $this->check_login();
        $data = array();


        $this->load->model('AdminMessageModel');


        $this->load->library('form_validation');
        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'type',
                    'label' => 'Send Message To',
                    'rules' => 'trim|required|greater_than[0]|less_than[5]'
                ),

                array(
                    'field' => 'subject',
                    'label' => 'Message Subject',
                    'rules' => 'trim|required|max_length[100]'
                ),
                array(
                    'field' => 'receiver',
                    'label' => 'Message Recipient',
                    'rules' => 'trim|required|max_length[30]'
                ),
                array(
                    'field' => 'message',
                    'label' => 'Message',
                    'rules' => 'trim|required'
                )
            );

            $this->form_validation->set_message("greater_than", "Invalid Receiver Type Selected");
            $this->form_validation->set_message("less_than", "Invalid Receiver Type Selected");
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i> ', '</p>');


            $message = array(
                'Subject' => $this->input->post('subject'),
                'Message' => $this->input->post('message'),
                'Date' => date("d/m/y"),
                'AdminID' => $_SESSION['admin_username']
            );


            $receiver = $this->input->post('receiver');
            $data['receiver'] = $receiver;
            $data['message'] = $message;
            if ($this->form_validation->run() == FALSE) {
            } else {

                $type = $this->input->post('type');
                $check = $this->checkID($receiver, $type);

                if ($check && ($type == 1)) {
                    $message['TeacherID'] = $receiver;
                    $data['success'] = $this->AdminMessageModel->send_message_to_teacher($message);
                } else if ($check && ($type == 2)) {
                    $message['StudentID'] = $receiver;
                    $data['success'] = $this->AdminMessageModel->send_message_to_student($message);
                } else if ($check && ($type == 3)) {
                    $message['ParentID'] = $receiver;
                    $data['success'] = $this->AdminMessageModel->send_message_to_parent($message);
                } else {
                    $data['error'] = "The Receiver ID is Invalid";
                }
            }

        } else {
            $message = array(
                'Subject' => "",
                'Message' => "",
                'Date' => ""
            );
            $data['message'] = $message;
            $data['receiver'] = "";
        }
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view("mailbox/compose", $data);

    }

    public function checkID($id, $type)
    {
        if ($type == 1) {
            $this->load->model("LoginModel");
            $employee = $this->LoginModel->get_employee_where($id);
            if ($employee) {
                return true;
            } else {
                return false;
            }
        } else if ($type == 2) {
            $this->load->model("LoginModel");
            $student = $this->LoginModel->get_student_where($id);
            if ($student) {
                return true;
            } else {
                return false;
            }
        } else if ($type == 3) {
            $this->load->model("LoginModel");
            $parent = $this->LoginModel->get_parent_where($id);
            if ($parent) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function student_inbox()
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AdminMessageModel");
        $data['messages'] = $this->AdminMessageModel->get_messages($_SESSION['admin_username'], "STUDENT");
        $this->load->view('mailbox/admin_mailbox', $data);

    }

    public function parent_inbox()
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AdminMessageModel");
        $data['messages'] = $this->AdminMessageModel->get_messages($_SESSION['admin_username'], "PARENT");
        $this->load->view('mailbox/admin_mailbox', $data);

    }


    public function teacher_inbox()
    {
        $this->check_login();
        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->model("AdminMessageModel");
        $data['messages'] = $this->AdminMessageModel->get_messages($_SESSION['admin_username'], "TEACHER");
        $this->load->view('mailbox/admin_mailbox', $data);

    }

    public function read_mail($id = "")
    {
        $this->check_login();
        if (isset($id) && is_numeric($id)) {

            $this->load->model("AdminMessageModel");
            $data['message'] = $this->AdminMessageModel->get_message($id);

            $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
            $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


            if ($data['message'])
                $this->load->view('mailbox/admin_read_mail', $data);
            else
                redirect(site_url("AdminMessageController/"));
        } else
            redirect(site_url("AdminMessageController/"));
    }

}
