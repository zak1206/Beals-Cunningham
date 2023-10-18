function goToByScroll(id) {
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    $('html,body').animate({
        scrollTop: $("#" + id).offset().top
    }, 'slow');
}


$( document ).ready(function() {
    $(".builder-container").click(function(){
        var id = $(this).attr('data-id');

        $.ajax({
            url: 'inc/mods/package_builder/builderAsync.php?action=getcats&id='+id,
            cache: false,
            success: function(data){
                $(".subcat").html(data);
                goToByScroll('subcatsection');

            }
        })


    });



});

var stepperEl = document.getElementById('stepper1');
var stepper = new Stepper(document.getElementById('stepper1'),{
    linear:false
});

stepperEl.addEventListener('show.bs-stepper', function (event) {
    // You can call prevent to stop the rendering of your step
    // event.preventDefault()

    console.warn(event.detail.indexStep)
})

stepperEl.addEventListener('shown.bs-stepper', function (event) {
    console.warn('step shown')
})

function getCategory(selectObject){
    // var value = selectObject.value;
    var value = selectObject;

    $.ajax({
        url: 'inc/mods/package_builder/builderAsync.php?action=getequip&value='+value,
        cache: false,
        success: function(data){
            $(".equipment").html(data);
        }
    });


}

function filterAtts(){
    $("#search-atts").keyup(function() {

        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(),
            count = 0;

        // Loop through the comment list
        $('#attachment-table tr td').each(function() {


            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).hide();  // MY CHANGE

                // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show(); // MY CHANGE
                count++;
            }

        });

    });

}



function startConfig() {
    
    var id = $('#equipment').data('value');
    console.log(id);
    // alert(id);
    $("#hidden-input-id").html('<input id="equipmentId" type="text" value="'+id+'" name="equipmentId" class="form-control" style="display:none;">');
    
    $.ajax({
        url: 'inc/mods/package_builder/builderAsync.php?action=getimplements&id='+id,
        cache: false,
        success: function(data){
            if(data == '') {
                $.ajax({
                    url: 'inc/mods/package_builder/builderAsync.php?action=getattachments&id='+id,
                    cache: false,
                    success: function(data){
                        var stepper = new Stepper(document.querySelector('.bs-stepper'),{
                            linear:false
                        })
                        stepper.to(3)
                        $("#test-l-3").html(data);
                        $('.att-info').tooltip({
                            animated: 'fade',
                            placement: 'bottom',
                            html: true
                        });
                        $(".step:nth-child(3)").css('display', 'none');
                        $(".bs-stepper-line:nth-child(2)").css('display', 'none');
                        $("#att-prev").attr("onclick","stepper.to(1)");
                        $('#stepper1trigger3 > span.bs-stepper-circle').html('2');
                        $('#stepper1trigger4 > span.bs-stepper-circle').html('3');
                        getSelections();
                        getAttachmentItems();
                        filterAtts();
                        $(".attchecks").click(function(){
                            getAttachmentItems();
                        });
                    }
                });
            } else {
                var stepper = new Stepper(document.querySelector('.bs-stepper'),{
                    linear:false
                })
                stepper.next()
                $("#test-l-2").html(data);
                $(window).scrollTop(0);
                $('.att-info').tooltip({
                    animated: 'fade',
                    placement: 'bottom',
                    html: true
                });
                getSelections();

            }

        }
    });
}

function getAttach(id) {

    $.ajax({
        url: 'inc/mods/package_builder/builderAsync.php?action=getattachments&id='+id,
        cache: false,
        success: function(data){
            if(data == '') {
                $( "#builder-form" ).submit();
            } else {
                var stepper = new Stepper(document.querySelector('.bs-stepper'),{
                    linear:false
                })
                stepper.to(3)
                $("#test-l-3").html(data);

                $('.att-info').tooltip({
                    animated: 'fade',
                    placement: 'bottom',
                    html: true
                });
                getSelections();
                getAttachmentItems();
                filterAtts();

                $(".attchecks").click(function(){
                    getAttachmentItems();
                    // $(window).scrollTop(0);
                });

            }
        }
    });

}

function getOffers(id) {
    $.ajax({
        cache: false,
        url: 'inc/mods/package_builder/builderAsync.php?action=getoffers&id='+id,
        success: function (data) {
            $("#offersModal .modal-body").html(data);
            $("#offersModal").modal();
            $("#offersModal .modal-dialog").css('width','100%');
        }

    });

}

$('#builder-form').validate({
    
    submitHandler: function (form) {
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'inc/mods/package_builder/builderAsync.php?action=getfinal',
            data: $('#builder-form').serialize(),
            success: function (data) {
                stepper.to(4)
                $("#test-l-4").html(data);
                var sum = 0;
                $('.addit').each(function () {
                    // console.log($(this).text());
                    sumNum = $(this).text().substring(1).replace(/,/g, '');
                    sum += parseFloat(sumNum);  // Or this.innerHTML, this.innerText
                });
                $('.sumit').html('$'+sum.toFixed(2));
                $(window).scrollTop(0);
                getTotalSum();
                rangeSlider();
                calculateMonthly();

            }

        });
    }
});

function getTotalSum() {

    $('#interest').on('input', function() {
        interest = $(this).val();
        origNum = $('#subtal').text().substring(1).replace(/,/g, '');
        delivFee = $('#delivery').text().substring(1).replace(/,/g, '');
      //  Tot = parseInt(origNum);
        Tot = origNum;
        console.log(interest);
        if(interest < 1) {
            newVal = Number(Tot);
        } else{
            newVal = Tot * (interest / 100 + 1);
        }
        console.log("this is newVal: " + newVal);
        $('#total').html('$'+newVal.toFixed(2));
        calculateMonthly();
    });

    $('#downpay').on('input', function() {
        calculateMonthly();
    });

    $('.range-slider').on('click', function() {
        calculateMonthly();
    });

    $('#interestrate').on('input', function() {
        calculateMonthly();
    });
};

var rangeSlider = function(){
    var slider = $('.range-slider'),
        range = $('.range-slider__range'),
        value = $('.range-slider__value');

    slider.each(function(){

        value.each(function(){
            var value = $(this).prev().attr('value');
            $(this).html(value);
        });

        range.on('input', function(){
            $(this).next(value).html(this.value);
        });
    });
};

function calculateMonthly() {
    var total = $('#total').text();
    var newtotal = total.substring(1);

    // TOTAL AMOUNT========
    var amount = parseFloat(newtotal);

    // var rate = $('#interestrate1').val() / 1200;
    var rate = 0;

    // PERIODS=========
    var periods =  parseFloat($('.range-slider__value').text());


    // DOWNPAYMENT VALUE======
    var downpay =  $('#downpay').val();


    var amountAfterDownPayment = amount - parseFloat(downpay);

if($('.add-discount').data('val') !== undefined){
    var adddiscount = $('.add-discount').data('val');
}else{
    var adddiscount = 0;

}

    var amountAfterDiscount = amountAfterDownPayment - parseFloat(adddiscount);


    var totaldiscount = amountAfterDiscount;
    switch(periods) {
        case 60: 
            console.log(periods+' case 1');
            var financePrice = amountAfterDiscount * 0;
            console.log(financePrice.toFixed(2));
            $('#financeCharge').html('$ '+ financePrice.toFixed(2));
            $('#interest-rate-desc').html('(0%) $'+financePrice.toFixed(2)+' finance charge when you finance for 60 months.');
            break;
        case 72:
            console.log(periods+' case 2');
            var financePrice = amountAfterDiscount * .015;
            console.log(financePrice.toFixed(2));
            $('#financeCharge').html('$ '+ financePrice.toFixed(2));
            $('#interest-rate-desc').html('(1.5%) $'+financePrice.toFixed(2)+' finance charge when you finance for 72 months.');

            break;
        case 84:
            console.log(periods+' case 3');
            var financePrice = amountAfterDiscount * 0.03;
            console.log(financePrice.toFixed(2));
            $('#financeCharge').html('$ '+ financePrice.toFixed(2));
            $('#interest-rate-desc').html('(3%) $'+financePrice.toFixed(2)+' finance charge when you finance for 84 months.');

            break;
        default:
            console.log('default');
            break; 
    }

        if(rate == 0) {
            var payment = (totaldiscount+financePrice)/periods;
        } else {
            var payment = (rate * (totaldiscount+financePrice))/(1 - Math.pow(1 + rate, - periods));
        }
    

    function newRound(num, places) {
        var tens = Math.pow(10, places);
        var temp = num * tens;
        temp = Math.round(temp);
        temp = temp / tens;
        return temp;

    }

    var thePayment = newRound(payment, 2);

    $('#monthlypayment').html('$ '+ thePayment);

    switch(periods) {
        case 60: 
            console.log(periods+' case 1');
            var financePrice = amountAfterDiscount * 0;
            console.log(financePrice.toFixed(2));
            $('#financeCharge').html('$ '+ financePrice.toFixed(2));
            break;
        case 72:
            console.log(periods+' case 2');
            var financePrice = amountAfterDiscount * .015;
            console.log(financePrice.toFixed(2));
            $('#financeCharge').html('$ '+ financePrice.toFixed(2));
            break;
        case 84:
            console.log(periods+' case 3');
            var financePrice = amountAfterDiscount * 0.03;
            console.log(financePrice.toFixed(2));
            $('#financeCharge').html('$ '+ financePrice.toFixed(2));
            break;
        default:
            console.log('default');
            break; 
    }
}

function calculateFinance() {
    var total = $('#total').text();
    var newtotal = total.substring(1);
    var amount = parseFloat(newtotal);
    var rate = $('#interestrate').val() / 1200;
    var periods =  parseFloat($("input[type='radio'][name='months']:checked").val());
    // var downpay =  $('#downpay').val();
    var adddiscount = $('.add-discount').data('val');

    var totaldiscount = parseInt(downpay) + parseInt(adddiscount);

    console.log('total discount is'+totaldiscount);
    if(adddiscount != undefined) {
        if(rate == 0) {
            var payment = (amount - totaldiscount)/periods;
        } else {
            var payment = (rate * (amount-totaldiscount))/(1 - Math.pow(1 + rate, - periods));
        }
    } else {
        if(rate == 0) {
            var payment = (amount - downpay)/periods;
        } else {
            var payment = (rate * (amount-downpay))/(1 - Math.pow(1 + rate, - periods));
        }
    }

    function newRound(num, places) {
        var tens = Math.pow(10, places);
        var temp = num * tens;
        temp = Math.round(temp);
        temp = temp / tens;
        return temp;
    }
    
    var thePayment = newRound(payment, 2);

    $('#financeCharge').html('$ '+ thePayment);
    

}

function getSelections() {
    tmp = [];

    $('#stepper1 select').each(function(){
        tmp.push($(this).val());
    });

    var remove2 = tmp.splice(0, 2);

    var newtmp = tmp.filter(function(el) {
        return el != "";
    });



    if(newtmp.length == 0) {
        $('.selections').html('');
    } else {

        var formattedItems = '';

        $.each(tmp, function(index, item) {
            if (item == '') {

            } else {
                var formIt = item.split('-');
                formattedItems += '<p>' + formIt[0] + ' - $' + formIt[1] + '</p>';
                $('.selections').html(formattedItems);
            }
        }.bind(this));
    }
}

function getAttachmentItems() {
    atts = [];

    $('input:checked').each(function(){
        atts.push($(this).val());
    });

    if(atts.length == 0) {
        $(window).scrollTop(0);
        $('.attachments').html('');
    } else {

        var formattedItems = '';

        $.each(atts, function(index, item) {
            if (item == '') {

            } else {
                var formIt = item.split('-');
                formattedItems += '<p>' + formIt[0] + ' - $' + formIt[1] + '</p>';
                $('.attachments').html(formattedItems);
            }
        }.bind(this));
    }
}



function getFormStuff() {
    var saletax = $('#interest').val();
    $('.tax-val').text(saletax);

    // var downpay = $('#downpay').val();
    // $('.downpay-val').text(downpay);

    var intrateval = $('#interestrate').val();
    $('.int-rate-val').text(intrateval);

    var monthval = $("input[type='radio'][name='months']:checked").val();
    $('.month-val').text(monthval);

    var equip = $('.eqinfo').text();
    $("#equipment-type").val(equip);

    var geninfo = '';

    $('#gen-info .capture').each(function() {
        geninfo += $(this).html();
        geninfo += '<br>';
    });

    $('#general-information').val(geninfo);

    var payinfo = '';

    $('#pay-info .capture').each(function() {
        payinfo += $(this).html();
        payinfo += '<br>';
    });
    $('#payment-information').val(payinfo);
};

$('#package_builder_form').validate({
    submitHandler: function(form) {
        getFormStuff();

        $.ajax({
            type: 'POST',
            url: 'inc/mods/package_builder/builderAsync.php?action=processform',
            data: $('#package_builder_form').serialize(),
            success: function(data)
            {

                $('#package_builder_form').slideUp('fast');
                console.log(data);
                $('#success-message').html('<div class="alert alert-success" style="margin: 20px;">Thank you for your interest. We will contact you shortly.</div>');

            }
        });
    }
});