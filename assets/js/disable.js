/**
 * Created by Master Aamir on 05-Apr-17.
 */

$(document).ready(function () {

    $(document).on("contextmenu",function(e){
            e.preventDefault();
    });


    Object.defineProperty(console, '_commandLineAPI',
        { get : function() {

            throw "Console is disabled";
        }

        });
});
