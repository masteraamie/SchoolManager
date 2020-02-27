<?php

class SMSController extends CI_Controller
{

    public function index()
    {
        $this->admin_login();
    }


    public function sms_students()
    {
        $data = array();

        $this->load->library('form_validation');
        $this->load->model("AcademicModel");

        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'class',
                    'label' => 'Class Name',
                    'rules' => 'trim|required'
                ),

                array(
                    'field' => 'section',
                    'label' => 'Section',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'message',
                    'label' => 'Message',
                    'rules' => 'trim|required'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $sms = array(

                'ClassID' => $this->input->post('class'),
                'SectionID' => $this->input->post('section'),
                'Message' => $this->input->post('message'),
            );

            $data['message'] = $sms['Message'];
            if ($this->form_validation->run() == FALSE) {
            } else {
                $this->load->model("SMSModel");
                $data['success'] = $this->SMSModel->sms_students($sms);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $data['message'] = "";
        }


        $data['classes'] = $this->AcademicModel->get_classes();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view("sms/SMSStudents", $data);
    }


    public function sms_employees()
    {
        $data = array();

        $this->load->library('form_validation');
        $this->load->model("HRModel");

        if ($_POST) {
            $rules = array(

                array(
                    'field' => 'department',
                    'label' => 'Department',
                    'rules' => 'trim|required'
                )
            );


            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters('<p class="alert alert-danger"><i class="fa fa-warning"></i>', '</p>');


            $sms = array(
                'DepartmentID' => $this->input->post('department'),
                'Message' => $this->input->post('message'),
            );

            $data['message'] = $sms['Message'];
            if ($this->form_validation->run() == FALSE) {
            } else {
                $this->load->model("SMSModel");
                $data['success'] = $this->SMSModel->sms_employees($sms);
                //echo "<script>alert('Class Added Successfully')   </script>";
            }

        } else {
            $data['message'] = "";
        }


        $data['departments'] = $this->HRModel->get_departments();

        $this->load->model("AdminMessageModel");
        $data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
        $data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

        $this->load->view("sms/SMSEmployees", $data);
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
}
