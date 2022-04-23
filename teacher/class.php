<?php
require_once("process_section.php");
include("head.php");

//Get current URI
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$session_user_id = $_SESSION['user_id'];
$section_id = 0;
if (isset($_GET['section'])) {
    $class = $_GET['section'];
    $section_id = $_GET['section'];
} else {
    header("location: section.php");
}
$classes = mysqli_query($mysqli, "SELECT s.code, u.firstname, u.lastname FROM class c
JOIN subjects s
ON c.subject_id = s.id
JOIN users u
ON u.id = c.user_id
WHERE section_id = '$section_id' ");
?>

<title>Module Hub - Section</title>

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
                    <h1 class="h3 mb-2 text-gray-800">Section</h1>
                    <p class="mb-4"></p>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Associate Student to the section</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="process_section.php">
                                <div class="row">

                                    <!-- Grade Level -->
                                    <div class="col-xl-12 col-md-6 mb-4">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Students</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <select type="number" min="1" max="12" class="form-control" name="user_id" required>
                                                    <option value="" disabled selected>Select Student From the Dropdown</option>
                                                    <?php $students = mysqli_query($mysqli, "SELECT *, u.id AS user_id
                                                        FROM users u
                                                        LEFT JOIN class c ON c.user_id = u.id
                                                        WHERE c.user_id IS NULL AND u.role = '2' ");
                                                        while($student = mysqli_fetch_array($students)){?>
                                                        <option value="<?php echo $student['user_id']; ?>"><?php echo $student['lastname'].' '.$student['firstname']; ?></option>
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
                                                <input name="section_id" value="<?php echo $class; ?>" style="visibility: hidden;"> 
                                                <button type="submit" class="btn btn-primary float-right mr-1" name="associate_user" id="save">
                                                    <i class="far fa-save"></i> Associate User
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="card shadow mb-4" style="display: none;">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of Grade and Sections</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td>Student Name</td>
                                            <td>Subject</td>
                                            <td>Returned</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $returned = false;
                                        while ($class = mysqli_fetch_array($classes)) {
                                            // $returned = boolval($class["returned"]);
                                        ?>
                                            <tr>
                                                <td><?php echo $class['firstname'] . ' ' . $class['lastname']; ?></td>
                                                <td><?php echo ucfirst($class['code']); ?></td>
                                                <td><?php if($returned){ ?>
                                                    <span class="badge bg-success text-white">Returned</span>
                                                <?php }else{ ?>
                                                    <span class="badge bg-warning text-white">Pending</span>
                                                <?php } ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Section Tables -->
                    <?php
                        $subjects = mysqli_query($mysqli, " SELECT * FROM subjects");
                        while($subject = mysqli_fetch_array($subjects)){
                    ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?php echo strtoupper($subject["code"]); ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td>Student Name</td>
                                            <td>Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $subjectId = $subject['id'];
                                        $classes = mysqli_query($mysqli, "SELECT * FROM users u
                                        JOIN class c
                                        ON c.user_id = u.id
                                        WHERE section_id = '$section_id' AND subject_id = '$subjectId'
                                        GROUP BY u.id ");                                        
                                        while ($class = mysqli_fetch_array($classes)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $class['firstname'] . ' ' . $class['lastname']; ?></td>
                                                <td>Status Percent Here %%%%% </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

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
            <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="../js/demo/datatables-demo.js"></script>

            <!-- End scripts here -->
</body>

</html>