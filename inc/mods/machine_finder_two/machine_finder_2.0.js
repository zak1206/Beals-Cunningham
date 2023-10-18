$(function(){

    window.onpopstate = function(event) {
        if(event && event.state) {
            location.reload();
        }
    }



    $(".filt-cat").on('click',function(){
        $(".catbox").toggle();
    })

    $(".man-cat").on('click',function(){
        $(".manbox").toggle();
    })

    $(".mo-filters").on('click',function(){
        $(".morebox").toggle();
    })

    $(".con-filters").on('click',function(){
        $(".conbox").toggle();
    })


    //=======CATEGORY FUNCTIONS FOR FILITERS BEGIN=======//

    $(".catobj").on('click',function(){

        var catname = $(this).data('cats');
        var checkActive = $(this).find("span i");
        if ( $( checkActive ).hasClass( "checknon" ) ) {
            $(checkActive).removeClass('checknon').addClass('checknon-active');
            var adjustName = catname.replace(/[^a-z0-9\s]/gi, '').replace(/\s/g,'-');
            $(".tags").append('<button type="button" class="btn btn-light filbu-'+adjustName+'" style="margin: 10px 10px 0px 0px; border:solid thin #cfcfcf; border-radius: 0; display: inline-block" onclick="clearTabs(\''+catname+'\',\'categories\')">'+catname+' <span class="badge"><i class="fas fa-times"></i></span></button>');
        }else{
            var adjustName = catname.replace(/[^a-z0-9\s]/gi, '').replace(/\s/g,'-');
            $(checkActive).removeClass('checknon-active').addClass('checknon')
            $('.filbu-'+adjustName).remove();
           // console.log('remove '+catname+'');
        }

        // /var fixItem =
        var url_string = window.location.href;
        var url = new URL(url_string);
        var paramValueCats = url.searchParams.get("categories");

        if(paramValueCats != null){
            //CREATE//

            var ars = paramValueCats.split("~");

            if(jQuery.inArray(catname, ars) !== -1){
               // console.log(catname);
                var newstr = paramValueCats.replace(catname+'~', "");
                url.searchParams.set('categories', newstr);
            }else{
                url.searchParams.set("categories", paramValueCats+catname+'~');
                // url += encodeURIComponent(catname+'~');
            }

        }else{
            //ADD//
            if (url_string.indexOf('?') > -1){
                url += '&categories='+encodeURIComponent(catname+'~');
            }else{
                url += '?categories='+encodeURIComponent(catname+'~');
            }
        }



        window.history.pushState(null, null, url);

        jsonObj = [];
        $(".catbox .catobj").each(function() {
            var checkactives = $(this).find('span i');

            if ( $(checkactives).hasClass( "checknon-active" ) ) {
                var asscman = $(this).data('asscman');
                jsonObj.push(asscman);
            }
        });

        //var unique = jsonObj.filter(onlyUnique);
        // console.log(unique);
        var punch = '';
        $.each(jsonObj, function(key,value) {
           punch += value;
        })

        punch = punch.replace(/,\s*$/, "");

        var selcats = punch.split(",");

        var unique = selcats.filter(onlyUnique);

        //FUNCTION TO PROCESS ACTIVE MANUFACTURERS//
        $(".manbox .manobj").each(function() {
            var manus = $(this).data('mans');
            if(jQuery.inArray(manus, unique) !== -1){
                $(this).show();
            }else{
                $(this).hide();
            }
        });



        pullUnits(1);

    })


    //=========END CATEGORY FUNCTIONS=============//

    //==========MANUFACTURER FILTER FUNCTIONS BEGIN======//

    $(".manobj").on('click',function(){

        var manname = $(this).data('mans');
        var checkActive = $(this).find("span i");
        if ( $( checkActive ).hasClass( "checknon" ) ) {
            $(checkActive).removeClass('checknon').addClass('checknon-active');
            var adjustName = manname.replace(/[^a-z0-9\s]/gi, '').replace(/\s/g,'-');
            $(".tags").append('<button type="button" class="btn btn-light filbu-'+adjustName+'" style="margin: 10px 10px 0px 0px; border:solid thin #cfcfcf; border-radius: 0; display: inline-block" onclick="clearTabs(\''+manname+'\',\'manufacturer\')">'+manname+' <span class="badge"><i class="fas fa-times"></i></span></button>');
        }else{
            var adjustName = manname.replace(/[^a-z0-9\s]/gi, '').replace(/\s/g,'-');
            $(checkActive).removeClass('checknon-active').addClass('checknon');
            $('.filbu-'+adjustName).remove();
           // console.log('remove '+manname+'');
        }

        // /var fixItem =
        var url_string = window.location.href;
        var url = new URL(url_string);
        var paramValueMans = url.searchParams.get("manufacturer");

        if(paramValueMans != null){
            //CREATE//

            var ars = paramValueMans.split("~");

            if(jQuery.inArray(manname, ars) !== -1){
               // console.log(manname);
                var newstr = paramValueMans.replace(manname+'~', "");
                url.searchParams.set('manufacturer', newstr);
            }else{
                url.searchParams.set("manufacturer", paramValueMans+manname+'~');
                // url += encodeURIComponent(catname+'~');
            }

        }else{
            //ADD//
            if (url_string.indexOf('?') > -1){
                url += '&manufacturer='+encodeURIComponent(manname+'~');
            }else{
                url += '?manufacturer='+encodeURIComponent(manname+'~');
            }
        }



        window.history.pushState(null, null, url);

        jsonObj = [];
        $(".catbox .catobj").each(function() {
            var checkactives = $(this).find('span i');

            if ( $(checkactives).hasClass( "checknon-active" ) ) {
                var mannm = $(this).data('mans');
                jsonObj.push(mannm);
            }
        });

        // console.log(jsonObj);

        // $.ajax({
        //     type: "POST",
        //     url: "inc/mods/machine_finder_two/async.php?action=pullmods",
        //     // The key needs to match your method's input parameter (case-sensitive).
        //     data: { cats:JSON.stringify(jsonObj)},
        //     success: function(data){
        //         $(".manbox").html(data);
        //         recallManu();
        //     }
        // });


        pullUnits(1);

    })

    $(".locbutt").on('click',function(){

        var url_string = window.location.href;
        var url = new URL(url_string);
        var paramValueMans = url.searchParams.get("locations");
        var city = $(this).data('loca');

        if ($(this).hasClass("locbutt")) {
            $(this).removeClass('locbutt').addClass('locbutt-active');
        }else{
            $(this).removeClass('locbutt-active').addClass('locbutt');
        }

        if(paramValueMans != null){
            //CREATE//

            var ars = paramValueMans.split("~");

            if(jQuery.inArray(city, ars) !== -1){
                var newstr = paramValueMans.replace(city+'~', "");
                url.searchParams.set('locations', newstr);
            }else{
                url.searchParams.set("locations", paramValueMans+city+'~');
                // url += encodeURIComponent(catname+'~');
            }

        }else{
            //ADD//
            if (url_string.indexOf('?') > -1){
                url += '&locations='+encodeURIComponent(city+'~');
            }else{
                url += '?locations='+encodeURIComponent(city+'~');
            }
        }
        window.history.pushState(null, null, url);

        pullUnits(1);
    })

    var url_string = window.location.href;
    var url = new URL(url_string);
    var paramValuePage = url.searchParams.get("page");

    if(paramValuePage != null){
        var setPage = paramValuePage;
    }else{
        var setPage = 1;
    }

    pullUnits(setPage);

    $("#macyear").slider();
    $("#macyear").on("slideStop", function(ev) {
        var theyears = ev.value;
        var str = theyears[0];
        var ends = theyears[1];
        $("#stryear").text(str);
        $("#endyear").text(ends);

        //DO URL STUFF HERE//
        var url_string = window.location.href;
        var url = new URL(url_string);
        var paramValueMans = url.searchParams.get("years");

        if(paramValueMans != null){
            var ars = paramValueMans.split("~");

            url.searchParams.set('years', str+'-'+ends);
            window.history.pushState(null, null, url);

        }else {

            if (url_string.indexOf('?') > -1) {
                url += '&years=' + encodeURIComponent(str + '-' + ends);
            } else {
                url += '?years=' + encodeURIComponent(str + '-' + ends);
            }

            window.history.pushState(null, null, url);
        }

        pullUnits(1);

    });
    $("#macprice").slider();
    $("#macprice").on("slideStop", function(ev) {
        var theprice = ev.value;
        var strprice = theprice[0];
        var endsprice = theprice[1];
        $("#strprice").text("$"+ new Intl.NumberFormat().format(strprice));
        $("#endprice").text("$"+ new Intl.NumberFormat().format(endsprice));

        //DO URL STUFF HERE//
        var url_string = window.location.href;
        var url = new URL(url_string);
        var paramValueMans = url.searchParams.get("price");

        if(paramValueMans != null){
            var ars = paramValueMans.split("~");

            url.searchParams.set('price', strprice+'-'+endsprice);
            window.history.pushState(null, null, url);

        }else {

            if (url_string.indexOf('?') > -1) {
                url += '&price=' + encodeURIComponent(strprice + '-' + endsprice );
            } else {
                url += '?price=' + encodeURIComponent(strprice + '-' + endsprice);
            }

            window.history.pushState(null, null, url);
        }

        pullUnits(1);
    });
    $("#hourprice").slider();
    $("#hourprice").on("slideStop", function(ev) {
        var thehour = ev.value;
        var strhour = thehour[0];
        var endshour = thehour[1];
        $("#strhour").text(strhour);
        $("#endhour").text(endshour);

        //DO URL STUFF HERE//
        var url_string = window.location.href;
        var url = new URL(url_string);
        var paramValueMans = url.searchParams.get("hours");

        if(paramValueMans != null){
            var ars = paramValueMans.split("~");

            url.searchParams.set('hours', strhour+'-'+endshour);
            window.history.pushState(null, null, url);

        }else {

            if (url_string.indexOf('?') > -1) {
                url += '&hours=' + encodeURIComponent(strhour + '-' + endshour );
            } else {
                url += '?hours=' + encodeURIComponent(strhour + '-' + endshour);
            }

            window.history.pushState(null, null, url);
        }
        pullUnits(1);
    });

    $(".sorters").on('click',function(){
        var sortType = $(this).data('dorttype');
        $(".sortparent").text(sortType);


        //DO URL STUFF HERE//
        var url_string = window.location.href;
        var url = new URL(url_string);
        var paramValueSort = url.searchParams.get("sort");

        if(paramValueSort != null){
            var ars = paramValueSort.split("~");

            url.searchParams.set('sort', sortType);
            window.history.pushState(null, null, url);

        }else{

            if (url_string.indexOf('?') > -1) {
                url += '&sort=' + encodeURIComponent(sortType);
            } else {
                url += '?sort=' + encodeURIComponent(sortType);
            }

            window.history.pushState(null, null, url);
        }
        pullUnits(1);

    })

    $(".eqtypset").on('click',function(){
        var eqtyps = $(this).data('eqcond');
        $(".eqtparent").text(eqtyps);

        //DO URL STUFF HERE//
        var url_string = window.location.href;
        var url = new URL(url_string);
        var paramValueCon = url.searchParams.get("eqcondition");

        if(paramValueCon != null){
            var ars = paramValueCon.split("~");

            url.searchParams.set('eqcondition', eqtyps);
            window.history.pushState(null, null, url);

        }else{

            if (url_string.indexOf('?') > -1) {
                url += '&eqcondition=' + encodeURIComponent(eqtyps);
            } else {
                url += '?eqcondition=' + encodeURIComponent(eqtyps);
            }

            window.history.pushState(null, null, url);
        }

        //ADJUST CATEGORIES BY TYPES IF NEW//
        if(eqtyps == 'New') {
            $(".catobj").each(function () {
                var cond = $(this).data('cond');
                if (cond == true) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            })
        }

        if(eqtyps == 'Used') {
            $(".catobj").each(function () {
                if ($(this).data('cond') == false) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            })
        }

        if(eqtyps == 'New & Used') {
            $(".catobj").each(function () {
                $(this).show();
            })
        }


        pullUnits(1);
    })

        $('[data-toggle="tooltip"]').tooltip()



    $("#search_cat_list").keyup(function(){


        jQuery.expr[':'].contains = function(a, i, m) {
            return jQuery(a).text().toUpperCase()
                .indexOf(m[3].toUpperCase()) >= 0;
        };

        var inputval = $(this).val();
        $(".catname").each(function(){
            if($(this).is(':contains("'+inputval+'")')){
                $(this).closest('.catobj').show();
            }else{
                $(this).closest('.catobj').hide();
            }
        })
    })

    $("#search_man_list").keyup(function(){

        jQuery.expr[':'].contains = function(a, i, m) {
            return jQuery(a).text().toUpperCase()
                .indexOf(m[3].toUpperCase()) >= 0;
        };

        var inputval = $(this).val();
        $(".manname").each(function(){
            if($(this).is(':contains("'+inputval+'")')){
                $(this).closest('.manobj').show();
            }else{
                $(this).closest('.manobj').hide();
            }
        })
    })

    $(".closthis").on('click',function(){
        //$(this).parent().parent().toggle();
        $(".catbox").hide();
        $(".manbox").hide();
        $(".morebox").hide();
    })


        $('.catbox').on('scroll', function() {
            if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                $(".moreshow").hide();
            }else{
                $(".moreshow").show();
            }
        })

    $('.manbox').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            $(".moreshow").hide();
        }else{
            $(".moreshow").show();
        }
    })

    $("#usedser").on('keyup',function(){
        if(window.location.href.indexOf("?") > -1) {

            var uri = window.location.toString();
            if (uri.indexOf("?") > 0) {
                var clean_uri = uri.substring(0, uri.indexOf("?"));
                window.history.replaceState({}, document.title, clean_uri);
            }
        }
        var query = $(this).val();


        //DO URL STUFF HERE//
        var url_string = window.location.href;
        var url = new URL(url_string);
        var paramValueCon = url.searchParams.get("search");

        if(paramValueCon != null){
            var ars = paramValueCon.split("~");

            url.searchParams.set('search', query);
            window.history.pushState(null, null, url);

        }else{

            if (url_string.indexOf('?') > -1) {
                url += '&search=' + encodeURIComponent(query);
            } else {
                url += '?search=' + encodeURIComponent(query);
            }

            window.history.pushState(null, null, url);
        }

        $.ajax({
            traditional: true,
            type: 'POST',
            url: 'inc/mods/machine_finder_two/async.php?action=searchunits',
            data: {"query":query},
            success: function(msg){
                msg = JSON.parse(msg);
                $(".manobj").hide();
                $(".catobj").each(function(){
                    var catss = $(this).data('cats');
                    if(contains(msg, "category", catss)){
                        $(this).show();
                        var assman = $(this).data('asscman');
                        assman = assman.split(',');

                        for(var i=0; i< assman.length; i++){
                            $('.manobj[data-mans="'+ assman[i] +'"]').show();
                        }

                    } else{
                        $(this).hide();
                    }
                })



                // $.each(msg, function(index, item) {
                //     console.log(item["category"]);
                // });

            }
        });

        pullUnits(1)
    })

    $(".listtypout").on('click',function () {
        var settype = $(this).data('listtype');
        $('.listtypout').removeClass('active');
        $(this).addClass('active');

        //DO URL STUFF HERE//
        var url_string = window.location.href;
        var url = new URL(url_string);
        var paramValueCon = url.searchParams.get("listtype");

        if(paramValueCon != null){
            var ars = paramValueCon.split("~");

            url.searchParams.set('listtype', settype);
            window.history.pushState(null, null, url);

        }else{

            if (url_string.indexOf('?') > -1) {
                url += '&listtype=' + encodeURIComponent(settype);
            } else {
                url += '?listtype=' + encodeURIComponent(settype);
            }

            window.history.pushState(null, null, url);
        }

        pullUnits(1)
    })


    //attempt wrap cond & sort when mobile//
    $( window ).resize(function() {



        if($(window).width() < 1000){
            if ($(".drogblock")[0]){

            }else{
                $(".mobsens").wrapAll("<div class='drogblock row'></div>");
                $('.drogblock').append('<div class="col mobsens2 eqlas" style="display: none"><button class="btn btn-default shsowconds" style="padding: 14px; border-radius: 0;background: #fff;border: solid thin #c7c7c7;color: #b1b1b1;margin-top: 2px;"><i class="fas fa-ellipsis-v"></i></button></div>');

                $('.eqlas').on('click',function(){
                    $(".mobsens").toggle();
                    $('.eqlas').toggle();
                })
            }
            console.log($( window ).width());
        }else{
            $('.drogblock').contents().unwrap();
            $('.mobsens').show();

        }

    });

    $('.shsowconds').on('click',function(){
        $(".mobsens").toggle();
        $('.eqlas').toggle();
    })



})

function contains(arr, key, val) {
    for (var i = 0; i < arr.length; i++) {
        if(arr[i][key] === val) return true;
    }
    return false;
}

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}

//=======EXTERNAL MODEL UPDATE=======//

function recallManu(){


    $(".manobj").on('click',function(){

        var manname = $(this).data('mans');
        var checkActive = $(this).find("span i");
        if ( $( checkActive ).hasClass( "checknon" ) ) {
            $(checkActive).removeClass('checknon').addClass('checknon-active');
            var adjustName = manname.replace(/[^a-z0-9\s]/gi, '').replace(/\s/g,'-');
            $(".tags").append('<button type="button" class="btn btn-light filbu-'+adjustName+'" style="margin: 10px 10px 0px 0px; border:solid thin #cfcfcf; border-radius: 0; display: inline-block" onclick="clearTabs(\''+manname+'\',\'manufacturer\')">'+manname+' <span class="badge"><i class="fas fa-times"></i></span></button>');
        }else{
            var adjustName = manname.replace(/[^a-z0-9\s]/gi, '').replace(/\s/g,'-');
            $(checkActive).removeClass('checknon-active').addClass('checknon')
            $('.filbu-'+adjustName).remove();
           /// console.log('remove '+manname+'');
        }

        // /var fixItem =
        var url_string = window.location.href;
        var url = new URL(url_string);
        var paramValueMans = url.searchParams.get("manufacturer");

        if(paramValueMans != null){
            //CREATE//

            var ars = paramValueMans.split("~");

            if(jQuery.inArray(manname, ars) !== -1){
              //  console.log(manname);
                var newstr = paramValueMans.replace(manname+'~', "");
                url.searchParams.set('manufacturer', newstr);
            }else{
                url.searchParams.set("manufacturer", paramValueMans+manname+'~');
                // url += encodeURIComponent(catname+'~');
            }

        }else{
            //ADD//
            if (url_string.indexOf('?') > -1){
                url += '&manufacturer='+encodeURIComponent(manname+'~');
            }else{
                url += '?manufacturer='+encodeURIComponent(manname+'~');
            }
        }



        window.history.pushState(null, null, url);

        jsonObj = [];
        $(".catbox .catobj").each(function() {
            var checkactives = $(this).find('span i');

            if ( $(checkactives).hasClass( "checknon-active" ) ) {
                var mannm = $(this).data('mans');
                jsonObj.push(mannm);
            }
        });

        // console.log(jsonObj);

        // $.ajax({
        //     type: "POST",
        //     url: "inc/mods/machine_finder_two/async.php?action=pullmods",
        //     // The key needs to match your method's input parameter (case-sensitive).
        //     data: { cats:JSON.stringify(jsonObj)},
        //     success: function(data){
        //         $(".manbox").html(data);
        //         recallManu();
        //     }
        // });

        pullUnits(1);

    })
}


//========CORE UNIT PULLER=========//

function pullUnits(pagnum){
    $(".lds-ring").show();
    var queryString = window.location.search;


    $.ajax({
        traditional: true,
        type: 'POST',
        url: 'inc/mods/machine_finder_two/async.php?action=pullunits&page='+pagnum,
        data: queryString,
        success: function(msg){
            $(".lds-ring").hide();
            $(".useditems").html(msg);

            var urlsd = window.location.href;
            history.pushState(null, null, urlsd);
        }
    });

    //TRY TO DO SOME CORRECTIONS FOR MANUFACTURER//
    var url_string = window.location.href;
    var url = new URL(url_string);
    var paramValueCats = url.searchParams.get("categories");
    var paramValueMan = url.searchParams.get("manufacturer");


    if(paramValueCats != null) {
        $('.manobj').hide();
        $(".catobj").each(function () {
            var ches = $(this).find(".fa-check");
            if (ches.hasClass('checknon-active')) {
                var manus = $(this).data('asscman');
                var splits = manus.split(',');
                $.each(splits, function (i, item) {
                    $('.manobj[data-mans="' + item + '"]').show();
                   // console.log(item);
                });
            }
        })

    }

    if(paramValueMan != null) {
        $('.catobj').hide();
        $(".manobj").each(function () {
            var ches = $(this).find(".fa-check");
            if (ches.hasClass('checknon-active')) {
                var cats = $(this).data('asscat');
                var splits = cats.split(',');
                $.each(splits, function (i, item) {
                    console.log(item);
                    $('.catobj[data-cats="' + item + '"]').show();
                    // console.log(item);
                });
            }
        })
    }

    if(paramValueCats == ''){
        $('.manobj').show();
    }

    if(paramValueMan == ''){
        $('.catobj').show();
    }

   /// history.pushState(null, null, url["href"]);

    // console.log("HERE -  "+url["href"]);


}

//=============CATEGORY TAB CLEAR FUNCTIONS=================//
function clearTabs(tabobj,cleartyp){

   // console.log(cleartyp);

    var url_string = window.location.href;
    var url = new URL(url_string);

    //DO URL THINGS FOR CATEGORY HERE//
    var paramValueCats = url.searchParams.get(""+cleartyp+"");

    if(paramValueCats != null){
        //CREATE//

        var ars = paramValueCats.split("~");

        if(jQuery.inArray(tabobj, ars) !== -1){
            var newstr = paramValueCats.replace(tabobj+'~', "");
            url.searchParams.set(cleartyp, newstr);
        }else{
            url += encodeURIComponent(tabobj+'~');
        }


    }else{
        //ADD//
        if (url_string.indexOf('?') > -1){
            url += '&'+cleartyp+'='+encodeURIComponent(tabobj+'~');
        }else{
            url += '?'+cleartyp+'='+encodeURIComponent(tabobj+'~');
        }
    }


    window.history.pushState(null, null, url);

    var adjustName = tabobj.replace(/[^a-z0-9\s]/gi, '').replace(/\s/g,'-');
    $('.filbu-'+adjustName).remove();


    if(cleartyp == 'categories') {
        $('*[data-cats="' + tabobj + '"]').find('.checknon-active').removeClass('checknon-active').addClass('checknon');
    }

    if(cleartyp == 'manufacturer') {
        $('*[data-mans="' + tabobj + '"]').find('.checknon-active').removeClass('checknon-active').addClass('checknon');
    }

    pullUnits(1);

}

function pageData(pagenum){
    //DO URL STUFF HERE//
    var url_string = window.location.href;
    var url = new URL(url_string);
    var paramValuePage = url.searchParams.get("page");


    if(paramValuePage != null){
        var ars = paramValuePage.split("~");

        url.searchParams.set('page', pagenum);


    }else{

        if (url_string.indexOf('?') > -1) {
            url += '&page=' + encodeURIComponent(pagenum);
        } else {
            url += '?page=' + encodeURIComponent(pagenum);
        }
        window.location.href = url;
    }


    history.pushState(null, null, url['href']);
    pullUnits(pagenum);
    $('html,body').scrollTop(0);

}



//==========MOUSE FUNCTIONS FOR FILTER SECTIONS============//
$(document).mouseup(function(e)
{
    var container = $(".catbox");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        container.hide();
    }

    var container = $(".manbox");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        container.hide();
    }

    var container = $(".morebox");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        container.hide();
    }

});
