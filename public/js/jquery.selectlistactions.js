/**
 *  jQuery.SelectListActions
 *  https://github.com/esausilva/jquery.selectlistactions.js
 *
 *  (c) http://esausilva.com
 */

(function ($) {
    //Moves selected item(s) from sourceList to destinationList
    $.fn.moveToList = function (sourceList, destinationList) {
        var opts = $(sourceList + ' option:selected');
        if (opts.length == 0) {
            console.log("Inside moveToList");
            alert("Nothing to move");
        }

        $(destinationList).append($(opts).clone());
    };

    //Moves all items from sourceList to destinationList
    $.fn.moveAllToList = function (sourceList, destinationList) {
        var opts = $(sourceList + ' option');
        if (opts.length == 0) {
            console.log("Inside moveAllToList");
            alert("Nothing to move");
        }

        $(destinationList).append($(opts).clone());
    };

    //Moves selected item(s) from sourceList to destinationList and deleting the
    // selected item(s) from the source list
    $.fn.moveToListAndDelete = function (sourceList, destinationList) {
        var src_opts = $(sourceList + ' option:selected');
        var no_opts = $(destinationList + " option[value!='0']");
        if (src_opts.length == 0) {
            console.log("Inside moveToListAndDelete");
            alert("Nothing to move");
        }
        $(src_opts).remove();
        $(destinationList).prepend($(src_opts).clone());

        if(sourceList.endsWith("1"))
        {
            if($(destinationList + " option[value='0']").length > 0)
            {
                var des_opts = $(destinationList + " option[value!='0']");
                $(des_opts).remove();
                $(sourceList).prepend($(no_opts));
            }
        }
    };

    //Moves all items from sourceList to destinationList and deleting
    // all items from the source list
    $.fn.moveAllToListAndDelete = function (sourceList, destinationList) {
        var src_opts = $(sourceList + " option[value!='0']");
        var no_opts = $(destinationList + " option[value!='0']");
        /*
        if (src_opts.length == 0) {
            console.log("Inside moveAllToListAndDelete");
            alert("Nothing to move");
        }
        */
        $(src_opts).remove();
        $(destinationList).prepend($(src_opts).clone());

        if(sourceList.endsWith("1"))
        {
            if($(destinationList + " option[value='0']").length > 0)
            {
                var des_opts = $(destinationList + " option[value!='0']");
                $(des_opts).remove();
                $(sourceList).prepend($(no_opts));
            }
        }

        /*
        var opts = $(sourceList + ' option');
        if (opts.length == 0) {
            //alert("Nothing to move");
        }

        $(opts).remove();
        $(destinationList).append($(opts).clone());
        */
    };

    //Removes selected item(s) from list
    $.fn.removeSelected = function (list) {
        var opts = $(list + ' option:selected');
        if (opts.length == 0) {
            console.log("Inside removeSelected");
            alert("Nothing to remove");
        }

        $(opts).remove();
    };

    //Moves selected item(s) up or down in a list
    $.fn.moveUpDown = function (list, btnUp, btnDown) {
        var opts = $(list + ' option:selected');
        if (opts.length == 0) {
            console.log("Inside moveUpDown");
            alert("Nothing to move");
        }

        if (btnUp) {
            opts.first().prev().before(opts);
        } else if (btnDown) {
            opts.last().next().after(opts);
        }
    };
})(jQuery);
