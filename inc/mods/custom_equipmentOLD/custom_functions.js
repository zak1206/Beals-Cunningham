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