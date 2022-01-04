<?php
    require_once("process_users.php");
    include("head.php");

    //Get current URI
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $_SESSION['getURI'] = $getURI;

?>

<title>Module Hub - Generate QR Code</title>
<head>
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>
    <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("topbar.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Generate QR Code - <?php echo ucfirst($_GET["firstname"])." ".ucfirst($_GET["lastname"]); ?></h1>
                    <p class="mb-4"></p>
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <div id="qrcode"></div>
                            <br>
                            Please save this image. This QR code belongs to <?php echo ucfirst($_GET["firstname"])." ".ucfirst($_GET["lastname"]); ?>. (Download or copy paste the QR code above in Microsoft Word)
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<?php include("footer.php"); ?>

    <!-- Start scripts here -->
        <script>

        </script>

        <!-- Generate QR Code -->
        <script src="js/qrcode.min.js"></script>
        <script type="text/javascript">
            let qrValue = "{\"user\": "+<?php echo $_GET["student"]; ?>+"}"
            new QRCode(document.getElementById("qrcode"), qrValue);
        </script>




        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/datatables-demo.js"></script>

    <!-- End scripts here -->
</body>

</html>
