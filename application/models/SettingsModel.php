<?php

class SettingsModel extends CI_Model
{

    const TABLE_IMAGES = 'tbl_images';
    const TABLE_PRINCIPAL = 'tbl_principal_message';
    const TABLE_VICE_PRINCIPAL = 'tbl_vp_message';
    const TABLE_DIRECTOR = 'tbl_director_message';

    //Images TABLE FUNCTIONS
    public function update_image($image, $number)
    {
        if ($number == 1) {
            $this->db->update($this::TABLE_IMAGES, array(
                "Image1" => $image
            ));
            return TRUE;
        } elseif ($number == 2) {
            $this->db->update($this::TABLE_IMAGES, array(
                "Image2" => $image
            ));
            return TRUE;
        } elseif ($number == 3) {
            $this->db->update($this::TABLE_IMAGES, array(
                "Image3" => $image
            ));
            return TRUE;
        } elseif ($number == 4) {
            $this->db->update($this::TABLE_IMAGES, array(
                "Image4" => $image
            ));
            return TRUE;
        } else
            return FALSE;


    }

    public function get_images()
    {
        $this->db->select("*")->from($this::TABLE_IMAGES)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    //Principal TABLE FUNCTIONS
    public function update_principal($data)
    {

        return $this->db->update($this::TABLE_PRINCIPAL, $data);


    }

    public function update_principal_image($image)
    {

        return $this->db->update($this::TABLE_PRINCIPAL, array(
            "Image" => $image
        ));


    }

    public function get_principal()
    {
        $this->db->select("*")->from($this::TABLE_PRINCIPAL)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }


    //Principal TABLE FUNCTIONS
    public function update_vice_principal($data)
    {

        return $this->db->update($this::TABLE_VICE_PRINCIPAL, $data);


    }

    public function update_vice_principal_image($image)
    {

        return $this->db->update($this::TABLE_VICE_PRINCIPAL, array(
            "Image" => $image
        ));


    }

    public function get_vice_principal()
    {
        $this->db->select("*")->from($this::TABLE_VICE_PRINCIPAL)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    //Director TABLE FUNCTIONS
    public function update_director($data)
    {

        return $this->db->update($this::TABLE_DIRECTOR, $data);


    }

    public function update_director_image($image)
    {

        return $this->db->update($this::TABLE_DIRECTOR, array(
            "Image" => $image
        ));


    }

    public function get_director()
    {
        $this->db->select("*")->from($this::TABLE_DIRECTOR)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

} 