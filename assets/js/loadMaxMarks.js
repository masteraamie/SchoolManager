
$(document).ready(


    function () {

        get_section();
        $("#exam").change(function () {
            get_section();
        });

    }
);


function get_section()
{
    var  marks = "";
    var examID = $("#exam").val();

    if(examID != 0) {

        $.when(
            $.ajax(
                {
                    type: "POST",
                    url: "../../get_max_marks",
                    data: {
                        ExamID: examID
                    },
                    success: function (data) {
                        marks = JSON.parse(data);

                        //alert(marks);
                    }
                }
            )
        ).then(
            function () {
                set_max_marks(marks);
            },
            function () {
                set_max_marks("");
            }
        );
    }
    else
    {
        set_max_marks("" , "");
    }
}

function set_max_marks(marks)
{

        if(marks != "") {

            $("#max_marks").val(marks);
        }
        else
        {
            $("#max_marks").val("No Max Marks");
        }


}

