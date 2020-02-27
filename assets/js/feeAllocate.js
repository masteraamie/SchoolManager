/**
 * Created by Master Aamir on 05-Apr-17.
 */
var category = 1 , classes = 0;
$(document).ready(function () {


    get_classes();
    $("#category").change(
        function () {

            category = $("#category").val();

            if(category == 2)
            {
                get_stops();
            }
            else
            {
                get_classes();
            }
        }
    );

    $("#btn_allocate").click(function () {


        if(category == 2)
        {
            var stop = $("#selection").val();
            var amount = $("#amount").val();
            var type = $("#type").val();
            $.ajax(
                    {
                        type: "POST",
                        url: "allocate_bus_fee",
                        data: {
                            CategoryID: 2,
                            StopID: stop,
                            Amount: amount,
                            Type: type
                        },
                        success: function (data) {

                            if(data == "SUCCESS")
                            {
                                alert("Bus Fee Allocated Successfully");
                                location.reload();
                            }
                            else
                            {
                                alert("Something went wrong");
                            }

                        }
                    }
                );

        }
        else
        {
            category = $("#category").val();
            var clas = $("#selection").val();
            var amount = $("#amount").val();
            var type = $("#type").val();

            $.ajax(
                {
                    type: "POST",
                    url: "allocate_other_fee",
                    data: {
                        CategoryID: category,
                        ClassID: clas,
                        Amount: amount,
                        Type: type
                    },
                    success: function (data) {

                        if(data == "SUCCESS")
                        {
                            alert("Fee Allocated Successfully");


                            location.reload();
                        }
                        else
                        {
                            alert("Something went wrong");
                        }

                    }
                }
            );

        }


    });

});


function get_classes() {

    $("#lbl_select").html("Select Class");
    if(classes != "") {

        $("#selection").html('');
        $.each(classes , function (i , item) {
            $("#selection").append($('<option>', {
                value : item,
                text: classNames[i]
            }))
        })

    }
    else
    {
        $("#selection").html('');
        $("#selection").append($('<option>', {
            value: 0,
            text: "No Classes Available"
        }))
    }
}

function get_stops() {

    $("#lbl_select").html("Select Stop");

    if(stops != "") {

        $("#selection").html('');
        $.each(stops , function (i , item) {
            $("#selection").append($('<option>', {
                value : item,
                text: stopNames[i]
            }))
        })

    }
    else
    {
        $("#selection").html('');
        $("#selection").append($('<option>', {
            value: 0,
            text: "No Stops Available"
        }))
    }
}


