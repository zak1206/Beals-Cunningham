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

$(function(){
    $("#locasel").on('change',function(){
        if($(this).val() != '') {
            $('.save-later').removeAttr("disabled");
            $('.save-later').removeClass('disabs');
        }else{
            $('.save-later').attr('disabled', 'disabled');
            $('.save-later').addClass('disabs');
        }
    })
})

$(".save-later").on('click',function(){
    var eqipid = $(this).data('eqid');
    var eqname = $(this).data('eqname');
    var eqtype = $(this).data('eqtype');
    var price = $(this).data('price');
    var url = $(this).data('url');
    var tabs = $(this).data('tabs');
    var qty = $("#qty").val();
    var itemid = $(this).data('itemid');
    var locasel = $("#locasel").val();
    $.ajax({
        type: 'POST',
        url: 'inc/ajaxCalls.php?action=saveforlater',
        data: {
            'eqipid': eqipid,
            'eqname': eqname,
            'eqtype': eqtype,
            'price': price,
            'emcomurl': url,
            'tabs': tabs,
            'qty': qty,
            'itemid': itemid,
            'locasel': locasel
        },
        success: function(msg){
           // alert(msg);
            var obj = jQuery.parseJSON(msg)
               // alert(obj.response);
            if(obj.response == 'good'){
                $('.save-later').html('ADDED to CART!');
                $('.save-later').prop("disabled",true);
                pullMiniCart();
            }else{
                alert(obj.message);
            }
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

/*get mini cart*/
function pullMiniCart(){
    $.ajax({
        url:'inc/ajaxCalls.php?action=getmini',
        cache:false,
        success: function (data){
            var parsedJson = $.parseJSON(data);
            $(".cartcount").html(parsedJson.itemCount);
            $(".cart-dropdown-menu").html(parsedJson.cart);
            $(".cart-button").trigger('click');
        }
    })
}