<?php
defined('BASEPATH') or exit('');
?>

<!DOCTYPE HTML>
<html>

<head>
  <title><?= $pageTitle ?></title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= base_url() ?>public/images/icon.ico">
  <!-- favicon ends -->

  <!-- LOAD FILES -->
  <?php if ((stristr($_SERVER['HTTP_HOST'], "localhost") !== FALSE) || (stristr($_SERVER['HTTP_HOST'], "192.168.") !== FALSE) || (stristr($_SERVER['HTTP_HOST'], "127.0.0.") !== FALSE)) : ?>
    <link rel="stylesheet" href="<?= base_url() ?>public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/bootstrap/css/bootstrap-theme.min.css" media="screen">
    <link rel="stylesheet" href="<?= base_url() ?>public/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/font-awesome/css/font-awesome-animation.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/ext/select2/select2.min.css">

    <script src="<?= base_url() ?>public/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>public/ext/select2/select2.min.js"></script>

  <?php else : ?>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.8/font-awesome-animation.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <?php endif; ?>

  <!-- custom CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>public/css/main.css">

  <!-- custom JS -->
  <script src="<?= base_url() ?>public/js/main.js"></script>

  <!-- Fix collapse functionality -->
  <script>
    $(document).ready(function() {
      // Check which dropdown should stay open
      $(".nav-stacked .collapse").each(function() {
        if ($(this).find(".active").length) {
          $(this).addClass("in");
        }
      });

      // Ensure dropdown stays open when clicking an item inside it
      $('.nav-stacked li a').on('click', function() {
        var $parent = $(this).closest('.collapse');
        if ($parent.length) {
          $parent.addClass("in");
        }
      });
    });
  </script>
  <style>
    /* Sidebar styles */
    .mySideNav {
      background-color: #f8f9fa;
      height: 100vh;
      padding-top: 10px;
    }

    .nav-stacked>li>a {
      padding: 10px 15px;
    }

    /* Fix for collapsing effect */
    .collapse {
      display: none;
    }

    .collapse.in {
      display: block;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-default hidden-print">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header" style="display: flex; align-items: center;">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="<?= base_url() ?>" style="margin-top:-15px; margin-right: -10px;">
          <img src="<?= base_url() ?>public/images/logo_white.png" alt="logo" class="img-responsive" width="53px">
        </a>

        <span style="color: green; font-size: 10px; margin-top:15px">A step towards healthy lifestyle!!</span>
      </div>


      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a>Total Earned Today: <b>&#8377;<span id="totalEarnedToday"></span></b></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user"></i> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="dropdown-menu-header text-center"><strong>Account</strong></li>
              <li class="divider"></li>
              <li><a href="<?= site_url('logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div><!-- /.container-fluid -->
  </nav>

  <div class="container-fluid hidden-print">
    <div class="row content">
      <!-- Left sidebar -->
      <div class="col-sm-2 sidenav hidden-xs mySideNav">
        <br>
        <ul class="nav nav-pills nav-stacked pointer">
          <?php if ($this->session->admin_role === "Super" || $this->session->admin_role === "Basic") : ?>
            <li class="<?= $pageTitle == 'Dashboard' ? 'active' : '' ?>">
              <a href="<?= site_url('dashboard') ?>">
                <i class="fa fa-home"></i>
                Dashboard
              </a>
            </li>
          <?php endif; ?>
          <li class="<?= $pageTitle == 'Transactions' ? 'active' : '' ?>">
            <a href="<?= site_url('transactions') ?>">
              <i class="fa fa-exchange"></i>
              Invoices
            </a>
          </li>

          <!-- Inventory Management Dropdown -->
          <li>
            <a href="#inventoryDropdown" data-toggle="collapse" class="collapsed">
              <i class="fa fa-shopping-cart"></i> Inventory Management <span class="caret"></span>
            </a>
            <ul class="nav nav-pills nav-stacked collapse" id="inventoryDropdown">
              <li class="<?= $pageTitle == 'Manufacturers' ? 'active' : '' ?>">
                <a href="<?= site_url('manufacturer') ?>">
                  <i class="fa fa-industry"></i> Manufacturer
                </a>
              </li>
              <li class="<?= $pageTitle == 'Category' ? 'active' : '' ?>">
                <a href="<?= site_url('category') ?>">
                  <i class="fa fa-list"></i> Category
                </a>
              </li>
              <li class="<?= $pageTitle == 'Items' ? 'active' : '' ?>">
                <a href="<?= site_url('items') ?>">
                  <i class="fa fa-shopping-cart"></i> Items
                </a>
              </li>
            </ul>
          </li>

          <?php if ($this->session->admin_role === "Super") : ?>
            <li class="<?= $pageTitle == 'Database' ? 'active' : '' ?>">
              <a href="<?= site_url('dbmanagement') ?>">
                <i class="fa fa-database"></i>
                Database Management
              </a>
            </li>

            <li class="<?= $pageTitle == 'Administrators' ? 'active' : '' ?>">
              <a href="<?= site_url('administrators') ?>">
                <i class="fa fa-user"></i>
                Admin Management
              </a>
            </li>
          <?php endif; ?>
        </ul>
        <br>
      </div>
      <!-- Left sidebar ends -->
      <br>

      <!-- Main content -->
      <div class="col-sm-10">
        <?= isset($pageContent) ? $pageContent : "" ?>
      </div>
      <!-- Main content ends -->
    </div>
  </div>

  <footer class="container-fluid text-center hidden-print">
    <p>
      <i class="fa fa-copyright"></i>
      Copyright <a href="">Kalpvruksh Enterprises</a> (2020 - <?= date('Y') ?>)
    </p>
  </footer>

  <!--Modal to show flash message-->
  <div id="flashMsgModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" id="flashMsgHeader">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><i id="flashMsgIcon"></i>
            <font id="flashMsg"></font>
          </center>
        </div>
      </div>
    </div>
  </div>
  <!--Modal end-->

  <!--modal to display transaction receipt when a transaction's ref is clicked on the transaction list table -->
  <div class="modal fade" role='dialog' data-backdrop='static' id="transReceiptModal">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header hidden-print">
          <button class="close" data-dismiss='modal'>&times;</button>
          <h4 class="text-center">Transaction Receipt</h4>
        </div>
        <div class="modal-body" id='transReceipt'></div>
      </div>
    </div>
  </div>
  <!-- End of modal-->

  <!-- Item label modal -->
  <div id="itemLabelModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body" id="itemLabel">
                <!-- label content loads here -->
            </div>
        </div>
    </div>
</div>
<!-- End of item label modal-->


  <!--Login Modal-->
  <div class="modal fade" role='dialog' data-backdrop='static' id='logInModal'>
    <div class="modal-dialog">
      <!-- Log in div below-->
      <div class="modal-content">
        <div class="modal-header">
          <button class="close closeLogInModal">&times;</button>
          <h4 class="text-center">Log In</h4>
          <div id="logInModalFMsg" class="text-center errMsg"></div>
        </div>
        <div class="modal-body">
          <form name="logInModalForm">
            <div class="row">
              <div class="col-sm-12 form-group">
                <label for='logInModalEmail' class="control-label">E-mail</label>
                <input type="email" id='logInModalEmail' class="form-control checkField" placeholder="E-mail" autofocus>
                <span class="help-block errMsg" id="logInModalEmailErr"></span>
              </div>
              <div class="col-sm-12 form-group">
                <label for='logInPassword' class="control-label">Password</label>
                <input type="password" id='logInModalPassword' class="form-control checkField" placeholder="Password">
                <span class="help-block errMsg" id="logInModalPasswordErr"></span>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4"></div>
              <div class="col-sm-2 pull-right">
                <button id='loginModalSubmit' class="btn btn-primary">Log in</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- End of log in div-->
    </div>
  </div>
  <!---end of Login Modal-->
</body>

</html>