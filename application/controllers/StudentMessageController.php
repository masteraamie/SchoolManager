<?php

class StudentMessageController extends CI_Controller
{


    public function index()
    {
        redirect(site_url() . 'StudentDashboard/');
    }

    public function check_login()
    {
        if ($this->session->has_userdata('student_username') && $this->session->has_userdata('student_login_time')) {
        } else {
            redirect(site_url("StudentLogin/"));
        }
    }


    public function student_compose()
    {
        $this->check_login();
        $data = array();


        $this->load->model('StudentMessageModel');


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
                'Date' => date("D/M/y"),
                'SenderStudentID' => $_SESSION['student_username']
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
                    $data['success'] = $this->StudentMessageModel->send_message_to_teacher($message);
                } else if ($check && ($type == 2)) {
                    $message['StudentID'] = $receiver;
                    $data['success'] = $this->StudentMessageModel->send_message_to_student($message);
                } else if ($check && ($type == 3)) {
                    $data['success'] = $this->StudentMessageModel->send_message_to_parent($message);
                } else if ($check && ($type == 4)) {
                    $data['success'] = $this->StudentMessageModel->send_message_to_admin($message);
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

        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view("mailbox/student_compose", $data);

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
        } else if ($type == 4) {
            $this->load->model("LoginModel");
            $student = $this->LoginModel->get_admin_where($id);
            if ($student) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function admin_inbox()
    {
        $this->check_login();
        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $data['messages'] = $this->StudentMessageModel->get_messages($_SESSION['student_username'], "ADMIN");
        $this->load->view('mailbox/student_mailbox', $data);

    }

    public function student_inbox()
    {
        $this->check_login();
        $this->load->model("StudentMessageModel");

        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;


        $data['messages'] = $this->StudentMessageModel->get_messages($_SESSION['student_username'], "STUDENT");
        $this->load->view('mailbox/student_mailbox', $data);

    }

    public function parent_inbox()
    {
        $this->check_login();
        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['messages'] = $this->StudentMessageModel->get_messages($_SESSION['student_username'], "PARENT");
        $this->load->view('mailbox/student_mailbox', $data);

    }

    public function teacher_inbox()
    {
        $this->check_login();
        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $data['messages'] = $this->StudentMessageModel->get_messages($_SESSION['student_username'], "TEACHER");
        $this->load->view('mailbox/student_mailbox', $data);

    }

    public function read_mail($id = "")
    {
        $this->check_login();
        $this->load->model("StudentMessageModel");
        $data['unread_messages'] = $this->StudentMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        if (isset($id) && is_numeric($id)) {
            $data['message'] = $this->StudentMessageModel->get_message($id);

            if ($data['message'])
                $this->load->view('mailbox/student_read_mail', $data);
            else
                redirect(site_url("StudentMessageController/"));
        } else
            redirect(site_url("StudentMessageController/"));
    }

}
