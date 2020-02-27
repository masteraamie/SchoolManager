var success = 0, url = "";
var dos = "", titles = "", ids = "", subjects = "";

$(document).ready(
    function () {


        $("#btn_get").click(function () {

            get_datesheets();

        });


    }
);


function get_datesheets() {

    classID = $("#class").val();


    if (classID != 0) {

        $.when(
            $.ajax(
                {
                    type: "POST",
                    url: "get_datesheets",
                    data: {
                        ClassID: classID,
                        Column: "DatesheetID"
                    },
                    success: function (data) {
                        ids = JSON.parse(data);

                    }
                }
            ),


            $.ajax(
                {
                    type: "POST",
                    url: "get_datesheets",
                    data: {
                        ClassID: classID,
                        Column: "Title"
                    },
                    success: function (data) {
                        titles = JSON.parse(data);
                    }
                }
            ),


            $.ajax(
                {
                    type: "POST",
                    url: "get_datesheets",
                    data: {
                        ClassID: classID,
                        Column: "DOE"
                    },
                    success: function (data) {
                        dos = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),
            $.ajax(
                {
                    type: "POST",
                    url: "get_url",
                    data: {
                        Type: 2,
                    },
                    success: function (data) {
                        url = JSON.parse(data);
                        //alert(url);
                    }
                }
            )
        ).then(
            function () {
                populate_table();
            },
            function () {
                populate_table();
            }
        );
    }
    else {
        populate_table();
    }
}

function populate_table() {


    $("#box_attendance").show(1000);
    if (ids != "") {
        $("#table_body").html('');
        $("#table_head").html('<tr><td>Date of Exam</td><td>Title</td><td>Action</td></tr>');
        $.each(ids, function (i, item) {


            $("#table_body").append("<tr><td>" + dos[i] + "</td><td>" + titles[i] + "</td>" +
                "<td><a class='btn btn-sm btn-outline-primary' href='" + url + item + "'>SAVE</a></td></tr>");

        });

    }
    else {
        $("#table_body").html('');

        $("#table_body").append("<tr><td>No data Available</td></tr>");


    }


}

