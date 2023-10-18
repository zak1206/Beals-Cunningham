var prevHtml = "";

function Checkout_Step2() {
    prevHtml = $('.next-button').html();
    var imageElement = $('<img>');
    imageElement.attr('src', 'img/loader-green.gif');
    imageElement.attr('width', 45);
    imageElement.attr('height', 45);
    $('.next-button').html("");
    $('.next-button').html(imageElement);

    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/checkout/checkout-page.php",
        data: {
            action: 'step-2',
            test: 'titties'
        },
        success: function (response) {
            $('.next-button').html(prevHtml);
            $(".checkout-content").html(response);
        },
        error: function (error) {
            $('.form-errors').html(error);
            $('.form-errors').removeClass('d-none');
            $('.next-button').html(prevHtml);
        }
    });
}

function Checkout_Step3() {
    const prevHtml = $('.next-button').html();
    var imageElement = $('<img>');
    imageElement.attr('src', 'img/loader-green.gif');
    imageElement.attr('width', 45);
    imageElement.attr('height', 45);
    $('.next-button').html("");
    $('.next-button').html(imageElement);

    var firstName = $("#ship_firstName").val();
    var lastName = $("#ship_lastName").val();
    var addr = $("#ship_address").val();
    var addr2 = $("#ship_address_2").val();
    var city = $("#ship_city").val();
    var state = $("#ship_state").val();
    var zip = $("#ship_zip").val();
    var email = $("#contact_email").val();
    var phone = $("#contact_phone").val();
    var discountCode = $("#discount-code").val();

    var data = {
        firstName: firstName,
        lastName: lastName,
        addr: addr,
        addr2: addr2,
        city: city,
        state: state,
        zip: zip,
        email: email,
        phone: phone,
        discountCode: discountCode
    };

    var issues = CheckFormIssues();
    if (issues == "") {
        $.ajax({
            type: "POST",
            url: "inc/mods/custom_equipment/checkout/checkout-page.php?action=validateaddress",
            data: data,
            dataType: 'json',
            success: function (response) {
                $('.next-button').html(prevHtml);
                if (response.valid) {
                    $('.next-button').html(prevHtml);
                    //Continue to Step-3
                    $.ajax({
                        type: "POST",
                        url: "inc/mods/custom_equipment/checkout/checkout-page.php?action=step-3",
                        data: data,
                        success: function (response) {
                            $(".checkout-content").html(response);
                        }
                    });
                } else {
                    $('.form-errors').html(issues);
                    if ($('.form-errors').hasClass('d-none')) {
                        $('.form-errors').removeClass('d-none');
                    }
                }
            },
            error: function (error) {
                $('.next-button').html(prevHtml);
                $('.form-errors').html(error);
                $('.form-errors').removeClass('d-none');
            }
        });
    } else {
        $('.form-errors').html("Address Invalid!<br>Please Enter A Valid Shipping Address.");
        if ($('.form-errors').hasClass('d-none')) {
            $('.form-errors').removeClass('d-none');
        }
    }
}

function SetShippingServiceCode() {
    prevHtml = $('.next-button').html();
    var imageElement = $('<img>');
    imageElement.attr('src', 'img/loader-green.gif');
    imageElement.attr('width', 45);
    imageElement.attr('height', 45);
    $('.next-button').html("");
    $('.next-button').html(imageElement);

    var shipService = $("#ship_service").val();
    const splitted = shipService.split('|');
    var service_code = splitted[0];
    var carrier_id = splitted[1];

    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/checkout/checkout-page.php?action=setshipservice",
        data: {
            service_code: service_code,
            carrier_id: carrier_id
        },
        success: function (response) {
            if (!$('.form-errors').hasClass('d-none')) {
                $('.form-errors').addClass('d-none');
            }
            $('.next-button').html(prevHtml);
        }
    });
}

function SetShippingType() {
    prevHtml = $('.next-button').html();
    var imageElement = $('<img>');
    imageElement.attr('src', 'img/loader-green.gif');
    imageElement.attr('width', 45);
    imageElement.attr('height', 45);
    $('.next-button').html("");
    $('.next-button').html(imageElement);

    var shipType = $("#ship_type").val();

    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/checkout/checkout-page.php?action=setshiptype",
        data: {
            shipType: shipType
        },
        success: function (response) {
            $(".ship_type_section").html(response);
            if (!$('.form-errors').hasClass('d-none')) {
                $('.form-errors').addClass('d-none');
            }
            $('.next-button').html(prevHtml);
        }
    });
}

function SetPickupLocation() {
    prevHtml = $('.next-button').html();
    var imageElement = $('<img>');
    imageElement.attr('src', 'img/loader-green.gif');
    imageElement.attr('width', 45);
    imageElement.attr('height', 45);
    $('.next-button').html("");
    $('.next-button').html(imageElement);

    var locId = $("#pickup_location").val();
    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/checkout/checkout-page.php?action=pickuplocation",
        data: {
            id: locId
        },
        success: function (response) {
            console.log(response)
            $('.next-button').html(prevHtml);
        }
    });
}

function ContinueToShippingMethod() {

    Checkout_Step3();
}

function calculateDaysBetweenDates(startDate, endDate) {
}

function CheckFormIssues() {
    var firstName = $("#ship_firstName").val();
    var lastName = $("#ship_lastName").val();
    var addr = $("#ship_address").val();
    var addr2 = $("#ship_address_2").val();
    var city = $("#ship_city").val();
    var state = $("#ship_state").val();
    var zip = $("#ship_zip").val();
    var email = $("#contact_email").val();
    var phone = $("#contact_phone").val();
    let errorMsg = '';

    if (firstName == '') {
        errorMsg += '- First Name Cannot Be Blank!<br>';
    }

    if (lastName == '') {
        errorMsg += '- Last Name Cannot Be Blank!<br>';
    }

    if (addr == '') {
        errorMsg += '- Address Cannot Be Blank!<br>';
    }

    if (city == '') {
        errorMsg += '- City Cannot Be Blank!<br>';
    }

    if (state == '') {
        errorMsg += '- State Cannot Be Blank!<br>';
    }

    if (zip == '') {
        errorMsg += '- Zip-Code Cannot Be Blank!<br>';
    }

    if (email == '') {
        errorMsg += '- Contact Email Cannot Be Blank!<br>';
    }

    if (phone == '') {
        errorMsg += '- Contact Phone Number Cannot Be Blank!<br>';
    }

    return errorMsg;
}

function CheckBillingFormIssues() {
    var card_num = $('#card_number').val();
    var card_exp = $('#expiration').val();
    var card_csv = $('#csv').val();

    var firstName = $("#ship_firstName").val();
    var lastName = $("#ship_lastName").val();
    var addr = $("#address").val();
    var city = $("#city").val();
    var state = $("#state").val();
    var zip = $("#zip").val();
    let errorMsg = '';

    if (firstName == '') {
        errorMsg += 'First Name Cannot Be Blank.<br>';
    }

    if (lastName == '') {
        errorMsg += 'Last Name Cannot Be Blank.<br>';
    }

    if (addr == '') {
        errorMsg += 'Address Cannot Be Blank.<br>';
    }

    if (city == '') {
        errorMsg += 'City Cannot Be Blank.<br>';
    }

    if (state == '') {
        errorMsg += 'State Cannot Be Blank.<br>';
    }

    if (zip == '') {
        errorMsg += 'Zip-Code Cannot Be Blank.<br>';
    }

    if (card_num == '' || card_exp == '' || card_csv == '') {
        errorMsg += 'Please Enter Valid Card Details.<br>';
    }

    return errorMsg;
}

function GoBackStep3(first, last, addr, addr2, city, state, zip, email, phone) {

    var data = {
        firstName: first,
        lastName: last,
        addr: addr,
        addr2: addr2,
        city: city,
        state: state,
        zip: zip,
        email: email,
        phone: phone,
    };

    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/checkout/checkout-page.php?action=step-3",
        data: data,
        success: function (response) {
            $(".checkout-content").html(response);
        },
        error: function (error) {
            $('.form-errors').html(error);
            $('.form-errors').removeClass('d-none');
            $('.next-button').html(prevHtml);
        }
    });
}

function Checkout_Step4(first, last, addr, addr2, city, state, zip, email, phone) {
    prevHtml = $('.next-button').html();
    var imageElement = $('<img>');
    imageElement.attr('src', 'img/loader-green.gif');
    imageElement.attr('width', 45);
    imageElement.attr('height', 45);
    $('.next-button').html("");
    $('.next-button').html(imageElement);

    var shipSel = $("#ship_type").val();

    if (shipSel == "-1") {
        $(".form-errors").html("Please Select A Shipping/Pickup Method from the Dropdown.");
        $(".form-errors").addClass("text-center");
        $(".form-errors").removeClass("d-none");
        $('.next-button').html(prevHtml);
    } else {
        if (shipSel == 1) {
            var pickupLoc = $("#pickup_location").val();
            console.log("Pickup Loc: " + pickupLoc);
            if (pickupLoc == "Select A Pickup Location") {
                $(".form-errors").html("Please Select A Pickup Location From The Dropdown.");
                $(".form-errors").addClass("text-center");
                $(".form-errors").removeClass("d-none");
                $('.next-button').html(prevHtml);
                return;
            }
        }

        var data = {
            firstName: first,
            lastName: last,
            addr: addr,
            addr2: addr2,
            city: city,
            state: state,
            zip: zip,
            email: email,
            phone: phone
        };

        $.ajax({
            type: "POST",
            url: "inc/mods/custom_equipment/checkout/checkout-page.php?action=step-4",
            data: data,
            success: function (response) {
                $(".checkout-content").html(response);
                console.log("RESP: " + response);
            },
            error: function (error) {
                $('.form-errors').html(error);
                $('.form-errors').removeClass('d-none');
                $('.next-button').html(prevHtml);
            }
        });
    }
}

function displayBase64Image(base64String) {
    var imageElement = document.getElementById('image');
    imageElement.src = 'data:image/pdf;base64,' + base64String; // Replace 'png' with the actual image format if needed
}

function printContent() {
    var w = window.open();
    var contentToPrint = $('.printable-content').html();

    w.document.write('<html><head><title>Print</title></head><body>');
    w.document.write(contentToPrint);
    w.document.write('</body></html>');
    w.print();
    w.close();
}

function ApplyDiscountCode() {
    var code = $("#discount-code").val();
    console.log("Applying Discount: " + code);

    var data = {
        discountCode: code
    };
    var currentTimestamp = new Date().getTime();

    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/checkout/checkout-page.php?action=applydiscount",
        data: data,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            console.log("TIMESTAMP: " + currentTimestamp);
            if (response.valid == true) {
                console.log("SUCCESS DISCOUNT APPLIED!");
                console.log("Response: " + response.response);
                console.log("Coupon Name: " + response.coupon_name);
                var percentage = response.discount_percentage * 100;
                console.log("Percentage: " + percentage + "%");
                console.log("Code: " + response.discount_code);
                console.log("Type: " + response.coupon_type);
                console.log("Expires: " + response.expiration);
                $("#discount-area").html("[" + percentage + "%]  " + response.response);
                $("#discount-area").addClass("pl-4");
                $("#discount-area").addClass("pt-1");
                $("#discount-area").addClass("text-center");
                $("#discount-area").addClass("text-primary");
            } else {
                console.log("FAILED TO APPLY DISCOUNT CODE!!");
            }
        }
    });
}

function UpdateQty(id, uniqId, name, price) {
    var amt = $("#itmqty_" + uniqId).val();
    console.log("Updating Item: " + uniqId + " | Value: " + amt);
    //TODO
    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/command_processor.php?action=updateqty",
        data: {
            id: id,
            uniqId: uniqId,
            name: name,
            price: price,
            qty: amt
        },
        dataType: "json",
        success: function (obj) {
            if (obj.response == "good") {
                $("#price_of_all_" + uniqId).html("$" + obj.itemTotal);
                $("#price-total").html("$" + obj.cartTotal);
                location.reload();
            } else {
                alert(obj.message);
            }
        }
    })
}

function GetTaxRate(zip) {
    var zip = '';

    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/command_processor.php?action=taxrate",
        data: {
            zip: zip
        },
        success: function (obj) {
            console.log(obj);
        }
    })
}

function ProcessPayment(first, last, addr, addr2, city, state, zip, email, phone) {
    var bill_first_name = $("#first_name").val();
    var bill_last_name = $("#last_name").val();
    var bill_address = $('#address').val();
    var bill_city = $('#city').val();
    var bill_state = $('#state').val();
    var bill_zip = $('#zip').val();

    var data = {
        firstName: first,
        lastName: last,
        addr: addr,
        addr2: addr2,
        city: city,
        state: state,
        zip: zip,
        email: email,
        phone: phone,
        billing_first_name: bill_first_name,
        billing_last_name: bill_last_name,
        billing_address: bill_address,
        billing_city: bill_city,
        billing_state: bill_state,
        billing_zip: bill_zip
    };

    //Check Form Field Issues
    var issues = CheckBillingFormIssues();
    if (issues != '') {
        $('.form-errors').html(issues);
        if ($('.form-errors').hasClass('d-none')) {
            $('.form-errors').removeClass('d-none');
        }
        return;
    }

    $.ajax({
        type: "POST",
        url: "inc/mods/custom_equipment/checkout/checkout-page.php?action=processpayment",
        data: data,
        success: function (obj) {
            console.log(obj);
            $(".checkout-content").html(obj);
        }
    })
}

function SetBillingAddress(street, city, state, zip) {
    if ($('#address').val() == '') {
        $('#address').val(street);
        $('#city').val(city);
        $('#state').val(state);
        $('#zip').val(zip);
    } else {
        $('#address').val('');
        $('#city').val('');
        $('#state').val('');
        $('#zip').val('');
    }
}