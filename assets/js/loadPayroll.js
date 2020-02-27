/**
 * Created by Master Aamir on 19-Mar-17.
 */

$(document).ready(


    function () {
        get_salaries();

        $("#viewPay").click(function () {
            get_salaries();
        });

    }
);


function get_salaries()
{
    var ids = "" ,names = "", salary = "";
    var month = $("#month").val();
    var year = $("#year").val();
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
                        Column: "Salary"
                    },
                    success: function (data) {

                        salary = JSON.parse(data);
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
                        names = JSON.parse(data);
                    }
                }
            )

        ).then(function () {
                populate_table(names , salary , ids);
            } , function () {
                alert("Failure");
            });

    }
}

function populate_table(names , salary , ids)
{

    total = 0;
    if(ids != "") {
        $("#table_body").html("");
        for (var i = 0; i < names.length; i++) {
            $("#table_body").append("<tr><td>" + ids[i] + "</td><td>" + names[i] + "</td><td>" + salary[i] + "</td></tr>");
            total += Number(salary[i]);
        }
        $("#table_body").append("<tr><td></td><td class='alert-danger Bold'>Total</td><td class='alert-success Bold'>" + total + "</td></tr>");
    }
    else {
        $("#table_body").html("");
        $("#table_body").append("<tr><td>No Data Available</td><td></td><td></td></tr>");
    }
}
