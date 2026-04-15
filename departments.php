<?php
session_start();
include "config.php";

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$isStudent = ($_SESSION['role'] === "student");
?>

<!DOCTYPE html>
<html>
<head>
<title>Departments</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="main-container">

<!-- LEFT PANEL -->
<div class="left-panel">
<img src="image/logo.jpeg" class="logo">
<div class="left-content">
<h1>SPARK</h1>
<h3>Explore student projects</h3>
</div>
</div>

<!-- RIGHT PANEL -->
<div class="right-panel">

<!-- 🔥 TOP BUTTONS -->
<div style="display:flex; justify-content:space-between; align-items:center;">

<!-- ✅ BACK BUTTON ONLY AFTER CLICK -->
<?php if(isset($_GET['all'])){ ?>
<a href="departments.php" class="back-btn">← Back</a>
<?php } else { ?>
<div></div> <!-- empty space -->
<?php } ?>

<!-- LOGOUT -->
<a href="logout.php" class="logout-btn">Logout</a>

<?php if($isStudent && !isset($_GET['all'])){ ?>
<div style="margin:15px 0;">
    <a href="departments.php?all=1" class="btn">
        📂 All Files
    </a>
    <div style=" margin:575px 0;">

</div>
<?php } ?>

</div>

<?php
// ================== ALL FILES PAGE ==================
if(isset($_GET['all']) && $isStudent){

    echo "<div style='width:95%; margin:auto; padding:20px; background:white;'>";

    echo "<h2 style='text-align:center;'>All Projects</h2>";

    $query = "SELECT * FROM projects";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){

        echo "<table border='1' cellpadding='10' style='width:100%; text-align:center; border-collapse:collapse;'>";

        echo "<tr>
        <th>Title</th>
        <th>Guide</th>
        <th>Department</th>
        <th>Type</th>
        <th>Batch</th>
        <th>Download</th>
        </tr>";

        while($row = mysqli_fetch_assoc($result)){

            echo "<tr>
            <td>".$row['project_name']."</td>
            <td>".$row['guide_name']."</td>
            <td>".$row['department']."</td>
            <td>".strtoupper($row['project_type'])."</td>
            <td>".$row['batch']."</td>
            <td>
                <a href='uploads/".$row['file']."' download class='view-btn'>
                Download
                </a>
            </td>
            </tr>";
        }

        echo "</table>";

    } else {
        echo "<p style='text-align:center;'>No projects available</p>";
    }

    echo "</div>";

}else{
?>

<!-- 🔥 DEPARTMENT CARD -->
<div class="center-container">
    <div class="card">
<h2>Select Department</h2>

<div class="project-list">

<?php

// STAFF → ONLY THEIR DEPARTMENT
if($_SESSION['role'] === "staff"){

    $dept = $_SESSION['department'];

    if(!empty($dept)){
        echo "<a href='project-type.php?dept=$dept' class='btn'>$dept</a>";
    } else {
        echo "<p>No department assigned</p>";
    }

}else{

    // STUDENT → DYNAMIC DEPARTMENTS
    $query = "SELECT DISTINCT department FROM projects";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_assoc($result)){
            $dept = $row['department'];

            echo "<a href='project-type.php?dept=$dept' class='btn'>
                    $dept
                  </a>";
        }

    } else {
        echo "<p>No departments available</p>";
    }
}
?>

</div>

</div>
    </div>
</div>

<?php } ?>

</div>
</div>

</body>
</html>