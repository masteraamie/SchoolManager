/**
 * Created by Master Aamir on 05-Apr-17.
 */

$(document).ready(function () {

    check();
    $("#mode").change(function () {


       check();

    });

});

function check() {
    var val = $("#mode").val();

    if(val == 2)
    {
        $("#cheque").prop('disabled' , false);
    }
    else
    {
        $("#cheque").prop('disabled' , true);
    }
}