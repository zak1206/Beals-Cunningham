 $("#coverflow").flipster({
            style: 'carousel',
            spacing: -0.5,
            nav: false,
            buttons: true,
        });

 $("#feat-used").flipster({
        style: 'carousel',
        spacing: -0.5,
        nav: false,
        buttons: true,
    });
        $(function(){
            $('.myCarousel').carousel()
        });

        var scrollW = document.getElementById("wrap-scroll");
        var scrollUl = document.getElementById("ul-scroll");
        var itemsScrolled,
            itemsMax,
            cloned = false;

        var listOpts = {
            itemCount: null,
            itemHeight: null,
            items: [],
        };

        function scrollWrap () {

            itemsScrolled = Math.ceil( (this.scrollTop + listOpts.itemHeight / 2 ) / listOpts.itemHeight);

            if (this.scrollTop < 1) {
                itemsScrolled = 0;
            }

            listOpts.items.forEach(function (ele) {
                ele.classList.remove("active");
            })

            if (itemsScrolled < listOpts.items.length) {
                listOpts.items[itemsScrolled].classList.add("active");
            }

            if (itemsScrolled > listOpts.items.length - 3) {

                var node;
                for ( _x = 0; _x <= itemsMax - 1; _x++ ) {

                    node = listOpts.items[_x];

                    if ( !cloned ) {
                        node = listOpts.items[_x].cloneNode(true);
                    }

                    scrollUl.appendChild(node);
                }

                initItems(cloned);
                cloned = true;
                itemsScrolled = 0;

            }
        }

        function initItems (scrollSmooth) {

            listOpts.items = [].slice.call(scrollUl.querySelectorAll("li"));
            listOpts.itemHeight = listOpts.items[0].clientHeight;
            listOpts.itemCount = listOpts.items.length;

            if (!itemsMax) {
                itemsMax = listOpts.itemCount;
            }

            if (scrollSmooth) {
                var seamLessScrollPoint = ((itemsMax - 3) * listOpts.itemHeight);
                scrollW.scrollTop = seamLessScrollPoint;
            }

        }

        document.addEventListener("DOMContentLoaded", function(event) {
            initItems();
            scrollW.onscroll = scrollWrap;
        });

        $(document).ready(function() {
            $(".megamenu").on("click", function(e) {
                e.stopPropagation();
            });
        });
