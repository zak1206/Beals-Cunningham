<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Image Editor</title>
    <link rel="stylesheet" href="assets/imgedits/pixie/styles.min.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>
    <style>
        body, html {
            margin: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>

<div class="some-container">
    <pixie-editor></pixie-editor>
</div>
<script src="assets/imgedits/pixie/scripts.min.js"></script>

<script>
    var pixie = new Pixie({
        image: '../img/14310553_large_93430.jpg',
        onLoad: function() {
            console.log('Pixie is ready');
        }
    });
</script>
</body>
</html>