<?php

class SMSModel extends CI_Model
{

    const TABLE_PARENT_DETAILS = 'tbl_parent_details';
    const TABLE_STUDENT_DETAILS = 'tbl_student_details';
    const TABLE_EMPLOYEE_DETAILS = 'tbl_employee_details';

    //SMS FUNCTIONS
    public function sms_students($data)
    {

        if ($data['SectionID'] == 0 && $data['ClassID'] == 0) {

        } else {
            if ($data['SectionID'] == 0) {
                $this->db->where("ClassID", $data['ClassID']);
            } else {
                $this->db->where("ClassID", $data['ClassID']);
                $this->db->where("SectionID", $data['SectionID']);
            }
        }
        $this->db->select('*')->from($this::TABLE_STUDENT_DETAILS);

        $res = $this->db->get();

        $students = $res->result_array();


        $contacts = array();
        foreach ($students as $s) {
            $contacts[] = "91" . $s['Contact'];
        }

        $numbers = implode(",", $contacts);
        return $this->send_sms($numbers, $data['Message']);
    }


    public function sms_employees($data)
    {
        if ($data['DepartmentID'] == 0) {
        } else {
            $this->db->where("DepartmentID", $data['DepartmentID']);
        }

        $this->db->select('*')->from($this::TABLE_EMPLOYEE_DETAILS);

        $res = $this->db->get();

        $students = $res->result_array();

        $contacts = array();
        foreach ($students as $s) {
            $contacts[] = "91" . $s['Contact'];
        }

        $numbers = implode(",", $contacts);


        return $this->send_sms($numbers, $data['Message']);

    }


    public function send_sms($mobile, $message)
    {
        $username = 'masteraamie@gmail.com';
        $hash = '43278912da2733712991ab15a47a4a4f25a1ba3806d53d7cb01fc8a866cdc604';

        // Message details
        $numbers = "91" . $mobile;
        $sender = urlencode('TXTLCL');
        $message = rawurlencode($message);


        // Prepare data for POST request
        $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        // Send the POST request with cURL
        $ch = curl_init('http://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
        //echo "<script>alert('$response');</script>";
    }
}