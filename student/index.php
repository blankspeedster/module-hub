<?php
require_once("process_index.php");

$session_user_id = $_SESSION['user_id'];
$modules = mysqli_query($mysqli, "SELECT * FROM module m
WHERE m.user_id = '$session_user_id'
GROUP BY m.code_unique ");

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

                    <!-- Notification here -->
                    <?php
                    if (isset($_SESSION['message'])) { ?>
                        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            ?>
                        </div>
                    <?php } ?>
                    <!-- End Notification -->
                    
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Home - Modules</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
                    </div>

                    <!-- Content Row -->
                    <?php while ($module = mysqli_fetch_array($modules)) {
                        $unique_code = $module['code_unique'];
                        $subjects =  mysqli_query($mysqli, "SELECT *, s.id AS subject_id FROM module m
                        JOIN subjects s ON s.id = m.subject_id
                        WHERE m.user_id = '$session_user_id' AND m.code_unique = '$unique_code' ");

                    ?>
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $module["module_name"]; ?></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-xl-12 col-md-12 mb-4 card shadow p-2">
                                            Module Name: <?php echo $module["module_name"]; ?><br>
                                            Week #: <?php echo $module["count_week"]; ?><br>
                                            <?php
                                            $ave_returned = 0;
                                            $subject_count = 0;
                                            $subject_returned = 0;
                                            while ($subject = mysqli_fetch_array($subjects)) {
                                                $subject_count++;
                                            ?>
                                                <div class="card border-left-info shadow h-100 py-2 mt-2 mb-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?php echo $subject["code"]; ?>
                                                                </div>
                                                                <div class="row no-gutters align-items-center">
                                                                    <div class="col-auto">
                                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                                            <?php
                                                                            if ($subject["returned"] == '0') {
                                                                                echo "NO";
                                                                            } else {
                                                                                $subject_returned++;
                                                                                echo "YES";
                                                                            }
                                                                            ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto m-2">
                                                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                                            </div>
                                                            <!-- Start Drop down Delete here -->
                                                            <button class=",-2 btn btn-info dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="far fa-trash-alt"></i> Return
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
                                                                You sure you want to return? You cannot undo the changes<br />
                                                                <a href="#" class='btn btn-warning btn-sm'><i class="far fa-window-close"></i> Cancel</a>
                                                                <a href="process_module.php?return_subject=<?php echo $subject["subject_id"]; ?>&module_code=<?php echo $unique_code; ?>&student_id=<?php echo $session_user_id; ?>" class='btn btn-success btn-sm'><i class="far fa-trash-alt"></i> Confirm Return</a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            <?php }
                                            if ($subject_returned == 0) {
                                                $ave_returned = 0;
                                            } else {
                                                $ave_returned = ($subject_returned / $subject_count) * 100;
                                            }
                                            ?>
                                            <div class="row no-gutters align-items-center m-2 mb-2">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Progress for this module:
                                                    </div>
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto">
                                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo number_format($ave_returned, 2); ?>%</div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="progress progress-sm mr-2">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $ave_returned; ?>%" aria-valuenow="<?php echo $ave_returned; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Content Row -->
                    <div class="row" style="display: none;">
                        <!-- Earnings (Monthly) Card Example -->


                        <div class="col-lg-12 mb-4">
                            <?php if ($_SESSION['role'] != 2) { ?>
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
                                                            <?php if ($subject['returned'] == "0") { ?>
                                                                <span class="badge bg-danger text-white">Pending Pickup</span>
                                                            <?php } else if ($subject['returned'] == "-1") { ?>
                                                                <span class="badge bg-warning text-white">Pending Submission</span>
                                                            <?php } else if ($subject['returned'] == "1") { ?>
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
            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="../js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="../vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="../js/demo/chart-area-demo.js"></script>
            <script src="../js/demo/chart-pie-demo.js"></script>

            <!-- End scripts here -->
</body>

</html>