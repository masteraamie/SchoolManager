var classID,   subject , subjectIds = "", subjectNames = "", exam, success = 0
var url = "", exams = [], subjects = [], marks = [], examIds = [], examNames = [];
$(document).ready(
    function () {

        $("#btn_get").click(function () {
            get_students();
        });

        $("#class").change(function () {
            $("#box_attendance").hide(1000);
        });
        $("#student").change(function () {
            $("#box_attendance").hide(1000);
        });


    }
);


function get_students() {
    classID = $("#class").val();
    studentID = $("#student").val();
    date = $("#date").val();

    if (classID != 0 && studentID != 0) {

        $.when(
            $.ajax(
                {
                    type: "POST",
                    url: "get_student_result",
                    data: {
                        ClassID: classID,
                        StudentID: studentID,
                        Column: "SubjectID"
                    },
                    success: function (data) {
                        subjects = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_student_result",
                    data: {
                        ClassID: classID,
                        StudentID: studentID,
                        Column: "ExamID"
                    },
                    success: function (data) {
                        exams = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),
            $.ajax(
                {
                    type: "POST",
                    url: "get_student_result",
                    data: {
                        ClassID: classID,
                        StudentID: studentID,
                        Column: "Marks"
                    },
                    success: function (data) {
                        marks = JSON.parse(data);
                        //alert(names);
                    }
                }
            ),
            $.ajax(
                {
                    type: "POST",
                    url: "get_subjects",
                    data: {
                        Column: "SubjectID"
                    },
                    success: function (data) {
                        subjectIds = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),
            $.ajax(
                {
                    type: "POST",
                    url: "get_subjects",
                    data: {
                        Column: "Name"
                    },
                    success: function (data) {
                        subjectNames = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),
            $.ajax(
                {
                    type: "POST",
                    url: "get_exams",
                    data: {
                        Column: "ExamID"
                    },
                    success: function (data) {
                        examIds = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),
            $.ajax(
                {
                    type: "POST",
                    url: "get_exams",
                    data: {
                        Column: "Name"
                    },
                    success: function (data) {
                        examNames = JSON.parse(data);

                        //alert(roll);
                    }
                }
            )
        ).then(
            function () {
                populate_table();
            },
            function () {
                populate_table();
            }
        );
    }
    else {
        populate_table();
    }
}

function populate_table() {

    $("#box_attendance").show(1000);
    if (subjects != "") {
        $("#table_body").html('')


        $.each(subjects, function (i, item) {


            var index = subjectIds.indexOf(item);
            subject = subjectNames[index];


            index = examIds.indexOf(exams[i]);
            exam = examNames[index];


            $("#table_body").append("<tr><td>" + item + " " + subject + "</td><td>" + exam + "</td><td>" + marks[i] + "</td>");

        });

    }
    else {
        $("#table_body").html('');

        $("#table_body").append("<tr><td>No data Available</td></tr>");


    }


}

