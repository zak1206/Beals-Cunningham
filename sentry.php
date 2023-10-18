<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Page View</title>

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../../css/styles.css" rel="stylesheet">

    <style>
        /* DONT REMOVE THE BELOW CSS CODE. IT GIVES THE BODY EDIT AREA SOME PRESENTS */
        body {
            border: dashed thin red;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Heritage Tractor Location Map</h1>
                        <p style="font-size: 14pt;">Select a Heritage Tractor location for contact information,
                            store hours,
                            and directions.</p>
                        <p style="font-size: 14pt;">Click the map below to find a location near you.</p>
                        <ul>
                            <ul>
                                <li style="list-style-type: none; display: inline-block;">
                                    <div class="" style="float: left; margin-right: 10px;"><img src="img/SmallHTMapPin.png"></div>Heritage Tractor Location
                                </li>
                            </ul>
                        </ul>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-8">
                                <label for="zipCode">Enter Zip Code:</label>
                                <input type="text" class="form-control" id="zipCode" placeholder="Enter Zip Code">
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary" onclick="SearchByZip()">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-sm-12 col-xs-12 mt-md-0 mt-lg-0 mt-3">
                        <div class="map-content-search mt-sm-3"></div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div id="test-map" style="margin-bottom: 30px; height: 700px; width: 80%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>