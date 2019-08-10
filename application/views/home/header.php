<?php
    $items = getCompany();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $items['subtitle'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font/font.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font/iconsmind/style.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/fullcalendar.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/bootstrap-float-label.min.css" />
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/dataTables.bootstrap4.min.css" /> -->
    <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/datatables.responsive.bootstrap4.min.css" /> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/select2.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/bootstrap-stars.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/nouislider.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" />

    <!-- begin swal -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/swal/sweetalert.css"/>

    <!-- jqgrid -->
    <link href="<?php echo base_url(); ?>assets/jqgrid/css/ui.jqgrid-bootstrap.css" rel="stylesheet" type="text/css"/>
    <!-- <link href="<?php echo base_url(); ?>assets/jqgrid/css/ui.jqgrid.css" rel="stylesheet" type="text/css"/> -->
    <link href="<?php echo base_url(); ?>assets/jqgrid/css/jqgrid.custom.css" rel="stylesheet" type="text/css"/>


    <style type="text/css">
        .select2-container .select2-selection--single {
            height: 41px !important;
            padding-left: 12px;
            padding-top: 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 9px !important;
            right: 3px !important;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner" onkeydown="myFunction(event)">
    <nav class="navbar fixed-top">
        <div class="d-flex align-items-center navbar-left">
            <a href="#" class="menu-button d-none d-md-block">
                <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                    <rect x="0.48" y="0.5" width="7" height="1" />
                    <rect x="0.48" y="7.5" width="7" height="1" />
                    <rect x="0.48" y="15.5" width="7" height="1" />
                </svg>
                <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                    <rect x="1.56" y="0.5" width="16" height="1" />
                    <rect x="1.56" y="7.5" width="16" height="1" />
                    <rect x="1.56" y="15.5" width="16" height="1" />
                </svg>
            </a>

            <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                    <rect x="0.5" y="0.5" width="25" height="1" />
                    <rect x="0.5" y="7.5" width="25" height="1" />
                    <rect x="0.5" y="15.5" width="25" height="1" />
                </svg>
            </a>

            <div class="search" data-search-path="Layouts.Search.html?q=">
                <input placeholder="Pencarian...">
                <span class="search-icon">
                    <i class="simple-icon-magnifier"></i>
                </span>
            </div>
        </div>


        <a class="navbar-logo" href="javascript:;">
            <!-- <span class="logo d-none d-xs-block"></span> -->
            <!-- <span class="logo-mobile d-block d-xs-none"></span> -->
            <div class="d-none d-lg-block">
            <img src="<?php echo base_url().$items['logo'];?>" alt="logo" width="40" height="40">
            <span style="font-weight: bold; font-size: 18px; margin-left: 5px; margin-top: 20px;"><?php echo $items['name'];?></span> 
            </div>

            <img class="d-none d-block d-lg-none" src="<?php echo base_url().$items['logo'];?>" alt="logo" width="40" height="40">
            

        </a>

        <div class="navbar-right">
            <div class="header-icons d-inline-block align-middle">

                <button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
                    <i class="simple-icon-size-fullscreen"></i>
                    <i class="simple-icon-size-actual"></i>
                </button>

            </div>

            <div class="user d-inline-block">
                <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="name"><?php echo $this->session->userdata('user_full_name'); ?></span>
                    <span>
                        <img alt="Profile Picture" src="<?php echo base_url(); ?>assets/img/profile-pic-l.jpg" />
                    </span>
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-3">
                    <a class="dropdown-item" href="<?php echo base_url().'auth/logout'; ?>">Sign out</a>
                </div>
            </div>
        </div>
    </nav>