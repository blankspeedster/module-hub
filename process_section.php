<?php
    include("dbh.php");

    if(isset($_POST['save_section'])){
        $section= $_POST['section'];
        $grade = ucfirst($_POST['grade']);

        $mysqli->query(" INSERT INTO section (grade, section) VALUES('$grade','$section') ") or die ($mysqli->error());

        $_SESSION['message'] = "Section: ".$section." Creation Successful!";
        $_SESSION['msg_type'] = "success";
        header("location: section.php");
    }
?>