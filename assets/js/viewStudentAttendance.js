/**
 * Created by Master Aamir on 30-Apr-17.
 */


$(document).ready(function()
{

    $(":radio").on('click',function(){
        if($(":radio#daily").is(':checked'))
        {
            $(".daily").slideDown();
        }

        else
        {
            $(".daily").slideUp();
        }

    });


    $(":input#get_det").click(function(){


        var id = $('#student').val();
        var day = $("#day").val();
        var month = $("#month").val();
        var year = $("#year").val();
        var type = $("#monthly").prop("checked") == true ? "monthly" : "daily";
        var classID = $("#class").val();
        var sectionID = $("#section").val();


        $("#content").html("");

        $.post("get_student_attendance",
            {
                id : id,
                ClassID : classID,
                SectionID : sectionID,
                day : day,
                month : month,
                year : year,
                type : type
            },
            function(data)
            {
                if(data) {

                    var ul = data;
                    if(ul != "") {
                        $("#table_body").html(ul);

                        $("#box_attendance").show(1000);
                    }
                    else
                    {
                        alert("No Attendance Recorded ! !");
                    }
                }
                else
                    alert("No Attendance Recorded ! !");
            }
        );

    });


});