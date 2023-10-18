<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
    <style>
        body{
            background: #2962FF;
        }
        .perCirc {
            position: relative;
            text-align: center;
            width: 110px;
            height: 110px;
            border-radius: 100%;
            background-color: #ffffff;
            background-image: linear-gradient(91deg, transparent 50%, #314782 50%), linear-gradient(90deg, #2d4da5 50%, transparent 50%);
            margin: 25px;
        }
        .perCirc .perCircInner {
            position: relative;
            top: 10px;
            left: 10px;
            text-align: center;
            width: 90px;
            height: 90px;
            border-radius: 100%;
            background-color: #2962FF;
        }
        .perCirc .perCircInner div {
            position: relative;
            top: 22px;
            color:#fff;
            font-size: 12px;
        }
        .perCirc .perCircStat {
            font-size: 30px;
            line-height:1em;
        }
        .lds-ring {
            display: inline-block;
            position: absolute;
            width: 54px;
            height: 80px;
            top: 14px;
            right: 0;
        }
        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 30px;
            height: 30px;
            margin: 8px;
            border: 2px solid #fff;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #fff transparent transparent transparent;
            zoom: 80%;
        }
        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }
        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }
        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }
        @keyframes lds-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

    </style>
</head>
<body style="padding: 50px">
<div class="lds-ring" style="display: none"><div></div><div></div><div></div><div></div></div>
<span class="thetitle" style="color: #fff;"></span>
<div id="results" class="row">
    <div id="sellPerCirc" class="perCirc">
        <div class="perCircInner">
            <div>Performance</div> <div class="perCircStat">0%</div>
        </div>
    </div>

    <div id="sellPerCirc2" class="perCirc">
        <div class="perCircInner">
            <div>Accessibility</div> <div class="perCircStat">0%</div>
        </div>
    </div>

    <div id="sellPerCirc3" class="perCirc">
        <div class="perCircInner">
            <div>Best Practices</div> <div class="perCircStat">0%</div>
        </div>
    </div>

    <div id="sellPerCirc4" class="perCirc">
        <div class="perCircInner">
            <div>SEO</div> <div class="perCircStat">0%</div>
        </div>
    </div>

    <!--    <div id="sellPerCirc3" class="perCirc">-->
    <!--        <div class="perCircInner">-->
    <!--            <div class="perCircStat">0%</div><div>Complete</div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!---->
    <!--    <div id="sellPerCirc4" class="perCirc">-->
    <!--        <div class="perCircInner">-->
    <!--            <div class="perCircStat">0%</div><div>Complete</div>-->
    <!--        </div>-->
    <!--    </div>-->
</div>
<!--<button onclick="loadClient()">load</button>-->
<!--<button onclick="execute()">execute</button>-->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://apis.google.com/js/api.js"></script>
<script>
    /**
     * Sample JavaScript code for pagespeedonline.pagespeedapi.runpagespeed
     * See instructions for running APIs Explorer code samples locally:
     * https://developers.google.com/explorer-help/guides/code_samples#javascript
     */

    function loadClient() {
        gapi.client.setApiKey("AIzaSyBhwMW-3xelpI3nmUgkrPUP60AuFoGwH8Y");
        return gapi.client.load("https://content.googleapis.com/discovery/v1/apis/pagespeedonline/v5/rest")
            .then(function() { console.log("GAPI client loaded for API"); },
                function(err) { console.error("Error loading GAPI client for API", err); });
    }
    // Make sure the client is loaded before calling this method.
    function execute(urltest) {
        $(".thetitle").html('Testing: '+urltest+' Please Wait..');
        $(".lds-ring").show();
        return gapi.client.pagespeedonline.pagespeedapi.runpagespeed({
            "url": urltest,
            "category": [
                "seo",
                "performance",
                "accessibility",
                "best-practices"
            ],
            "strategy": "mobile"
        })
            .then(function(response) {
                    // Handle the results here (response.result has the parsed body).
                    //
                    //document.getElementById('tresults').innerHTML = response;
                    var performance = JSON.stringify(response["result"]["lighthouseResult"]["categories"]["performance"]["score"]);
                    var accessibility = JSON.stringify(response["result"]["lighthouseResult"]["categories"]["accessibility"]["score"]);
                    var bestpractices = JSON.stringify(response["result"]["lighthouseResult"]["categories"]["best-practices"]["score"]);
                    var seo = JSON.stringify(response["result"]["lighthouseResult"]["categories"]["seo"]["score"]);

                    var perhtml = '';
                    var result = (performance - Math.floor(performance)) !== 0;
                    if (result) {
                        performance = performance.split('.');
                        performance = performance[1];
                    }else{
                        performance = performance;
                    }

                var result2 = (accessibility - Math.floor(accessibility)) !== 0;
                if (result2) {
                    accessibility = accessibility.split('.');
                    accessibility = accessibility[1];
                }else{
                    accessibility = accessibility;
                }

                var result3 = (bestpractices - Math.floor(bestpractices)) !== 0;
                if (result3) {
                    bestpractices = bestpractices.split('.');
                    bestpractices = bestpractices[1];
                }else{
                    bestpractices = bestpractices;
                }

                var result4 = (seo - Math.floor(seo)) !== 0;
                if (result4) {
                    seo = seo.split('.');
                    seo = seo[1];
                }else{
                    seo = seo;
                    console.log("HERER SEO "+seo);
                }

                    if(parseInt(performance) > 9){performance = performance;}else{if(performance == '1'){performance = performance+'00';}else{performance = performance+0;}}
                    if(parseInt(accessibility) > 9){accessibility = accessibility;}else{if(accessibility == '1'){accessibility = accessibility+'00';}else{accessibility = accessibility+0;}}
                    if(parseInt(bestpractices) > 9){bestpractices = bestpractices;}else{if(bestpractices == '1'){bestpractices = bestpractices+'00';}else{bestpractices = bestpractices+0;}}
                    if(parseInt(seo) > 9){seo = seo;}else{if(seo == '1'){seo = seo+'00';console.log("HERER SEO  100");}else{seo = seo+0; console.log("HERER SEO NO 100");}}

                    // perhtml += '<div class="col-md-4">'+performance+'</div>';
                    // perhtml += '<div class="col-md-4">'+accessibility+'</div>';
                    // perhtml += '<div class="col-md-4">'+bestpractices+'</div>';
                    // perhtml += '<div class="col-md-4">'+seo+'</div>';

                    perCirc($('#sellPerCirc'), performance);
                    perCirc($('#sellPerCirc2'), accessibility);
                    perCirc($('#sellPerCirc3'), bestpractices);
                    perCirc($('#sellPerCirc4'), seo);

                    $(".thetitle").html('Testing Complete For: '+urltest);
                    $(".lds-ring").hide();

                    //$("#results").html(perhtml);
                    console.log("Response", response);
                },
                function(err) { console.error("Execute error", err); });
    }
    gapi.load("client");



    function perCirc($el, end, i) {
        if (end < 0)
            end = 0;
        else if (end > 100)
            end = 100;
        if (typeof i === 'undefined')
            i = 0;
        var curr = (100 * i) / 360;
        $el.find(".perCircStat").html(Math.round(curr) + "%");
        if (i <= 180) {
            $el.css('background-image', 'linear-gradient(' + (90 + i) + 'deg, transparent 50%, #314782 50%),linear-gradient(90deg, #314782 50%, transparent 50%)');
        } else {
            $el.css('background-image', 'linear-gradient(' + (i - 90) + 'deg, transparent 50%, #fff 50%),linear-gradient(90deg, #314782 50%, transparent 50%)');
        }
        if (curr < end) {
            setTimeout(function () {
                perCirc($el, end, ++i);
            }, 1);
        }
    }

</script>
</body>
</html>