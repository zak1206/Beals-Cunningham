$('.your-class').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    adaptiveHeight: true,
    asNavFor: '.slider-nav'
});

$('.slider-nav').slick({
    slidesToShow: 2,
    slidesToScroll: 1,
    asNavFor: '.your-class',
    dots: true,
    arrows: false,
    centerMode: true,
    focusOnSelect: true
});

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function pageData(a) {
    parentObj = [], $(".target-box").each(function() {
        var a = $(this).data("filter-box");
        jsonObj = [], $(this).children("span").each(function() {
            itemsz = {}, itemsz.item = $(this).data(a + "-set"), jsonObj.push(itemsz)
        }), firstitem = {}, firstitem[a] = jsonObj, parentObj.push(firstitem)
    });
    var t = JSON.stringify(parentObj),
        e = $("#price_from").val(),
        i = $("#price_to").val(),
        s = $("#hours_from").val(),
        r = $("#hours_to").val(),
        o = $("#year_from").val(),
        n = $("#year_to").val(),
        c = $("#sorterset").val(),
        l = $("#viewtype").val();
    $.ajax({
        url: "inc/mods/machine_finder/asyncfile.php?action=getresults&page=" + a,
        cache: !1,
        type: "POST",
        data: {
            filters: t,
            price_from: e,
            price_to: i,
            hours_from: s,
            hours_to: r,
            year_from: o,
            year_to: n,
            viewtype: l,
            sorttype: c
        },
        success: function(a) {
            $(".rezout").html(a), $(window).scrollTop(0), getSortobj()
        }
    })
}

function recallEvent() {
    $(".clickobjtabs").on("click", function() {
        var a = $(this).data("labtype"),
            t = $(this).data(a + "-set");
        $("[data-" + a + '-set="' + t + '"]').remove(), $('[data-vals="' + t + '"]').find(".thecheck").remove();
        var e = a;
        if ("category" == e) {
            $(".man-item").hide(), $('[data-vals="' + t + '"]').removeClass("catfilter");
            var i = $(".catfilter").length;
            0 == parseInt(i) && ($(".man-item").show(), $(".mod-item").show()), $(".catfilter").each(function(a, t) {
                var e = $(this).data("manus").split(",");
                $.each(e, function(a, t) {
                    $('[data-vals="' + t + '"]').show()
                })
            })


            window.history.replaceState(null, null, "?param1=value");
        }
        if ("manufacturer" == e) {
            $(".cat-item").hide(), $('[data-vals="' + t + '"]').removeClass("manfilter");
            var s = $(".manfilter").length;
            0 == parseInt(s) && ($(".cat-item").show(), $(".man-item").show()), $(".manfilter").each(function(a, t) {
                var e = $(this).data("cats").split(",");
                $.each(e, function(a, t) {
                    $('[data-vals="' + t + '"]').show()
                });
                var i = $(this).data("mods");
                $(".mod-item").show();
                var s = i.split(",");
                $(".mod-item").hide(), $.each(s, function(a, t) {
                    $('[data-vals="' + t + '"]').show()
                })
            })
        }
        if ("model" == e) {
            $(".cat-item").hide(), $(".man-item").hide(), $('[data-vals="' + t + '"]').removeClass("modfilter");
            var r = $(".modfilter").length;
            if (0 == parseInt(r)) {
                $(".mod-item").show(), $(".man-item").hide(), $(".cat-item").show();
                i = $(".catfilter").length;
                0 != parseInt(i) ? $(".catfilter").each(function(a, t) {
                    var e = $(this).data("manus").split(",");
                    $.each(e, function(a, t) {
                        $('[data-vals="' + t + '"]').show()
                    })
                }) : $(".man-item").show()
            }
            $(".modfilter").each(function(a, t) {
                var e = $(this).data("cats").split(",");
                $.each(e, function(a, t) {
                    $('[data-vals="' + t + '"]').show()
                });
                var i = $(this).data("manus").split(",");
                $.each(i, function(a, t) {
                    $('[data-vals="' + t + '"]').show()
                })
            })
        }
        parentObj = [], $(".target-box").each(function() {
            var a = $(this).data("filter-box");
            jsonObj = [], $(this).children("span").each(function() {
                itemsz = {}, itemsz.item = $(this).data(a + "-set"), jsonObj.push(itemsz)
            }), firstitem = {}, firstitem[a] = jsonObj, parentObj.push(firstitem)
        });
        var o = JSON.stringify(parentObj),
            n = $("#price_from").val(),
            c = $("#price_to").val(),
            l = $("#hours_from").val(),
            h = $("#hours_to").val(),
            m = $("#year_from").val(),
            f = $("#year_to").val();
        $.ajax({
            url: "inc/mods/machine_finder/asyncfile.php?action=filter",
            cache: !1,
            type: "POST",
            data: {
                filters: o
            },
            success: function(a) {
                var t = $.parseJSON(a),
                    i = t.models,
                    s = t.years;
                if ("model" != e) {
                    var r = [];
                    $(".mod-item").each(function() {
                        r.push($(this).data("vals"))
                    }), $(".mod-item").hide(), $.each(i, function(a, t) {
                        var e = !1;
                        $.map(r, function(a, i) {
                            a == t && ($('[data-vals="' + t + '"]').show(), e = !0)
                        }), e || $('[data-vals="' + t + '"]').hide()
                    })
                }
                var o = [];
                $(".year-item").each(function() {
                    o.push($(this).data("vals"))
                }), $(".year-item").hide(), $.each(s, function(a, t) {
                    var e = !1;
                    $.map(o, function(a, i) {
                        a == t && ($('[data-vals="' + t + '"]').show(), e = !0)
                    }), e || $('[data-vals="' + t + '"]').hide()
                })
            }
        });
        var d = $("#sorterset").val();
        $.ajax({
            url: "inc/mods/machine_finder/asyncfile.php?action=getresults",
            cache: !1,
            type: "POST",
            data: {
                filters: o,
                price_from: n,
                price_to: c,
                hours_from: l,
                hours_to: h,
                year_from: m,
                year_to: f,
                sorttype: d
            },
            success: function(a) {
                $(".rezout").html(a), getSortobj()
            }
        })
    })
}

function resetFilters() {
    $("#searchinput").val(""), $(".clickobjtabs").remove(), $(".thecheck").remove(), $(".cat-item").show(), $(".cat-item").each(function() {
        $(this).removeClass("catfilter")
    }), $(".man-item").each(function() {
        $(this).removeClass("manfilter")
    }), $(".mod-item").each(function() {
        $(this).removeClass("modfilter")
    }), $(".man-item").show(), $(".mod-item").show(), $(".year-item").show(), $(".js-range-slider").data("ionRangeSlider").update({
        from: 0,
        to: 9e5
    }), $(".js-range-slider-2").data("ionRangeSlider").update({
        from: 0,
        to: 9e3
    }), $(".js-range-slider-3").data("ionRangeSlider").update({
        from: 1900,
        to: (new Date).getFullYear()
    }), $("#price_from").val("0"), $("#price_to").val("900000"), $("#hours_from").val("0"), $("#hours_to").val("9000"), $("#year_from").val("1900"), $("#year_to").val((new Date).getFullYear()), $("#sorterset").val(""), $(".show-sort").text("Sort"), pageData(1)
}

function resetFilters() {
    $("#searchinput").val(""), $(".clickobjtabs").remove(), $(".thecheck").remove(), $(".cat-item").show(), $(".cat-item").each(function() {
        $(this).removeClass("catfilter")
    }), $(".man-item").each(function() {
        $(this).removeClass("manfilter")
    }), $(".mod-item").each(function() {
        $(this).removeClass("modfilter")
    }), $(".man-item").show(), $(".mod-item").show(), $(".year-item").show(), $(".js-range-slider").data("ionRangeSlider").update({
        from: 0,
        to: 9e5
    }), $(".js-range-slider-2").data("ionRangeSlider").update({
        from: 0,
        to: 9e3
    }), $(".js-range-slider-3").data("ionRangeSlider").update({
        from: 1900,
        to: (new Date).getFullYear()
    }), $("#price_from").val("0"), $("#price_to").val("900000"), $("#hours_from").val("0"), $("#hours_to").val("9000"), $("#year_from").val("1900"), $("#year_to").val((new Date).getFullYear()), $("#sorterset").val(""), $(".show-sort").text("Sort"), pageData(1)

    var url = window.location.href;

    var exp = url.split('?');

    var resetss = exp[0];

    window.history.replaceState(null, null, resetss);
}

function getSortobj() {
    $(".sorters").on("click", function() {
        var a = $(this).data("dorttype");
        $(this).text();
        $("#sorterset").val(a), pageData(1)
    })
}

function expUrl(str){

}


function rerunFiltration() {

    var filterParms = location.search;



    if(filterParms != ''){
       //var passover = jQuery.parseJSON(expUrl(filterParms));
        $.ajax({
            url: 'inc/mods/machine_finder/asyncfile.php?action=dourlwork',
            type: "POST",
            data: {
                urlstring: filterParms
            },
            success: function (a) {
                var obj = jQuery.parseJSON(a);

                var url = window.location.href;

                var exp = url.split('?');

                var newUrl = exp[0];


                window.history.replaceState(null, null, newUrl);
                resetFilters();

                $.each(obj.cats, function(key,value) {

                    $('*[data-vals="'+value+'"]').click();
                })

                $.each(obj.mans, function(key,value) {
                    value = decodeURI(value);
                    $('*[data-vals="'+value+'"]').click();
                })

                $.each(obj.mods, function(key,value) {

                    $('*[data-vals="'+value+'"]').click();
                })


            }
        })

    }else{

    }

    parentObj = [], $(".target-box").each(function() {
        var a = $(this).data("filter-box");
        jsonObj = [], $(this).children("span").each(function() {
            itemsz = {}, itemsz.item = $(this).data(a + "-set"), jsonObj.push(itemsz)
        }), firstitem = {}, firstitem[a] = jsonObj, parentObj.push(firstitem)
    });
    var a = JSON.stringify(parentObj);
    $("#price_from").val(), $("#price_to").val(), $("#hours_from").val(), $("#hours_to").val(), $("#year_from").val(), $("#year_to").val();
    $.ajax({
        url: "inc/mods/machine_finder/asyncfile.php?action=filter",
        cache: !1,
        type: "POST",
        data: {
            filters: a
        },
        success: function(a) {
            var t = $.parseJSON(a),
                e = t.models,
                i = t.years;
            $(".man-item").hide(), $(".catfilter").each(function(a, t) {
                var e = $(this).data("manus").split(",");
                $.each(e, function(a, t) {
                    $('[data-vals="' + t + '"]').show()
                })
            });
            var s = [];
            $(".mod-item").each(function() {
                s.push($(this).data("vals"))
            }), $(".mod-item").hide(), $.each(e, function(a, t) {
                var e = !1;
                $.map(s, function(a, i) {
                    a == t && ($('[data-vals="' + t + '"]').show(), e = !0)
                }), e || $('[data-vals="' + t + '"]').hide()
            });
            var r = [];
            $(".year-item").each(function() {
                r.push($(this).data("vals"))
            }), $(".year-item").hide(), $.each(i, function(a, t) {
                var e = !1;
                $.map(r, function(a, i) {
                    a == t && ($('[data-vals="' + t + '"]').show(), e = !0)
                }), e || $('[data-vals="' + t + '"]').hide()
            })
        }
    })
}
$(function() {
    $(".clickobj").on("click", function() {
        var a = $(this).data("obj"),
            t = $(this).data("vals");

        if (1 == $(this).find(".thecheck").length ? ($(this).find(".thecheck").remove(), $("[data-" + a + '-set="' + t + '"]').remove()) : ($(this).append(' <span class="thecheck"> <i class="fa fa-check green-check"></i></span>'), $("." + a + "-labs").append('<span class="badge badge-secondary badge-lab clickobjtabs" data-labtype="' + a + '" data-' + a + '-set="' + t + '">' + t + ' <i class="fa fa-times-circle"></i></span>'), recallEvent()), "category" == a) {
            $(".man-item").hide(), $(this).hasClass("catfilter") ? $(this).removeClass("catfilter") : $(this).addClass("catfilter");
            var e = $(".catfilter").length;
            0 == parseInt(e) && $(".man-item").show(), $(".catfilter").each(function(a, t) {
                var e = $(this).data("manus").split(",");
                $.each(e, function(a, t) {
                    $('[data-vals="' + t + '"]').show()
                })
            })
        }

        if ("category" == a) {
            var filterParms = location.search;
           // window.history.replaceState(null, null, window.location.href+filterParms+"&category="+t);

            var url = window.location.href;

            var tcheck = t.replace(/ /g, "%20");
            if(url.indexOf(tcheck) != -1){
                console.log('category='+tcheck + " found");
                url = url.replace('&category='+tcheck,'');
                url = url.replace('?category='+tcheck,'');
                window.history.replaceState(null, null, url);
            }else{
                if (url.indexOf('?') > -1){
                    url += '&category='+t
                }else{
                    url += '?category='+t
                }

                window.history.replaceState(null, null, url);
            }


        }

        if ("model" == a) {




            var url = window.location.href;


            var tcheck = t.replace(/ /g, "%20");
            if(url.indexOf(tcheck) != -1){
                console.log('model='+tcheck + " found");
                url = url.replace('model='+tcheck,'');
                url = url.replace('?model='+tcheck,'');
                window.history.replaceState(null, null, url);
            }else{
                if (url.indexOf('?') > -1){
                    url += '&model='+t
                }else{
                    url += '?model='+t
                }

                window.history.replaceState(null, null, url);
            }



        }

        if ("manufacturer" == a) {
            $(".cat-item").hide(), $(this).hasClass("manfilter") ? $(this).removeClass("manfilter") : $(this).addClass("manfilter");
            var i = $(".manfilter").length;
            0 == parseInt(i) && $(".cat-item").show(), $(".manfilter").each(function(a, t) {
                var e = $(this).data("cats").split(",");
                $.each(e, function(a, t) {
                    $('[data-vals="' + t + '"]').show()
                });
                var i = $(this).data("mods").split(",");
                $(".mod-item").hide(), $.each(i, function(a, t) {
                    $('[data-vals="' + t + '"]').show()
                })
            })

            var url = window.location.href;

            var tcheck = t.replace(/ /g, "%20");
            if(url.indexOf(tcheck) != -1){
                console.log('manufacturer='+tcheck + " found");
                url = url.replace('manufacturer='+tcheck,'');
                url = url.replace('?manufacturer='+tcheck,'');
                window.history.replaceState(null, null, url);
            }else{
                if (url.indexOf('?') > -1){
                    url += '&manufacturer='+t
                }else{
                    url += '?manufacturer='+t
                }
                window.history.replaceState(null, null, url);
            }

        }
        if ("city" == a && ($(this).hasClass("locfilter") ? $(this).removeClass("locfilter") : $(this).addClass("locfilter")), "model" == a) {
            $(".cat-item").hide(), $(".man-item").hide(), $(this).hasClass("modfilter") ? $(this).removeClass("modfilter") : $(this).addClass("modfilter");
            var s = $(".modfilter").length;
            if (0 == parseInt(s)) {
                $(".mod-item").show(), $(".man-item").hide(), $(".cat-item").show();
                e = $(".catfilter").length;
                0 != parseInt(e) ? $(".catfilter").each(function(a, t) {
                    var e = $(this).data("manus").split(",");
                    $.each(e, function(a, t) {
                        $('[data-vals="' + t + '"]').show()
                    })
                }) : $(".man-item").show()
            }
            $(".modfilter").each(function(a, t) {
                var e = $(this).data("cats").split(",");
                $.each(e, function(a, t) {
                    $('[data-vals="' + t + '"]').show()
                });
                var i = $(this).data("manus").split(",");
                $.each(i, function(a, t) {
                    $('[data-vals="' + t + '"]').show()
                })
            })
        }
        parentObj = [], $(".target-box").each(function() {
            var a = $(this).data("filter-box");
            jsonObj = [], $(this).children("span").each(function() {
                itemsz = {}, itemsz.item = $(this).data(a + "-set"), jsonObj.push(itemsz)
            }), firstitem = {}, firstitem[a] = jsonObj, parentObj.push(firstitem)
        });
        var r = JSON.stringify(parentObj),
            o = $("#price_from").val(),
            n = $("#price_to").val(),
            c = $("#hours_from").val(),
            l = $("#hours_to").val(),
            h = $("#year_from").val(),
            m = $("#year_to").val(),
            f = $("#sorterset").val(),
            d = $("#viewtype").val();
        $.ajax({
            url: "inc/mods/machine_finder/asyncfile.php?action=filter",
            type: "POST",
            cache: !1,
            data: {
                filters: r,
                price_from: o,
                price_to: n,
                hours_from: c,
                hours_to: l,
                year_from: h,
                year_to: m,
                viewtype: d,
                sorttype: f
            },
            success: function(t) {
                var e = $.parseJSON(t),
                    i = e.models,
                    s = e.years;
                if ("model" != a) {
                    var r = [];
                    $(".mod-item").each(function() {
                        r.push($(this).data("vals"))
                    }), $(".mod-item").hide(), $.each(i, function(a, t) {
                        var e = !1;
                        $.map(r, function(a, i) {
                            a == t && ($('[data-vals="' + t + '"]').show(), e = !0)
                        }), e || $('[data-vals="' + t + '"]').hide()
                    })
                }
                var o = [];
                $(".year-item").each(function() {
                    o.push($(this).data("vals"))
                }), $(".year-item").hide(), $.each(s, function(a, t) {
                    var e = !1;
                    $.map(o, function(a, i) {
                        a == t && ($('[data-vals="' + t + '"]').show(), e = !0)
                    }), e || $('[data-vals="' + t + '"]').hide()
                })
            }
        }), $.ajax({
            url: "inc/mods/machine_finder/asyncfile.php?action=getresults&page=1",
            cache: !1,
            type: "POST",
            data: {
                filters: r,
                price_from: o,
                price_to: n,
                hours_from: c,
                hours_to: l,
                year_from: h,
                year_to: m,
                viewtype: d,
                sorttype: f
            },
            success: function(a) {
                $(".rezout").html(a), getSortobj()
            }
        })
    })
}), $.fn.donetyping = function(a) {
    var t, e = $(this);

    function i() {
        clearTimeout(t), a.call(e)
    }
    e.keyup(function() {
        clearTimeout(t), t = setTimeout(i, 1e3)
    })
}, $(".theautos").donetyping(function(a) {
    var t = $(this).val();
    $.ajax({
        url: "inc/mods/machine_finder/asyncfile.php?action=inputsearch",
        cache: !1,
        type: "POST",
        data: {
            searchinput: t
        },
        success: function(a) {
            $(".rezout").html(a), getSortobj()
        }
    })
}), $(function() {
    $(".js-range-slider").ionRangeSlider({
        skin: "round",
        onFinish: function(a) {
            $("#price_from").val(a.from), $("#price_to").val(a.to), pageData(1)
        }
    }), $(".js-range-slider-2").ionRangeSlider({
        skin: "round",
        onFinish: function(a) {
            $("#hours_from").val(a.from), $("#hours_to").val(a.to), pageData(1)
        }
    }), $(".js-range-slider-3").ionRangeSlider({
        skin: "round",
        prettify_enabled: !1,
        onFinish: function(a) {
            $("#year_from").val(a.from), $("#year_to").val(a.to), pageData(1)
        }
    })
}), $(function() {
    rerunFiltration();
    var a = $("#pageons").val();
    if ("undefined" == a) var t = "1";
    else t = a;
    pageData(t), $(".opnfilters").on("click", function() {
        $(".mob-sensor").toggle(), $("html, body").animate({
            scrollTop: 0
        }, 0), $(".mob-sensor").is(":visible") ? $(".opnfilters").text("Close Filters") : $(".opnfilters").text("Open Filters")
    })
});

function setViewType(a) {
    $("#viewtype").val(a), pageData(1)
}

setViewType('list');