<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>EQHarvest Site Performance Test.</title>

</head>
<body>
<div class="row" style="padding: 20px">
    <div class="col-md-12">
    <h1>EQHarvest Site Comparison Test.</h1>
        <div style="float: right;">
    <button class="btn btn-primary" onclick="loadFrameOne()">load</button>
    <button onclick="runTest()" class="btn btn-success">execute</button>
        </div>
    </div>
</div>
<div class="row" style="padding: 20px">
    <div class="col-md-6"><input type="text" class="form-control" name="urlone" id="urlone" value="" placeholder="Enter URL of site to be tested."><br><iframe id="metricone" src="metrix.php" style="width:100%; height: 100vh; border: none"></iframe></div>
    <div class="col-md-6"><input type="text" class="form-control" name="urltwo" id="urltwo" value="" placeholder="Enter URL of site to be tested."><br><iframe id="metrictwo" src="metrix2.php" style="width:100%; height: 100vh; border: none"></iframe></div>
</div>
<!--<button onclick="loadClient()">load</button>-->
<!--<button onclick="runTest()">execute</button>-->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://apis.google.com/js/api.js"></script>
<script>
    function loadFrameOne(){
        $('#metricone')[0].contentWindow.loadClient();
        $('#metrictwo')[0].contentWindow.loadClient2();
    }

    function runTest(){
        var urlone = $("#urlone").val();
        var urltwo = $("#urltwo").val();
        $('#metricone')[0].contentWindow.execute(urlone);
        $('#metrictwo')[0].contentWindow.execute2(urltwo);
    }
</script>

</body>
</html>