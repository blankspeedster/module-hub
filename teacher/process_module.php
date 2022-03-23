<?php
    include("../dbh.php");
    $date = date_default_timezone_set('Asia/Manila');
    $date = date('Y-m-d H:i:s');

    // Insert Module
    if(isset($_POST['insert_module'])){
        echo $section_id= $_POST['section'];
        echo $module_name = ucfirst($_POST['module_name']);
        echo $teacher_id = ucfirst($_POST['teacher_id']);

        $count = 0;
        $modules = mysqli_query($mysqli, "SELECT * FROM module m WHERE m.section_id = '$section_id' ");
        if (mysqli_num_rows($modules) == 0) {
            $count = 1;
        }
        else{
            $module = mysqli_fetch_array($modules);
            $count = $module["count_week"]+1;
        }

        $moduleUniqueHash = str_replace(' ', '', $module_name);
        $moduleUniqueHash = $moduleUniqueHash."-".$teacher_id."-".$section_id;

        $subjects = mysqli_query($mysqli, "SELECT * FROM class c WHERE c.section_id = '$section_id' ");

        while($subject = mysqli_fetch_array($subjects)){
            $student_id = $subject["user_id"];
            $subject_id = $subject["subject_id"];
            // $section_id = $subject["section_id"];

            $mysqli->query(" INSERT INTO module (module_name, user_id, subject_id, section_id, teacher_id, count_week, code_unique, updated_at) VALUES('$module_name','$student_id', '$subject_id', '$section_id', '$teacher_id', '$count', '$moduleUniqueHash','$date') ") or die ($mysqli->error);
        }


        $_SESSION['message'] = $module_name." Creation Successful!";
        $_SESSION['msg_type'] = "success";
        header("location: modules.php");
    }
?>