;
(function () {
    var counter = -1;
    var activecounter = false;
    var totalIndex = $(".mainForm .formSection").length;
    var scrollTopValue = (400 * $(window).height()) / 984;
    // console.log('scrollTopValue ', scrollTopValue);
    $("#formStart").click(function () {
        $(".startForm").addClass('deactive');
        $(".mainForm").addClass("active");
        $(".formSection.formInit").removeClass("formInit");
        counter = counter + 1;
        activateWithCounter();
        scrollToPluss(scrollTopValue);
        $("#startForm").focus();
        $('#eventName').focus();
    });
    $("#formstart").keypress(function (e) {
        if (e.keyCode == 13) {
            $(".startForm").addClass('deactive');
            $(".mainForm").addClass("active");
            $(".formSection.formInit").removeClass("formInit");
            counter = counter + 1;
            activateWithCounter();
            scrollToPluss(scrollTopValue);
            $("#startForm").focus();
            $('#eventName').focus();
        }
    });
    $(".proceedToNext").click(function (e) { // #proceedFirst 
        e.stopPropagation();
        $(".formSection.formMove").removeClass("formMove");
        $(".arrow-foot").addClass("active");
        counter = counter + 1;
        activateWithCounter();
        scrollToPluss(scrollTopValue);
        activecounter = true;
    });
    $(".enterinput").keypress(function (e) {
        if (e.keyCode == 13) {
            if (!e.shiftKey) {
                e.stopPropagation();
                e.preventDefault();
                $(".formSection.formMove").removeClass("formMove");
                $(".arrow-foot").addClass("active");
                counter = counter + 1;
                activateWithCounter();
                scrollToPluss(scrollTopValue);
                activecounter = true;
            }
        }
    });

    $(".updatebutton").click(function () {

        var thisType = $(this).attr("data-type");
        if (thisType == 'next' && counter < totalIndex - 1) {
            counter = counter + 1;
            activateWithCounter();
            scrollToPluss(scrollTopValue);
        } else if (thisType == 'prev' && counter !== 0) {
            counter = counter - 1;
            activateWithCounter();
            scrollToPluss(scrollTopValue);
        }
    });

    $(".mainForm .formSection").click(function () {

        var thisIndex = $(this).index();
        // console.log('thisIndex ', thisIndex);
        counter = thisIndex;
        activateWithCounter();
        scrollToPluss(scrollTopValue);
    });

    $(".mainForm .formSection > .withArr").click(function (e) {
        e.stopPropagation();
    });


    window.addEventListener('mousewheel', scrollEventHandler, false);
    window.addEventListener("DOMMouseScroll", scrollEventHandler, false);


    function scrollEventHandler(event) {
        // var wDelta = e.wheelDelta < 0 ? 'down' : 'up';
        if ('wheelDelta' in event) {
            rolled = event.wheelDelta;
        } else { // Firefox
            // The measurement units of the detail and wheelDelta properties are different.
            rolled = -40 * event.detail;
        }
        var wDelta = rolled < 0 ? 'down' : 'up';
        if (wDelta === 'up' && counter >= 1) {
            counter = counter - 1;
            activateWithCounter();
            scrollToPluss(scrollTopValue);
        } else if (wDelta === 'down' && counter < totalIndex - 1) {
            if (counter >= 0 && activecounter == true) {
                counter = counter + 1;
                activateWithCounter();
                scrollToPluss(scrollTopValue);
            }
        }

    }

    function activateWithCounter() {
        if (counter > totalIndex - 1) {
            counter = totalIndex - 1;
            return false;
        } else {
            $(".mainForm .formSection").removeClass("active");
            $(".mainForm .formSection:eq( " + counter + " )").addClass("active");
            if (counter + 1 == totalIndex) {
                $(".subMit-bottom").addClass("active");
            } else {
                $(".subMit-bottom").removeClass("active");
            }
        }
    }

    function scrollToPluss(value) {
        //if(counter )
        var windowWidth = $(window).width();
        var activeSection = $(".mainForm .formSection:eq( " + counter + " )");
        //if ($(activeSection) !== undefined) {
        var offsetTop = $(activeSection).offset().top;
        //}
        var offminus = value;
        if (windowWidth > 767) {
            if (counter === totalIndex - 1) {
                $("html, body").animate({
                    scrollTop: offsetTop - 150
                }, 300);
            } else {
                $("html, body").animate({
                    scrollTop: offsetTop - offminus
                }, 300);
            }

        } else {
            $("html, body").animate({
                scrollTop: offsetTop - 50
            }, 300);
        }
    }
    // just a demo function for focusing input of selectbox

    $("#departmentGroup").change(function (e) {
        e.stopPropagation();
        if ($(this).is(':checked')) {
            $("#withArr").focus();
            var activeSection = $(".mainForm .formSection:eq( " + counter + " )");
            if (activeSection) {
                var offsetTopFc = $(activeSection).offset().top;
            }
            $("html, body").animate({
                scrollTop: offsetTopFc - 100
            }, 300);
        }
    });
}());

// --- activating next section and deactivationg previous section, adding 1 or removeing 1 with update of "totalIndex" variable