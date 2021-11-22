<?php
    require_once('process_registration.php');

    if(isset($_SESSION['email'])){
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- icon-->
    <link rel="icon" href="./img/favicon.png" sizes="16x16">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PharmaClique - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Alert Here -->
        <?php
        if(isset($_SESSION['registerError'])){ ?>
        <br>
        <div class="alert alert-danger alert-dismissible">
            <?php
            echo $_SESSION['registerError'];
            unset($_SESSION['registerError']);
            ?>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
        <?php } ?>
        <!-- End Alert Here -->
        <div class="card o-hidden border-0 shadow-lg my-5">

            <div class="card-body p-0">

                <!-- Nested Row within Card Body -->
                <div class="row">

                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>

                            <form class="user" method="post" action="process_registration.php">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <select name="role" class="form-control" required>
                                            <option value="" disabled selected>Registration for:</option>
                                            <option value="1">Customer</option>
                                            <option value="2">Rider</option>
                                            <option value="3">Pharmacist</option>
                                            <option value="4">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control" id="exampleFirstName"
                                            placeholder="First Name" name="fname" value="<?php if(isset($_GET['fname'])){echo $_GET['fname'];} ?>" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="exampleLastName"
                                            placeholder="Last Name" name="lname" value="<?php if(isset($_GET['lname'])){echo $_GET['lname'];} ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="exampleInputEmail"
                                           value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" placeholder="Email Address" name="email" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control"
                                           value="<?php if(isset($_GET['phone_number'])){echo $_GET['phone_number'];} ?>" placeholder="Phone Number" name="phone_number"  id="phone_number" required>
                                </div>                                
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" onkeyup='check();' required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control"  placeholder="Repeat Password" name="confirm_password" id="confirm_password" onkeyup='check();' required>
                                    </div>
                                    <button disabled id="password-message" class="btn btn-block"></button>
                                </div>
                                <button type="submit" id="register_account" name="register_account" href="login.php" class="btn btn-primary btn-block">
                                    Register Account
                                </button>
                                <hr>
                            </form>
                            <div class="text-center">
                                <a class="small" href="forgot-password.php">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        let check = function() {
            if (document.getElementById('password').value == document.getElementById('confirm_password').value) {
                document.getElementById('password-message').style.color = 'green';
                document.getElementById('password-message').innerHTML = 'Passwords matched';
                document.getElementById("register_account").disabled = false;
            } else {
                document.getElementById('password-message').style.color = 'red';
                document.getElementById('password-message').innerHTML = 'Passwords do not match!';
                document.getElementById("register_account").disabled = true;
            }
        }
    </script>
</body>

</html>