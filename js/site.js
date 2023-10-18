
$(function(){
    $('.your-class').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        adaptiveHeight: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        asNavFor: '.your-class',
        dots: true,
        arrows: false,
        centerMode: true,
        focusOnSelect: true
    });

    $(".moreinfo").on('click',function(){
        var equiLink = $(this).data('url');
        var equiTitle = $(this).data('equipment');

        $("#equipment_link").val(equiLink);
        $("#equipment_title").val(equiTitle);
    })
})

$(function() {

  ///THIS IS A CORE FUNCTION THAT HELPS THE FORMS WORK.. DO NOT DELETE///
    $(".form-process").validate({
    submitHandler: function(form) {
        var formName = $(form).attr('id');
        var valid = true;

        // Iterate through all form fields
        $(form).find('input, textarea').each(function() {
            // Check if the field value is empty or contains only spaces
            if ($(this).val() == " ") {
                valid = false;
                return false; // Exit the loop early if an invalid field is found
            }
        });

        if (!valid) {
            $("#" + formName + "_alerts").html('<div class="alert alert-danger">Fields cannot be empty or contain only spaces.</div>');
        } else {
            $.ajax({
                type: "POST",
                url: 'inc/shortCalls.php?action=formsubmit',
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    var response = $.parseJSON(data);
                    var rescode = response.code;
                    var resmessage = response.message;
                    if (rescode == 'invalid') {
                        $("#" + formName + "_alerts").html('<div class="alert alert-danger">' + resmessage + '</div>');
                    } else {
                        $("#" + formName).remove();
                        $("#" + formName + "_alerts").html('' + resmessage + '');
                    }
                }
            });
        }
    }
});

    //Caffeine Click Event - DO NOT DELETE//

    $("[data-cafftrak]").on( "click", function () {
        var eventTar = $(this).data('cafftrak');
        var href = document.location.href;
        var lastPathSegment = href.substr(href.lastIndexOf('/') + 1);
        //console.log(eventTar);
        $.ajax({
            url:'inc/ajaxCalls.php?action=eventtrak&target='+eventTar+'&page='+lastPathSegment,
            success: function(data){
                // alert(data);
            }
        })
    } );
  
})
function recallCaffTrak(){
    $("[data-cafftrak]").on( "click", function () {
        var eventTar = $(this).data('cafftrak');
        var href = document.location.href;
        var lastPathSegment = href.substr(href.lastIndexOf('/') + 1);
        //console.log(eventTar);
        $.ajax({
            url:'inc/ajaxCalls.php?action=eventtrak&target='+eventTar+'&page='+lastPathSegment,
            success: function(data){
                // alert(data);
            }
        })
    } );
}
const observer = lozad(); // lazy loads elements with default selector as '.lozad'
observer.observe();

$(function() {
    $("#bs-example-navbar-collapse-1 ul:first-child").append('<li class="nav-item"><a class="search-toggle nav-link" href="javascript:void(0)"><i class="fa fa-search"></i></a></li>');

    $('.search-toggle').on('click', function () {
        $("#site-search").slideToggle('fast');
        $("#serterm").focus();
    })

    $(document).ready(function () {
        $('#cart-popover').popover({
            html: true,
            container: 'body',
            content: function () {
                return $('#popover_content_wrapper').html();
            },
            trigger: 'focus'
        });
    });

});

$(function(){
    $.ajax({
        url:'inc/ajaxCalls.php?action=getmini',
        cache:false,
        success: function (data){
            var parsedJson = $.parseJSON(data);
            $(".cartcount").html(parsedJson.itemCount);
            $(".cart-dropdown-menu").html(parsedJson.cart);
        }
    })
})


