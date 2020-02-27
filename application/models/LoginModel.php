<?php

class LoginModel extends CI_Model
{

    const TABLE_ADMIN_LOGIN = 'tbl_admin_login';
    const TABLE_EMPLOYEE_LOGIN = 'tbl_employee_details';
    const TABLE_STUDENT_LOGIN = 'tbl_student_details';
    const TABLE_PARENT_LOGIN = 'tbl_parent_login';


    //EVENT TABLE FUNCTIONS
    public function add_admin($data)
    {
        $this->db->insert($this::TABLE_ADMIN_LOGIN, $data);
        return $this->db->insert_id();
    }

    public function delete_admin($id)
    {
        $this->db->where("AdminID", $id);
        return $this->db->delete($this::TABLE_ADMIN_LOGIN);
    }

    public function get_admin_where($admin)
    {
        $check = array(
            "Username" => $admin
        );
        $this->db->select("*")->from($this::TABLE_ADMIN_LOGIN)->where($check)->limit(1);
        $admin = $this->db->get();

        if ($admin->num_rows() > 0)
            return TRUE;

        return FALSE;
    }

    public function admin_login($admin)
    {
        $check = array(
            "Username" => $admin['Username'],
            "Password" => $admin['Password']
        );
        $this->db->select("*")->from($this::TABLE_ADMIN_LOGIN)->where($check)->limit(1);
        $admin = $this->db->get();

        if ($admin->num_rows() > 0)
            return TRUE;

        return FALSE;
    }

    public function check_session_username($username)
    {
        $this->db->where("Username", $username);
        $this->db->select("*")->from($this::TABLE_ADMIN_LOGIN)->limit(1);
        $admin = $this->db->get();

        if ($admin->num_rows() > 0)
            return TRUE;

        return FALSE;
    }


    public function employee_login($loginID)
    {
        $check = array(
            "LoginID" => $loginID['LoginID'],
            "Password" => $this->encrypt($loginID['Password'])
        );
        $this->db->select("*")->from($this::TABLE_EMPLOYEE_LOGIN)->where($check)->limit(1);
        $admin = $this->db->get();

        if ($admin->num_rows() > 0)
            return TRUE;

        return FALSE;
    }

    public function get_employee_where($loginID)
    {
        $check = array(
            "LoginID" => $loginID
        );
        $this->db->select("*")->from($this::TABLE_EMPLOYEE_LOGIN)->where($check)->limit(1);
        $admin = $this->db->get();

        if ($admin->num_rows() > 0)
            return TRUE;

        return FALSE;
    }


    public function get_parent_where($loginID)
    {
        $this->db->where("LoginID", $loginID);
        $this->db->select("*")->from($this::TABLE_PARENT_LOGIN)->limit(1);
        $admin = $this->db->get();
        return $admin->result_array();
    }

    public function get_student_where($loginID)
    {
        $check = array(
            "LoginID" => $loginID
        );
        $this->db->select("*")->from($this::TABLE_STUDENT_LOGIN)->where($check)->limit(1);
        $admin = $this->db->get();

        if ($admin->num_rows() > 0)
            return TRUE;

        return FALSE;
    }

    public function student_login($loginID)
    {
        $check = array(
            "LoginID" => $loginID['LoginID'],
            "Password" => $this->encrypt($loginID['Password'])
        );
        $this->db->select("*")->from($this::TABLE_STUDENT_LOGIN)->where($check)->limit(1);
        $admin = $this->db->get();

        if ($admin->num_rows() > 0)
            return TRUE;

        return FALSE;
    }


    public function get_admin_id($login)
    {
        $this->db->select("*")->from($this::TABLE_ADMIN_LOGIN)->where("Username", $login)->limit(1);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function get_student_id($login)
    {
        $this->db->select("*")->from($this::TABLE_STUDENT_LOGIN)->where("LoginID", $login)->limit(1);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function get_employee_id($login)
    {
        $this->db->select("*")->from($this::TABLE_EMPLOYEE_LOGIN)->where("LoginID", $login)->limit(1);
        $result = $this->db->get();
        return $result->result_array();
    }


    public function get_employee($login)
    {
        $this->db->select("*")->from($this::TABLE_EMPLOYEE_LOGIN)->where("LoginID", $login)->limit(1);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function admin_change_password($adminID, $pass)
    {
        $this->db->where("AdminID", $adminID);
        return $this->db->update($this::TABLE_ADMIN_LOGIN, array(
            "Password" => $pass
        ));
    }

    public function student_change_password($studentID, $pass)
    {
        $this->db->where("StudentID", $studentID);
        return $this->db->update($this::TABLE_STUDENT_LOGIN, array(
            "Password" => $pass
        ));
    }

    public function employee_change_password($employeeID, $pass)
    {
        $this->db->where("EmployeeID", $employeeID);
        return $this->db->update($this::TABLE_EMPLOYEE_LOGIN, array(
            "Password" => $pass
        ));
    }

    public function encrypt($str)
    {

        return sha1(md5(sha1(md5($str))));
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

    //FORGOT PASSWORD FUNCTIONS
    public function send_admin_link($username)
    {

        $this->db->select('*')->from($this::TABLE_ADMIN_LOGIN)->where("Username", $username);


        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $randNumber = mt_rand(100000, 999999);
            $_SESSION['forgot'] = $randNumber;


            $url = site_url("Login/forgot_password/" . $randNumber);


            $message = "If You Have Forgotten Your Password Click on The Link To Reset Your Password . Please Note Open this Link only in the Browser you Requested Link from  . Link : ";

            $message .= $url;


            $admin = $result->result_array();
            $mobile = $admin[0]['Contact'];
            $email = $admin[0]['Email'];

            $_SESSION['forgot_username'] = $admin[0]['Username'];

            $this->send_sms($mobile, $message);
            $this->send_forgot_email($email, $message);

            return TRUE;
        } else
            return FALSE;
    }


    public function send_employee_link($loginID)
    {

        $this->db->select('*')->from($this::TABLE_EMPLOYEE_LOGIN)->where("LoginID", $loginID)->limit(1);


        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $randNumber = mt_rand(100000, 999999);
            $_SESSION['employee_forgot'] = $randNumber;


            $url = site_url("TeacherLogin/forgot_password/" . $randNumber);


            $message = "If You Have Forgotten Your Password Click on The Link To Reset Your Password . Please Note Open this Link only in the Browser you Requested Link from  . Link : ";

            $message .= $url;


            $this->load->model('HRModel');

            $emp = $result->result_array();

            $employee = $this->HRModel->get_employee_where_id($emp[0]['EmployeeID']);

            $flag = 0;


            if (isset($employee[0]['Email']) && !empty(isset($employee[0]['Email']))) {
                $email = $employee[0]['Email'];
                $this->send_forgot_email($email, $message);
            } else {
                echo "<script>alert('No Email ID set while Registration . Contact The Admin')</script>";
                $flag++;

            }
            if (isset($employee[0]['Contact']) && !empty($employee[0]['Contact'])) {
                $mobile = $employee[0]['Contact'];
                $this->send_sms($mobile, $message);
            } else {
                echo "<script>alert('No Contact Number set while Registration . Contact The Admin')</script>";
                $flag++;
            }

            $_SESSION['forgot_teacher_username'] = $emp[0]['LoginID'];


            if ($flag < 2)
                return TRUE;

            return FALSE;

        } else
            return FALSE;
    }


    public function send_student_link($loginID)
    {

        $this->db->select('*')->from($this::TABLE_STUDENT_LOGIN)->where("LoginID", $loginID)->limit(1);


        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $randNumber = mt_rand(100000, 999999);
            $_SESSION['student_forgot'] = $randNumber;


            $url = site_url("StudentLogin/forgot_password/" . $randNumber);


            $message = "If You Have Forgotten Your Password Click on The Link To Reset Your Password . Please Note Open this Link only in the Browser you Requested Link from  . Link : ";

            $message .= $url;


            $this->load->model('StudentModel');

            $stu = $result->result_array();

            $student = $this->StudentModel->get_student_where_id($stu[0]['StudentID']);

            $flag = 0;

            if (isset($student[0]['Email']) && !empty($student[0]['Email'])) {
                $email = $student[0]['Email'];
                $this->send_forgot_email($email, $message);
            } else {
                echo "<script>alert('No Email ID set while Registration . Contact The Admin')</script>";
                $flag++;

            }
            if (isset($student[0]['Contact']) && !empty($student[0]['Contact'])) {
                $mobile = $student[0]['Contact'];
                $this->send_sms($mobile, $message);
            } else {
                echo "<script>alert('No Contact Number set while Registration . Contact The Admin')</script>";
                $flag++;
            }

            $_SESSION['forgot_student_username'] = $stu[0]['LoginID'];


            if ($flag < 2)
                return TRUE;

            return FALSE;
        } else
            return FALSE;
    }


    public function send_forgot_email($email, $message)
    {
        $from_email = "www.sbssrinagar.com";
        $to_email = $email;
        $message = "    <html>
                                        <head>
                                        <title>Forgot Password</title>
                                        </head>
                                        <body>
                                        " . $message . "
                                        </body>
                                        </html>";
        //Load email library
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->from($from_email, 'SBS MANAGER');
        $this->email->to($to_email);
        $this->email->subject('Forgot Password');
        $this->email->message($message);

        //Send mail
        $this->email->send();
    }


} 