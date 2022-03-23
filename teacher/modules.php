<?php
require_once("process_section.php");
include("head.php");

//Get current URI
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$session_user_id = $_SESSION['user_id'];
$sections =  mysqli_query($mysqli, "SELECT *, s.id AS section_id FROM section s JOIN users u ON u.id = s.teacher_id WHERE u.id = '$session_user_id' ");

?>

<title>Module Hub - Classes</title>

<head>
    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                    <h1 class="h3 mb-2 text-gray-800">Your Module</h1>
                    <p class="mb-4"></p>
                    
                    <div class="card shadow mb-4" >
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add Module</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="process_module.php">
                                <div class="row">

                                    <!-- Section Name -->
                                    <div class="col-xl-6 col-md-6 mb-4">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Module Name</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <input type="text" class="form-control" name="module_name" value=" " required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Select Teacher -->
                                    <div class="col-xl-6 col-md-6 mb-4">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Grade and Section to be added</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <select class="form-control" name="section">
                                                        <?php while($section = mysqli_fetch_assoc($sections)){
                                                            $section_id = $section["section_id"];?>
                                                        <option value="<?php echo $section_id; ?>"><?php echo $section["grade"]." - ".$section["section"]; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Form -->
                                    <div class="col-xl-12 col-md-6 mb-4">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <input type="text" value="<?php echo $session_user_id; ?>" style="visibility: hidden;" name="teacher_id"> 
                                                <button type="submit" class="btn btn-primary float-right mr-1" name="insert_module" id="save">
                                                    <i class="far fa-save"></i> Insert Module
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Users Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of modules (week count) and section</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Module Name</th>
                                            <th>Week Count</th>
                                            <th>Grade</th>
                                            <th>Section</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $modules =  mysqli_query($mysqli, "SELECT * FROM module m
                                        JOIN users u ON u.id = m.user_id
                                        JOIN section s ON s.id = m.section_id
                                        JOIN subjects sbj ON sbj.id = m.subject_id
                                        WHERE m.teacher_id = '$session_user_id'
                                        GROUP BY m.code_unique");
                                        while ($module = mysqli_fetch_array($modules)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $module["module_name"]; ?></td>
                                                <td><?php echo $module["count_week"]; ?></td>
                                                <td><?php echo $module["grade"]; ?></td>
                                                <td><?php echo $module["section"]; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
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
            <script src="../endor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="../js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="../js/demo/datatables-demo.js"></script>

            <!-- End scripts here -->
</body>

</html>