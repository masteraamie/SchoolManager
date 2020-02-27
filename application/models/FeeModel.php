<?php

class FeeModel extends CI_Model
{

    const TABLE_FEE_CATEGORY = 'tbl_fee_categories';
    const TABLE_FEE_ALLOCATE = 'tbl_fee_allocation';
    const TABLE_BUSFEE_ALLOCATE = 'tbl_busfee_allocation';
    const TABLE_PAYMENTS = 'tbl_fee_payments';
    const TABLE_LATE_FEE = 'tbl_late_fee';


    //FEE CATEGORY TABLE FUNCTIONS
    public function add_fee_category($data)
    {
        $this->db->insert($this::TABLE_FEE_CATEGORY, $data);
        return $this->db->insert_id();
    }

    public function update_fee_category($data)
    {
        $this->db->where("CategoryID", $data['CategoryID']);
        return $this->db->update($this::TABLE_FEE_CATEGORY, array(
            "Name" => $data['Name'],
            "Details" => $data['Details']
        ));
    }

    public function delete_fee_category($id)
    {
        $this->db->where("CategoryID", $id);
        return $this->db->delete($this::TABLE_FEE_CATEGORY);
    }

    public function get_fee_categories()
    {
        $this->db->select("*")->from($this::TABLE_FEE_CATEGORY)->order_by("CategoryID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_fee_category_where($id)
    {
        $this->db->select("*")->from($this::TABLE_FEE_CATEGORY)->where("CategoryID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    //FEE ALLOCATION TABLE FUNCTIONS
    public function allocate_fee($data)
    {
        if ($this->check_allocated_fee($data)) {
            $this->db->insert($this::TABLE_FEE_ALLOCATE, $data);
            return $this->db->insert_id();
        } else {
            return $this->update_allocate_fee($data);
        }
    }

    public function check_allocated_fee($data)
    {
        $this->db->where("ClassID", $data['ClassID']);
        $this->db->where("CategoryID", $data['CategoryID']);
        $this->db->select('*')->from($this::TABLE_FEE_ALLOCATE);

        $result = $this->db->get();

        if ($result->num_rows() > 0)
            return FALSE;
        else
            return TRUE;
    }

    public function get_allocated_fee()
    {
        $this->db->select('*')->from($this::TABLE_FEE_ALLOCATE);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function get_allocated_fee_where($classID, $categoryID)
    {
        $this->db->where("ClassID", $classID);
        $this->db->where("CategoryID", $categoryID);
        $this->db->select('*')->from($this::TABLE_FEE_ALLOCATE)->limit(1);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function update_allocate_fee($data)
    {
        $this->db->where("ClassID", $data['ClassID']);
        $this->db->where("CategoryID", $data['CategoryID']);
        return $this->db->update($this::TABLE_FEE_ALLOCATE, array(

            "CategoryID" => $data['CategoryID'],
            "Type" => $data['Type'],
            "Amount" => $data['Amount']

        ));
    }

    public function delete_allocate_fee($data)
    {
        $this->db->where("ClassID", $data['ClassID']);
        $this->db->where("CategoryID", $data['CategoryID']);
        return $this->db->delete($this::TABLE_FEE_ALLOCATE);
    }


    //BUS FEE ALLOCATIONS
    public function allocate_bus_fee($data)
    {
        if ($this->check_allocated_bus_fee_where($data['StopID'])) {
            $this->db->insert($this::TABLE_BUSFEE_ALLOCATE, $data);
            return $this->db->insert_id();
        } else {
            return $this->update_allocate_bus_fee($data);
        }

    }

    public function update_allocate_bus_fee($data)
    {
        $this->db->where("StopID", $data['StopID']);
        return $this->db->update($this::TABLE_BUSFEE_ALLOCATE, array(
            "CategoryID" => $data['CategoryID'],
            "Type" => $data['Type'],
            "Amount" => $data['Amount']
        ));
    }

    public function get_allocated_bus_fee_where($routeID)
    {
        $this->db->where("StopID", $routeID);
        $this->db->select('*')->from($this::TABLE_BUSFEE_ALLOCATE)->limit(1);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function check_allocated_bus_fee_where($routeID)
    {
        $this->db->where("StopID", $routeID);
        $this->db->select('*')->from($this::TABLE_BUSFEE_ALLOCATE)->limit(1);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_allocated_bus_fee()
    {
        $this->db->select('*')->from($this::TABLE_BUSFEE_ALLOCATE);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function calculate_late_fee()
    {
        $this->db->select("*")->from($this::TABLE_LATE_FEE)->limit(1);

        $r = $this->db->get();

        $f = $r->result_array();

        $day = $f[0]['Day'];


        $diff = date('d') - $day;

        if ($diff > 0) {
            $amount = $diff * $f[0]['Amount'];
            return $amount;
        }
        return 0;

    }


    //TABLE PAYMENTS FUNCTIONS
    public function add_payment($data)
    {
        $this->db->where("ReceiptID", $data['ReceiptID']);
        $this->db->select("*")->from($this::TABLE_PAYMENTS);

        $ex = $this->db->get();

        if ($ex->num_rows() > 0) {
            return 0;
        } else {

            $this->db->where("StudentID", $data['StudentID']);
            $this->db->where("Month", $data['Month']);
            $this->db->where("CategoryID", $data['CategoryID']);
            $this->db->where("Year", $data['Year']);
            $this->db->where("Status", 1);
            $this->db->select("*")->from($this::TABLE_PAYMENTS);

            $exist = $this->db->get();

              if($exist->num_rows() > 0)
              {
                  return 1;
              }
              else {
            $this->db->insert($this::TABLE_PAYMENTS, $data);
            return $this->db->insert_id() + 5;
            }
        }

    }

    public function get_last_payment()
    {
        $this->db->select('*')->from($this::TABLE_PAYMENTS)->order_by("PaymentID", 'desc')->limit(1);
        $last = $this->db->get();

        return $last->result_array();
    }


    //TABLE LATE FEE
    public function allocate_late_fee($fee)
    {
        $this->db->select("*")->from($this::TABLE_LATE_FEE);

        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $this->db->update($this::TABLE_LATE_FEE, array(
                "Amount" => $fee['Amount'],
                "Day" => $fee['Day']
            ));
        } else {
            $this->db->insert($this::TABLE_LATE_FEE, $fee);
            return $this->db->insert_id();
        }

    }

    public function get_late_fee()
    {
        $this->db->select("*")->from($this::TABLE_LATE_FEE);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function get_payments($offset = 0)
    {

        $this->db->select('*')->from($this::TABLE_PAYMENTS)->where("Status", 1)->order_by('PaymentID', 'desc')->limit(6)->offset($offset);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function get_payment_where($ID, $category)
    {

        $this->db->where("StudentID", $ID);
        $this->db->where("CategoryID", $category);
        $this->db->where("Status", 1);
        $this->db->select('*')->from($this::TABLE_PAYMENTS)->order_by("PaymentID", 'desc')->limit(1);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function get_payment_where_receipt($ID)
    {

        $this->db->where("ReceiptID", $ID);
        $this->db->select('*')->from($this::TABLE_PAYMENTS)->order_by("PaymentID", 'desc')->limit(1);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function get_payments_count()
    {

        $this->db->select('*')->from($this::TABLE_PAYMENTS)->where("Status", 1);
        $result = $this->db->get();

        return $result->num_rows();
    }

    public function get_student_payments($id, $offset = 0)
    {
        $this->db->where("Status", 1);
        $this->db->where("StudentID", $id);
        $this->db->select('*')->from($this::TABLE_PAYMENTS)->order_by('PaymentID', 'desc')->limit(6)->offset($offset);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function get_student_payments_count($id)
    {

        $this->db->where("Status", 1);
        $this->db->where("StudentID", $id);
        $this->db->select('*')->from($this::TABLE_PAYMENTS);
        $result = $this->db->get();

        return $result->num_rows();
    }

    public function get_payments_where($month = 0, $year = 0)
    {

        $this->db->where("Status", 1);

        $start = $year . "-" . $month . "-1";
        $end = $year . "-" . $month . "-31";

        $this->db->where("Date >=", $start);
        $this->db->where("Date <=", $end);


        $this->db->select('*')->from($this::TABLE_PAYMENTS);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function confirm_payment_receipt($receipt)
    {
        $this->db->where("ReceiptID", $receipt);
        $this->db->select('*')->from($this::TABLE_PAYMENTS);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {

            $this->db->where("ReceiptID", $receipt);
            return $this->db->update($this::TABLE_PAYMENTS, array(

                "Status" => 1

            ));
            return TRUE;
        }
        return FALSE;
    }


    public function add_last_payment($data)
    {
        $this->db->where("ReceiptID", $data['ReceiptID']);
        $this->db->select("*")->from($this::TABLE_PAYMENTS);

        $exist = $this->db->get();

        if ($exist->num_rows() > 0) {
            return 0;
        } else {

            $this->db->where("StudentID", $data['StudentID']);
            $this->db->where("Month >=", $data['Month']);
            $this->db->where("CategoryID", $data['CategoryID']);
            $this->db->where("Year", $data['Year']);
            $this->db->where("Status", 1);

            $this->db->select("*")->from($this::TABLE_PAYMENTS);

            $exist = $this->db->get();

            if ($exist->num_rows() > 0) {
                foreach ($exist as $e) {
                    $this->db->where("StudentID", $data['StudentID']);
                    $this->db->where("Month >", $data['Month']);
                    $this->db->where("CategoryID", $data['CategoryID']);
                    $this->db->where("Year", $data['Year']);
                    $this->db->where("Status", 1);
                    $this->db->update($this::TABLE_PAYMENTS, array(
                        "Status" => 0
                    ));
                }
            }
            $this->db->insert($this::TABLE_PAYMENTS, $data);
            return (5 + $this->db->insert_id());
        }

    }

    public function get_pending_dues($studentID, $category = 1)
    {
        $this->db->where("StudentID", $studentID);
        $this->db->where("CategoryID", $category);
        $this->db->where("Status", 1);
        $this->db->select("*")->from($this::TABLE_PAYMENTS)->order_by("PaymentID", "desc")->limit(1);

        $r = $this->db->get();
        return $r->result_array();
    }


    public function get_fees_month()
    {
        $month = date('m');
        $year = date('Y');


        $start = $year . "-" . $month . "-1";
        $end = $year . "-" . $month . "-31";

        $this->db->where("Date >=", $start);
        $this->db->where("Date <=", $end);
        $this->db->where("Status", 1);
        $this->db->select("*")->from($this::TABLE_PAYMENTS);

        $r = $this->db->get();
        $fee = $r->result_array();

        $total = 0;
        foreach ($fee as $item) {
            $total += $item['Amount'];
        }
        return $total;
    }

} 