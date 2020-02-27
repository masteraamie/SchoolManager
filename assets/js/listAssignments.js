var  success = 0 , url = "";
var dos = "", titles = "" , ids = "" , subjects = "";

$(document).ready(


    function () {


        get_assignments();


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
                    Type: 3
                },
                success: function (data) {
                    url = JSON.parse(data);
                    //alert(names);
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

                        $("#table_body").append("<tr><td>" + titles[i] + "</td><td>" + subject + "</td>" +
                            "<td>" + dos[i] + "</td>" +
                            "<td><a href='" + url + item + "'><i class='fa fa-eye'></i></a></td></tr>");
                    })
            });

        }
        else
        {
            $("#table_body").html('');

            $("#table_body").append("<tr><td>No data Available</td></tr>");


        }


}

