<?php
session_start();
include "config.php";

if($_SESSION['role']!="staff"){
    header("Location: departments.php");
    exit();
}

$dept = strtoupper(trim($_POST['department']));
$type = strtolower(trim($_POST['project_type']));
$batch = $_POST['batch'];
$project_name = $_POST['project_name'];
$guide = $_POST['guide_name'];

$file = $_FILES['project_file']['name'];
$tmp = $_FILES['project_file']['tmp_name'];

$file = preg_replace("/[^a-zA-Z0-9.]/", "_", $file);
$new_file = time()."_".$file;

move_uploaded_file($tmp, "uploads/".$new_file);

$query = "INSERT INTO projects(department,project_type,batch,project_name,guide_name,file)
VALUES('$dept','$type','$batch','$project_name','$guide','$new_file')";

mysqli_query($conn,$query);

header("Location: project-type.php?dept=".$dept);
exit();
?>