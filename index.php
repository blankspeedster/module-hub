<?php
require_once("process_index.php");
$user_counts = $mysqli->query("SELECT COUNT(id) AS total_count FROM users") or die($mysqli->error());
$user_count = $user_counts->fetch_array();
$user_count = $user_count['total_count'];
include("head.php");
?>

<title>Module Hub - Home</title>

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Home</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
                    </div>




                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-lg-12 mb-4">
                            <?php if($_SESSION['role']!=2){ ?>
                            <!-- Placeholder for Admin -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                                </div>
                                <div class="card-body">
                                    <p>Module Hub makes extensive use of Bootstrap 4 utility classes in order to reduce
                                        CSS bloat and poor page performance. Custom CSS classes are used to create
                                        custom components and custom utility classes.</p>
                                    <p class="mb-0">Before working with this theme, you should become familiar with the
                                        Bootstrap framework, especially the utility classes.</p>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">STATUS OF YOUR MODULES</h6>
                                </div>
                                <div class="card-body">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Subject</td>
                                            <th style="text-align: center;">Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $userId = $_SESSION['user_id'];
                                        $subjects = mysqli_query($mysqli, "SELECT *, s.code AS subject_code FROM users u
                                        JOIN class c
                                        ON c.user_id = u.id
                                        JOIN subjects s
                                        ON c.subject_id = s.id
                                        WHERE u.id = '$userId' ");                                        
                                        while ($subject = mysqli_fetch_array($subjects)) {
                                        ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo strtoupper($subject["subject_code"]); ?></td>
                                                <td style="text-align: center;">
                                                    <?php if($subject['returned'] == "0"){ ?>
                                                    <span class="badge bg-danger text-white">Pending Pickup</span>
                                                    <?php } else if($subject['returned'] == "-1"){ ?>
                                                    <span class="badge bg-warning text-white">Pending Submission</span>
                                                    <?php } else if($subject['returned'] == "1"){ ?>
                                                    <span class="badge bg-success text-white">Submitted</span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                </div>                                    
                            </div>
                            <?php } ?>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include("footer.php"); ?>

            <!-- Start scripts here -->

            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script>

            <!-- End scripts here -->
</body>

</html>