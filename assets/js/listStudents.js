var regs  , classID , sectionID , success = 0 , url = "";
$(document).ready(


    function () {

        $("#export").hide();

        $("#btn_get").click(function () {
            $("#export").show();
            get_students();
        });

        $("#class").change(function () {
            $("#export").hide();
            $("#box_attendance").hide(1000);
        });
        $("#section").change(function () {
            $("#export").hide();
            $("#box_attendance").hide(1000);
        });

    }
);


function get_students()
{
    var roll = "", fnames = "" , lnames = "" , mnames = "" , ids ="";
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
                        fnames = JSON.parse(data);
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
                        Column: "RegistrationNumber"
                    },
                    success: function (data) {
                        regs = JSON.parse(data);
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
                        Column: "MiddleName"
                    },
                    success: function (data) {
                        mnames = JSON.parse(data);
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
                        Column: "LastName"
                    },
                    success: function (data) {
                        lnames = JSON.parse(data);
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
            ),

        $.ajax(
            {
                type: "POST",
                url: "get_url",
                success: function (data) {
                    url = JSON.parse(data);
                    //alert(names);
                }
            }
        )


        ).then(
            function () {
                populate_table(fnames , mnames , lnames , roll , ids);
            },
            function () {
                populate_table("", "" , "");
            }
        );
    }
    else
    {
        populate_table("" , "" , "" , "", "" , "");
    }
}

function populate_table(fnames , mnames , lnames , roll , ids)
{

        $("#box_attendance").show(1000);
        if(fnames != "") {
            $("#table_body").html('');
            $.each(fnames , function (i , item) {

                $("#table_body").append("<tr><td>"+roll[i]+"</td><td>"+regs[i]+"</td><td>"+item+" "+mnames[i]+" "+lnames[i]+"</td>" +
                    "<td><a href='"+url+ids[i]+"'><i class='fa fa-eye'></i></a></td></tr>");
            })

        }
        else
        {
            $("#table_body").html('');

            $("#table_body").append("<tr><td>No data Available</td></tr>");


        }


}

