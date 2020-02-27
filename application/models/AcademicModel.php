<?php

class AcademicModel extends CI_Model
{

    const TABLE_CLASS = 'tbl_classes';
    const TABLE_EXAM = 'tbl_exams';
    const TABLE_BATCH = 'tbl_batches';
    const TABLE_SECTION = 'tbl_sections';
    const TABLE_BOOKS = 'tbl_book_details';
    const TABLE_SUBJECT = 'tbl_subjects';
    const TABLE_ASSIGNMENT = 'tbl_assignments';
    const TABLE_SYLLABUS = 'tbl_syllabus';
    const TABLE_SUBJECT_ALLOCATE = 'tbl_subject_allocation';
    const TABLE_CIRCULAR = 'tbl_circulars';
    const TABLE_TEACHER_ALLOCATE = 'tbl_teacher_allocation';
    const TABLE_TIME_TABLE = 'tbl_time_table';
    const TABLE_DATESHEET = 'tbl_datesheet';
    const TABLE_LECTURES = 'tbl_video_lectures';
    const TABLE_PLANNERS = 'tbl_academic_planners';

    public function commit()
    {
        $this->db->trans_commit();
    }

    public function roll_back()
    {
        $this->db->trans_rollback();
    }

    //TABLE CLASS FUNCTIONS
    public function add_class($data)
    {
        $this->db->insert($this::TABLE_CLASS, $data);
        return $this->db->insert_id();
    }

    public function edit_class($data)
    {
        $this->db->where("ClassID", $data['ClassID']);
        return $this->db->update($this::TABLE_CLASS, array(
            "Name" => $data['Name'],
            "MinAttendance" => $data['MinAttendance']
        ));
    }

    public function get_classes()
    {
        $this->db->select("*")->from($this::TABLE_CLASS)->order_by("ClassID", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_classes_pagination($offset = 0)
    {
        $this->db->select("*")->from($this::TABLE_CLASS)->order_by("ClassID", "asc")->limit(5)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_classes_count()
    {
        $this->db->select("*")->from($this::TABLE_CLASS)->order_by("Name", "asc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_class_where($id)
    {
        $this->db->select("*")->from($this::TABLE_CLASS)->where("ClassID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function delete_class($id)
    {
        $this->db->where("ClassID", $id);
        return $this->db->delete($this::TABLE_CLASS);
    }

    //TABLE EXAM FUNCTIONS
    public function add_exam($data)
    {
        $this->db->insert($this::TABLE_EXAM, $data);
        return $this->db->insert_id();
    }

    public function get_exams($offset = 0)
    {
        $this->db->select("*")->from($this::TABLE_EXAM)->order_by("ExamID", "asc")->limit(5)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_exam_where($id)
    {
        $this->db->select("*")->from($this::TABLE_EXAM)->where("ExamID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_exams_count()
    {
        $this->db->select("*")->from($this::TABLE_EXAM);
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function edit_exam($data)
    {
        $this->db->where("ExamID", $data['ExamID']);
        return $this->db->update($this::TABLE_EXAM, array(
            "Name" => $data['Name'],
            "MaxMarks" => $data['MaxMarks']
        ));
    }

    public function delete_exam($id)
    {
        $this->db->where("ExamID", $id);
        return $this->db->delete($this::TABLE_EXAM);
    }

    //TABLE BATCH FUNCTIONS
    public function add_batch($data)
    {
        $this->db->insert($this::TABLE_BATCH, $data);
        return $this->db->insert_id();
    }

    public function edit_batch($data)
    {
        $this->db->where("BatchID", $data['BatchID']);
        return $this->db->update($this::TABLE_BATCH, array(
            "Year" => $data['Year']
        ));
    }

    public function get_batches($offset = 0)
    {
        $this->db->select("*")->from($this::TABLE_BATCH)->order_by("Year", "desc")->limit(5)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_batches_count()
    {
        $this->db->select("*")->from($this::TABLE_BATCH)->order_by("Year", "desc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_batch_where($id)
    {
        $this->db->select("*")->from($this::TABLE_BATCH)->where('BatchID', $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function delete_batch($id)
    {
        $this->db->where("BatchID", $id);
        return $this->db->delete($this::TABLE_BATCH);
    }


//TABLE BOOKS FUNCTIONS
    public function add_book($data)
    {
        $this->db->insert($this::TABLE_BOOKS, $data);
        return $this->db->insert_id();
    }

    public function edit_book($data, $id)
    {
        $this->db->where("SerialID", $id);
        return $this->db->update($this::TABLE_BOOKS, $data);
    }

    public function delete_book($id)
    {
        $this->db->where("SerialID", $id);
        return $this->db->delete($this::TABLE_BOOKS);
    }

    public function issue_book($data)
    {
        $this->db->where("SerialID", $data['SerialID']);
        $update = $this->db->update($this::TABLE_BOOKS, array(
            "Status" => 1,
            "DOIssue" => $data['DOIssue'],
            "DORet" => $data['DORet'],
            "IssuedTo" => $data['IssuedTo'],
        ));

        return $update;
    }

    public function check_book($id)
    {
        $where = array(
            "SerialID" => $id,
            "Status" => 1
        );
        $this->db->select("*")->from($this::TABLE_BOOKS)->where($where);
        $result = $this->db->get();

        if ($result->num_rows() > 0)
            return false;
        return true;
    }

    public function get_last_book()
    {
        $this->db->select("*")->from($this::TABLE_BOOKS)->order_by("SerialID", "desc");
        $book = $this->db->get();

        if ($book->num_rows() > 0) {
            $arr = $book->result_array();
            $arr = $arr[0]["SerialID"];
        } else
            $arr = 0;
        return $arr;
    }

    public function get_books($offset = 0)
    {
        $this->db->select("*")->from($this::TABLE_BOOKS)->order_by("Name", "desc")->limit(5)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_books_count()
    {
        $this->db->select("*")->from($this::TABLE_BOOKS)->order_by("Name", "desc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_book_where($id)
    {
        $this->db->select("*")->from($this::TABLE_BOOKS)->where("SerialID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }


    //TABLE SECTION FUNCTIONS
    public function add_section($data)
    {
        $this->db->insert($this::TABLE_SECTION, $data);
        return $this->db->insert_id();
    }

    public function edit_section($data)
    {
        $this->db->where("SectionID", $data['SectionID']);
        return $this->db->update($this::TABLE_SECTION, array(

            "ClassID" => $data['ClassID'],
            "Name" => $data['Name']

        ));
    }

    public function delete_section($id)
    {
        $this->db->where("SectionID", $id['SectionID']);
        return $this->db->delete($this::TABLE_SECTION);
    }

    public function get_sections($offset = 0)
    {
        $this->db->select("*")->from($this::TABLE_SECTION)->order_by("ClassID", "asc")->limit(5)->offset($offset);
        $sections = $this->db->get();

        return $sections->result_array();
    }

    public function get_section_count()
    {
        $this->db->select("*")->from($this::TABLE_SECTION)->order_by("ClassID", "asc");
        $sections = $this->db->get();

        return $sections->num_rows();
    }

    public function get_section_where($id)
    {
        $this->db->select("*")->from($this::TABLE_SECTION)->where("SectionID", $id)->limit(1);
        $sections = $this->db->get();

        return $sections->result_array();
    }

    public function check_section($classID, $sectionName)
    {
        $check = array(

            'Name' => $sectionName,
            'ClassID' => $classID

        );
        $this->db->select('SectionID')->from($this::TABLE_SECTION)->where($check);

        $result = $this->db->get();

        if ($result->row())
            return false;
        else
            return true;

    }

    public function get_section_where_class($classID)
    {
        $this->db->select("*")->from($this::TABLE_SECTION)->where("ClassID", $classID)->order_by("SectionID", "asc");
        $sections = $this->db->get();
        return $sections->result_array();
    }

    //TABLE SUBJECTS FUNCTIONS
    public function add_subject($data)
    {
        $this->db->insert($this::TABLE_SUBJECT, $data);
        return $this->db->insert_id();
    }

    public function edit_subject($data)
    {
        $this->db->where('SubjectID', $data['SubjectID']);
        return $this->db->update($this::TABLE_SUBJECT, array(
            "Name" => $data['Name']
        ));
    }

    public function delete_subject($id)
    {
        $this->db->where("SubjectID", $id);
        return $this->db->delete($this::TABLE_SUBJECT);
    }

    public function allocate_subject($data)
    {
        $this->db->insert($this::TABLE_SUBJECT_ALLOCATE, $data);
        return $this->db->insert_id();
    }

    public function check_subject($classID, $subjectID)
    {
        $check = array(

            'ClassID' => $classID,
            "SubjectID" => $subjectID

        );
        $this->db->select('SubjectID')->from($this::TABLE_SUBJECT_ALLOCATE)->where($check);

        $result = $this->db->get();

        if ($result->row())
            return false;
        else
            return true;

    }

    public function get_subjects()
    {
        $this->db->select("*")->from($this::TABLE_SUBJECT)->order_by("Name", "asc");
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_subjects_pagination($offset = 0)
    {
        $this->db->select("*")->from($this::TABLE_SUBJECT)->order_by("Name", "asc")->limit(5)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_subjects_count()
    {
        $this->db->select("*")->from($this::TABLE_SUBJECT)->order_by("Name", "asc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_subject_where($id)
    {
        $this->db->where("SubjectID", $id);
        $this->db->select("*")->from($this::TABLE_SUBJECT)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_allocated_subjects($classIDs)
    {


        $subjectCount = array();

        foreach ($classIDs as $c) {

            $check = array(

                'ClassID' => $c['ClassID']
            );


            $this->db->select("*")->from($this::TABLE_SUBJECT_ALLOCATE)->where($check);
            $classes = $this->db->get();
            $subjectCount[$c['ClassID']] = $classes->num_rows();
        }
        return $subjectCount;
    }

    public function get_allocated_subject_where($classID)
    {
        $this->db->select("*")->from($this::TABLE_SUBJECT_ALLOCATE)->where("ClassID", $classID);
        $subjects = $this->db->get();
        return $subjects->result_array();
    }

    public function get_subjects_where($classID)
    {
        $this->db->select("*")->from($this::TABLE_SUBJECT)->where("ClassID", $classID);
        $subjects = $this->db->get();
        return $subjects->result_array();
    }

    public function delete_subject_allocation($classID, $subjectID)
    {
        $this->db->where("ClassID", $classID);
        $this->db->where("SubjectID", $subjectID);
        return $this->db->delete($this::TABLE_SUBJECT_ALLOCATE);
    }

    //TABLE CIRCULAR FUNCTION
    public function add_circular($data)
    {
        $this->db->insert($this::TABLE_CIRCULAR, $data);
        return $this->db->insert_id();
    }

    public function edit_circular($data, $id)
    {
        $this->db->where("CircularID", $id);
        $this->db->update($this::TABLE_CIRCULAR, $data);
        return $this->db->insert_id();
    }

    public function delete_circular($id)
    {
        $this->db->where("CircularID", $id);
        return $this->db->delete($this::TABLE_CIRCULAR);
    }

    public function get_circulars($offset = 0)
    {
        $this->db->select("*")->from($this::TABLE_CIRCULAR)->order_by("Date", "asc")->limit(5)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_circular_count()
    {
        $this->db->select("*")->from($this::TABLE_CIRCULAR)->order_by("Date", "asc");
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_circular_where($id)
    {
        $this->db->select("*")->from($this::TABLE_CIRCULAR)->where("CircularID", $id);
        $classes = $this->db->get();

        return $classes->result_array();
    }


    //TABLE TEACHER ALLOCATION FUNCTIONS
    public function allocate_teacher($data)
    {
        $this->db->insert($this::TABLE_TEACHER_ALLOCATE, $data);
        return $this->db->insert_id();
    }

    public function get_teacher_allocation()
    {
        $this->db->select("*")->from($this::TABLE_TEACHER_ALLOCATE)->order_by("ClassID", "asc");
        $classes = $this->db->get();
        return $classes->result_array();
    }

    public function delete_teacher_allocation($classID, $sectionID, $teacherID)
    {
        $this->db->where('ClassID', $classID);
        $this->db->where('SectionID', $sectionID);
        $this->db->where('TeacherID', $teacherID);
        return $this->db->delete($this::TABLE_TEACHER_ALLOCATE);
    }

    public function check_teacher_allocation($data)
    {
        $this->db->select("*")->from($this::TABLE_TEACHER_ALLOCATE)->where(array(
            "ClassID" => $data['ClassID'],
            "SectionID" => $data['SectionID']
        ));
        $classes = $this->db->get();

        if ($classes->num_rows() > 0)
            return false;

        return true;
    }


    //TABLE LECTURES FUNCTION
    public function add_lecture($data)
    {
        $this->db->insert($this::TABLE_LECTURES, $data);
        return $this->db->insert_id();
    }

    public function update_lecture($data, $id)
    {
        $this->db->where("LectureID", $id);
        return $this->db->update($this::TABLE_LECTURES, $data);
    }

    public function delete_lecture($id)
    {
        $this->db->where("LectureID", $id);
        return $this->db->delete($this::TABLE_LECTURES);
    }

    public function get_lectures()
    {
        $this->db->select("*")->from($this::TABLE_LECTURES);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_lecture_where($id)
    {
        $this->db->select("*")->from($this::TABLE_LECTURES)->where("LectureID", $id)->limit(1);
        $classes = $this->db->get();

        return $classes->result_array();
    }


    //TABLE ASSIGNMENT FUNCTION
    public function add_assignment($data)
    {
        $this->db->trans_begin();
        $this->db->insert($this::TABLE_ASSIGNMENT, $data);
        return $this->db->insert_id();
    }

    public function update_assignment($data, $id)
    {
        $this->db->trans_begin();
        $this->db->where("AssignmentID", $id);
        return $this->db->update($this::TABLE_ASSIGNMENT, $data);
    }

    public function add_assignment_file($id, $file)
    {
        $this->db->where('AssignmentID', $id);
        $this->db->update($this::TABLE_ASSIGNMENT, array(
            "File" => $file
        ));
    }

    public function delete_assignment($id)
    {
        $this->db->where("AssignmentID", $id);
        return $this->db->delete($this::TABLE_ASSIGNMENT);
    }

    public function get_assignments($offset = 0)
    {
        $this->db->select("*")->from($this::TABLE_ASSIGNMENT)->order_by('AssignmentID', 'asc')->limit(6)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_assignment_count()
    {
        $this->db->select("*")->from($this::TABLE_ASSIGNMENT);
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_assignment_where($id)
    {
        $this->db->select("*")->from($this::TABLE_ASSIGNMENT)->where(array(
            "AssignmentID" => $id
        ));
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_assignment_where_class($cid, $sid)
    {
        $this->db->select("*")->from($this::TABLE_ASSIGNMENT)->where(array(
            "ClassID" => $cid,
            "SectionID" => $sid
        ));
        $classes = $this->db->get();

        return $classes->result_array();
    }


    //TABLE ASSIGNMENT FUNCTION
    public function add_planner($data)
    {
        $this->db->trans_begin();
        $this->db->insert($this::TABLE_PLANNERS, $data);
        return $this->db->insert_id();
    }

    public function update_planner($data, $id)
    {
        $this->db->trans_begin();
        $this->db->where("PlannerID", $id);
        return $this->db->update($this::TABLE_PLANNERS, $data);
    }

    public function add_planner_file($id, $file)
    {
        $this->db->where('PlannerID', $id);
        $this->db->update($this::TABLE_PLANNERS, array(
            "File" => $file
        ));
    }

    public function delete_planner($id)
    {
        $this->db->where("PlannerID", $id);
        return $this->db->delete($this::TABLE_PLANNERS);
    }

    public function get_planners($offset = 0)
    {
        $this->db->select("*")->from($this::TABLE_PLANNERS)->order_by('PlannerID', 'asc')->limit(6)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_planner_count()
    {
        $this->db->select("*")->from($this::TABLE_PLANNERS);
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_planner_where($id)
    {
        $this->db->select("*")->from($this::TABLE_PLANNERS)->where(array(
            "PlannerID" => $id
        ));
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_planner_where_class($cid, $sid)
    {
        $this->db->select("*")->from($this::TABLE_PLANNERS)->where(array(
            "ClassID" => $cid,
            "SectionID" => $sid
        ));
        $classes = $this->db->get();

        return $classes->result_array();
    }

    //TABLE ASSIGNMENT FUNCTION
    public function add_syllabus($data)
    {
        $this->db->trans_begin();
        $this->db->insert($this::TABLE_SYLLABUS, $data);
        return $this->db->insert_id();
    }

    public function update_syllabus($data, $id)
    {
        $this->db->trans_begin();
        $this->db->where("SyllabusID", $id);
        return $this->db->update($this::TABLE_SYLLABUS, $data);
    }

    public function add_syllabus_file($id, $file)
    {
        $this->db->where('SyllabusID', $id);
        $this->db->update($this::TABLE_SYLLABUS, array(
            "File" => $file
        ));
    }

    public function delete_syllabus($id)
    {
        $this->db->where("SyllabusID", $id);
        return $this->db->delete($this::TABLE_SYLLABUS);
    }

    public function get_syllabi($offset = 0)
    {
        $this->db->select("*")->from($this::TABLE_SYLLABUS)->limit(6)->offset($offset);
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_syllabus_count()
    {
        $this->db->select("*")->from($this::TABLE_SYLLABUS);
        $classes = $this->db->get();

        return $classes->num_rows();
    }

    public function get_syllabus_where($id)
    {
        $this->db->select("*")->from($this::TABLE_SYLLABUS)->where(array(
            "SyllabusID" => $id
        ));
        $classes = $this->db->get();

        return $classes->result_array();
    }

    public function get_syllabus_where_class($cid, $sid)
    {
        $this->db->select("*")->from($this::TABLE_SYLLABUS)->where(array(
            "ClassID" => $cid,
            "SectionID" => $sid
        ));
        $classes = $this->db->get();

        return $classes->result_array();
    }

    //TABLE TIME TABLE FUNCTION
    public function add_period($data)
    {

        $this->db->where("ClassID", $data['ClassID']);
        $this->db->where("SectionID", $data['SectionID']);
        $this->db->where("SubjectID", $data['SubjectID']);
        $this->db->where("Day", $data['Day']);

        $this->db->select("*")->from($this::TABLE_TIME_TABLE);

        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $this->db->where("ClassID", $data['ClassID']);
            $this->db->where("SectionID", $data['SectionID']);
            $this->db->where("SubjectID", $data['SubjectID']);
            $this->db->where("Day", $data['Day']);
            $result = $this->db->update($this::TABLE_TIME_TABLE, $data);
            return $result;
        } else {
            $this->db->insert($this::TABLE_TIME_TABLE, $data);
            return $this->db->insert_id();
        }
    }

    public function get_periods($data)
    {

        $this->db->select("*")->from($this::TABLE_TIME_TABLE)->where($data)->order_by("StartTime", "asc");

        $result = $this->db->get();

        return $result->result_array();
    }

    //TABLE DATE SHEET FUNCTION
    public function add_datesheet($data)
    {
        $this->db->trans_begin();
        $this->db->insert($this::TABLE_DATESHEET, $data);
        return $this->db->insert_id();
    }

    public function add_datesheet_file($id, $file)
    {
        $this->db->where('DatesheetID', $id);
        $this->db->update($this::TABLE_DATESHEET, array(
            "File" => $file
        ));
    }

    public function update_datesheet($data, $id)
    {
        $this->db->trans_begin();
        $this->db->where("DatesheetID", $id);
        return $this->db->update($this::TABLE_DATESHEET, $data);
    }

    public function delete_datesheet($id)
    {
        $this->db->where("DatesheetID", $id);
        return $this->db->delete($this::TABLE_DATESHEET);
    }

    public function get_datesheet_where($id)
    {
        $this->db->where("DatesheetID", $id);
        $this->db->select("*")->from($this::TABLE_DATESHEET)->limit(1);
        $d = $this->db->get();

        return $d->result_array();

    }

    public function get_datesheet_where_class($class)
    {
        $this->db->where("ClassID", $class);
        $this->db->select("*")->from($this::TABLE_DATESHEET);
        $d = $this->db->get();

        return $d->result_array();

    }

    public function get_datesheets($offset = 0)
    {

        $this->db->select("*")->from($this::TABLE_DATESHEET)->order_by("DOE", "asc")->limit(6)->offset($offset);
        $d = $this->db->get();

        return $d->result_array();
    }

    public function get_datesheet_count()
    {

        $this->db->select("*")->from($this::TABLE_DATESHEET);
        $d = $this->db->get();

        return $d->num_rows();
    }
}