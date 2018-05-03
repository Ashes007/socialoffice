$(window).load(function () {
    $("#formstart").focus();
    $("#formstart").keypress(function (e) {
        if (e.keyCode == 13) {
            var targetThis = $(this);
            startForm(targetThis);
        }
    });
});
$("#formList").click(function () {
    var targetThis = $(this);
    startForm(targetThis);
});
function startForm(elem){
    $(elem).closest(".formstartContainer").addClass("deactive");
    $(".formList.firstForm ").show();
    setTimeout(function () {
        $(".formList.firstForm ").show();
        $(".formList.firstForm ").find('li').addClass('active');
        $(".formList.firstForm ").find('li').find('input').focus();
        scrollToPluss(400);
        $(elem).closest(".formstartContainer").hide();
    }, 700);
}

// ------------ opening form script -------------
$("#startFormKey").click(function (e) {
    e.stopPropagation();
    $(".formList.secondForm ").show();
    $(".formList li").removeClass("active");
    setTimeout(function () {
        $(".formList.secondForm ").find('li:first-child').addClass('active');
        $(".formList.secondForm ").find('li:first-child').find('input').focus();
        scrollToPluss(400);
        // $(".arrow-foot").addClass("active");
    });
});

function scrollToPluss(value) {
    var windowWidth = $(window).width();
    var activeLi = $(".typeForm").find("li.active");
    var offsetTop = $(activeLi).offset().top;
    var offminus = value;
    // console.log('offminus ', offminus);
    // var windowScrollTop =  $(window).scrollTop();
    // var docHeight = $(document).height();
    // console.log('windowScrollTop ', windowScrollTop, 'docHeight ', docHeight);
    if(windowWidth > 767){
        $("html, body").animate({
            scrollTop: offsetTop - offminus
        }, 300);
    }else{
        $("html, body").animate({
            scrollTop: offsetTop - 50
        }, 300);
    }
    
}
// ----- click and got to that list
$(".typeForm").find("li").click(function () {
    var checklast = $(this).attr('data-pos');
    $(".typeForm").find("li").removeClass("active");
    $(this).addClass("active");
    // scrollToPluss(500);
    if (checklast == 'last') {
        console.log(789);
        $(".subMit-bottom").addClass('active');
        scrollToPluss(200);
    }
    else {
        $(".subMit-bottom").removeClass('active');
        scrollToPluss(400);
    }
});

// $(".typeForm").find(".thisishidden").each(function () {
//     $(this).click(function () {
//         var thisParent = $(this).closest('li');
//         scrollToPluss();
//     });
// });

// $(".typeForm").find("input").change(function () {
//     $(this).closest("li").find(".thisishidden").click();
// });

$(".next-prev-btn").click(function () {
    var thisData = $(this).attr("data-id");
    var activeLi = $(".formList .secondForm").children('li.active');
    if (thisData == nextField) {

    }
    scrollToPluss();
});