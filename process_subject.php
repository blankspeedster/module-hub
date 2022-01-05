<?php
    include("dbh.php");


    //Save Subject
    if(isset($_POST["save_subject"])){
        $code = $_POST["code"];
        $description = $_POST["description"];
        $grade = $_POST["grade"];

        $mysqli->query(" INSERT INTO subjects ( code, description, grade) VALUES('$code','$description','$grade') ") or die ($mysqli->error);

        $_SESSION['message'] = "Subject has been created!";
        $_SESSION['msg_type'] = "success";

        header("location: subjects.php");

    }

    //Update Subject
    if(isset($_POST["update_subject"])){
        $subjectId =  $_POST["subjectId"];
        $code = $_POST["code"];
        $description = $_POST["description"];
        $grade = $_POST["grade"];

        $mysqli->query("UPDATE subjects SET code = '$code', description = '$description', grade = '$grade' WHERE id = '$subjectId' ") or die ($mysqli->error);

        $_SESSION['message'] = "Subject has been updated!";
        $_SESSION['msg_type'] = "success";

        header("location: subjects.php");

    }

    //Delete Subject
    if(isset($_GET["delete_subject"])){
        $subjectId =  $_GET["delete_subject"];

        $mysqli->query("DELETE FROM subjects WHERE id='$subjectId'") or die($mysqli->error);

        $_SESSION['message'] = "Subject has been updated!";
        $_SESSION['msg_type'] = "danger";

        header("location: subjects.php");

        }
?>