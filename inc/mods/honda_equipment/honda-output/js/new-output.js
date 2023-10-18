$( document ).ready(function() {
    console.log( "ready!" );
// / / When the user scrolls the page, execute myFunction


    
window.onscroll = function() {myFunction()};

// Get the navbar
var navbar = document.getElementById("new-navbar");

    if ($(navbar).length ) {

// Get the offset position of the navbar
        var sticky = navbar.offsetTop;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }
    }

    // Cache selectors
    var lastId,
        topMenu = $("#new-navbar"),
        topMenuHeight = topMenu.outerHeight()+15,
        // All list items
        menuItems = topMenu.find("a"),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function(){
            var item = $($(this).attr("href"));
            if (item.length) { return item; }
        });

// Bind click handler to menu items
// so we can get a fancy scroll animation
    menuItems.click(function(e){
        var href = $(this).attr("href"),
            offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+1;
        $('html, body').stop().animate({
            scrollTop: offsetTop
        }, 300);
        e.preventDefault();
    });

// Bind to scroll
    $(window).scroll(function(){
        // Get container scroll position
        var fromTop = $(this).scrollTop()+topMenuHeight;

        // Get id of current scroll item
        var cur = scrollItems.map(function(){
            if ($(this).offset().top < fromTop)
                return this;
        });
        // Get the id of the current element
        cur = cur[cur.length-1];
        var id = cur && cur.length ? cur[0].id : "";

        if (lastId !== id) {
            lastId = id;
            // Set/remove active class
            menuItems
                .parent().removeClass("active")
                .end().filter("[href='#"+id+"']").parent().addClass("active");
        }
    });

    $(".overall-ratings").children('.rating-item').each(function () {
        var rates = parseInt($(this).data('value'));
        var calsc = 2 * rates * 10;
//console.log(calsc);

        $(this).find(".bar .bg").css('width',calsc+'%');
    } );


        $('.review-card-summary').children('.rating-item').each(function () {
            var rates = parseInt($(this).data('value'));
            var calsc = 2 * rates * 10;
//console.log(calsc);

            $(this).find(".bar .bg").css('width',calsc+'%');
        } );



    $(".reviews-summary").children(".jq-ry-container").each(function () {
        var rates = parseInt($(this).data('value'));
        var calsc = 2 * rates * 10;
        console.log(rates);

        $(this).find(".jq-ry-rated-group").css('width',calsc+'%');
    } );

    $(".rating-top").children(".jq-ry-container").each(function () {
        var rates = parseInt($(this).data('value'));
        var calsc = 2 * rates * 10;
        console.log(rates);

        $(this).find(".jq-ry-rated-group").css('width',calsc+'%');
    } );


    $(".reviews-summary").hover(function(){
        $(".snapshot").toggleClass("hide");
    });


    $('.jq-ry-group-wrapper').children('.jq-ry-container').each(function () {
        var rates = $(this).data('value');
        var calsc = 2 * rates * 10;
        console.log(rates);

        $(this).find(".jq-ry-rated-group").css('width',calsc+'%');
    } );

    $('#lightSlider').lightSlider({
        gallery: true,
        item: 1,
        loop:true,
        slideMargin: 0,
        thumbItem: 9
    });

    $(".arrow-right").bind("click", function (event) {
        event.preventDefault();
        $(".vid-list-container").stop().animate({
            scrollLeft: "+=336"
        }, 750);
    });
    $(".arrow-left").bind("click", function (event) {
        event.preventDefault();
        $(".vid-list-container").stop().animate({
            scrollLeft: "-=336"
        }, 750);
    });

    $('#reviewdata').paginate({
        scope: $('.rating'), // targets all div elements
});




    $('#comp-options').change(function(){
        $('option:selected', this).hide();
        // console.log("changed");

        var id = $("#comp-options").data("equipid");
        var val = this.value;
        // alert(id+''+val);

        $.ajax({
            type: 'GET',
            url: 'inc/mods/deere_equipment/deere-output/compare.php?action=compare&value='+val+'&equipid='+id,
            dataType: 'json',
            success: function (data) {




                var i = 0;
                $('.table-striped .rowdata').each(function()
                {
                    if(data[i] == undefined) {

                    }else {
                        $(this).append('<td style="border:solid thin #b3afaf">' + data[i] + '</td>');

                        i++;
                    }
                });

            }
        });
        $(".table_head").append('<td></td>');

    });





    $("#specs-table").on("click", ".remove-col", function ( event ) {
        var optval = $(this).data("value");
        // console.log(optval);

        $('#comp-options option[value="'+optval+'"]').show();

        // Get index of parent TD among its siblings (add one for nth-child)
        var ndx = $(this).parent().index() + 1;
        // Find all TD elements with the same index
        $("td", event.delegateTarget).remove(":nth-child(" + ndx + ")");
    });




    $(".acc-collapse").each(function(i) {
        $(this).attr('id', "acccollapse" + (i + 1));
    });

    $(".acc-title").each(function(i) {
        $(this).attr('href', "#acccollapse" + (i + 1));
    });

    var product = $('#product').val();
    var brand = $('#brand').val();
    var description = $('#description').val();
    var price = $('#price').val();

    if (price != undefined) {
        var priceform = price.replace(",","");
        var priceformat = priceform.split('.')[0];
    }

    console.log(priceformat);
    //var priceform = price.replace(",","");
    //var finalprice = parseFloat(priceform).toFixed(2);
    var ratingval = $('#ratingval').val();
    var ratingcount = $('#ratingcount').val();
    var schemaimg = $('#schemaimg').val();

    var el = document.createElement('script');
    el.type = 'application/ld+json';
    el.text = JSON.stringify({ "@context" : "http://schema.org",
        "@type" : "Product",
        "name" : product,
        "image" : schemaimg,
        "description" : description,
        "brand" : {
            "@type" : "Brand",
            "name" : brand
        },
        "offers" : {
            "@type" : "Offer",
            "price" : priceformat,
            "priceCurrency" : "USD"
        },
        "aggregateRating" : {
            "@type" : "AggregateRating",
            "ratingValue" : ratingval,
            "ratingCount" : ratingcount }});

    document.querySelector('head').appendChild(el);



    // processCompare();
});

var myDiv = document.getElementById("promise-tab");


// var myValue = myDiv.style.top = "0px";

// yValue);
var myMenu = document.getElementById("promise-img");

// function processCompare(){
//     $.ajax({
//         type: 'GET',
//         url: 'compare.php',
//         dataType: 'json',
//         success: function (data) {
//
//             //console.log(data[0]);
//
//             var i = 0;
//             $('.table-striped .rowdata').each(function()
//             {
//                 $(this).append('<td>'+data[i]+'</td>');
//
//                 i++;
//             });
//
//         }
//     });
//
//     $(".table_head").append('<td></td>');
// }

