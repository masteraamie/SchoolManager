var success = 0, url = "";
var dos = "", titles = "", ids = "", year = "";

$(document).ready(
    function () {


        $("#btn_get").click(function () {

            get_planners();

        });


    }
);


function get_planners() {

    classID = $("#class").val();
    sectionID = $("#section").val();


    if (classID != 0 && sectionID != 0) {

        $.when(
            $.ajax(
                {
                    type: "POST",
                    url: "get_planners",
                    data: {
                        ClassID: classID,
                        SectionID: sectionID,
                        Column: "PlannerID"
                    },
                    success: function (data) {
                        ids = JSON.parse(data);

                    }
                }
            ),


            $.ajax(
                {
                    type: "POST",
                    url: "get_planners",
                    data: {
                        ClassID: classID,
                        SectionID: sectionID,
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
                    url: "get_planners",
                    data: {
                        ClassID: classID,
                        SectionID: sectionID,
                        Column: "Year"
                    },
                    success: function (data) {
                        year = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),
            $.ajax(
                {
                    type: "POST",
                    url: "get_url",
                    data: {
                        Type: 4,
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
        $("#table_head").html('<tr><td>Title</td> <td>Year</td><td>Action</td></tr>');
        $.each(ids, function (i, item) {


            $("#table_body").append("<tr><td>" + titles[i] + "</td>" +
                "<td>" + year + "</td>" +
                "<td><a class='btn btn-sm btn-outline-primary' href='" + url + item + "'>SAVE</a></td></tr>");

        });

    }
    else {
        $("#table_body").html('');

        $("#table_body").append("<tr><td>No data Available</td></tr>");


    }


}

