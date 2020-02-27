<?php

class TransportModel extends CI_Model
{

    const TABLE_BUSES = 'tbl_buses';
    const TABLE_STUDENT_DETAILS = 'tbl_student_details';
    const TABLE_ROUTES = 'tbl_routes';
    const TABLE_STOPS = 'tbl_bus_stops';
    const TABLE_ROUTE_ALLOCATION = 'tbl_route_allocation';

    //BUS TABLE FUNCTIONS
    public function add_bus($data)
    {
        $this->db->insert($this::TABLE_BUSES, $data);
        return $this->db->insert_id();
    }

    public function update_bus($data, $id)
    {
        $this->db->where("BusID", $id);
        return $this->db->update($this::TABLE_BUSES, $data);
    }

    public function delete_bus($id)
    {
        $this->db->where("BusID", $id);
        return $this->db->delete($this::TABLE_BUSES);
    }

    public function get_buses()
    {
        $this->db->select("*")->from($this::TABLE_BUSES)->order_by("BusID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_bus_where($id)
    {
        $this->db->select("*")->from($this::TABLE_BUSES)->where("BusID", $id);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    //BUS ROUTE TABLE FUNCTIONS
    public function add_route($data)
    {
        $this->db->insert($this::TABLE_ROUTES, $data);
        return $this->db->insert_id();
    }

    public function update_route($data, $id)
    {
        $this->db->where("RouteID", $id);
        return $this->db->update($this::TABLE_ROUTES, $data);
    }

    public function delete_route($id)
    {
        $this->db->where("RouteID", $id);
        return $this->db->delete($this::TABLE_ROUTES);
    }

    public function get_routes()
    {
        $this->db->select("*")->from($this::TABLE_ROUTES)->order_by("RouteID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_route_where($id)
    {
        $this->db->select("*")->from($this::TABLE_ROUTES)->where("RouteID", $id);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function add_route_allocation($data)
    {
        if ($this->get_route_allocation_where($data['BusID'])) {
            $this->update_route_allocation($data);
        } else {
            $this->db->insert($this::TABLE_ROUTE_ALLOCATION, $data);
            return $this->db->insert_id();
        }
    }

    public function update_route_allocation($data)
    {
        $this->db->where("BusID", $data['BusID']);
        return $this->db->update($this::TABLE_ROUTE_ALLOCATION,
            array(
                "RouteID" => $data['RouteID']
            ));
    }

    public function get_route_allocations()
    {
        $this->db->select("*")->from($this::TABLE_ROUTE_ALLOCATION)->order_by("RouteID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_route_allocation_where($id)
    {
        $this->db->select("*")->from($this::TABLE_ROUTE_ALLOCATION)->where("BusID", $id);
        $classes = $this->db->get();

        if ($classes->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }


    public function allocate_bus($data)
    {
        if ($data['BusID'] != 0) {
            $this->db->where("BusID", $data['BusID']);
            $this->db->select('*')->from($this::TABLE_ROUTE_ALLOCATION)->limit(1);

            $r = $this->db->get();

            $route = $r->result_array();

            $data['RouteID'] = $route[0]['RouteID'];


            $this->db->where("StudentID", $data['StudentID']);
            return $this->db->update($this::TABLE_STUDENT_DETAILS, array(

                "BusID" => $data['BusID'],
                "RouteID" => $data['RouteID']

            ));
        } else {
            $this->db->where("StudentID", $data['StudentID']);
            return $this->db->update($this::TABLE_STUDENT_DETAILS, array(

                "BusID" => 0,
                "RouteID" => 0

            ));
        }

    }

    //BUS STOP TABLE FUNCTIONS
    public function add_stop($data)
    {
        $this->db->insert($this::TABLE_STOPS, $data);
        return $this->db->insert_id();
    }

    public function update_stop($data, $id)
    {
        $this->db->where("StopID", $id);
        return $this->db->update($this::TABLE_STOPS, $data);
    }

    public function delete_stop($id)
    {
        $this->db->where("StopID", $id);
        return $this->db->delete($this::TABLE_STOPS);
    }

    public function get_stops()
    {
        $this->db->select("*")->from($this::TABLE_STOPS)->order_by("StopID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_stop_where($id)
    {
        $this->db->select("*")->from($this::TABLE_STOPS)->where("StopID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function allocate_stop($data)
    {
        if ($data['StopID'] != 0) {
            $this->db->where("StudentID", $data['StudentID']);
            return $this->db->update($this::TABLE_STUDENT_DETAILS, array(
                "StopID" => $data['StopID']
            ));
        } else {
            $this->db->where("StudentID", $data['StudentID']);
            return $this->db->update($this::TABLE_STUDENT_DETAILS, array(

                "StopID" => 0

            ));
        }

    }

} 
