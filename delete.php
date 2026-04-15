<?php
session_start();
include "config.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] !== "staff"){
    header("Location: departments.php");
    exit();
}

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT file FROM projects WHERE id=$id");
$row = mysqli_fetch_assoc($result);

unlink("uploads/".$row['file']);

mysqli_query($conn, "DELETE FROM projects WHERE id=$id");

header("Location: project-list.php");
exit();
?>