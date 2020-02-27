
$(document).ready(


    function () {

        get_section_upgrade();
        $("#up_class").change(function () {
            get_section_upgrade();
        });

    }
);


function get_section_upgrade()
{
    var ids = "", names = "";
    var classID = $("#up_class").val();

    if(classID != 0) {

        $.when(

            $.ajax(
                {
                    type: "POST",
                    url: "get_sections",
                    data: {
                        ClassID: classID,
                        Column: "Name"
                    },
                    success: function (data) {
                        names = JSON.parse(data);

                        //alert(names)
                    }
                }
            ),


            $.ajax(
                {
                    type: "POST",
                    url: "get_sections",
                    data: {
                        ClassID: classID,
                        Column: "SectionID"
                    },
                    success: function (data) {
                        ids = JSON.parse(data);

                    }
                }
            )

        ).then(
            function () {
                populate_select_upgrade(names, ids);
            },
            function () {
                populate_select_upgrade("", "");
            }
        );
    }
    else
    {
        populate_select_upgrade("" , "");
    }
}

function populate_select_upgrade(names , ids)
{

        if(names != "") {

            $("#up_section").html('');
            $.each(names , function (i , item) {
                $("#up_section").append($('<option>', {
                    value : ids[i],
                    text: item
                }))
            })

        }
        else
        {
            $("#up_section").html('');
            $("#up_section").append($('<option>', {
                value: 0,
                text: "No Section Available"
            }))
        }


}

