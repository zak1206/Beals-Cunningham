$( document ).ready(function() {
    $(".builder-container").click(function(){
        var id = $(this).attr('data-id');

        $.ajax({
            url: 'inc/mods/package_builder/builderAsync.php?action=getcats&id='+id,
            cache: false,
            success: function(data){
                $(".subcat").html(data);

            }
        })


    });



});

var stepperEl = document.getElementById('stepper1');
var stepper = new Stepper(stepperEl);

stepperEl.addEventListener('show.bs-stepper', function (event) {
    // You can call prevent to stop the rendering of your step
    // event.preventDefault()

    console.warn(event.detail.indexStep)
})

stepperEl.addEventListener('shown.bs-stepper', function (event) {
    console.warn('step shown')
})

function getCategory(selectObject){
    var value = selectObject.value;
    // alert('this is '+value);
    $.ajax({
        url: 'inc/mods/package_builder/builderAsync.php?action=getequip&value='+value,
        cache: false,
        success: function(data){
            $(".equipment").html(data);
        }
    });


}

function startConfig() {

    var id = $("#equipment").val();
    // alert(id);
    $.ajax({
        url: 'inc/mods/package_builder/builderAsync.php?action=getimplements&id='+id,
        cache: false,
        success: function(data){
            if(data == '') {
                $.ajax({
                    url: 'inc/mods/package_builder/builderAsync.php?action=getattachments&id='+id,
                    cache: false,
                    success: function(data){
                        var stepper = new Stepper(document.querySelector('.bs-stepper'))
                        stepper.to(3)
                        $("#test-l-3").html(data);
                        $('.att-info').tooltip();
                        getSelections();
                        getAttachmentItems();
                        $(".attchecks").click(function(){
                            $(window).scrollTop(0);
                            getAttachmentItems();
                        });
                    }
                });
            } else {
                var stepper = new Stepper(document.querySelector('.bs-stepper'))
                stepper.next()
                $("#test-l-2").html(data);
                $(window).scrollTop(0);
                getSelections();
            }

            // console.log(data);
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
                var stepper = new Stepper(document.querySelector('.bs-stepper'))
                stepper.to(3)
                $("#test-l-3").html(data);
                $('.att-info').tooltip();
                getSelections();
                getAttachmentItems();
                $(".attchecks").click(function(){
                    getAttachmentItems();
                    $(window).scrollTop(0);
                });

            }
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
        delivFee = $('#delivery').text().substring(1).replace(/,/g, '');;
        Tot = parseInt(origNum);
        if(interest < 1) {
            newVal = Tot;
        } else {
            newVal = Tot * (interest / 100 + 1);
        }

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


//function getFinal(id) {
//  var datastring = $('#builder-form').serialize();
//  $.ajax({
//        url: 'inc/builderAsync.php?action=getfinal&id='+id+'&datastring='+datastring,
//        cache: false,
//        success: function(data){
//           	var stepper = new Stepper(document.querySelector('.bs-stepper'))
//             stepper.to(4)
//            $("#test-l-4").html(data);
//        }
//    });
//}





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
    var amount = parseFloat(newtotal);
    var rate = $('#interestrate').val() / 1200;
    var periods =  parseFloat($('.range-slider__value').text());
    var downpay =  $('#downpay').val();
    if(rate == 0) {
        var payment = (amount - downpay)/periods;
    } else {
        var payment = (rate * (amount-downpay))/(1 - Math.pow(1 + rate, - periods));
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







