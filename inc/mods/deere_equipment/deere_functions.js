$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
    if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
    }
    var $subMenu = $(this).next('.dropdown-menu');
    $subMenu.toggleClass('show');


    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
        $('.dropdown-submenu .show').removeClass('show');
    });


    return false;
});

$(function(){
    $('#compare_select').change(function(){
        $('option:selected', this).hide();
        // console.log("changed");
        //var id = $("#comp-options").data("equipid");
        var val = this.value;
        var eq = $(this).find(':selected').data('seleq');

        $.ajax({
            type: 'GET',
            url: 'inc/mods/deere_equipment/compare.php?eqname='+eq+'&equipid='+val,
            dataType: 'json',
            cache: false,
            success: function (data) {
                console.log(data);
                var i = 0;
                $('.deerets').each(function()
                {
                    if(data[i] == undefined) {

                    }else {

                        $(this).append('<td style="border:solid thin #dee2e6">' + data[i] + '</td>');

                        i++;
                    }
                });
                $(".table_head").append('<td></td>');
            }

        });


    });

    $(".specstab").on("click", ".remove-col", function ( event ) {
        var optval = $(this).data("value");
        console.log(optval);

        $('#compare_select option[value="'+optval+'"]').show();

        // Get index of parent TD among its siblings (add one for nth-child)
        var ndx = $(this).parent().index() + 1;
        // Find all TD elements with the same index
        $("td", event.delegateTarget).remove(":nth-child(" + ndx + ")");
    });
});

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