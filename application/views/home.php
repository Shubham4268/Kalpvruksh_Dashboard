<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>public/images/icon.ico">
    <!-- favicon ends --->

    <!--- LOAD FILES -->
    <?php echo base_url(); ?>
    <?php if ($_SERVER['HTTP_HOST'] == "localhost" || (stristr($_SERVER['HTTP_HOST'], "192.168.") !== FALSE) || (stristr($_SERVER['HTTP_HOST'], "127.0.0.") !== FALSE)): ?>
        <link rel="stylesheet" href="<?= base_url() ?>public/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>public/font-awesome/css/font-awesome.min.css">

        <script src="<?= base_url() ?>public/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>public/bootstrap/js/bootstrap.min.js"></script>

    <?php else: ?>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <?php endif; ?>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>public/css/form-elements.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/css/main.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- [if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif] -->

</head>

<body class="position-relative">

    <!-- User Login Button at Top Right -->
    <div class="position-absolute top-0 end-0 m-3">
        <a href="<?= site_url('userlogin') ?>" class="btn btn-primary">Get Customer Transactions</a>
    </div>

    <!-- Top content -->
    <div class="top-content">
        <div class="inner-bg">
            <div class="container">

                <div class="row">
                </div>

                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="bg-primary text-center text-white p-2">
                            <div class="col-sm-8 col-sm-offset-2 text">
                                <div style="font-size:100px">
                                    <h1><img src="<?= base_url() ?>public/images/logo_white.png" alt="Kalpvruksh-logo" height="150px"></h1>

                                </div>
                                <span style="color: green; font-size: 12px;">A step towards healthy lifestyle!!</span>
                            </div>
                            <span id="errMsg"></span>
                        </div>
                        <div class="form-bottom">
                            <form id="loginForm">
                                <div class="form-group">
                                    <label class="sr-only" for="email">E-mail</label>
                                    <input type="email" placeholder="Email" class="form-control checkField" id="email">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="password">Password</label>
                                    <input type="password" placeholder="Password" class="form-control checkField" id="password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Log in!</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>









    <!-- Javascript -->
    <script src="<?= base_url() ?>public/js/jquery.backstretch.min.js"></script>
    <script src="<?= base_url() ?>public/js/main.js"></script>
    <script src="<?= base_url() ?>public/js/access.js"></script>
    <!--Javascript--->

</body>

</html>