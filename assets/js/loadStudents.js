var subjectID , classID , sectionID , date , success = 0 , mnames = lnames = [] , c = 0;
$(document).ready(


    function () {

        $("#btn_get").click(function () {
            get_students();
        });

        $("#btn_attend").click(function () {
            do_attendance();
        });

        $("#class").change(function () {
            $("#box_attendance").hide(1000);
        });
        $("#section").change(function () {
            $("#box_attendance").hide(1000);
        });
    }
);


function do_attendance() {

    classID = $("#class").val();
    sectionID = $("#section").val();
    date = $("#date").val();

    if(c > 0) {
        $.when(
            $("#box_attendance input:checkbox:checked").each(function (i) {

                //alert($(this).val());
                $.ajax(
                    {
                        type: "POST",
                        url: "do_attendance",
                        data: {
                            ClassID: classID,
                            SectionID: sectionID,
                            StudentID: $(this).val(),
                            Status: 'P',
                            Date: date
                        },
                        success: function (data) {

                            if (data == 'success') {

                            }
                        }
                    }
                )


            }),

            $("#box_attendance input:checkbox:not(:checked)").each(function (i) {

                //alert($(this).val());
                $.ajax(
                    {
                        type: "POST",
                        url: "do_attendance",
                        data: {
                            ClassID: classID,
                            SectionID: sectionID,
                            StudentID: $(this).val(),
                            Status: 'A',
                            Date: date
                        },
                        success: function (data) {

                            if (data == 'success') {

                            }
                        }
                    }
                )


            })
        ).then(function () {
            alert("Attendance Successful");
            c = 0;
        });
    }
    else
    {
        var click = confirm('Check the Attendance Again ?');

        if (click == true) {
            // Save it!
            c++
        } else {
            // Do nothing!
            event.preventDefault();
        }
    }

}

function get_students()
{
    var roll = "", names = "" , ids ="";
    classID = $("#class").val();
    sectionID = $("#section").val();
    date = $("#date").val();

    if(classID != 0 && sectionID != 0 && subjectID != 0) {

        $.when(

            $.ajax(
                {
                    type: "POST",
                    url: "get_students",
                    data: {
                        ClassID: classID,
                        SectionID : sectionID,
                        Column: "Roll"
                    },
                    success: function (data) {
                        roll = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),


            $.ajax(
                {
                    type: "POST",
                    url: "get_students",
                    data: {
                        ClassID: classID,
                        SectionID : sectionID,
                        Column: "FirstName"
                    },
                    success: function (data) {
                        names = JSON.parse(data);
                        //alert(names);
                    }
                }
            )

            ,

            $.ajax(
                {
                    type: "POST",
                    url: "get_students",
                    data: {
                        ClassID: classID,
                        SectionID : sectionID,
                        Column: "MiddleName"
                    },
                    success: function (data) {
                        mnames = JSON.parse(data);
                    }
                }
            ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_students",
                    data: {
                        ClassID: classID,
                        SectionID : sectionID,
                        Column: "LastName"
                    },
                    success: function (data) {
                        lnames = JSON.parse(data);
                    }
                }
            ),
            $.ajax(
                {
                    type: "POST",
                    url: "get_students",
                    data: {
                        ClassID: classID,
                        SectionID : sectionID,
                        Column: "StudentID"
                    },
                    success: function (data) {
                        ids = JSON.parse(data);
                        //alert(names);
                    }
                }
            )


        ).then(
            function () {
                populate_table(names, roll , ids);
            },
            function () {
                populate_table("", "" , "");
            }
        );
    }
    else
    {
        populate_table("" , "" , "");
    }
}

function populate_table(names , roll , ids)
{

        $("#box_attendance").show(1000);
        if(names != "") {
            $("#table_body").html('');
            $.each(names , function (i , item) {
                $("#table_body").append("<tr><td>"+roll[i]+"</td><td>"+item+" "+mnames[i]+" "+lnames[i]+"</td>" +
                    "<td><input type='checkbox' class='icheckbox_flat-green' checked value='"+ids[i]+"'></td></tr>");
            })

        }
        else
        {
            $("#table_body").html('');

            $("#table_body").append("<tr><td>No data Available</td></tr>");


        }


}

