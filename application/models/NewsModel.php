<?php

class NewsModel extends CI_Model
{

    const TABLE_NEWS = 'tbl_news';

    //news TABLE FUNCTIONS
    public function add_news($data)
    {
        $this->db->insert($this::TABLE_NEWS, $data);
        return $this->db->insert_id();
    }

    public function add_news_photo($id, $data)
    {
        $this->db->where("NewsID", $id);
        return $this->db->update($this::TABLE_NEWS, array(
            "Image" => $data
        ));
    }

    public function update_news($data, $id)
    {
        $this->db->where("NewsID", $id);
        return $this->db->update($this::TABLE_NEWS, $data);
    }

    public function delete_news($id)
    {
        $this->db->where("NewsID", $id);
        return $this->db->delete($this::TABLE_NEWS);
    }

    public function get_news($offset = 0, $per_page = 6)
    {
        $this->db->select("*")->from($this::TABLE_NEWS)->order_by("Date", "desc")->limit($per_page)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_news_count()
    {
        $this->db->select("*")->from($this::TABLE_NEWS)->order_by("Date", "desc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_news_where($id)
    {
        $this->db->select("*")->from($this::TABLE_NEWS)->where("NewsID", $id);
        $classes = $this->db->get();

        return $classes->result_array();
    }
} 