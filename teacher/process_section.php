<?php
    include("../dbh.php");

    if(isset($_POST['save_section'])){
        $section= $_POST['section'];
        $grade = ucfirst($_POST['grade']);
        $teacher = ucfirst($_POST['teacher']);

        $mysqli->query(" INSERT INTO section (grade, section, teacher_id) VALUES('$grade','$section', '$teacher') ") or die ($mysqli->error);

        $_SESSION['message'] = "Section: ".$section." Creation Successful!";
        $_SESSION['msg_type'] = "success";
        header("location: section.php");
    }

    if(isset($_POST['update_section'])){
        $section= $_POST['section'];
        $grade = ucfirst($_POST['grade']);
        $teacher = ucfirst($_POST['teacher']);
        $section_id = $_POST['section_id'];

        $mysqli->query(" UPDATE section SET grade = '$grade', section = '$section', teacher_id = '$teacher' WHERE id = '$section_id' ") or die ($mysqli->error);

        $_SESSION['message'] = "Section: ".$section." update Successful!";
        $_SESSION['msg_type'] = "success";
        header("location: section.php");
    }

    if(isset($_POST['associate_user'])){
        $section_id= $_POST['section_id'];
        $user_id = ucfirst($_POST['user_id']);
        
        //Get the grade of the section
        $grades = mysqli_query($mysqli, "SELECT * FROM section WHERE id = '$section_id' ");
        $newGrades = $grades->fetch_array();
        $grade = $newGrades['grade'];

        //Get the subjects based on grade
        $subjects = mysqli_query($mysqli, "SELECT * FROM subjects WHERE grade = '$grade' ");

        while($subject = mysqli_fetch_array($subjects)){
            $subject_id = $subject['id'];
            $mysqli->query(" INSERT INTO class (user_id, subject_id, section_id) VALUES('$user_id','$subject_id','$section_id') ") or die ($mysqli->error);
        }

        $_SESSION['message'] = "Student association successful!";
        $_SESSION['msg_type'] = "success";
        header("location: class.php?section=".$section_id);
    }
?>