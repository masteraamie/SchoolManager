<?php

class AchievementModel extends CI_Model
{

    const TABLE_ACHIEVEMENT = 'tbl_achievements';

    //Achievement TABLE FUNCTIONS
    public function add_achievement($data)
    {
        $this->db->insert($this::TABLE_ACHIEVEMENT, $data);
        return $this->db->insert_id();
    }

    public function add_achievement_photo($id, $data)
    {
        $this->db->where("AchievementID", $id);
        return $this->db->update($this::TABLE_ACHIEVEMENT, array(
            "Image" => $data
        ));
    }

    public function update_achievement($data, $id)
    {
        $this->db->where("AchievementID", $id);
        return $this->db->update($this::TABLE_ACHIEVEMENT, $data);
    }

    public function delete_achievement($id)
    {
        $this->db->where("AchievementID", $id);
        return $this->db->delete($this::TABLE_ACHIEVEMENT);
    }

    public function get_achievements($offset = 0, $per_page = 6)
    {
        $this->db->select("*")->from($this::TABLE_ACHIEVEMENT)->order_by("Date", "desc")->limit($per_page)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_achievement_count()
    {
        $this->db->select("*")->from($this::TABLE_ACHIEVEMENT)->order_by("Date", "desc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_achievement_where($id)
    {
        $this->db->select("*")->from($this::TABLE_ACHIEVEMENT)->where("AchievementID", $id);
        $classes = $this->db->get();

        return $classes->result_array();
    }
} 