
$(document).ready(


    function () {

        get_section();
        $("#class").change(function () {
            get_section();
        });

    }
);


function get_section()
{
    var ids = "", names = "";
    var classID = $("#class").val();

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
                populate_select(names, ids);
            },
            function () {
                populate_select("", "");
            }
        );
    }
    else
    {
        populate_select("" , "");
    }
}

function populate_select(names , ids)
{

        if(names != "") {

            $("#section").html('');
            $.each(names , function (i , item) {
                $("#section").append($('<option>', {
                    value : ids[i],
                    text: item
                }))
            })

        }
        else
        {
            $("#section").html('');
            $("#section").append($('<option>', {
                value: 0,
                text: "No Section Available"
            }))
        }


}

