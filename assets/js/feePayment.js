/**
 * Created by Master Aamir on 05-Apr-17.
 */
var category = 0, amount = 0, lastMonth = 0, lastYear = 0, last = 0;

var months = ["None", "January", "February", "March", "April", "May"
    , "June", "July", "August", "September", "October", "November", "December"];

$(document).ready(function () {
    get_last_deposit();
    get_fees();
    $("#category").change(
        function () {
            get_last_deposit();
            get_fees();
        }
    );


    $("#student").change(
        function () {
            get_last_deposit();
            get_fees();
        }
    );

});

function get_last_deposit() {

    var studentID = $("#student").val();
    var category = $("#category").val();
    $.when(
        $.ajax(
            {
                type: "POST",
                url: "get_last_deposit",
                data: {
                    StudentID: studentID,
                    CategoryID: category,
                    Column: 'Month'
                },
                success: function (data) {

                    //alert(data);
                    if (data != "ERROR") {
                        lastMonth = JSON.parse(data);
                        //alert(classID);
                    }
                    else {
                        lastMonth = 0;
                    }
                }
            }
        ),
        $.ajax(
            {
                type: "POST",
                url: "get_last_deposit",
                data: {
                    StudentID: studentID,
                    CategoryID: category,
                    Column: 'Year'
                },
                success: function (data) {

                    //alert(data);
                    if (data != "ERROR") {
                        lastYear = Number(JSON.parse(data));
                        //alert(classID);
                    }
                    else {
                        lastYear = 2017;
                    }


                }
            }
        )
    ).then(function () {
        //alert(lastMonth);
        if (lastMonth == 12) {
            last = 1;
            lastYear++;
        }
        else {
            last = Number(lastMonth) + 1;
            //alert(last);
        }
        var m = months[last];
        $('#month').val(last);
        $('#month2').val(m);

        $('#year').val(lastYear);
        $('#year2').val(lastYear);
    });

}

function get_fees() {
    var studentID = $("#student").val();
    category = $("#category").val();
    var classID = '';
    var routeID = '';

    // alert(studentID);

    if (studentID != 0 && category != 0) {

        if (category != 2) {
            $.when(
                $.ajax(
                    {
                        type: "POST",
                        url: "get_class",
                        data: {
                            StudentID: studentID,
                        },
                        success: function (data) {

                            if (data != "ERROR") {
                                classID = JSON.parse(data);
                                //alert(classID);
                            }
                            else {
                                $('#amount').val("Fee not available");
                                $('#amount2').val("Fee not available");
                                $("#btn_pay").prop('disabled', true);
                                alert("Something went wrong ! ! !");
                            }
                        }
                    }
                )).then(
                function () {
                    if (classID != '') {
                        $.ajax(
                            {
                                type: "POST",
                                url: "get_fee",
                                data: {
                                    ClassID: classID,
                                    CategoryID: category
                                },
                                success: function (data) {

                                    if (data != "ERROR") {
                                        amount = JSON.parse(data);
                                        //alert(amount);
                                        $('#amount').val(amount);
                                        $('#amount2').val(amount);
                                        $("#btn_pay").prop('disabled', false);
                                    }
                                    else {
                                        $('#amount').val("Fee not available");
                                        $('#amount2').val("Fee not available");
                                        $("#btn_pay").prop('disabled', true);
                                        alert("Fee not assigned ! ! !");
                                    }
                                }
                            }
                        );


                    }
                }
            );


        }

        else {
            $.when(
                $.ajax(
                    {
                        type: "POST",
                        url: "get_stop",
                        data: {
                            StudentID: studentID,
                        },
                        success: function (data) {

                            if (data != "ERROR")
                                stopID = JSON.parse(data);
                            else {
                                $('#amount').val("Fee not available");
                                $('#amount2').val("Fee not available");
                                $("#btn_pay").prop('disabled', true);
                                alert("Something went wrong ! ! !");
                            }
                        }
                    }
                )).then(
                function () {
                    if (stopID != '') {
                        $.ajax(
                            {
                                type: "POST",
                                url: "get_bus_fee",
                                data: {
                                    StopID: stopID
                                },
                                success: function (data) {


                                    if (data != "ERROR") {
                                        amount = JSON.parse(data);
                                        $('#amount').val(amount);
                                        $('#amount2').val(amount);

                                        $("#btn_pay").prop('disabled', false);
                                    }
                                    else {
                                        $('#amount').val("Fee not available");
                                        $('#amount2').val("Fee not available");
                                        $("#btn_pay").prop('disabled', true);
                                        alert("Bus Fee not assigned ! ! !");
                                    }
                                }
                            }
                        )
                    }
                    else {
                        $('#amount').val("Fee not available");
                        $('#amount2').val("Fee not available");
                        alert("Bus Fee not assigned ! ! !");
                        $("#btn_pay").prop('disabled', true);
                    }
                }
            );
        }
    }
}


