
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

        $("#hidden_url_c").val(equiLink);
        $("#equipment_link").val(equiLink);
        $("#equipment_title").val(equiTitle);
    })
})

$(function() {

  ///THIS IS A CORE FUNCTION THAT HELPS THE FORMS WORK.. DO NOT DELETE///
    $(".form-process").validate({
        submitHandler: function(form) {
            var formName = $(form).attr('id');
            $('.loader-overlay').show();
            $(".loader-message").show();
            $.ajax({
                type: "POST",
                url: 'inc/shortCalls.php?action=formsubmit',
                data: new FormData(form),
                contentType: !1,
                cache: !1,
                processData: !1,
                success: function(data) {
                    var response = $.parseJSON(data);
                    var rescode = response.code;
                    var resmessage = response.message;
                    if (rescode == 'invalid') {
                        $("#" + formName + "_alerts").html('<div class="alert alert-danger">' + resmessage + '</div>')
                    } else {
                        $("#" + formName).remove();
                        $("#" + formName + "_alerts").html('' + resmessage + '')
                        $('.loader-overlay').hide();
                        $(".loader-message").hide();
                    }
                }
            })
        }
    })

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

// slider for ohter products
$(document).ready(function(){
    $('.other_product_slide').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 1,
                  infinite: true,
                  dots: true
                }
              },
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
              infinite: true,
              arrows: false,
              dots: true
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              infinite: true,
              arrows: false,
              dots: true
            }
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
              arrows: false,
              dots: true
            }
          }
        ]
      });
});

