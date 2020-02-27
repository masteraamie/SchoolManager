<?php

class EventModel extends CI_Model
{

    const TABLE_EVENT_TYPE = 'tbl_event_type';
    const TABLE_EVENT = 'tbl_events';

    //EVENT TYPE TABLE FUNCTIONS
    public function add_event_type($data)
    {
        $this->db->insert($this::TABLE_EVENT_TYPE, $data);
        return $this->db->insert_id();
    }

    public function update_event_type($data)
    {
        $this->db->where("EventTypeID", $data['EventTypeID']);
        return $this->db->update($this::TABLE_EVENT_TYPE, array(
            "Type" => $data['Type']
        ));
    }

    public function delete_event_type($id)
    {
        $this->db->where("EventTypeID", $id);
        return $this->db->delete($this::TABLE_EVENT_TYPE);
    }

    public function get_event_types()
    {
        $this->db->select("*")->from($this::TABLE_EVENT_TYPE)->order_by("EventTypeID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_event_type_where($id)
    {
        $this->db->select("*")->from($this::TABLE_EVENT_TYPE)->where("EventTypeID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    //EVENT TABLE FUNCTIONS
    public function add_event($data)
    {
        $this->db->insert($this::TABLE_EVENT, $data);
        return $this->db->insert_id();
    }

    public function update_event($data, $id)
    {
        $this->db->where("EventID", $id);
        return $this->db->update($this::TABLE_EVENT, $data);
    }

    public function delete_event($id)
    {
        $this->db->where("EventID", $id);
        return $this->db->delete($this::TABLE_EVENT);
    }

    public function get_events()
    {
        $this->db->select("*")->from($this::TABLE_EVENT)->order_by("StartDate", "desc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_events_pagination($offset = 0, $per_page = 6)
    {
        $this->db->select("*")->from($this::TABLE_EVENT)->order_by("StartDate", "desc")->limit($per_page)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_event_count()
    {
        $this->db->select("*")->from($this::TABLE_EVENT)->order_by("StartDate", "desc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_event_where($id)
    {
        $this->db->select("*")->from($this::TABLE_EVENT)->where("EventID", $id);
        $classes = $this->db->get();

        return $classes->result_array();
    }
} 