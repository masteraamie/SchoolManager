<?php

class DownloadFiles extends CI_Controller
{

    public function download_assignment($id = NULL)
    {
        if (isset($id)) {

            $this->load->model("AcademicModel");
            $assignment = $this->AcademicModel->get_assignment_where($id);


            if ($assignment) {

                $this->load->helper('download');


                $file = $assignment[0]['File'];
                // check file exists
                if (file_exists($file)) {
                    // get file content
                    $data = file_get_contents($file);
                    //force download
                    force_download($file, $data);
                } else {
                    // Redirect to base url
                    echo "<script>alert('File Does Not Exist');   
                            window.history.back();</script>";
                }


            }

        }

    }

    public function download_kit()
    {


        $this->load->helper('download');


        $file = "./uploads/joiningkit.doc";
        // check file exists
        if (file_exists($file)) {
            // get file content
            $data = file_get_contents($file);
            //force download
            force_download($file, $data);

        } else {
            // Redirect to base url
            echo "<script>alert('File Does Not Exist');   
                            window.history.back();</script>";
        }


    }


    public function download_admission()
    {
        $this->load->helper('download');


        $file = "./uploads/AdmissionForm.pdf";
        // check file exists
        if (file_exists($file)) {
            // get file content
            $data = file_get_contents($file);
            //force download
            force_download($file, $data);

        } else {
            // Redirect to base url
            echo "<script>alert('File Does Not Exist');   
                            window.history.back();</script>";
        }


    }

    public function download_planner($id = NULL)
    {
        if (isset($id)) {

            $this->load->model("AcademicModel");
            $assignment = $this->AcademicModel->get_planner_where($id);


            if ($assignment) {

                $this->load->helper('download');


                $file = $assignment[0]['File'];
                // check file exists
                if (file_exists($file)) {
                    // get file content
                    $data = file_get_contents($file);
                    //force download
                    force_download($file, $data);
                } else {
                    // Redirect to base url
                    echo "<script>alert('File Does Not Exist');   
                            window.history.back();</script>";
                }


            }

        }

    }

    public function download_syllabus($id = NULL)
    {
        if (isset($id)) {

            $this->load->model("AcademicModel");
            $assignment = $this->AcademicModel->get_syllabus_where($id);


            if ($assignment) {

                $this->load->helper('download');


                $file = $assignment[0]['File'];
                // check file exists
                if (file_exists($file)) {
                    // get file content
                    $data = file_get_contents($file);
                    //force download
                    force_download($file, $data);
                } else {
                    // Redirect to base url
                    echo "<script>alert('File Does Not Exist');   
                            window.history.back();</script>";
                }


            }

        }

    }

    public function download_datesheet($id = NULL)
    {
        if (isset($id)) {

            $this->load->model("AcademicModel");
            $assignment = $this->AcademicModel->get_datesheet_where($id);


            if ($assignment) {

                $this->load->helper('download');


                $file = $assignment[0]['File'];
                // check file exists
                if (file_exists($file)) {
                    // get file content
                    $data = file_get_contents($file);
                    //force download
                    force_download($file, $data);
                } else {
                    // Redirect to base url
                    echo "<script>alert('File Does Not Exist');   
                            window.history.back();</script>";
                }


            }

        }

    }

    public function download_employee_doc($id = null)
    {
        if (isset($id)) {

            $this->load->model("HRModel");
            $employee = $this->HRModel->get_employee_where_id($id);


            if ($employee) {

                $this->load->helper('download');


                $file = $employee[0]['QualificationDoc'];
                // check file exists
                if (file_exists($file)) {
                    // get file content
                    $data = file_get_contents($file);
                    //force download
                    force_download($file, $data);
                } else {
                    // Redirect to base url
                    echo "<script>alert('File Does Not Exist');   
                            window.history.back();</script>";
                }


            }

        }
    }

    public function download_admin_attachment($id = NULL)
    {
        if (isset($id)) {

            $this->load->model("AdminMessageModel");
            $message = $this->AdminMessageModel->get_message($id);


            if ($message) {

                $this->load->helper('download');


                $file = $message[0]['Attachment'];
                // check file exists
                if (file_exists($file)) {
                    // get file content
                    $data = file_get_contents($file);
                    //force download
                    force_download($file, $data);
                } else {
                    // Redirect to base url
                    echo "<script>alert('File Does Not Exist');   
                            window.history.back();</script>";
                }


            }

        }

    }

    public function download_student_attachment($id = NULL)
    {
        if (isset($id)) {

            $this->load->model("StudentMessageModel");
            $message = $this->StudentMessageModel->get_message($id);


            if ($message) {

                $this->load->helper('download');


                $file = $message[0]['Attachment'];
                // check file exists
                if (file_exists($file)) {
                    // get file content
                    $data = file_get_contents($file);
                    //force download
                    force_download($file, $data);
                } else {
                    // Redirect to base url
                    echo "<script>alert('File Does Not Exist');   
                            window.history.back();</script>";
                }


            }

        }

    }

    public function download_teacher_attachment($id = NULL)
    {
        if (isset($id)) {

            $this->load->model("TeacherMessageModel");
            $message = $this->TeacherMessageModel->get_message($id);


            if ($message) {

                $this->load->helper('download');


                $file = $message[0]['Attachment'];
                // check file exists
                if (file_exists($file)) {
                    // get file content
                    $data = file_get_contents($file);
                    //force download
                    force_download($file, $data);
                } else {
                    // Redirect to base url
                    echo "<script>alert('File Does Not Exist');   
                            window.history.back();</script>";
                }


            }

        }

    }


}
