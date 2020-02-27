
$(document).ready(


    function () {

        get_class();
        $("#class").change(function () {
            get_class();
        });

    }
);

function get_class() {

    var val = $("#class").val();


    if(val == 0)
    {
        $("#section").hide();
    }
    else
    {
        $("#section").show(500);
    }

}

