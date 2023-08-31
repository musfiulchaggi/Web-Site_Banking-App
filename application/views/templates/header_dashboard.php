<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?></title>

    <link rel="shortcut icon" href="<?= base_url('assets/img/profile/') ?>amiraicon.png" type="image/x-icon">

    <!-- mapbox -->
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />

    <!-- Load the `mapbox-gl-geocoder` plugin. -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">

    <!-- data-table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

    <!-- ckeditor -->
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <style>
        .btn-transparent {
            background-color: transparent;
            border-color: transparent;
            color: #fff; /* Set the desired text color */
        }
       
        .btn-upload {
            padding: 10px 20px;
            margin-left: 10px;
        }
        .upload-input-group {
            margin-bottom: 10px;
        }

        .input-group>.custom-select:not(:last-child), .input-group>.form-control:not(:last-child) {
        height: 45px;
        }

        /* // modal freeze */
        .modal {
            background: rgba(237, 231, 225, 0.8);
        }
        .modal-backdrop {
            display: none;
        };

        /* // carousel */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
        height: 100px;
        width: 30px;
        outline: black;
        background-size: 100%, 100%;
        border-radius: 50%;
        border: 1px solid black;
        background-image: none;
        }

        .carousel-control-next-icon
        {
        font-size: 100px;
        color: grey;
        }

        .carousel-control-prev-icon {
        font-size: 100px;
        color: grey;
        }

    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">