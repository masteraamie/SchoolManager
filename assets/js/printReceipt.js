/**
 * Created by Master Aamir on 05-Apr-17.
 */

$(document).ready(function () {

    $("#btn_print").click(function () {

        var divToPrint = document.getElementById('printDiv');

        var newWin=window.open('','Print-Window');

        newWin.document.open();

        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

        newWin.document.close();

        setTimeout(function(){newWin.close();},10);

    });

});
