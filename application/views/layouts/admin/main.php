<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title_web; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/font_googleapis.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url(); ?>vendor/components/font-awesome/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/adminlte/css/adminlte.min.css">

    <style>
        td {
            padding: 0;
            margin: 0;
        }

        .canvasjs-chart-tooltip {
            box-shadow: none !important;
        }

        .canvasjs-chart-credit {
            display: none;
        }

        .white_block {
            position: relative;
            top: -15px;
            width: 57px;
            background-color: #fff;

        }

        .white_block2 {
            position: relative;
            top: -15px;
            width: 57px;
            background-color: #fff;

        }

        .white_block3 {
            position: relative;
            top: -15px;
            width: 57px;
            background-color: #fff;
        }

        .white_block4 {
            position: relative;
            top: -15px;
            width: 57px;
            background-color: #fff;
        }

        .white_block5 {
            position: relative;
            top: -15px;
            width: 57px;
            background-color: #fff;
        }

        .white_block6 {
            position: relative;
            top: -15px;
            width: 57px;
            background-color: #fff;
        }

        .white_block7 {
            position: relative;
            top: -15px;
            width: 57px;
            background-color: #fff;
        }

        .white_block8 {
            position: relative;
            top: -15px;
            width: 57px;
            background-color: #fff;
        }
    </style>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-collapse">
    <div class="wrapper">
        <!-- Navbar -->
        <?php $this->load->view('layouts/admin/navbar'); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php $this->load->view('layouts/admin/sidebar'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php //$this->load->view('layouts/admin/breadcrumb'); 
            ?>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <?php $this->load->view('pages/admin/' . $content_web); ?>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <!-- <aside class="control-sidebar control-sidebar-dark">
            Control sidebar content goes here
        </aside> -->
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2021 <a href="javascript:;">PT. Central Motor Wheel Jakarta</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <input type="hidden" id="base_url" value="<?= base_url(); ?>">
    <input type="hidden" id="site_url" value="<?= site_url(); ?>">

    <!-- jQuery -->
    <script src="<?= base_url(); ?>vendor/components/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url(); ?>vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="<?= base_url(); ?>assets/vendor/adminlte/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="<?= base_url(); ?>assets/js/canvasjs.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/jquery.blockUI.js"></script>
    <script src="<?= base_url(); ?>assets/js/sweetalert2@10.js"></script>
    <script src="<?= base_url(); ?>assets/js/html2pdf.bundle.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/canvas2image.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/jspdf.debug.js"></script>
    <script src="<?= base_url(); ?>assets/js/jspdf.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/html2pdf.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <!-- <script src="<?= base_url(); ?>assets/vendor/adminlte/js/demo.js"></script> -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <?php $this->load->view('pages/admin/' . $vitamin_web); ?>
</body>

</html>