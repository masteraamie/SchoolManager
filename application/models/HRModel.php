<?php

class HRModel extends CI_Model
{
    const TABLE_DEPARTMENT = 'tbl_departments';
    const TABLE_DESIGNATION = 'tbl_designations';
    const TABLE_EMPLOYEE = 'tbl_employee_details';
    const TABLE_EMPLOYEE_LOGIN = 'tbl_employee_login';
    const TABLE_EMPLOYEE_ATTENDANCE = 'tbl_employee_attendance';
    const TABLE_LEAVE_TYPE = 'tbl_leave_types';
    const TABLE_MAX_LEAVES = 'tbl_max_leaves';

    //TABLE DEPARTMENT FUNCTION
    public function add_department($data)
    {
        $this->db->insert($this::TABLE_DEPARTMENT, $data);
        return $this->db->insert_id();
    }

    public function update_department($data)
    {
        $this->db->where("DepartmentID", $data['DepartmentID']);
        $result = $this->db->update($this::TABLE_DEPARTMENT, array(

            "Name" => $data['Name']

        ));
        return $result;
    }

    public function delete_department($id)
    {
        $this->db->where("DepartmentID", $id);
        $result = $this->db->delete($this::TABLE_DEPARTMENT);
        return $result;
    }

    public function get_departments()
    {
        $this->db->select("*")->from($this::TABLE_DEPARTMENT)->order_by("Name", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_department_where($id)
    {
        $this->db->select("*")->from($this::TABLE_DEPARTMENT)->where("DepartmentID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }


    //TABLE DESIGNATION FUNCTION
    public function add_designation($data)
    {
        $this->db->insert($this::TABLE_DESIGNATION, $data);
        return $this->db->insert_id();
    }

    public function update_designation($data)
    {
        $this->db->where("DesignationID", $data['DesignationID']);
        $result = $this->db->update($this::TABLE_DESIGNATION, array(

            "Name" => $data['Name']

        ));
        return $result;
    }

    public function get_designation_where($id)
    {
        $this->db->select("*")->from($this::TABLE_DESIGNATION)->where("DesignationID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function delete_designation($id)
    {
        if ($id > 7) {
            $this->db->where("DesignationID", $id);
            $result = $this->db->delete($this::TABLE_DESIGNATION);
            return $result;
        } else {
            echo "<script>alert('Cannot Delete This Item');</script>";
        }
    }

    public function get_designations()
    {
        $this->db->select("*")->from($this::TABLE_DESIGNATION)->order_by("DesignationID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_teacher_id()
    {
        $this->db->select("*")->from($this::TABLE_DESIGNATION)->where("Name", "Teacher")->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_accountant_id()
    {
        $this->db->select("*")->from($this::TABLE_DESIGNATION)->where("Name", "Accountant")->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_driver_id()
    {
        $this->db->select("*")->from($this::TABLE_DESIGNATION)->where("Name", "Driver")->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }


    //TABLE EMPLOYEE FUNCTIONS
    public function add_employee($data)
    {
        $this->db->insert($this::TABLE_EMPLOYEE, $data);
        $id = $this->db->insert_id();

        return $id;

    }

    public function set_leaves($id, $designation)
    {
        $this->db->where("DesignationID", $designation);
        $this->db->select("*")->from($this::TABLE_MAX_LEAVES)->limit(1);
        $leave = $this->db->get();
        $leaves = $leave->result_array();


        if ($leaves) {
            $this->db->where("EmployeeID", $id);
            $this->db->update($this::TABLE_EMPLOYEE, array(
                "Leaves" => $leaves[0]['LeaveCount']
            ));
        } else {
            $this->db->where("EmployeeID", $id);
            $this->db->update($this::TABLE_EMPLOYEE, array(
                "Leaves" => 0
            ));
        }

    }

    public function update_employee($data, $id)
    {
        $this->db->where("EmployeeID", $id);
        $result = $this->db->update($this::TABLE_EMPLOYEE, $data);
        return $result;
    }

    public function add_employee_photo($id, $file)
    {
        $this->db->where('EmployeeID', $id);
        $this->db->update($this::TABLE_EMPLOYEE, array(
            "Photo" => $file
        ));
    }

    public function add_employee_doc($id, $file)
    {
        $this->db->where('EmployeeID', $id);
        $this->db->update($this::TABLE_EMPLOYEE, array(
            "QualificationDoc" => $file
        ));
    }

    public function add_employee_login($data)
    {
        $this->db->insert($this::TABLE_EMPLOYEE_LOGIN, $data);
        return $this->db->insert_id();
    }

    public function get_employees()
    {
        $this->db->select("*")->from($this::TABLE_EMPLOYEE)->order_by("EmployeeID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_last_id()
    {
        $this->db->select("*")->from($this::TABLE_EMPLOYEE)->order_by("EmployeeID", "desc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_employees_attendance($data)
    {
        $this->db->where($data);
        $this->db->select("*")->from($this::TABLE_EMPLOYEE_ATTENDANCE);
        $attendance = $this->db->get();

        return $attendance->result_array();

    }

    public function get_attendance_where($data, $status)
    {
        $this->db->where($data);
        $this->db->where("Status", $status);
        $this->db->select("*")->from($this::TABLE_EMPLOYEE_ATTENDANCE);
        $attendance = $this->db->get();

        return $attendance->num_rows();

    }

    public function get_employees_count()
    {
        $this->db->select("*")->from($this::TABLE_EMPLOYEE)->order_by("EmployeeID", "asc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_teachers()
    {
        $teacherID = $this->get_teacher_id();

        $this->db->select("*")->from($this::TABLE_EMPLOYEE)->where('DesignationID', $teacherID[0]['DesignationID'])->order_by("EmployeeID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_drivers()
    {
        $driverID = $this->get_driver_id();

        $this->db->select("*")->from($this::TABLE_EMPLOYEE)->where('DesignationID', $driverID[0]['DesignationID'])->order_by("EmployeeID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_employee_where_id($id)
    {
        $this->db->select("*")->from($this::TABLE_EMPLOYEE)->where("EmployeeID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_employees_where_dept($deptID)
    {
        $this->db->select("*")->from($this::TABLE_EMPLOYEE)->where("DepartmentID", $deptID)->order_by("EmployeeID", "asc");
        $sections = $this->db->get();
        return $sections->result_array();
    }


    //TABLE LEAVE TYPE FUNCTIONS
    public function add_leave_type($data)
    {
        $this->db->insert($this::TABLE_LEAVE_TYPE, $data);
        return $this->db->insert_id();
    }

    public function update_leave_type($data)
    {
        $this->db->where("LeaveTypeID", $data['LeaveTypeID']);
        $result = $this->db->update($this::TABLE_LEAVE_TYPE, array(
            'Type' => $data['Type']
        ));
        return $result;
    }

    public function delete_leave_type($data)
    {
        $this->db->where("LeaveTypeID", $data['LeaveTypeID']);
        $result = $this->db->delete($this::TABLE_LEAVE_TYPE);
        return $result;
    }

    public function get_leave_types()
    {
        $this->db->select("*")->from($this::TABLE_LEAVE_TYPE)->order_by("LeaveTypeID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_leave_type_where($id)
    {
        $this->db->select("*")->from($this::TABLE_LEAVE_TYPE)->where("LeaveTypeID", $id);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function add_max_leaves($data)
    {
        $this->db->insert($this::TABLE_MAX_LEAVES, $data);
        $id = $this->db->insert_id();

        return $id;

    }

    public function update_max_leaves($data)
    {
        $this->db->where("DesignationID", $data['DesignationID']);
        $result = $this->db->update($this::TABLE_MAX_LEAVES, array(
            "LeaveCount" => $data['LeaveCount']
        ));

        return $result;
    }

    public function get_max_leave_where($id)
    {
        $this->db->select("*")->from($this::TABLE_MAX_LEAVES)->where("DesignationID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_max_leaves()
    {
        $this->db->select("*")->from($this::TABLE_MAX_LEAVES)->order_by("DesignationID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_employee_id_where_login($login)
    {
        $compare = array(
            "LoginID" => $login
        );
        $this->db->select("*")->from($this::TABLE_EMPLOYEE_LOGIN)->where($compare)->limit(1);
        $employee = $this->db->get();
        return $employee->result_array();

    }


    public function do_employee_attendance($data)
    {

        if ($data['Status'] == 'A') {


            $this->db->where("EmployeeID", $data['EmployeeID']);
            $this->db->select("*")->from($this::TABLE_EMPLOYEE)->limit(1);

            $r = $this->db->get();
            $leaves = $r->result_array();

            if ($leaves) {

                $leave_left = $leaves[0]['Leaves'];

                $leave_left--;

                if ($leave_left < 5) {
                    //send alert SMS
                    $from_email = "www.sbssrinagar.com";
                    $to_email = $leaves[0]['Email'];
                    $message = "    <html>
                                        <head>
                                        <title>Leave Alert</title>
                                        </head>
                                        <body>
                                        <table>
                                        <tr>
                                        <th>Employee</th>
                                        <th>Leaves Left</th>
                                        </tr>
                                        <tr>
                                        <td>" . $leaves[0]['FirstName'] . "  " . $leaves[0]['MiddleName'] . " " . $leaves[0]['LastName'] . "</td>
                                        <td>$leave_left</td>
                                        </tr>
                                        </table>
                                        </body>
                                        </html>";
                    //Load email library
                    $this->load->library('email');
                    $this->email->set_mailtype("html");
                    $this->email->from($from_email, 'SBS MANAGER');
                    $this->email->to($to_email);
                    $this->email->subject('Leave Alert');
                    $this->email->message($message);

                    //Send mail
                    $this->email->send();

                    $message = "Leave Alert !! You have only " . $leave_left . " leaves left";
                    $this->send_sms($leaves[0]['Contact'], $message);
                }
            }

            $this->db->where("EmployeeID", $data['EmployeeID']);
            $this->db->update($this::TABLE_EMPLOYEE, array(
                "Leaves" => $leave_left
            ));


        }

        $where = "(Date = '" . $data['Date'] . "' AND EmployeeID = " . $data['EmployeeID'] . ")";
        $this->db->select('*')->from($this::TABLE_EMPLOYEE_ATTENDANCE)->where($where);
        $exists = $this->db->get();


        if ($exists->num_rows() > 0) {
            $this->db->where($where);
            $this->db->update($this::TABLE_EMPLOYEE_ATTENDANCE, array(
                "Status" => $data['Status']
            ));


            return "success";
        } else {
            $this->db->insert($this::TABLE_EMPLOYEE_ATTENDANCE, $data);
            return "success";
        }

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
        echo "<script>alert('$response');</script>";
    }

    public function upload_excel_attendance($data)
    {
        if ($this->db->insert_batch($this::TABLE_EMPLOYEE_ATTENDANCE, $data)) {
            return TRUE;
        }
        return FALSE;
    }


}