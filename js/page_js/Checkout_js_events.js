$(function(){
        $.ajax({
            url: 'inc/ajaxCalls.php?action=getwholecart',
            success: function(data){
                $(".cartcontents").html(data);
                refreshCheckButton();

                $(".updateval").on('click',function(){
                    var itemname = $(this).data('itemname');
                    var itemid = $(this).data('itemid');
                    var eqtabs = $(this).data('eqtabs');
                    var realid = $(this).data('realid');
                    var selectQty = $("#itmqty_"+itemid).val();

                    $.ajax({
                        url: 'inc/ajaxCalls.php?action=updateqty&itemname='+itemname+'&itemid='+itemid+'&realid='+realid+'&eqtabs='+eqtabs+'&qty='+selectQty,
                        cache: false,
                        success:function(data){
                            var obj = $.parseJSON(data);
                            var status = obj.status;
                            var message = obj.message;

                            if(status == 'good'){
                                $(".informares").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>'+message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            }else{
                                $(".informares").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>'+message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            }

                            refreshTheCart();
                            getBaseMini();

                        }
                    })

                })

            }
        })


        $("#ship_same").on('click',function(){
            $(".ship_pan").slideToggle('fast');
        });
      
      $("#control-8896319").on('click',function(){
      	console.log('TEST');
      })

    });

function removeSavedCart(eqid, saletabs) {
    $(".saveblock-" + eqid).remove();
    $.ajax({
        url: 'inc/ajaxCalls.php?action=removesaved&varid=' + eqid,
        success: function(data) {
            refreshTheCart();
        }
    })
}

function refreshTheCart(){
    $.ajax({
        url: 'inc/ajaxCalls.php?action=getwholecart',
        success: function(data){
            $(".cartcontents").html(data);

            refreshCheckButton();

            $(".updateval").on('click',function(){
                var itemname = $(this).data('itemname');
                var itemid = $(this).data('itemid');
                var eqtabs = $(this).data('eqtabs');
                var realid = $(this).data('realid');
                var selectQty = $("#itmqty_"+itemid).val();

                $.ajax({
                    url: 'inc/ajaxCalls.php?action=updateqty&itemname='+itemname+'&itemid='+itemid+'&realid='+realid+'&eqtabs='+eqtabs+'&qty='+selectQty,
                    cache: false,
                    success:function(data){
                        var obj = $.parseJSON(data);
                        var status = obj.status;
                        var message = obj.message;

                        if(status == 'good'){
                            $(".informares").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>'+message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        }else{
                            $(".informares").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>'+message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        }
                        refreshTheCart();
                        getBaseMini();
                    }
                })


            })
            getBaseMini();
        }
    })
}

function getBaseMini(){
    $.ajax({
        url:'inc/ajaxCalls.php?action=getmini',
        cache:false,
        success: function (data){
            var parsedJson = $.parseJSON(data);
            $(".cartcount").html(parsedJson.itemCount);
            $(".cart-dropdown-menu").html(parsedJson.cart);
        }
    })
}

function refreshCheckButton(){
    $(".thecheckout").on('click',function(){
        $(".overlays").show();
        $(".lds-ring").show();
        $.ajax({
            url: 'inc/ajaxCalls.php?action=getwholecart-two',
            cache: false,
            success:function(data){
                $(".overlays").hide();
                $(".lds-ring").hide();
                $(".cartcontents").html(data);
                $("#billing_details").validate({
                    submitHandler: function(form) {
                        $(".overlays").show();
                        $(".lds-ring").show();
                        $.ajax({
                            type: "POST",
                            url: 'inc/ajaxCalls.php?action=selectshipping',
                            data: new FormData(form),
                            contentType: !1,
                            cache: false,
                            processData: !1,
                            success: function(data) {
                                $(".overlays").hide();
                                $(".lds-ring").hide();

                                $(".cartcontents").html(data);

                                refreshCheckButton();

                                $(".updateval").on('click',function(){
                                    var itemname = $(this).data('itemname');
                                    var itemid = $(this).data('itemid');
                                    var eqtabs = $(this).data('eqtabs');
                                    var realid = $(this).data('realid');
                                    var selectQty = $("#itmqty_"+itemid).val();

                                    $.ajax({
                                        url: 'inc/ajaxCalls.php?action=updateqty&itemname='+itemname+'&itemid='+itemid+'&realid='+realid+'&eqtabs='+eqtabs+'&qty='+selectQty,
                                        cache: false,
                                        success:function(data){
                                            var obj = $.parseJSON(data);
                                            var status = obj.status;
                                            var message = obj.message;

                                            if(status == 'good'){
                                                $(".informares").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>'+message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                            }else{
                                                $(".informares").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>'+message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                            }
                                            refreshTheCart();
                                            getBaseMini();
                                        }
                                    })
                                })

                                intReedem();

                                $("#shipping_select").on('change',function(){

                                    var price = $(this).find(':selected').data('amount');


                                        var cartPrice = $("#cartpricez").val();
                                        var readable = $(this).find(':selected').text();
                                        var shipToken = $(this).val();
                                        //$(".thetotals").html(response2.total);
                                        console.log(price+' - '+readable+' - '+shipToken);

                                        $.ajax({
                                            type: "POST",
                                            url: 'inc/ajaxCalls.php?action=selectedshipping',
                                            data: {
                                                'price': price,
                                                'readable': readable,
                                                'shipToken': shipToken
                                            },
                                            cache: false,
                                            success: function (data) {
                                                console.log(data);
                                                var obj = jQuery.parseJSON(data)
                                                $(".thetotals").html('$'+obj["totalAmout"]);
                                                $("#cartpricez").val(obj["totalAmout"])
                                                $(".tax_inplace").html('$'+obj["taxOut"])
                                            }
                                        })

                                        //$(".thetotals").html('$'+setsPrice);

                                })

                                ///INT THE PAYMENT BUTTON///

                                $("#shipssels").validate({
                                    submitHandler: function(form) {
                                        $.ajax({
                                            url: 'inc/ajaxCalls.php?action=paymentforms',
                                            cache: false,
                                            success: function(data) {
                                                $(".cartcontents").html(data);
                                                $(".theshipping").on('click',function(){
                                                    $(".overlays").show();
                                                    $(".lds-ring").show();
                                                    $.ajax({
                                                        url: 'inc/ajaxCalls.php?action=selectshipping&redoship=true',
                                                        cache:false,
                                                        success: function(data){
                                                            $(".cartcontents").html(data);
                                                            $(".overlays").hide();
                                                            $(".lds-ring").hide();

                                                            $(".cartcontents").html(data);

                                                            refreshCheckButton();

                                                            $(".updateval").on('click',function(){
                                                                var itemname = $(this).data('itemname');
                                                                var itemid = $(this).data('itemid');
                                                                var eqtabs = $(this).data('eqtabs');
                                                                var realid = $(this).data('realid');
                                                                var selectQty = $("#itmqty_"+itemid).val();

                                                                $.ajax({
                                                                    url: 'inc/ajaxCalls.php?action=updateqty&itemname='+itemname+'&itemid='+itemid+'&realid='+realid+'&eqtabs='+eqtabs+'&qty='+selectQty,
                                                                    cache: false,
                                                                    success:function(data){
                                                                        var obj = $.parseJSON(data);
                                                                        var status = obj.status;
                                                                        var message = obj.message;

                                                                        if(status == 'good'){
                                                                            $(".informares").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>'+message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                                                        }else{
                                                                            $(".informares").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>'+message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                                                        }
                                                                        refreshTheCart();
                                                                        getBaseMini();
                                                                    }
                                                                })

                                                            })

                                                            intReedem();

                                                            $("#shipping_select").on('change',function(){

                                                                var price = $(this).find(':selected').data('amount');

                                                                    var cartPrice = $("#cartpricez").val();
                                                                    var readable = $(this).find(':selected').text();
                                                                    var shipToken = $(this).val();
                                                                    //$(".thetotals").html(response2.total);
                                                                    console.log(price+' - '+readable+' - '+shipToken);

                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: 'inc/ajaxCalls.php?action=selectedshipping',
                                                                        data: {
                                                                            'price': price,
                                                                            'readable': readable,
                                                                            'shipToken': shipToken
                                                                        },
                                                                        cache: false,
                                                                        success: function (data) {
                                                                            $(".thetotals").html('$'+data);
                                                                            $("#cartpricez").val(data)
                                                                        }
                                                                    })
                                                            })

                                                            ///INT THE PAYMENT BUTTON///

                                                            $("#shipssels").validate({
                                                                submitHandler: function(form) {
                                                                    $.ajax({
                                                                        url: 'inc/ajaxCalls.php?action=paymentforms',
                                                                        cache: false,
                                                                        success: function(data) {
                                                                            $(".cartcontents").html(data);
                                                                            $(".theshipping").on('click',function(){
                                                                                $.ajax({
                                                                                    url: 'inc/ajaxCalls.php?action=selectshipping&redoship=true',
                                                                                    cache:false,
                                                                                    success: function(data){
                                                                                        $(".cartcontents").html(data);
                                                                                        $(".cartcontents").html(data);
                                                                                        $(".overlays").hide();
                                                                                        $(".lds-ring").hide();

                                                                                        $(".cartcontents").html(data);

                                                                                        refreshCheckButton();

                                                                                        $(".updateval").on('click',function(){
                                                                                            var itemname = $(this).data('itemname');
                                                                                            var itemid = $(this).data('itemid');
                                                                                            var eqtabs = $(this).data('eqtabs');
                                                                                            var realid = $(this).data('realid');
                                                                                            var selectQty = $("#itmqty_"+itemid).val();

                                                                                            $.ajax({
                                                                                                url: 'inc/ajaxCalls.php?action=updateqty&itemname='+itemname+'&itemid='+itemid+'&realid='+realid+'&eqtabs='+eqtabs+'&qty='+selectQty,
                                                                                                cache: false,
                                                                                                success:function(data){
                                                                                                    var obj = $.parseJSON(data);
                                                                                                    var status = obj.status;
                                                                                                    var message = obj.message;

                                                                                                    if(status == 'good'){
                                                                                                        $(".informares").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>'+message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                                                                                    }else{
                                                                                                        $(".informares").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>'+message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                                                                                    }
                                                                                                    refreshTheCart();
                                                                                                    getBaseMini();
                                                                                                }
                                                                                            })


                                                                                        })

                                                                                        intReedem();

                                                                                        $("#shipping_select").on('change',function(){

                                                                                            var price = $(this).find(':selected').data('amount');
                                                                                            if(price != 'pickup'){

                                                                                                var cartPrice = $("#cartpricez").val();
                                                                                                var readable = $(this).find(':selected').text();
                                                                                                var shipToken = $(this).val();
                                                                                                //$(".thetotals").html(response2.total);
                                                                                                console.log(price+' - '+readable+' - '+shipToken);

                                                                                                $.ajax({
                                                                                                    type: "POST",
                                                                                                    url: 'inc/ajaxCalls.php?action=selectedshipping',
                                                                                                    data: {
                                                                                                        'price': price,
                                                                                                        'readable': readable,
                                                                                                        'shipToken': shipToken
                                                                                                    },
                                                                                                    cache: false,
                                                                                                    success: function (data) {
                                                                                                        $(".thetotals").html('$'+data);
                                                                                                        $("#cartpricez").val(data)
                                                                                                    }
                                                                                                })

                                                                                                //$(".thetotals").html('$'+setsPrice);
                                                                                            }else{
                                                                                                alert('PICK IT UP');
                                                                                            }
                                                                                        })

                                                                                        ///INT THE PAYMENT BUTTON///

                                                                                        $("#shipssels").validate({
                                                                                            submitHandler: function(form) {
                                                                                                $.ajax({
                                                                                                    url: 'inc/ajaxCalls.php?action=paymentforms',
                                                                                                    cache: false,
                                                                                                    success: function(data) {
                                                                                                        $(".cartcontents").html(data);
                                                                                                        $(".theshipping").on('click',function(){
                                                                                                            $.ajax({
                                                                                                                url: 'inc/ajaxCalls.php?action=selectshipping&redoship=true',
                                                                                                                cache:false,
                                                                                                                success: function(data){
                                                                                                                    $(".cartcontents").html(data);

                                                                                                                }
                                                                                                            })
                                                                                                        })

                                                                                                        completePurchase();
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                        });

                                                                                        //inherent back button and call custom function for ecomm steps//
                                                                                        // window.onpopstate = function() {
                                                                                        //     alert("clicked back button");
                                                                                        // }; history.pushState({}, '');

                                                                                        $('.checkout-payment').on('click',function(){
                                                                                            $("#shipssels").submit();
                                                                                        })

                                                                                    }
                                                                                })
                                                                            })

                                                                            completePurchase();
                                                                        }
                                                                    })
                                                                }
                                                            });

                                                            //inherent back button and call custom function for ecomm steps//
                                                            // window.onpopstate = function() {
                                                            //     alert("clicked back button");
                                                            // }; history.pushState({}, '');

                                                            $('.checkout-payment').on('click',function(){
                                                                $("#shipssels").submit();
                                                            })

                                                        }
                                                    })
                                                })

                                                completePurchase();

                                            }
                                        })
                                    }
                                });

                                //inherent back button and call custom function for ecomm steps//
                                // window.onpopstate = function() {
                                //     alert("clicked back button");
                                // }; history.pushState({}, '');

                                $('.checkout-payment').on('click',function(){
                                    $("#shipssels").submit();
                                })


                            }
                        })


                    }
                });
                $.validator.messages.required = 'Required';
                processShipping();
                intReedem();

            }
        })
    })
}

function intReedem(){
    $("#the-discount").validate({
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: 'inc/ajaxCalls.php?action=checkcodes',
                data: new FormData(form),
                contentType: !1,
                cache: !1,
                processData: !1,
                success: function(data) {
                    $(".overlays").hide();
                    $(".lds-ring").hide();
                    var response = $.parseJSON(data);
                    var returncode = response.return_code;

                    if(returncode == 1) {
                        $("#the-discount").remove();
                        $.ajax({
                            url: 'inc/ajaxCalls.php?action=getCartTotal',
                            cache: false,
                            success: function (data) {
                                ///alert(data);
                                data = data.replace('\'', '\\\'');
                                var response2 = $.parseJSON(data);
                                var resmess = response2.return_code;

                                ///alert(resmess);

                                if(resmess == 1){
                                    //do things//
                                    $('.discountapply').html(response2.discount_info);
                                    $(".thetotals").html(response2.total);
                                }
                                processShipping();
                            }
                        })
                    }else{

                    }

                }
            })
        }
    });
}

function processShipping(){
    $(".checkout-shipping").on('click',function(){
        $("#billing_details").submit();
    })
}

function completePurchase(){
    // get public key from server //
    // $.ajax({
    //    place stripe processor here.
    // })

    // this identifies your website in the createToken call below
    // Stripe.setPublishableKey('pk_test_YmcL4IBBqEQxRd0mesobCr8I');
    // function stripeResponseHandler(status, response) {
    //     if (response.error) {
    //         // re-enable the submit button
    //         $('.submit-button').removeAttr("disabled");
    //         // show the errors on the form
    //         alert(response.error.message);
    //         //alert(response.error.message);
    //         $(".messars").html(response.error.message);
    //         $(".messars").show();
    //         $(".order_infosetter").slideDown('fast');
    //         $(".loadscree").hide();
    //         $(".removit").show();
    //     } else {
    //         var form$ = $("#billinfo");
    //         // token contains id, last4, and card type
    //         var token = response['id'];
    //         // insert the token into the form so it gets submitted to the server
    //         form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
    //         // and submit
    //         //form$.get(0).submit();
    //
    //         var billing_address = $("#billing_address").val();
    //         var billing_city = $("#billing_city").val();
    //         var billing_state = $("#billing_state").val();
    //         var stripeToken = $("input[name=stripeToken]").val();
    //         $.ajax({
    //             type: "POST",
    //             url: 'inc/ajaxCalls.php?action=paybill',
    //             data: {
    //                 'billing_address': billing_address,
    //                 'billing_city': billing_city,
    //                 'billing_state': billing_state,
    //                 'stripeToken': stripeToken,
    //             },
    //             success: function(data) {
    //                 $(".overlays").hide();
    //                 $(".lds-ring").hide();
    //                 console.log(data);
    //                 // var response = $.parseJSON(data);
    //                 // var returncode = response.return_code;
    //                 //
    //                 // if(returncode == 1) {
    //                 //
    //                 // }else{
    //                 //
    //                 // }
    //             }
    //         })
    //     }
    // }

    $(".complete-payment").on('click',function(){
        $("#billinfo").submit();

    })

    $("#billinfo").validate({
        submitHandler: function(form) {
            $(".overlays").show();
            $(".lds-ring").show();

            // ELAVON PROCESS //
            var token = $("#token").val();
            var card = $("#card_numbers").val();
            var exp = $("#card_date").val();
            var cvv = $("#card_cvv").val();
            var gettoken = $("#gettoken").val();
            var addtoken = $("#addtoken").val();
            var firstname = $("#first_name_on_card").val();
            var lastname = $("#last_name_on_card").val();
            var billing_address = $("#billing_address").val();
            var billing_city = $("#billing_city").val();
            var billing_state = $("#billing_state").val();
            var billing_zip = $("#billing_zip").val();
            var paymentData = {
                ssl_txn_auth_token: token,
                ssl_card_number: card,
                ssl_exp_date: exp,
                ssl_get_token: gettoken,
                ssl_add_token: addtoken,
                ssl_first_name: firstname,
                ssl_last_name: lastname,
                ssl_cvv2cvc2: cvv,
                ssl_avs_address: billing_address,
                ssl_avs_zip: billing_zip
            };
            var callback = {
                onError: function (error) {
                    //showResult("error", error);
                    console.log(error);
                    $(".overlays").hide();
                    $(".lds-ring").hide();
                    $(".messageareas").html('<div class="alert alert-danger"><strong>Payment Error!</strong><br><p>We\'re sorry! It appears that there was an error processing your payment.. Please try again.<br>If you continue to receive this error, please contact us.</p></div>');
                },
                onDeclined: function (response) {
                    console.log("Result Message=" + JSON.stringify(response));
                    //showResult("declined", JSON.stringify(response));
                    $(".overlays").hide();
                    $(".lds-ring").hide();
                    $(".messageareas").html('<div class="alert alert-danger"><strong>Payment Declined!</strong><br><p>It appears that the supplied payment method was declined.<br>Please use another method of payment or make sure your current details are correct.</p></div>');
                },
                onApproval: function (response) {
                    //console.log("Approval Code=" + JSON.stringify(response));
                    ///showResult("approval", JSON.stringify(response));
                   // console.log(response);
                    $(".couponars").remove();
                    $(".m-t-sm").remove();
                    $(".overlays").hide();
                    $(".lds-ring").hide();
                    $("#billinfo").remove();

                    // complete process //
                    $.ajax({
                        type: 'POST',
                        // make sure you respect the same origin policy with this url:
                        // http://en.wikipedia.org/wiki/Same_origin_policy
                        url: 'inc/ajaxCalls.php?action=complete_elavon_purchase',
                        data: {
                            'bill_fname': firstname,
                            'bill_lname': lastname,
                            'bill_address': billing_address,
                            'bill_city': billing_city,
                            'bill_state': billing_state,
                            'bill_zip': billing_zip,
                        },
                        success: function(msg){
                            // DO NOTHING //
                             console.log(msg);
                            msg = msg.replace('\'', '\\\'');
                            var response = $.parseJSON(msg);
                            var resmess = response.ret_message;

                            $(".messageareas").html('<div class="alert alert-success">'+resmess+'</div>');

                        }
                    });


                }
            };
            ConvergeEmbeddedPayment.pay(paymentData, callback);
            return false;



            // STRIPE PROCESS //

            // var card_date = $('#card_date').val();
            // var card_dates = card_date.split('/');

            // Stripe.createToken({
            //     number: '4242424242424242',
            //     cvc: '123',
            //     exp_month: '01',
            //     exp_year: '25',
            // }, stripeResponseHandler);


        }
    });

    var tokenRequest = {
        ssl_first_name: $("#first_name_on_card").val(),
        ssl_last_name: $("#last_name_on_card").val(),
        ssl_amount: $("#cartpricez").val()
    };
    $.post("inc/ajaxCalls.php?action=elavonpay", tokenRequest, function (data) {
        $("#token").val(data);
        transactionToken = data;
    });
    return false;

}