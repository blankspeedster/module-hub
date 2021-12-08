<?php
require_once("process_section.php");
include("head.php");

//Get current URI
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$session_user_id = $_SESSION['user_id'];
$sections = mysqli_query($mysqli, "SELECT *
    FROM section");
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
                            <h6 class="m-0 font-weight-bold text-primary">Add / Edit Section</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="process_section.php">
                                <div class="row">

                                    <!-- Grade Level -->
                                    <div class="col-xl-6 col-md-6 mb-4">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Grade Level</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <input type="number" min="1" max="12" class="form-control" name="grade" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section Name -->
                                    <div class="col-xl-6 col-md-6 mb-4">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Section Name</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <input type="text" class="form-control" name="section" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Form -->
                                    <div class="col-xl-12 col-md-6 mb-4">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <button type="submit" class="btn btn-primary float-right mr-1" name="save_section" id="save">
                                                    <i class="far fa-save"></i> Create Section
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
                            <h6 class="m-0 font-weight-bold text-primary">List of Grade and Sections</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Grade Level</th>
                                            <th width="40%">Section</th>
                                            <th>Actions</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($section = mysqli_fetch_array($sections)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $section["grade"]; ?></td>
                                                <td><a href="class.php?section=<?php echo $section["id"]; ?>"><?php echo $section["section"]; ?></a></td>
                                                <td>
                                                    <!-- Edit-->
                                                    <a href="section.php?edit=<?php echo $section['id']; ?>" class="btn btn-info btn-sm"><i class="far fa-edit"></i> Edit</a>
                                                    <!-- Start Drop down Delete here -->
                                                    <button class="btn btn-danger btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="far fa-trash-alt"></i> Delete
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
                                                        You sure you want to delete? You cannot undo the changes<br />
                                                        <a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a>
                                                        <a href="process_section.php?delete=<?php echo $section['id'] ?>" class='btn btn-danger btn-sm'><i class="far fa-trash-alt"></i> Confirm Delete</a>
                                                    </div>
                                                </td>
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