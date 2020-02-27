var  success = 0 , url = "";
var dos = "", titles = "" , ids = "" , subjects = "";

$(document).ready(


    function () {



        $("#btn_get").click(function () {

            get_assignments();

        });
        

    }
);


function get_assignments()
{

    classID = $("#class").val();
    sectionID = $("#section").val();


    if(classID != 0 && sectionID != 0) {

        $.when(


            $.ajax(
                {
                    type: "POST",
                    url: "get_assignments",
                    data: {
                        ClassID: classID,
                        SectionID : sectionID,
                        Column: "AssignmentID"
                    },
                    success: function (data) {
                        ids = JSON.parse(data);

                    }
                }
            ),


            $.ajax(
                {
                    type: "POST",
                    url: "get_assignments",
                    data: {
                        ClassID: classID,
                        SectionID : sectionID,
                        Column: "Title"
                    },
                    success: function (data) {
                        titles = JSON.parse(data);
                    }
                }
            ),


            $.ajax(
                {
                    type: "POST",
                    url: "get_assignments",
                    data: {
                        ClassID: classID,
                        SectionID : sectionID,
                        Column: "DOS"
                    },
                    success: function (data) {
                        dos = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_assignments",
                    data: {
                        ClassID: classID,
                        SectionID : sectionID,
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
                url: "get_url",
                data: {
                    Type: 1,
                },
                success: function (data) {
                    url = JSON.parse(data);
                    //alert(url);
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
    else
    {
        populate_table();
    }
}

function populate_table()
{

        $("#box_attendance").show(1000);
        if(ids != "") {
            $("#table_body").html('');
            $("#table_head").html('<tr><td>Date of Submission</td><td>Title</td> <td>Subject</td><td>Action</td></tr>');
            $.each(ids , function (i , item) {


                $.when(

                    $.ajax(
                        {
                            type: "POST",
                            url: "get_subject_name",
                            data: {
                                SubjectID: subjects[i]
                            },
                            success: function (data) {
                                subject = JSON.parse(data);

                                //alert(roll);
                            }
                        }
                    )
                ).then(
                    function () {

                        $("#table_body").append("<tr><td>" + dos[i] + "</td><td>" + titles[i] + "</td>" +
                            "<td>" + subject + "</td>" +
                            "<td><a class='btn btn-sm btn-outline-primary' href='" + url + item + "'>SAVE</a></td></tr>");
                    })
            });

        }
        else
        {
            $("#table_body").html('');

            $("#table_body").append("<tr><td>No data Available</td></tr>");


        }


}

