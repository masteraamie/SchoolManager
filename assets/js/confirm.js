/**
 * Created by Master Aamir on 05-Apr-17.
 */

$(document).ready(function () {

    $("a[name=remove]").click(function (event) {

        var click = confirm('Are you sure you want to delete ?');

        if (click == true) {
            // Save it!
        } else {
            // Do nothing!
            event.preventDefault();
        }

    });

});
