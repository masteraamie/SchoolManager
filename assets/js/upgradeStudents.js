var classID , sectionID , success = 0;
$(document).ready(


    function () {

        $("#btn_get").click(function () {
            get_students();
        });

        $("#btn_upgrade").click(function () {
            upgrade();
        });

        $("#class").change(function () {
            $("#box_attendance").hide(1000);
            $("#box_upgrade").hide(500);
        });
        $("#section").change(function () {
            $("#box_attendance").hide(1000);
            $("#box_upgrade").hide(500);
        });


    }
);


function upgrade() {

    classID = $("#up_class").val();
    sectionID = $("#up_section").val();


    $("#box_attendance input:checkbox:checked").each(function (i) {
       //alert($(this).val());
        $.ajax(
            {
                type: "POST",
                url: "upgrade_students",
                data: {
                    ClassID: classID,
                    SectionID : sectionID,
                    StudentID : $(this).val()
                },
                success: function (data) {

                    if(data == 'success')
                    {
                        success++;
                    }
                }
            }
        )
    });

    if(success > 0)
        alert("Upgrade Successful");
}

function get_students()
{
    var roll = "", names = "" , ids ="";
    classID = $("#class").val();
    sectionID = $("#section").val();
    date = $("#date").val();

    if(classID != 0 && sectionID != 0) {

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

        $("#box_upgrade").show(1000);
        $("#box_attendance").show(1000);
        if(names != "") {
            $("#table_body").html('');
            $.each(names , function (i , item) {
                $("#table_body").append("<tr><td>"+roll[i]+"</td><td>"+item+"</td>" +
                    "<td><input type='checkbox' class='icheckbox_flat-green' checked value='"+ids[i]+"'></td></tr>");
            })

        }
        else
        {
            $("#table_body").html('');

            $("#table_body").append("<tr><td>No data Available</td></tr>");


        }


}

