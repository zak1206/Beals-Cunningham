<?php
    $search = $_POST['keywordserjob'];
    $location = $_POST['locationser'];

?>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="../../../../css/styles.css" rel="stylesheet">
    <style>
        /* DONT REMOVE THE BELOW CSS CODE. IT GIVES THE BODY EDIT AREA SOME PRESENTS */
        body {
            border: dashed thin red;
            padding: 5px;
            margin: 5px;
        }

        .top-container {
            background-color: background: #D9D9D9;
        }
    </style>
</head>
<body>
<div>
<style>
    .top-container {
        background-color: #D9D9D9;
        z-index: 1;
    }

    h1,
    h2,
    h3,
    h4 {
        color: #377C2B;
        font-family: 'Avenir', sans-serif;
        font-weight: 800;
        font-style: normal;
    }

    img {
        width: 100%;
        height: auto;
        object-fit: contain;
    }

    .container2 {
        position: relative;
        margin: 0 auto;
        padding: 20px;
    }

    .search-form {
        position: absolute;
        top: -150%;
        left: 26%;
        width: 48%;
        padding: 10px;
        box-sizing: border-box;
        z-index: 3;
        background-color: #FFF;
        box-shadow: 7px 9px 32px -11px rgba(0, 0, 0, 0.25);
    }

    .title-text {
        position: relative;
        top: 10%;
        right: 7%;
    }

    .card-btn {
        position: relative;
        top: 5%;
        right: 5%;
    }

    .search-form input[type="text"] {
        width: 20px;
        padding: 5px;
        border: 0px solid #ccc;
        outline: none;
    }

    .drop-white {
        background-color: #fff;
        border: 1px solid #fff;
        color: #ccc;
        width: 100%;
    }

    .grey-card {
        background-color: #D9D9D9;
        max-height: 278px;
        height: 278px;
    }

    .grey-card-p {
        color: #000000;
        font-size: 15px;
    }

    .grey-card-title {
        color: #377C2B;
        font-size: 24px;
        font-weight: 800;
        font-family: 'Avenir', sans-serif;
    }
</style>
</div>
<div class="container top-container mb-5 pl-0 pr-0 pt-0 pb-0">
    <div class="row pr-0">
        <div class="col-sm-12 col-md-12 col-lg-5 justify-content-center align-content-center pl-3 pr-3">
            <h2 class="pt-3 pb-3">CAREERS AT LEGACY</h2>
            <p class="mt-2 mb-2">Legacy Equipment has been serving the community since 1935. Since then, the Legacy name has been coincident with innovative agricultural products and services. Our people are passionate individuals who make a difference in the lives of our customers and our communities every day. We pride ourselves on being able to provide the highest quality support and service that our customers expect and come back for year after year. Legacy Leads.</p>
            <div class="row justify-content-around mb-3 mt-2 pt-2 pb-3">
                <button class="btn btn-success mr-4" style="border-radius: 0;">View All Positions</button>
                <button class="btn btn-warning ml-4" style="border-radius: 0; border: none; color: #377C2B; background-color: #FFDE00;">Quick Apply</button>
            </div>
        </div>
        <img class="img-fluid col-sm-12 col-md-12 col-lg-7 pl-0 pr-0 pt-0 pb-0" src="../../../../img/Rectangle 2.png">
    </div>
</div>

{include}inc/career_search.php{/include}

<div class="container">
    <div class="row mt-2 justify-content-center">
        <h1>BROWSE BY CATEGORY</h1>
    </div>
    <div class="row justify-content-between">
        <div class="col-4 px-3 py-3">
            <div class="grey-card">
                <div class="row">
                    <div class="col-12">
                        <h4 class="grey-card-title text-center title-text">Service</h4>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center align-content-center">
                    <div class="col-3">
                        <img src="../../../../img/LEGEQP Career web page icons 9.png">
                    </div>
                    <div class="col-9">
                        <p class="grey-card-p" size="10">Get hands-on experience servicing John Deere equipment to keep it running smoothly and ensuring customers receive top-quality service. Start your career in Service today!</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <button class="btn btn-success mb-3 card-btn">View Positions</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 px-3 py-3">
            <div class="grey-card justify-content-between">
                <div class="row">
                    <div class="col-12">
                        <h4 class="grey-card-title text-center title-text">Sales</h4>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center align-content-center">
                    <div class="col-3">
                        <img src="../../../../img/LEGEQP Career web page icons-03.png">
                    </div>
                    <div class="col-9">
                        <p class="grey-card-p" size="10">Build strong relationships with customers, assess their needs, and provide tailored solutions that meet their unique requirements.</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <button class="btn btn-success mb-3 card-btn">View Positions</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 px-3 py-3">
            <div class="grey-card">
                <div class="row">
                    <div class="col-12">
                        <h4 class="grey-card-title text-center title-text">Ag Tech</h4>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center align-content-center">
                    <div class="col-3">
                        <img src="../../../../img/LEGEQP Career web page icons-05.png">
                    </div>
                    <div class="col-9">
                        <p class="grey-card-p" size="10">Build strong relationships with customers, assess their needs, and provide tailored solutions that meet their unique requirements.</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <button class="btn btn-success mb-3 card-btn">Learn More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-around my-3">
        <div class="col-4 px-3">
            <div class="grey-card">
                <div class="row">
                    <div class="col-12">
                        <h4 class="grey-card-title text-center title-text">Parts</h4>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center align-content-center">
                    <div class="col-3">
                        <img src="../../../../img/LEGEQP Career web page icons-01.png">
                    </div>
                    <div class="col-9">
                        <p class="grey-card-p" size="10">Whether you excel in parts counter sales or prefer working in the warehouse, there's a place for you on our team. If you have a passion for the John Deere brand, excellent communication skills, and a desire to provide top-notch service, apply now!</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <button class="btn btn-success mb-3 card-btn">View Positions</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 px-3">
            <div class="grey-card">
                <div class="row">
                    <div class="col-12">
                        <h4 class="grey-card-title text-center title-text">Admin</h4>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center align-content-center">
                    <div class="col-3">
                        <img src="../../../../img/LEGEQP Career web page icons 9.png">
                    </div>
                    <div class="col-9">
                        <p class="grey-card-p" size="10">Our admin are individuals who are passionate about supporting the success and contribute to the growth of Legacy. Apply today!</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <button class="btn btn-success mb-3 card-btn">View Positions</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 px-3">
            <div class="grey-card">
                <div class="row">
                    <div class="col-12">
                        <h4 class="grey-card-title text-center title-text">Apprentice Program</h4>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center align-content-center">
                    <div class="col-3">
                        <img src="../../../../img/LEGEQP Career web page icons 9.png">
                    </div>
                    <div class="col-9">
                        <p class="grey-card-p" size="10">Work alongside a Master Technician during our 12-month Apprentice Program. You'll gain invaluable knowledge from your Mentor and advance your skills as a Service Technician. Apply now!</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <button class="btn btn-success mb-3 card-btn">Learn More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-5 justify-content-center">
        <h1>THE LEGACY DIFFERENCE</h1>
    </div>
</div>
<div class="container top-container mb-5 pl-0 pr-0 pt-0 pb-0">
    <div class="row pr-0">
        <div class="col-sm-12 col-md-12 col-lg-7 pl-0 pr-0 pt-0 pb-0">
            <img class="img-fluid" src="../../../../img/Rectangle 2.png">
        </div>
        <div class="col-sm-12 col-md-12 col-lg-5 justify-content-center align-content-center pl-3 pr-3">
            <p class="mt-2 mb-2 px-3 pt-2">At Legacy Equipment, our success is built on the dedication and expertise of our people. We understand that our customers expect the highest level of support and service, which is why we pride ourselves on having exceptional team members. We put an emphasis on extensive training and career development opportunities to ensure each team members has the skills and knowledge necessary to provide the best service possible.We also offer our team members a competitive compensation package, including a 401K plan, 100% paid health insurance, paid time off, and many more benefits! We believe in taking care of our team members, and we work hard to ensure everyone at Legacy feel valued and supported.</p>
            <h4 class="pt-2 text-center">Welcome to the Legacy Equipment family!</h4>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mt-5 mb-3 justify-content-center">
        <h1>HEAR FROM OUR EMPLOYEES</h1>
    </div>
</div>

<div class="container">
    <div class="row slider">
        <div class="col-4">
            <img src="../../../../img/Rectangle 3.png">
        </div>
        <div class="col-4">
            <img src="../../../../img/Rectangle 4.png">
        </div>
        <div class="col-4">
            <img src="../../../../img/Employee images 2.png">
        </div>
    </div>
</div>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $('.slider').slick({
        dots: false,
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 3,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
        ]
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>
</html>