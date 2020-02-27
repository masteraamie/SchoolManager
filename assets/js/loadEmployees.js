/**
 * Created by Master Aamir on 19-Mar-17.
 */

var fnames = titles = lnames = contacts = loginIDs = ids = [];
var url = "";
$(document).ready(


    function () {
        $("#export").hide();
        $("#viewPay").click(function () {
            $("#export").show();
            get_salaries();
        });

        $("#department").change(function () {
            $("#table").hide();
        });

    }
);


function get_salaries()
{
    var dept = $("#department").val();
    if(dept != 0) {


        $.when(

            $.ajax(
                {
                    type: "POST",
                    url: "get_from_employees",
                    data: {
                        DepartmentID: dept,
                        Column: "EmployeeID"
                    },
                    success: function (data) {
                        ids = JSON.parse(data);
                    }
                }
            ) ,


            $.ajax(
                {
                    type: "POST",
                    url: "get_from_employees",
                    data: {
                        DepartmentID: dept,
                        Column: "FirstName"
                    },
                    success: function (data) {
                        fnames = JSON.parse(data);
                    }
                }
            ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_from_employees",
                    data: {
                        DepartmentID: dept,
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
                    url: "get_from_employees",
                    data: {
                        DepartmentID: dept,
                        Column: "LastName"
                    },
                    success: function (data) {
                        lnames = JSON.parse(data);
                    }
                }
            ),

        $.ajax(
            {
                type: "POST",
                url: "get_from_employees",
                data: {
                    DepartmentID: dept,
                    Column: "Contact"
                },
                success: function (data) {
                    contacts = JSON.parse(data);
                }
            }
        ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_url",
                    success: function (data) {
                        url = JSON.parse(data);
                        //alert(names);
                    }
                }
            )





        ).then(function () {
                populate_table();
            } , function () {
                alert("Failure");
            });

    }
    else
    {
        $.when(
            $.ajax(
                {
                    type: "POST",
                    url: "get_all_employees",
                    data: {
                        Column: "EmployeeID"
                    },
                    success: function (data) {
                        ids = JSON.parse(data);
                    }
                }
            ),


            $.ajax(
                {
                    type: "POST",
                    url: "get_all_employees",
                    data: {
                        Column: "FirstName"
                    },
                    success: function (data) {
                        fnames = JSON.parse(data);
                    }
                }
            ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_all_employees",
                    data: {
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
                    url: "get_all_employees",
                    data: {
                        Column: "LastName"
                    },
                    success: function (data) {
                        lnames = JSON.parse(data);
                    }
                }
            ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_all_employees",
                    data: {
                        Column: "Contact"
                    },
                    success: function (data) {
                        contacts = JSON.parse(data);
                    }
                }
            ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_all_employees",
                    data: {
                        Column: "LoginID"
                    },
                    success: function (data) {
                        loginIDs = JSON.parse(data);
                    }
                }
            ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_url",
                    success: function (data) {
                        url = JSON.parse(data);
                        //alert(names);
                    }
                }
            )
        ).then(function () {
            populate_table();
        }, function () {
            alert("Failure");
        });

    }
}

function populate_table()
{


    if(ids != "") {
        $("#table_body").html("");
        for (var i = 0; i < ids.length; i++) {
            $("#table_body").append("<tr><td>" + ids[i] + "</td><td>" +  titles[i] + fnames[i] +
                 " "+ lnames[i] + "</td><td>" + contacts[i] + "</td><td>" + loginIDs[i] + "</td>" +
                "<td><a href='"+url+ids[i]+"'><i class='fa fa-eye'></i></a></td></tr>");
        }

        $("#export").show();
    }
    else {
        $("#table_body").html("");
        $("#table_body").append("<tr><td>No Data Available</td><td></td><td></td></tr>");
    }

    $("#table").show(1000);
}
