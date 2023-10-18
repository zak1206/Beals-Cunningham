$('.product-box').hover(function() {

    $(this).find(".quick-btn").fadeIn('fast')
}, function() {
    $(this).find(".quick-btn").fadeOut()
});
$(".quick-btn").on('click', function() {
    var prodid = $(this).data('qukid');
    var prodtype = $(this).data('eqtype');
    var nextLink = $(this).closest('.product-box').next().data('boxval');
    var prevLink = $(this).closest('.product-box').prev().data('boxval');
    if (prevLink != undefined) {
        var prevButton = '<button class="btn btn-success mig-btn" data-qukid="' + prevLink + '" data-eqtype="' + prodtype + '"><i class="fa fa-angle-left" aria-hidden="true"></i></button>'
    } else {
        var prevButton = ''
    }
    if (nextLink != undefined) {
        var nextButton = '<button class="btn btn-success mig-btn" data-qukid="' + nextLink + '" data-eqtype="' + prodtype + '"><i class="fa fa-angle-right" aria-hidden="true"></i></button>'
    } else {
        var nextButton = ''
    }
    $.ajax({
        url: 'inc/mods/deere_equipment/deere_ajax.php?action=quickview',
        type: 'POST',
        data: {
            'equipid': prodid,
            'equiptype': prodtype,
            'linkset': window.location.href
        },
        success: function(msg) {
            $('.modal .modal-header').html('<div class="col-md-8">Quick View</div><div class="col-md-4" style="text-align: right">' + prevButton + '' + nextButton + '</div><div class="clearfix"></div>');
            $('.modal .modal-body').html(msg);
            $('.modal').modal();
            resetMigration()
        }
    })
})

function resetMigration() {
    $(".mig-btn").on('click', function() {
        var prodid = $(this).data('qukid');
        var prodtype = $(this).data('eqtype');
        var nextLink = $('.probox' + prodid).closest('.product-box').next().data('boxval');
        var prevLink = $('.probox' + prodid).closest('.product-box').prev().data('boxval');
        if (prevLink != undefined) {
            var prevButton = '<button class="btn btn-success mig-btn" data-qukid="' + prevLink + '" data-eqtype="' + prodtype + '"><i class="fa fa-angle-left" aria-hidden="true"></i></button>'
        } else {
            var prevButton = ''
        }
        if (nextLink != undefined) {
            var nextButton = '<button class="btn btn-success mig-btn" data-qukid="' + nextLink + '" data-eqtype="' + prodtype + '"><i class="fa fa-angle-right" aria-hidden="true"></i></button>'
        } else {
            var nextButton = ''
        }
        $.ajax({
            url: 'inc/mods/deere_equipment/deere_ajax.php?action=quickview',
            type: 'POST',
            data: {
                'equipid': prodid,
                'equiptype': prodtype,
                'linkset': window.location.href
            },
            success: function(msg) {
                $('.modal .modal-header').html('<div class="col-md-8">Quick View</div><div class="col-md-4" style="text-align: right">' + prevButton + '' + nextButton + '</div><div class="clearfix"></div>');
                $('.modal .modal-body').html(msg);
                $('.modal').modal();
                resetMigration()
            }
        })
    })
}

$(function(){
    $(".save-later").on('click', function() {
        var eqipid = $(this).data('eqid');
        var eqname = $(this).data('eqname');
        var eqtype = $(this).data('eqtype');
        var price = $(this).data('price');
        var url = $(this).data('url');
        $.ajax({
            type: 'POST',
            url: 'inc/ajaxCalls.php?action=saveforlater',
            data: {
                'eqipid': eqipid,
                'eqname': eqname,
                'eqtype': eqtype,
                'price': price,
                'url': url
            },
            success: function(msg) {
                $(".shopping-cart-items").html(msg);
                var thenums = parseInt($(".sav-nums").html());
                $(".sav-nums").html(thenums + 1);
                var cart_total = $("#cart_total").val();
                $(".the-total").html('$' + cart_total);
                $(".save-later").html('ADDED to CART!');
                $(".save-later").prop("disabled", !0);
                $(".shopping-cart").show();
                $(document).on('click', function(e) {
                    $('[data-toggle="popover"],[data-original-title]').each(function() {
                        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                            (($(this).popover('hide').data('bs.popover') || {}).inState || {}).click = !1
                        }
                    })
                })
            }
        })
    })
})