<?php

class StudentModel extends CI_Model
{

    const TABLE_STUDENT_DETAILS = 'tbl_student_details';
    const TABLE_STUDENT_PREV_DETAILS = 'tbl_student_prev_details';
    const TABLE_STUDENT_ATTENDANCE = 'tbl_student_attendance';
    const TABLE_PARENT_DETAILS = 'tbl_parent_details';
    const TABLE_STUDENT_LOGIN = 'tbl_student_login';
    const TABLE_PARENT_LOGIN = 'tbl_parent_login';
    const TABLE_RESULT = 'tbl_results';


    public function loginid()
    {
        $this->db->select("*")->from($this::TABLE_STUDENT_DETAILS)->order_by("StudentID", "asc");

        $st = $this->db->get();


        $students = $st->result_array();


        foreach ($students as $s) {

            $this->db->where("StudentID", $s['StudentID']);
            $this->db->update($this::TABLE_STUDENT_DETAILS, array(
                "LoginID" => $s['RegistrationNumber']
            ));

        }


    }

    public function encrypt_pass()
    {
        $this->db->select("*")->from($this::TABLE_STUDENT_DETAILS);

        $r = $this->db->get();

        $students = $r->result_array();

        foreach ($students as $s) {
            $newPass = sha1(md5(sha1(md5($s['Password']))));
            $this->db->where("StudentID", $s['StudentID']);
            $this->db->update($this::TABLE_STUDENT_DETAILS, array(
                "Password" => $newPass
            ));
        }

    }

    public function commit()
    {
        $this->db->trans_commit();
    }

    public function roll_back()
    {
        $this->db->trans_rollback();
    }

    //STUDENT TABLE FUNCTIONS
    public function add_student($data)
    {

        $this->db->trans_begin();

        $this->db->insert($this::TABLE_STUDENT_DETAILS, $data);
        return $this->db->insert_id();

    }

    public function update_student($data, $id)
    {
        $this->db->where("StudentID", $id);
        return $this->db->update($this::TABLE_STUDENT_DETAILS, $data);
    }

    public function upgrade_student($data)
    {
        $this->db->where("StudentID", $data['StudentID']);
        return $this->db->update($this::TABLE_STUDENT_DETAILS, array(
            "ClassID" => $data['ClassID'],
            "SectionID" => $data['SectionID']
        ));
    }

    public function delete_student($id)
    {
        $this->db->where("StudentID", $id);
        return $this->db->delete($this::TABLE_STUDENT_DETAILS);
    }

    public function add_student_photo($id, $file)
    {
        $this->db->where('StudentID', $id);
        $this->db->update($this::TABLE_STUDENT_DETAILS, array(
            "Photo" => $file
        ));
    }

    public function add_birth_document($id, $file)
    {
        $this->db->where('StudentID', $id);
        $this->db->update($this::TABLE_STUDENT_DETAILS, array(
            "BirthCertificate" => $file
        ));
    }

    public function add_migration_document($id, $file)
    {
        $this->db->where('StudentID', $id);
        $this->db->update($this::TABLE_STUDENT_DETAILS, array(
            "MigrationCertificate" => $file
        ));
    }

    public function add_state_document($id, $file)
    {
        $this->db->where('StudentID', $id);
        $this->db->update($this::TABLE_STUDENT_DETAILS, array(
            "StateCertificate" => $file
        ));
    }

    public function get_students()
    {
        $this->db->select("*")->from($this::TABLE_STUDENT_DETAILS)->order_by("StudentID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_students_count()
    {
        $this->db->select("*")->from($this::TABLE_STUDENT_DETAILS)->order_by("StudentID", "asc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_student_where_id($id)
    {
        $this->db->select("*")->from($this::TABLE_STUDENT_DETAILS)->where("StudentID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_last_student()
    {
        $this->db->select("*")->from($this::TABLE_STUDENT_DETAILS)->order_by("StudentID", "desc");
        $student = $this->db->get();

        if ($student->num_rows() > 0) {
            $arr = $student->result_array();
            $arr = $arr[0]["StudentID"];
        } else
            $arr = 0;
        return $arr;
    }

    public function get_student_where($classID, $sectionID)
    {
        $compare = array(
            "ClassID" => $classID,
            "SectionID" => $sectionID
        );
        $this->db->select("*")->from($this::TABLE_STUDENT_DETAILS)->where($compare)->order_by("StudentID", "asc");
        $student = $this->db->get();
        return $student->result_array();

    }

    public function get_student_where_bus($busID)
    {
        $compare = array(
            "BusID" => $busID
        );
        $this->db->select("*")->from($this::TABLE_STUDENT_DETAILS)->where($compare)->order_by("StudentID", "asc");
        $student = $this->db->get();
        return $student->result_array();

    }

    public function validate_student($id)
    {
        $compare = array(
            "RegistrationNumber" => $id
        );
        $this->db->select("*")->from($this::TABLE_STUDENT_DETAILS)->where($compare)->order_by("StudentID", "asc");
        $student = $this->db->get();
        if ($student->num_rows() > 0) {
            return true;
        }
        return false;

    }

    public function check_student_where($classID, $sectionID, $roll)
    {
        $compare = array(
            "ClassID" => $classID,
            "SectionID" => $sectionID,
            "Roll" => $roll
        );
        $this->db->select("*")->from($this::TABLE_STUDENT_DETAILS)->where($compare)->order_by("StudentID", "asc");
        $student = $this->db->get();
        if ($student->num_rows() > 0) {
            return false;
        }
        return true;

    }

    public function do_student_attendance($data)
    {

        $where = "(Date = '" . $data['Date'] . "' AND StudentID = " . $data['StudentID'] . ")";
        $this->db->select('*')->from($this::TABLE_STUDENT_ATTENDANCE)->where($where);
        $exists = $this->db->get();
        if ($exists->num_rows() > 0) {
            $this->db->where($where);
            $this->db->update($this::TABLE_STUDENT_ATTENDANCE, array(
                "Status" => $data['Status']
            ));

            return "success";
        } else {
            $this->db->insert($this::TABLE_STUDENT_ATTENDANCE, $data);
            return "success";
        }

    }

    public function get_student_attendance_today()
    {

        $where = "(Date = '" . date('Y-m-d') . "' AND Status='P')";
        $this->db->select('*')->from($this::TABLE_STUDENT_ATTENDANCE)->where($where);
        $exists = $this->db->get();
        return $exists->num_rows();

    }

    public function get_student_attendance($data)
    {
        $this->db->where($data);
        $this->db->select("*")->from($this::TABLE_STUDENT_ATTENDANCE);
        $attendance = $this->db->get();

        return $attendance->result_array();

    }

    public function get_attendance_where($data, $status)
    {
        $this->db->where($data);
        $this->db->where("Status", $status);
        $this->db->select("*")->from($this::TABLE_STUDENT_ATTENDANCE);
        $attendance = $this->db->get();

        return $attendance->num_rows();

    }

    //PARENT TABLE FUNCTIONS
    public function add_parent_login($data)
    {
        $this->db->insert($this::TABLE_PARENT_LOGIN, $data);
        return $this->db->insert_id();
    }

    public function add_parent_photo($id, $file)
    {
        $this->db->where('StudentID', $id);
        $this->db->update($this::TABLE_STUDENT_DETAILS, array(
            "PPhoto" => $file
        ));
    }

    public function get_parent_where($id)
    {
        $this->db->select("*")->from($this::TABLE_PARENT_DETAILS)->where("StudentID", $id)->limit(1);
        $student = $this->db->get();
        return $student->result_array();

    }


    //RESULT TABLE FUNCTIONS
    public function add_result($data)
    {

        $this->db->where("ClassID", $data['ClassID']);
        $this->db->where("SubjectID", $data['SubjectID']);
        $this->db->where("ExamID", $data['ExamID']);
        $this->db->where("StudentID", $data['StudentID']);
        $this->db->select('*')->from($this::TABLE_RESULT)->limit(1);
        $exists = $this->db->get();
        if ($exists->num_rows() > 0) {
            $this->db->where("ClassID", $data['ClassID']);
            $this->db->where("SubjectID", $data['SubjectID']);
            $this->db->where("ExamID", $data['ExamID']);
            $this->db->where("StudentID", $data['StudentID']);
            $this->db->update($this::TABLE_RESULT, array(
                "Marks" => $data['Marks']
            ));

            return "success";
        } else {
            $this->db->insert($this::TABLE_RESULT, $data);
            return "success";
        }
    }

    public function get_student_result($classID, $studentID)
    {
        $compare = array(
            "ClassID" => $classID,
            "StudentID" => $studentID
        );
        $this->db->select("*")->from($this::TABLE_RESULT)->where($compare);
        $student = $this->db->get();
        return $student->result_array();

    }

} 