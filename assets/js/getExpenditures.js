var ids = [] , names = [] , amounts = [] , types = [] , dates = [];
var editUrl = deleteUrl = '';
$(document).ready(


    function () {




        $("#btn_get").click(function () {
            get_expenditures();
        });



        $("#month").change(function () {
            $("#box_expenditures").hide(1000);
        });
        $("#year").change(function () {
            $("#box_expenditures").hide(1000);
        });

    }
);


function get_expenditures()
{
    month = $("#month").val();
    year = $("#year").val();

    if(month != 0 && year != 0) {

        $.when(

            $.ajax(
                {
                    type: "POST",
                    url: "get_expenditures",
                    data: {
                        Month: month,
                        Year : year,
                        Column: "ExpenditureID"
                    },
                    success: function (data) {
                        ids = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),


            $.ajax(
                {
                    type: "POST",
                    url: "get_expenditures",
                    data: {
                        Month: month,
                        Year : year,
                        Column: "Name"
                    },
                    success: function (data) {
                        names = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_expenditures",
                    data: {
                        Month: month,
                        Year : year,
                        Column: "Amount"
                    },
                    success: function (data) {
                        amounts = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),

            $.ajax(
                {
                    type: "POST",
                    url: "get_expenditures",
                    data: {
                        Month: month,
                        Year : year,
                        Column: "Date"
                    },
                    success: function (data) {
                        dates = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),


            $.ajax(
                {
                    type: "POST",
                    url: "get_expenditures",
                    data: {
                        Month: month,
                        Year : year,
                        Column: "Mode"
                    },
                    success: function (data) {
                        types = JSON.parse(data);

                        //alert(roll);
                    }
                }
            ),

        $.ajax(
            {
                type: "POST",
                url: "get_url",
                data: {
                    Type: 1,
                },
                success: function (data) {
                    editUrl = JSON.parse(data);
                    //alert(names);
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
                        deleteUrl = JSON.parse(data);
                        //alert(names);
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
    else
    {
        populate_table();
    }
}

function populate_table()
{

        var total = 0;

        $("#box_expenditures").show(1000);
        $("#pagination").hide();
        if(ids != "") {
            $("#table_body").html('');
            $.each(ids , function (i , item) {

                total += Number(amounts[i]);
                $("#table_body").append("<tr><td>EXP-100"+item+"</td><td>"+names[i]+"</td>" +
                    "<td>"+amounts[i]+"</td>"+
                    "<td>"+dates[i]+"</td>"+
                    "<td><a href='"+editUrl+item+"'><i class='fa fa-eye'></i></a></td>"+
                "<td><a name='remove' href='"+deleteUrl+item+"'><i class='fa fa-remove'></i></a></td>");
            })
            $("#table_body").append("<tr><td></td><td class='alert-danger Bold'>Total</td><td class='alert-success Bold'>" + total + "</td></tr>");
        }
        else
        {
            $("#table_body").html('');

            $("#table_body").append("<tr><td>No data Available</td></tr>");

        }

    $("a[name=remove]").click(function (event) {

        var click = confirm('Are you sure you want to delete ?');

        if (click == true) {
            // Save it!
        } else {
            // Do nothing!
            event.preventDefault();
        }

    });
}

