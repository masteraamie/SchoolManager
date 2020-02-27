/**
 * Created by Master Aamir on 11-Apr-17.
 */

var day = "" , classID = "" , sectionID = "" , table_row = "";
var subjects = [] , teachers = [] , startTimes = [] , endTimes = [];
$(document).ready(

    function () {

        table_row = $("#periods").html();

        $("#days").hide();


        $("#class").change(function () {
            $("#days").hide(1000);
        });
        $("#section").change(function () {
            $("#days").hide(1000);
        });
        $("#set").click(function () {
           addPeriod();
        });

        $("#get_days").click(function () {

            classID = $("#class").val();
            sectionID = $("#section").val();
            $("#days").show(1000);
        });


        $("#close_btn").click(function () {
            $("#time_table").slideUp(1000);
        });


        $("#monday").click(function () {
            day = "Monday";
            openTimeTableDialog();
        });

        $("#tuesday").click(function () {
            day = "Tuesday";
            openTimeTableDialog();
        });

        $("#wednesday").click(function () {
            day = "Wednesday";
            openTimeTableDialog();
        });

        $("#thursday").click(function () {
            day = "Thursday";
            openTimeTableDialog();
        });

        $("#friday").click(function () {
            day = "Friday";
            openTimeTableDialog();
        });

        $("#saturday").click(function () {
            day = "Saturday";
            openTimeTableDialog();
        });

        $("#sunday").click(function () {
            day = "Sunday";
            openTimeTableDialog();
        });
    }


);

function openTimeTableDialog() {


    $("#day").html(day);
    $.when(

        $.ajax(
            {
                type: "POST",
                url: "get_periods",
                data: {
                    ClassID: classID,
                    SectionID: sectionID,
                    Day: day,
                    Column : "SubjectID"
                },
                success: function (data) {

                    subjects = JSON.parse(data);
                }
            }
        ),

        $.ajax(
            {
                type: "POST",
                url: "get_periods",
                data: {
                    ClassID: classID,
                    SectionID: sectionID,
                    Day: day,
                    Column : "TeacherID"
                },
                success: function (data) {

                    teachers = JSON.parse(data);
                }
            }
        ),

        $.ajax(
            {
                type: "POST",
                url: "get_periods",
                data: {
                    ClassID: classID,
                    SectionID: sectionID,
                    Day: day,
                    Column : "StartTime"
                },
                success: function (data) {

                    startTimes = JSON.parse(data);
                }
            }
        ),

        $.ajax(
            {
                type: "POST",
                url: "get_periods",
                data: {
                    ClassID: classID,
                    SectionID: sectionID,
                    Day: day,
                    Column : "EndTime"
                },
                success: function (data) {

                    endTimes = JSON.parse(data);
                }
            }
        )

).then(

    function () {

        if(subjects) {

            $("#periods").html("");
            $.each(subjects , function (i , item) {


                var subjectName = "" , teacherName = "";
                $.when(
                $.ajax(
                    {
                        type: "POST",
                        url: "get_subject",
                        data: {
                            SubjectID: subjects[i]
                        },
                        success: function (data) {

                            subjectName = JSON.parse(data);

                        }
                    }
                ),

                    $.ajax(
                        {
                            type: "POST",
                            url: "get_teacher",
                            data: {
                                EmployeeID: teachers[i]
                            },
                            success: function (data) {

                                teacherName = JSON.parse(data);
                            }
                        }
                    )
                ).then(function () {

                    $("#periods").append("<tr><td>"+subjectName+"</td><td>"+teacherName+"</td><td>"+startTimes[i]+
                        "</td><td>"+endTimes[i]+"</td></tr>");

                });
            });

        }
        $("#periods").append(table_row);
        $(".timepicker").timepicker({
            showInputs: false});

        $("#set").click(function () {
            addPeriod();
        });
        $("#time_table").slideDown(1000);
    }

    );
}

function addPeriod() {
    var subject = $("#subject").val();
    var teacher = $("#teacher").val();
    var startTime = $("#start_time").val();
    var endTime = $("#end_time").val();


    if(startTime == endTime)
    {
        alert("The Start Time and End Time should be different");
    }
    else {
        $.ajax(
            {
                type: "POST",
                url: "add_period",
                data: {
                    ClassID: classID,
                    SectionID: sectionID,
                    SubjectID: subject,
                    TeacherID: teacher,
                    StartTime: startTime,
                    EndTime: endTime,
                    Day: day
                },
                success: function (data) {
                    if (data) {
                        alert("Success");

                        $("#set").hide();

                        $("#subject").attr("id" , "");
                        $("#teacher").attr("id" , "");
                        $("#start_time").attr("id" , "");
                        $("#end_time").attr("id" , "");
                        $("#set").attr("id" , "");

                       openTimeTableDialog();

                    }
                    else
                        alert("Failure");




                }
            }
        );
    }
}

