var busID , regNos , success = 0 , url = "";
$(document).ready(


    function () {

        $("#btn_get").click(function () {
            get_students();
        });

        $("#bus").change(function () {
            $("#box_attendance").hide(1000);
        });

    }
);


function get_students()
{
    var roll = "", fnames = "" , lnames = "" , mnames = "" , ids ="" , classIds = "" , sectionIds = "";
    busID = $("#bus").val();


    if(busID != 0) {

        $.when(

            $.ajax(
                {
                    type: "POST",
                    url: "get_students",
                    data: {
                        BusID: busID,
                        Column: "RegistrationNumber"
                    },
                    success: function (data) {
                        regNos = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_students",
                    data: {
                        BusID: busID,
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
                        BusID: busID,
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
                        BusID: busID,
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
                        BusID: busID,
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
                        BusID: busID,
                        Column: "ClassID"
                    },
                    success: function (data) {
                        classIds = JSON.parse(data);
                        //alert(names);
                    }
                }
            ),
            $.ajax(
                {
                    type: "POST",
                    url: "get_students",
                    data: {
                        BusID: busID,
                        Column: "SectionID"
                    },
                    success: function (data) {
                        sectionIds = JSON.parse(data);
                        //alert(names);
                    }
                }
            )


        ).then(
            function () {
                populate_table(fnames , mnames , lnames , roll  , classIds , sectionIds);
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

function populate_table(fnames , mnames , lnames , roll , classIds , sectionIds)
{

        $("#box_attendance").show(1000);
        if(fnames != "") {
            $("#table_body").html('');
            $.each(fnames , function (i , item) {


                var className = ""  , sectionName = "";
                $.when($.ajax(
                    {
                        type: "POST",
                        url: "get_class",
                        data: {
                            ClassID: classIds[i]
                        },
                        success: function (data) {

                            className = JSON.parse(data);

                        }
                    }
                ),

                    $.ajax(
                        {
                            type: "POST",
                            url: "get_section",
                            data: {
                                SectionID: sectionIds[i]
                            },
                            success: function (data) {

                                sectionName = JSON.parse(data);
                            }
                        }
                    )

                ).then(
                    function () {
                        $("#table_body").append("<tr><td>"+regNos[i]+"</td><td>"+item+" "+mnames[i]+" "+lnames[i]+"</td>" +
                            "<td>"+className+"</td>" +
                            "<td>"+sectionName+"</td>" +
                            "<td>"+roll[i]+"</td>"+
                            "</tr>");
                    }
                );


            })

        }
        else
        {
            $("#table_body").html('');

            $("#table_body").append("<tr><td>No data Available</td></tr>");


        }


}

