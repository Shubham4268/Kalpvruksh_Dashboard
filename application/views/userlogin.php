<?php
defined('BASEPATH') or exit('');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Login</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>public/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/css/main.css">

    <style>
        /* Centered Login Card */
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
            z-index: 2;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.9); /* Slightly transparent */
            border-radius: 10px;
            padding: 20px;
        }

        /* Form Styling */
        input[type="text"], 
        input[type="email"], 
        input[type="password"], 
        textarea {
            height: 50px;
            padding: 0 20px;
            background: #f8f8f8;
            border: 3px solid #ddd;
            font-size: 16px;
            font-weight: 300;
            color: #888;
            border-radius: 4px;
            transition: all .3s;
        }

        input:focus {
            background: #fff;
            border: 3px solid #ccc;
            outline: none;
        }

        input::placeholder {
            color: #888;
        }

        /* Button Styling */
        button.btn {
            height: 50px;
            background: #de995e;
            font-size: 16px;
            font-weight: 300;
            color: #fff;
            border-radius: 4px;
            transition: all .3s;
        }

        button.btn:hover, button.btn:focus {
            opacity: 0.6;
            background: #de995e;
            color: #fff;
        }

        /* Background Image Overlay */
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
    </style>

</head>

<body>

    <!-- Background Image -->
    <div class="background"></div>

    <div class="container login-container">
        <div class="card login-card">
            <div class="card-header text-center">
                <h3>User Login</h3>
            </div>
            <div class="card-body">
                <form action="<?= site_url('userlogin/auth') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-phone"></i> Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter your phone number" required>
                    </div>
                    <button type="submit" class="btn w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?= base_url() ?>public/js/jquery.backstretch.min.js"></script>
    <script src="<?= base_url() ?>public/js/main.js"></script>
    <script src="<?= base_url() ?>public/js/access.js"></script>

    <script>
        // Apply the same background slideshow as the home page
        $.backstretch([
            "<?= base_url() ?>public/images/backgrounds/2.jpg",
            "<?= base_url() ?>public/images/backgrounds/3.jpg",
            "<?= base_url() ?>public/images/backgrounds/1.jpg"
        ], {duration: 3000, fade: 750});
    </script>

</body>

</html>
