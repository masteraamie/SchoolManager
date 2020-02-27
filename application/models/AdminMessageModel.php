<?php

class AdminMessageModel extends CI_Model
{

    const TABLE_ADMIN_MESSAGES = 'tbl_admin_messages';
    const TABLE_TEACHER_MESSAGES = 'tbl_teacher_messages';
    const TABLE_PARENT_MESSAGES = 'tbl_parent_messages';
    const TABLE_STUDENT_MESSAGES = 'tbl_student_messages';

    //ADMIN MESSAGES TABLE FUNCTIONS
    public function send_message_to_teacher($data)
    {
        $this->db->insert($this::TABLE_TEACHER_MESSAGES, $data);
        return $this->db->insert_id();
    }

    public function send_message_to_student($data)
    {
        $this->db->insert($this::TABLE_STUDENT_MESSAGES, $data);
        return $this->db->insert_id();
    }

    public function send_message_to_parent($data)
    {
        $this->db->insert($this::TABLE_PARENT_MESSAGES, $data);
        return $this->db->insert_id();
    }

    public function get_messages($id, $inbox)
    {
        if ($inbox == "TEACHER") {
            $check = array(
                "SenderTeacherID !=" => '0'
            );
            $this->db->select('*')->from($this::TABLE_ADMIN_MESSAGES)->where($check);
        } elseif ($inbox == "STUDENT") {
            $check = array(
                "SenderStudentID !=" => '0'
            );
            $this->db->select('*')->from($this::TABLE_ADMIN_MESSAGES)->where($check);
        } elseif ($inbox == "PARENT") {
            $check = array(
                "SenderParentID !=" => '0'
            );
            $this->db->select('*')->from($this::TABLE_ADMIN_MESSAGES)->where($check);
        } else {
            return NULL;
        }
        $messages = $this->db->get();

        return $messages->result_array();
    }

    public function get_message($id)
    {
        $check = array(
            "MessageID" => $id,
        );
        $this->db->select('*')->from($this::TABLE_ADMIN_MESSAGES)->where($check)->limit(1);
        $messages = $this->db->get();

        if ($messages->num_rows() > 0) {
            $this->db->where($check);
            $this->db->update($this::TABLE_ADMIN_MESSAGES, array(
                "Status" => "1"
            ));
        }

        return $messages->result_array();
    }

    public function get_unread_messages()
    {
        $check = array(
            "Status" => 0,
        );
        $this->db->select('*')->from($this::TABLE_ADMIN_MESSAGES)->where($check)->limit(4);
        $messages = $this->db->get();

        if ($messages->num_rows() > 0) {
            return $messages->result_array();
        }

        return 0;
    }

    public function get_unread_messages_count()
    {
        $check = array(
            "Status" => 0,
        );
        $this->db->select('*')->from($this::TABLE_ADMIN_MESSAGES)->where($check);
        $messages = $this->db->get();

        return $messages->num_rows();
    }


} 