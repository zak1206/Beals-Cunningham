function toTimestamp(strDate){
    var datum = Date.parse(strDate);
    return datum/1000;
}

function checktheTimeOG(thetime){
    var selectedData = parseInt(toTimestamp(thetime+' 00:00:00'));

    var dateNow = parseInt(Date.now());
    dateNow = dateNow.toString().slice(0,-3)

    if(selectedData > dateNow){
        $(".timelimit").show();
        $(".timelimit").removeAttr('disabled');
        $('#timeSet option:first').prop('selected',true);
    }else{
        $(".timelimit").hide();
        $(".timelimit").attr('disabled');
        $('#timeSet option:first').prop('selected',true);
    }
}

function checktheTime(){
    var seldat = $("#selected_date").val();
    $.ajax({
        url: 'inc/mods/service_schedule/ssched.php?action=gettimelist&seldate='+seldat,
        success: function(data){
            $(".timeselector").html(data);
        }
    })
}

/////HERE///////

function getMsg(selector) {
    return $(selector).attr('data-msg');
}

function step_one_valid(){
    var validator = $('#sched_services').validate({
        ignore: "",
        rules: {
            "service_check[]": {
                required: true,
                minlength: 1
            },

            "selected_date":{
                required: true
            }
        },

        messages: {
            "service_check[]": "Please select at least one service.",
            selected_date: getMsg('#selected_date')
        },
        Element : 'div',
        errorLabelContainer: '.generrors',
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: 'inc/mods/service_schedule/ssched.php?step_two=true',
                data: $("#sched_services").serialize(),
                success: function(data)
                {
                    $(".bookit").html(data);
                    stepTwoValidation();
                }
            });
        }
    });

    $('#datetimepicker12').datepicker({
        inline: true,
        sideBySide: true,
        todayHighlight: true
    });
    $('#datetimepicker12').on('changeDate', function(event) {
        //alert(event.format());
        $("#selected_date").val(event.format());
        //alert(event.format());
        checktheTime();
    });
}

function stepTwoValidation(){
   // alert('validate client');
    var validator = $('#client_info').validate({
        ignore: "",
        rules: {
            "fname":{
                required: true
            },
            "lname":{
                required: true
            },
            "email":{
                required: true
            },
            "address":{
                required: true
            },
            "city":{
                required: true
            },
            "state":{
                required: true
            },
            "zip":{
                required: true,
                minlength: 5
            },
            "phone":{
                required: true
            }
        },

        messages: {
            fname: "Need First Name",
            lname: "Need Last Name",
            email: "Valid Email Address",
            address: "Need Address",
            city: "Need City",
            state: "Select State",
            zip: "Need Zip",
            phone: "Valid Phone Number"
        },
        Element : 'div',
        errorLabelContainer: '.generrors',
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: 'inc/mods/service_schedule/ssched.php?step_three=true',
                data: $("#client_info").serialize(),
                success: function(data)
                {
                    $(".bookit").html(data);
                    //service_finish

                    $("#service_finish").on("submit", function() {
                        $.ajax({
                            url: "inc/mods/service_schedule/ssched.php?step_four=true",
                            type: "post",
                            data: $("#service_finish").serialize(),
                            success: function(data) {
                                $(".bookit").html(data);
                            }
                        });
                    });

                }
            });


            e.preventDefault(); //
        }
    });
}



$(function(){
    $.ajax({
        url: 'inc/mods/service_schedule/ssched.php?step_one=true',
        success: function(data){
            $(".bookit").html(data);
            step_one_valid();
        }
    })
});