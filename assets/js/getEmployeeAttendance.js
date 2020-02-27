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


        var id = $('#employee').val();
        var day = $("#day").val();
        var month = $("#month").val();
        var year = $("#year").val();
        var type = $("#monthly").prop("checked") == true ? "monthly" : "daily";

        $("#content").html("");

        $.post("get_employees_attendance",
            {
                id : id,
                day : day,
                month : month,
                year : year,
                type : type
            },
            function(data , status)
            {
                if(data) {

                    var ul = data;
                    $("#attend").html(ul);

                    $(".show_attendance").slideDown();
                }
                else
                    alert("No Attendance Recorded ! !");
            }
        );

        $("#get_mem").html($("select#employee").find(":selected").text());

    });

    $(".close-btn").click(function(){
        $(".show_attendance").slideUp();
    });

});