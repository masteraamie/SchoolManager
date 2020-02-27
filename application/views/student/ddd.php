public function edit_student($id = "")
{
$this->check_login();
if (isset($id) && is_numeric($id)) {
$data = array();
if (!is_dir("./uploads/students"))
mkdir("./uploads/students", 0777, TRUE);


if (!is_dir("./uploads/parents"))
mkdir("./uploads/parents", 0777, TRUE);

$this->load->model('StudentModel');

$this->load->library('form_validation');
if ($_POST) {


$rules = array(

array(
'field' => 'fname',
'label' => 'Student First Name',
'rules' => 'trim|required|min_length[1]|max_length[25]|alpha'
),

array(
'field' => 'mname',
'label' => 'Student Middle Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'lname',
'label' => 'Student Last Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'p_fname',
'label' => 'Parent First Name',
'rules' => 'trim|required|min_length[1]|max_length[25]|alpha'
),

array(
'field' => 'p_mname',
'label' => 'Parent Middle Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'p_lname',
'label' => 'Parent Last Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'profession',
'label' => 'Parent Profession',
'rules' => 'trim|required'
),

array(
'field' => 'qualification',
'label' => 'Parent Qualification',
'rules' => 'trim|required'
),

array(
'field' => 'roll',
'label' => 'Roll Number',
'rules' => 'trim|required'
),

array(
'field' => 'section',
'label' => 'Section',
'rules' => 'trim|required|numeric'
),
array(
'field' => 'class',
'label' => 'Class',
'rules' => 'trim|required|numeric'
),

array(
'field' => 'gender',
'label' => 'Gender',
'rules' => 'trim|required'
),

array(
'field' => 'doj',
'label' => 'Date of Joining',
'rules' => 'trim|required'
),

array(
'field' => 'dob',
'label' => 'Date of Birth',
'rules' => 'trim|required'
),

array(
'field' => 'qualification',
'label' => 'Qualification',
'rules' => 'trim|required|min_length[1]|max_length[25]'
),
array(
'field' => 'p_address',
'label' => 'Permanent Address',
'rules' => 'trim|required'
),
array(
'field' => 'email',
'label' => 'Student Email',
'rules' => 'trim|valid_email'
),

array(
'field' => 'p_email',
'label' => 'Parent Email',
'rules' => 'trim|required|valid_email'
),

array(
'field' => 'contact',
'label' => 'Student Contact',
'rules' => 'trim|numeric'
),

array(
'field' => 'p_contact',
'label' => 'Parent Contact',
'rules' => 'trim|required|numeric'
)

);

$this->form_validation->set_rules($rules);
$this->form_validation->set_error_delimiters('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>');


$student = array(

'FirstName' => $this->input->post('fname'),
'LastName' => $this->input->post('lname'),
'MiddleName' => $this->input->post('mname'),
'Roll' => $this->input->post('roll'),
'P_Address' => $this->input->post('p_address'),
'C_Address' => $this->input->post('p_address'),
'DOB' => $this->input->post('dob'),
'DOJ' => $this->input->post('doj'),
'Gender' => $this->input->post('gender'),
'Contact' => $this->input->post('contact'),
'Email' => $this->input->post('email'),
'ClassID' => $this->input->post('class'),
'SectionID' => $this->input->post('section'),
);

$parent = array(
'FirstName' => $this->input->post('p_fname'),
'LastName' => $this->input->post('p_lname'),
'MiddleName' => $this->input->post('p_mname'),
'Relation' => $this->input->post('relation'),
'Qualification' => $this->input->post('qualification'),
'Profession' => $this->input->post('profession'),
'Contact' => $this->input->post('p_contact'),
'Email' => $this->input->post('p_email'),
);

$p_student = array(
'Class' => $this->input->post('p_class'),
'School' => $this->input->post('p_school'),
'Percentage' => $this->input->post('percent'),
);


$data['student'] = $student;
$data['parent'] = $parent;
$data['p_student'] = $p_student;
if ($this->form_validation->run() == FALSE) {
} else {


$data['id'] = $this->StudentModel->update_student($student, $id);


if (isset($p_student['Class']) && isset($p_student['School']) && isset($p_student['Percentage'])) {
$p_student['StudentID'] = $data['id'];
$this->StudentModel->update_prev_details($p_student, $id);
}


if ((isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])))
{
$config = array(

'file_name' => $student['FirstName'] . $data['id'],
'upload_path' => './uploads/students/',
'allowed_types' => 'png|jpg',
'overwrite' => TRUE,
'max_size' => '1024000',
'max_height' => '640',
'max_width' => '480'

);

$this->load->library('upload');
$this->upload->initialize($config);
if ($this->upload->do_upload('photo')) {

$upload_data = $this->upload->data();

if ($upload_data) {
$this->StudentModel->add_student_photo($data['id'], $config['upload_path'] . $upload_data['file_name']);

} else {
$this->StudentModel->roll_back();
$data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}

} else {
$this->StudentModel->roll_back();
$data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}
}

$d = $this->edit_parent($parent, $id);
$data['full_success'] = isset($d['full_success']) ? $d['full_success'] : NULL;
$data['p_img_error'] = isset($d['p_img_error']) ? $d['p_img_error'] : NULL;


$docs = $this->upload_documents($student['FirstName'], $id);
$data['birth_img_error'] = isset($docs['birth_img_error']) ? $docs['birth_img_error'] : NULL;
$data['migration_img_error'] = isset($docs['migration_img_error']) ? $docs['migration_img_error'] : NULL;
$data['state_img_error'] = isset($docs['state_img_error']) ? $docs['state_img_error'] : NULL;

$data['succeed'] = $docs['succeed'];
if ($docs['succeed'] == TRUE) {
$this->StudentModel->commit();
$data['success'] = true;
}

}
}
$this->load->model("AcademicModel");

$data['classes'] = $this->AcademicModel->get_classes();
$data['batches'] = $this->AcademicModel->get_batches();

$data['student'] = $this->StudentModel->get_student_where_id($id);
$data['p_student'] = $this->StudentModel->get_prev_details($id);
$data['parent'] = $this->StudentModel->get_parent_where($id);


if (!isset($data['parent'][0])) {

$parent = array(
array(
'FirstName' => "",
'LastName' => "",
'MiddleName' => "",
'Contact' => "",
'Email' => "",
"Qualification" => "",
"Profession" => ""
)
);
$data['parent'] = $parent;
}

if (!isset($data['p_student'][0])) {
$p_student = array(

array(
"StudentID" => "",
"Class" => "",
"School" => "",
"Percentage" => "")
);
$data['p_student'] = $p_student;
}

$this->load->model("AdminMessageModel");
$data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
$data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

$this->load->view("student/EditStudent", $data);
} else {
redirect(site_url("StudentController/student_list"));
}


$this->check_login();
$data = array();
if (!is_dir("./uploads/students"))
mkdir("./uploads/students", 0777, TRUE);


if (!is_dir("./uploads/parents"))
mkdir("./uploads/parents", 0777, TRUE);

$this->load->model('StudentModel');

$this->load->library('form_validation');
if ($_POST) {


$rules = array(

array(
'field' => 'fname',
'label' => 'Student First Name',
'rules' => 'trim|required|min_length[1]|max_length[25]|alpha'
),

array(
'field' => 'mname',
'label' => 'Student Middle Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'lname',
'label' => 'Student Last Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'p_fname',
'label' => 'Parent First Name',
'rules' => 'trim|required|min_length[1]|max_length[25]|alpha'
),

array(
'field' => 'p_mname',
'label' => 'Parent Middle Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'p_lname',
'label' => 'Parent Last Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'profession',
'label' => 'Parent Profession',
'rules' => 'trim|required'
),

array(
'field' => 'qualification',
'label' => 'Parent Qualification',
'rules' => 'trim|required'
),

array(
'field' => 'registration',
'label' => 'Registration Number',
'rules' => 'trim|required|min_length[3]|is_unique[tbl_student_details.RegistrationNumber]'
),

array(
'field' => 'roll',
'label' => 'Roll Number',
'rules' => 'trim|required'
),

array(
'field' => 'section',
'label' => 'Section',
'rules' => 'trim|required|numeric'
),
array(
'field' => 'class',
'label' => 'Class',
'rules' => 'trim|required|numeric'
),

array(
'field' => 'gender',
'label' => 'Gender',
'rules' => 'trim|required'
),

array(
'field' => 'batch',
'label' => 'Batch',
'rules' => 'trim|required|numeric'
),


array(
'field' => 'doj',
'label' => 'Date of Joining',
'rules' => 'trim|required'
),

array(
'field' => 'dob',
'label' => 'Date of Birth',
'rules' => 'trim|required'
),


array(
'field' => 'address',
'label' => 'Address',
'rules' => 'trim|required'
),
array(
'field' => 'email',
'label' => 'Student Email',
'rules' => 'trim|valid_email|is_unique[tbl_student_details.Email]|required'
),


array(
'field' => 'contact',
'label' => 'Student Contact',
'rules' => 'trim|numeric|required'
)
);

$this->form_validation->set_rules($rules);
$this->form_validation->set_error_delimiters('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>');


$student = array(

'FirstName' => $this->input->post('fname'),
'LastName' => $this->input->post('lname'),
'MiddleName' => $this->input->post('mname'),
'Batch' => $this->input->post('batch'),
'RegistrationNumber' => $this->input->post('registration'),
'Roll' => $this->input->post('roll'),
'Address' => $this->input->post('address'),
'DOB' => $this->input->post('dob'),
'DOJ' => $this->input->post('doj'),
'Gender' => $this->input->post('gender'),
'Contact' => '91' . $this->input->post('contact'),
'Email' => $this->input->post('email'),
'ClassID' => $this->input->post('class'),
'SectionID' => $this->input->post('section'),
'PFirstName' => $this->input->post('p_fname'),
'PLastName' => $this->input->post('p_lname'),
'PMiddleName' => $this->input->post('p_mname'),
'PRelation' => $this->input->post('relation'),
'PQualification' => $this->input->post('qualification'),
'PProfession' => $this->input->post('profession'),
'PrevClass' => $this->input->post('p_class'),
'PrevSchool' => $this->input->post('p_school'),
'PrevPercentage' => $this->input->post('percent'),
);

$reg = $this->StudentModel->get_last_student();

$length = strlen($reg);

if ($length == 1)
$reg = "100" . $reg;
elseif ($length == 2)
$reg = "10" . $reg;
elseif ($length == 3)
$reg = "1" . $reg;
else
$reg = $reg;

$loginID = $student['Batch'] . "SBS" . $reg;
$this->load->model('LoginModel');

$student["LoginID"] = $loginID;
$student["Password"] = $this->LoginModel->encrypt($loginID);

$data['student'] = $student;

if ($this->form_validation->run() == FALSE) {
} else {


if ($this->StudentModel->check_student_where($student['ClassID'], $student['SectionID'], $student['Roll'])) {

$data['id'] = $this->StudentModel->add_student($student);
if ((isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name']))) {
$login = array(

"ParentID" => $data['id'],
"LoginID" => $student['PFirstName'] . $data['id'],
"Password" => $this->LoginModel->encrypt("123456")

);
$data['plogin'] = $login;
$this->StudentModel->add_parent_login($login);


$config = array(

'file_name' => $student['FirstName'] . $data['id'],
'upload_path' => './uploads/students/',
'allowed_types' => 'png|jpg',
'overwrite' => TRUE,
'max_size' => '1024000'

);

$this->load->library('upload');
$this->upload->initialize($config);
if ($this->upload->do_upload('photo')) {

$upload_data = $this->upload->data();

if ($upload_data) {
$this->StudentModel->add_student_photo($data['id'], $config['upload_path'] . $upload_data['file_name']);
} else {
$this->StudentModel->roll_back();
$data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}

} else {
$this->StudentModel->roll_back();
$data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}
} else {
$this->StudentModel->roll_back();
$data['img_error'] = array(
"error" => "Student Image is Required "
);
}
if ((isset($_FILES['p_photo']['name']) && !empty($_FILES['p_photo']['name']))) {


$config = array(

'file_name' => $student['PFirstName'] . $data['id'] ,
'upload_path' => './uploads/parents/',
'allowed_types' => 'png|jpg',
'overwrite' => TRUE,
'max_size' => '1024000'
);

$this->load->library('upload', $config);

$this->upload->initialize($config);

if ($this->upload->do_upload('p_photo')) {

$upload_data = $this->upload->data();

if ($upload_data) {
$this->StudentModel->add_parent_photo($data['id'], $config['upload_path'] . $upload_data['file_name']);
$data['full_success'] = True;
} else {
$this->StudentModel->roll_back();
$data['p_img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}

} else {
$this->StudentModel->roll_back();
$data['p_img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}
} else {
$this->StudentModel->roll_back();
$data['p_img_error'] = array(
"error" => "Parent Image is Required "
);
}
$docs = $this->upload_documents($student['FirstName'], $data['id']);
$data['birth_img_error'] = isset($docs['birth_img_error']) ? $docs['birth_img_error'] : NULL;
$data['migration_img_error'] = isset($docs['migration_img_error']) ? $docs['migration_img_error'] : NULL;
$data['state_img_error'] = isset($docs['state_img_error']) ? $docs['state_img_error'] : NULL;

$data['succeed'] = $docs['succeed'];
if ($docs['succeed'] == TRUE) {
$this->StudentModel->commit();
$from_email = "www.sbssrinagar.com";
$to_email = $student['Email'];
$message = "
<html>
<head>
    <title>Login Details</title>
</head>
<body>
<table>
    <tr>
        <th>LOGIN ID</th>
        <th>PASSWORD</th>
    </tr>
    <tr>
        <td>" . $student['LoginID'] . "</td>
        <td>".$loginID."</td>
    </tr>
</table>
</body>
</html>";
//Load email library
$this->load->library('email');
$this->email->set_mailtype("html");
$this->email->from($from_email, 'SBS MANAGER');
$this->email->to($to_email);
$this->email->subject('LOGIN DETAILS');
$this->email->message($message);

//Send mail
$this->email->send();
$message = "LoginID is " . $student['LoginID'] . " Password is : ".$loginID;
$this->LoginModel->send_sms($student['Contact'], $message);

$data['full_success'] = TRUE;
}
} else {
$data['error'] = "Student With This Roll Number Already Present in this Class and Section";
}
}
} else {

$student = array(

'FirstName' => $this->input->post('fname'),
'LastName' => $this->input->post('lname'),
'MiddleName' => $this->input->post('mname'),
'Batch' => $this->input->post('batch'),
'RegistrationNumber' => $this->input->post('registration'),
'Roll' => $this->input->post('roll'),
'Address' => $this->input->post('p_address'),
'DOB' => $this->input->post('dob'),
'DOJ' => $this->input->post('doj'),
'Gender' => $this->input->post('gender'),
'Contact' => '91' . $this->input->post('contact'),
'Email' => $this->input->post('email'),
'ClassID' => $this->input->post('class'),
'SectionID' => $this->input->post('section'),
'PFirstName' => $this->input->post('p_fname'),
'PLastName' => $this->input->post('p_lname'),
'PMiddleName' => $this->input->post('p_mname'),
'PRelation' => $this->input->post('relation'),
'PQualification' => $this->input->post('qualification'),
'PProfession' => $this->input->post('profession'),
'PrevClass' => $this->input->post('p_class'),
'PrevSchool' => $this->input->post('p_school'),
'PrevPercentage' => $this->input->post('percent'),
);

$data['student'] = $student;
}
$this->load->model("AcademicModel");

$data['classes'] = $this->AcademicModel->get_classes();
$data['batches'] = $this->AcademicModel->get_batches();
$reg = $this->StudentModel->get_last_student() + 1;

$length = strlen($reg);

if ($length == 1)
$reg = "100" . $reg;
elseif ($length == 2)
$reg = "10" . $reg;
elseif ($length == 3)
$reg = "1" . $reg;
else
$reg = $reg;

$data['reg'] = $reg;
$this->load->model("AdminMessageModel");
$data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
$data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

$this->load->view("student/AddStudent", $data);


}*/
/* public function edit_student($id = "")
{
$this->check_login();
if (isset($id) && is_numeric($id)) {
$data = array();
if (!is_dir("./uploads/students"))
mkdir("./uploads/students", 0777, TRUE);


if (!is_dir("./uploads/parents"))
mkdir("./uploads/parents", 0777, TRUE);

$this->load->model('StudentModel');

$this->load->library('form_validation');
if ($_POST) {


$rules = array(

array(
'field' => 'fname',
'label' => 'Student First Name',
'rules' => 'trim|required|min_length[1]|max_length[25]|alpha'
),

array(
'field' => 'mname',
'label' => 'Student Middle Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'lname',
'label' => 'Student Last Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'p_fname',
'label' => 'Parent First Name',
'rules' => 'trim|required|min_length[1]|max_length[25]|alpha'
),

array(
'field' => 'p_mname',
'label' => 'Parent Middle Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'p_lname',
'label' => 'Parent Last Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'profession',
'label' => 'Parent Profession',
'rules' => 'trim|required'
),

array(
'field' => 'qualification',
'label' => 'Parent Qualification',
'rules' => 'trim|required'
),

array(
'field' => 'roll',
'label' => 'Roll Number',
'rules' => 'trim|required'
),

array(
'field' => 'section',
'label' => 'Section',
'rules' => 'trim|required|numeric'
),
array(
'field' => 'class',
'label' => 'Class',
'rules' => 'trim|required|numeric'
),

array(
'field' => 'gender',
'label' => 'Gender',
'rules' => 'trim|required'
),

array(
'field' => 'doj',
'label' => 'Date of Joining',
'rules' => 'trim|required'
),

array(
'field' => 'dob',
'label' => 'Date of Birth',
'rules' => 'trim|required'
),

array(
'field' => 'qualification',
'label' => 'Qualification',
'rules' => 'trim|required|min_length[1]|max_length[25]'
),
array(
'field' => 'p_address',
'label' => 'Permanent Address',
'rules' => 'trim|required'
),
array(
'field' => 'email',
'label' => 'Student Email',
'rules' => 'trim|valid_email'
),

array(
'field' => 'p_email',
'label' => 'Parent Email',
'rules' => 'trim|required|valid_email'
),

array(
'field' => 'contact',
'label' => 'Student Contact',
'rules' => 'trim|numeric'
),

array(
'field' => 'p_contact',
'label' => 'Parent Contact',
'rules' => 'trim|required|numeric'
)

);

$this->form_validation->set_rules($rules);
$this->form_validation->set_error_delimiters('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>');


$student = array(

'FirstName' => $this->input->post('fname'),
'LastName' => $this->input->post('lname'),
'MiddleName' => $this->input->post('mname'),
'Roll' => $this->input->post('roll'),
'P_Address' => $this->input->post('p_address'),
'C_Address' => $this->input->post('p_address'),
'DOB' => $this->input->post('dob'),
'DOJ' => $this->input->post('doj'),
'Gender' => $this->input->post('gender'),
'Contact' => $this->input->post('contact'),
'Email' => $this->input->post('email'),
'ClassID' => $this->input->post('class'),
'SectionID' => $this->input->post('section'),
);

$parent = array(
'FirstName' => $this->input->post('p_fname'),
'LastName' => $this->input->post('p_lname'),
'MiddleName' => $this->input->post('p_mname'),
'Relation' => $this->input->post('relation'),
'Qualification' => $this->input->post('qualification'),
'Profession' => $this->input->post('profession'),
'Contact' => $this->input->post('p_contact'),
'Email' => $this->input->post('p_email'),
);

$p_student = array(
'Class' => $this->input->post('p_class'),
'School' => $this->input->post('p_school'),
'Percentage' => $this->input->post('percent'),
);


$data['student'] = $student;
$data['parent'] = $parent;
$data['p_student'] = $p_student;
if ($this->form_validation->run() == FALSE) {
} else {


$data['id'] = $this->StudentModel->update_student($student, $id);


if (isset($p_student['Class']) && isset($p_student['School']) && isset($p_student['Percentage'])) {
$p_student['StudentID'] = $data['id'];
$this->StudentModel->update_prev_details($p_student, $id);
}


if ((isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])))
{
$config = array(

'file_name' => $student['FirstName'] . $data['id'],
'upload_path' => './uploads/students/',
'allowed_types' => 'png|jpg',
'overwrite' => TRUE,
'max_size' => '1024000',
'max_height' => '640',
'max_width' => '480'

);

$this->load->library('upload');
$this->upload->initialize($config);
if ($this->upload->do_upload('photo')) {

$upload_data = $this->upload->data();

if ($upload_data) {
$this->StudentModel->add_student_photo($data['id'], $config['upload_path'] . $upload_data['file_name']);

} else {
$this->StudentModel->roll_back();
$data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}

} else {
$this->StudentModel->roll_back();
$data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}
}

$d = $this->edit_parent($parent, $id);
$data['full_success'] = isset($d['full_success']) ? $d['full_success'] : NULL;
$data['p_img_error'] = isset($d['p_img_error']) ? $d['p_img_error'] : NULL;


$docs = $this->upload_documents($student['FirstName'], $id);
$data['birth_img_error'] = isset($docs['birth_img_error']) ? $docs['birth_img_error'] : NULL;
$data['migration_img_error'] = isset($docs['migration_img_error']) ? $docs['migration_img_error'] : NULL;
$data['state_img_error'] = isset($docs['state_img_error']) ? $docs['state_img_error'] : NULL;

$data['succeed'] = $docs['succeed'];
if ($docs['succeed'] == TRUE) {
$this->StudentModel->commit();
$data['success'] = true;
}

}
}
$this->load->model("AcademicModel");

$data['classes'] = $this->AcademicModel->get_classes();
$data['batches'] = $this->AcademicModel->get_batches();

$data['student'] = $this->StudentModel->get_student_where_id($id);
$data['p_student'] = $this->StudentModel->get_prev_details($id);
$data['parent'] = $this->StudentModel->get_parent_where($id);


if (!isset($data['parent'][0])) {

$parent = array(
array(
'FirstName' => "",
'LastName' => "",
'MiddleName' => "",
'Contact' => "",
'Email' => "",
"Qualification" => "",
"Profession" => ""
)
);
$data['parent'] = $parent;
}

if (!isset($data['p_student'][0])) {
$p_student = array(

array(
"StudentID" => "",
"Class" => "",
"School" => "",
"Percentage" => "")
);
$data['p_student'] = $p_student;
}

$this->load->model("AdminMessageModel");
$data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
$data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

$this->load->view("student/EditStudent", $data);
} else {
redirect(site_url("StudentController/student_list"));
}


$this->check_login();
$data = array();
if (!is_dir("./uploads/students"))
mkdir("./uploads/students", 0777, TRUE);


if (!is_dir("./uploads/parents"))
mkdir("./uploads/parents", 0777, TRUE);

$this->load->model('StudentModel');

$this->load->library('form_validation');
if ($_POST) {


$rules = array(

array(
'field' => 'fname',
'label' => 'Student First Name',
'rules' => 'trim|required|min_length[1]|max_length[25]|alpha'
),

array(
'field' => 'mname',
'label' => 'Student Middle Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'lname',
'label' => 'Student Last Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'p_fname',
'label' => 'Parent First Name',
'rules' => 'trim|required|min_length[1]|max_length[25]|alpha'
),

array(
'field' => 'p_mname',
'label' => 'Parent Middle Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'p_lname',
'label' => 'Parent Last Name',
'rules' => 'trim|alpha'
),

array(
'field' => 'profession',
'label' => 'Parent Profession',
'rules' => 'trim|required'
),

array(
'field' => 'qualification',
'label' => 'Parent Qualification',
'rules' => 'trim|required'
),

array(
'field' => 'registration',
'label' => 'Registration Number',
'rules' => 'trim|required|min_length[3]|is_unique[tbl_student_details.RegistrationNumber]'
),

array(
'field' => 'roll',
'label' => 'Roll Number',
'rules' => 'trim|required'
),

array(
'field' => 'section',
'label' => 'Section',
'rules' => 'trim|required|numeric'
),
array(
'field' => 'class',
'label' => 'Class',
'rules' => 'trim|required|numeric'
),

array(
'field' => 'gender',
'label' => 'Gender',
'rules' => 'trim|required'
),

array(
'field' => 'batch',
'label' => 'Batch',
'rules' => 'trim|required|numeric'
),


array(
'field' => 'doj',
'label' => 'Date of Joining',
'rules' => 'trim|required'
),

array(
'field' => 'dob',
'label' => 'Date of Birth',
'rules' => 'trim|required'
),


array(
'field' => 'address',
'label' => 'Address',
'rules' => 'trim|required'
),
array(
'field' => 'email',
'label' => 'Student Email',
'rules' => 'trim|valid_email|is_unique[tbl_student_details.Email]|required'
),


array(
'field' => 'contact',
'label' => 'Student Contact',
'rules' => 'trim|numeric|required'
)
);

$this->form_validation->set_rules($rules);
$this->form_validation->set_error_delimiters('<p class="alert alert-error"><i class="fa fa-warning"></i>', '</p>');


$student = array(

'FirstName' => $this->input->post('fname'),
'LastName' => $this->input->post('lname'),
'MiddleName' => $this->input->post('mname'),
'Batch' => $this->input->post('batch'),
'RegistrationNumber' => $this->input->post('registration'),
'Roll' => $this->input->post('roll'),
'Address' => $this->input->post('address'),
'DOB' => $this->input->post('dob'),
'DOJ' => $this->input->post('doj'),
'Gender' => $this->input->post('gender'),
'Contact' => '91' . $this->input->post('contact'),
'Email' => $this->input->post('email'),
'ClassID' => $this->input->post('class'),
'SectionID' => $this->input->post('section'),
'PFirstName' => $this->input->post('p_fname'),
'PLastName' => $this->input->post('p_lname'),
'PMiddleName' => $this->input->post('p_mname'),
'PRelation' => $this->input->post('relation'),
'PQualification' => $this->input->post('qualification'),
'PProfession' => $this->input->post('profession'),
'PrevClass' => $this->input->post('p_class'),
'PrevSchool' => $this->input->post('p_school'),
'PrevPercentage' => $this->input->post('percent'),
);

$reg = $this->StudentModel->get_last_student();

$length = strlen($reg);

if ($length == 1)
$reg = "100" . $reg;
elseif ($length == 2)
$reg = "10" . $reg;
elseif ($length == 3)
$reg = "1" . $reg;
else
$reg = $reg;

$loginID = $student['Batch'] . "SBS" . $reg;
$this->load->model('LoginModel');

$student["LoginID"] = $loginID;
$student["Password"] = $this->LoginModel->encrypt($loginID);

$data['student'] = $student;

if ($this->form_validation->run() == FALSE) {
} else {


if ($this->StudentModel->check_student_where($student['ClassID'], $student['SectionID'], $student['Roll'])) {

$data['id'] = $this->StudentModel->add_student($student);
if ((isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name']))) {
$login = array(

"ParentID" => $data['id'],
"LoginID" => $student['PFirstName'] . $data['id'],
"Password" => $this->LoginModel->encrypt("123456")

);
$data['plogin'] = $login;
$this->StudentModel->add_parent_login($login);


$config = array(

'file_name' => $student['FirstName'] . $data['id'],
'upload_path' => './uploads/students/',
'allowed_types' => 'png|jpg',
'overwrite' => TRUE,
'max_size' => '1024000'

);

$this->load->library('upload');
$this->upload->initialize($config);
if ($this->upload->do_upload('photo')) {

$upload_data = $this->upload->data();

if ($upload_data) {
$this->StudentModel->add_student_photo($data['id'], $config['upload_path'] . $upload_data['file_name']);
} else {
$this->StudentModel->roll_back();
$data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}

} else {
$this->StudentModel->roll_back();
$data['img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}
} else {
$this->StudentModel->roll_back();
$data['img_error'] = array(
"error" => "Student Image is Required "
);
}
if ((isset($_FILES['p_photo']['name']) && !empty($_FILES['p_photo']['name']))) {


$config = array(

'file_name' => $student['PFirstName'] . $data['id'] ,
'upload_path' => './uploads/parents/',
'allowed_types' => 'png|jpg',
'overwrite' => TRUE,
'max_size' => '1024000'
);

$this->load->library('upload', $config);

$this->upload->initialize($config);

if ($this->upload->do_upload('p_photo')) {

$upload_data = $this->upload->data();

if ($upload_data) {
$this->StudentModel->add_parent_photo($data['id'], $config['upload_path'] . $upload_data['file_name']);
$data['full_success'] = True;
} else {
$this->StudentModel->roll_back();
$data['p_img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}

} else {
$this->StudentModel->roll_back();
$data['p_img_error'] = array('error' => $this->upload->display_errors('<p class="alert alert-error"><i
            class="fa fa-warning"></i>', '</p>'));
}
} else {
$this->StudentModel->roll_back();
$data['p_img_error'] = array(
"error" => "Parent Image is Required "
);
}
$docs = $this->upload_documents($student['FirstName'], $data['id']);
$data['birth_img_error'] = isset($docs['birth_img_error']) ? $docs['birth_img_error'] : NULL;
$data['migration_img_error'] = isset($docs['migration_img_error']) ? $docs['migration_img_error'] : NULL;
$data['state_img_error'] = isset($docs['state_img_error']) ? $docs['state_img_error'] : NULL;

$data['succeed'] = $docs['succeed'];
if ($docs['succeed'] == TRUE) {
$this->StudentModel->commit();
$from_email = "www.sbssrinagar.com";
$to_email = $student['Email'];
$message = "
<html>
<head>
    <title>Login Details</title>
</head>
<body>
<table>
    <tr>
        <th>LOGIN ID</th>
        <th>PASSWORD</th>
    </tr>
    <tr>
        <td>" . $student['LoginID'] . "</td>
        <td>".$loginID."</td>
    </tr>
</table>
</body>
</html>";
//Load email library
$this->load->library('email');
$this->email->set_mailtype("html");
$this->email->from($from_email, 'SBS MANAGER');
$this->email->to($to_email);
$this->email->subject('LOGIN DETAILS');
$this->email->message($message);

//Send mail
$this->email->send();
$message = "LoginID is " . $student['LoginID'] . " Password is : ".$loginID;
$this->LoginModel->send_sms($student['Contact'], $message);

$data['full_success'] = TRUE;
}
} else {
$data['error'] = "Student With This Roll Number Already Present in this Class and Section";
}
}
} else {

$student = array(

'FirstName' => $this->input->post('fname'),
'LastName' => $this->input->post('lname'),
'MiddleName' => $this->input->post('mname'),
'Batch' => $this->input->post('batch'),
'RegistrationNumber' => $this->input->post('registration'),
'Roll' => $this->input->post('roll'),
'Address' => $this->input->post('p_address'),
'DOB' => $this->input->post('dob'),
'DOJ' => $this->input->post('doj'),
'Gender' => $this->input->post('gender'),
'Contact' => '91' . $this->input->post('contact'),
'Email' => $this->input->post('email'),
'ClassID' => $this->input->post('class'),
'SectionID' => $this->input->post('section'),
'PFirstName' => $this->input->post('p_fname'),
'PLastName' => $this->input->post('p_lname'),
'PMiddleName' => $this->input->post('p_mname'),
'PRelation' => $this->input->post('relation'),
'PQualification' => $this->input->post('qualification'),
'PProfession' => $this->input->post('profession'),
'PrevClass' => $this->input->post('p_class'),
'PrevSchool' => $this->input->post('p_school'),
'PrevPercentage' => $this->input->post('percent'),
);

$data['student'] = $student;
}
$this->load->model("AcademicModel");

$data['classes'] = $this->AcademicModel->get_classes();
$data['batches'] = $this->AcademicModel->get_batches();
$reg = $this->StudentModel->get_last_student() + 1;

$length = strlen($reg);

if ($length == 1)
$reg = "100" . $reg;
elseif ($length == 2)
$reg = "10" . $reg;
elseif ($length == 3)
$reg = "1" . $reg;
else
$reg = $reg;

$data['reg'] = $reg;
$this->load->model("AdminMessageModel");
$data['unread_messages'] = $this->AdminMessageModel->get_unread_messages();
$data['unread_count'] = is_array($data['unread_messages']) ? count($data['unread_messages']) : 0;

$this->load->view("student/AddStudent", $data);


}
