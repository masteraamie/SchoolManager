<?php

class VisitModel extends CI_Model
{

    const TABLE_VISITS = 'tbl_visits';

    //visit TABLE FUNCTIONS
    public function add_visit($data)
    {
        $this->db->insert($this::TABLE_VISITS, $data);
        return $this->db->insert_id();
    }

    public function add_visit_photo($id, $data)
    {
        $this->db->where("VisitID", $id);
        return $this->db->update($this::TABLE_VISITS, array(
            "Image" => $data
        ));
    }

    public function update_visit($data, $id)
    {
        $this->db->where("VisitID", $id);
        return $this->db->update($this::TABLE_VISITS, $data);
    }

    public function delete_visit($id)
    {
        $this->db->where("VisitID", $id);
        return $this->db->delete($this::TABLE_VISITS);
    }

    public function get_visits($offset = 0, $per_page = 6)
    {
        $this->db->select("*")->from($this::TABLE_VISITS)->order_by("Date", "desc")->limit($per_page)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_visit_count()
    {
        $this->db->select("*")->from($this::TABLE_VISITS)->order_by("Date", "desc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_visit_where($id)
    {
        $this->db->select("*")->from($this::TABLE_VISITS)->where("VisitID", $id);
        $classes = $this->db->get();

        return $classes->result_array();
    }
} 