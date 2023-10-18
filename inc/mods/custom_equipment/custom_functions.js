$('.product-box').hover(function () {

    $(this).find(".quick-btn").fadeIn('fast')
}, function () {
    $(this).find(".quick-btn").fadeOut()
});

$(".quick-btn").on('click', function () {
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
        success: function (msg) {
            $('.modal .modal-header').html('<div class="col-md-8">Quick View</div><div class="col-md-4" style="text-align: right">' + prevButton + '' + nextButton + '</div><div class="clearfix"></div>');
            $('.modal .modal-body').html(msg);
            $('.modal').modal();
            resetMigration()
        }
    })
})

$(function () {
    $("#locasel").on('change', function () {
        if ($(this).val() != '') {
            $('.add-to-cart').removeAttr("disabled");
            $('.add-to-cart').removeClass('disabs');
        } else {
            $('.add-to-cart').attr('disabled', 'disabled');
            $('.add-to-cart').addClass('disabs');
        }
    })
})

// Get Shipping Settings using Promises
function GetShippingSettings() {
    return Promise.all([
        GetShippingApiKey(),
        GetShippingApiType(),
        GetShippingApiUsage()
    ]).then(([api, type, usage]) => {
        console.log("Shipping Type: " + type);
        console.log("Shipping Usage: " + usage);
        console.log("Shipping API Key: " + api);
        return api;
    }).catch(error => {
        console.error(error);
        throw error;
    });
}

// Get Shippo/ShipEngine API Key
function GetShippingApiKey() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "inc/mods/custom_equipment/command_processor.php?action=shipping-settings",
            dataType: "json",
            success: function (resp) {
                if (resp.response === "success") {
                    console.log("Shipping API Retrieved...");
                    resolve(resp.apiKey);
                } else {
                    console.log("Failed To Retrieve Shipping API...");
                    reject("[ERROR] Failed To Retrieve Shipping API");
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                console.error("AJAX Error:", errorThrown);
                reject("[ERROR] AJAX Error");
            }
        });
    });
}

// Get Shipping Type - shippo | shipengine
function GetShippingApiType() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "inc/mods/custom_equipment/command_processor.php?action=shipping-settings",
            dataType: "json",
            success: function (resp) {
                if (resp.response === "success") {
                    resolve(resp.type);
                } else {
                    console.log("[ERROR] Failed To Get Shipping API Type...");
                    reject("[ERROR] Failed To Get Shipping API Type");
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                console.error("AJAX Error:", errorThrown);
                reject("[ERROR] AJAX Error");
            }
        });
    });
}

//Add Item To Cart
function AddToCart() {
    console.log("Adding Item To Cart");

    var id = $(".add-to-cart").data("id");
    var title = $(".add-to-cart").data("title");
    var price = $(".add-to-cart").data("price");
    var url = $(".add-to-cart").data("url");
    var uniqId = $(".add-to-cart").data("uniq");
    var shipType = $(".add-to-cart").data("shiptype");

    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/command_processor.php?action=addtocart",
        data: {
            id: id,
            title: title,
            price: price,
            url: url,
            shipType: shipType,
            uniqId: uniqId
        },
        dataType: "json",
        success: function (obj) {
            if (obj.response == "good") {
                $(".add-to-cart").html("ADDED TO CART!");
                $(".add-to-cart").prop("disabled", true);
                UpdateCart();
                location.reload();
            } else {
                alert(obj.message);
            }
        }
    })
}

//Remove Item From Cart
function RemoveCartItem(id) {
    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/command_processor.php?action=removecartitem",
        data: {
            id: id
        },
        success: function (obj) {
            console.log("Removed Item!: " + obj);
            $(".cart-item-" + id).addClass("d-none");
            UpdateCart();
        }
    })
}

document.addEventListener('load', function () {
    console.log("--------------- Page Loaded!");
    UpdateCart();
});

//Update Cart In Navigation
function UpdateCart() {
    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/cart/shopping_cart.php",
        dataType: 'json',
        success: function (obj) {
            $(".cart-dropdown").html(obj.html);
            $('.cartcount').val(obj.count);
            location.reload();
        }
    })
}

function WriteReview(product) {
    var name = $("#mod-name").val();
    var loc = $("#mod-loc").val();
    var title = $("#mod-title").val();
    var desc = $("#mod-desc").val();
    var usage = $("#mod-usage").val();
    var length = $("#mod-length").val();
    var rating = $("#mod-rating").val();
    var prod_name = product;

    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/command_processor.php?action=writereview",
        data: {
            name: name,
            location: loc,
            title: title,
            description: desc,
            usage: usage,
            length: length,
            rating: rating,
            product: prod_name
        },
        success: function (html) {
            $("#review-msg").html(html);
        }
    })
}

function ChangeImage(path) {
    $(".main-img").attr("src", path);
    $(".pop-img").attr("src", path);
}

function resetMigration() {
    $(".mig-btn").on('click', function () {
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
            success: function (msg) {
                $('.modal .modal-header').html('<div class="col-md-8">Quick View</div><div class="col-md-4" style="text-align: right">' + prevButton + '' + nextButton + '</div><div class="clearfix"></div>');
                $('.modal .modal-body').html(msg);
                $('.modal').modal();
                resetMigration()
            }
        })
    })
}


