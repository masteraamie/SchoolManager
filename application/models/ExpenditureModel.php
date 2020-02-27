<?php

class ExpenditureModel extends CI_Model
{

    const TABLE_EXPENDITURE = 'tbl_expenditures';


    //BUS TABLE FUNCTIONS
    public function add_expenditure($data)
    {
        $date_format = DateTime::createFromFormat("Y-m-d", $data['Date']);


        $month = $date_format->format('m');
        $year = $date_format->format('Y');


        $data['Month'] = $month;
        $data['Year'] = $year;

        $this->db->insert($this::TABLE_EXPENDITURE, $data);
        return $this->db->insert_id();
    }

    public function update_expenditure($data, $id)
    {
        $this->db->where("ExpenditureID", $id);
        return $this->db->update($this::TABLE_EXPENDITURE, $data);
    }

    public function delete_expenditure($id)
    {
        $this->db->where("ExpenditureID", $id);
        return $this->db->delete($this::TABLE_EXPENDITURE);
    }

    public function get_expenditures($offset = 0)
    {
        $this->db->select("*")->from($this::TABLE_EXPENDITURE)->order_by("ExpenditureID", "asc")->limit(10)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_expenditure_where($id)
    {
        $this->db->select("*")->from($this::TABLE_EXPENDITURE)->where("ExpenditureID", $id);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_expenditure_where_month($month, $year)
    {
        $this->db->where("Month", $month);
        $this->db->where("Year", $year);
        $this->db->select("*")->from($this::TABLE_EXPENDITURE)->order_by("ExpenditureID", "desc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_expenditures_count()
    {
        $this->db->select("*")->from($this::TABLE_EXPENDITURE)->order_by("ExpenditureID", "asc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_expenditure_month()
    {
        $this->db->where("Month", date('m'));
        $this->db->where("Year", date('Y'));
        $this->db->select("*")->from($this::TABLE_EXPENDITURE);
        $classes = $this->db->get();
        $expenses = $classes->result_array();

        $total = 0;
        foreach ($expenses as $e) {
            $total += $e['Amount'];
        }
        return $total;
    }
} 