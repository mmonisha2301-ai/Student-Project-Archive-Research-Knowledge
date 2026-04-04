<?php
session_start();

if(!isset($_SESSION['username'])){
header("Location: login.php");
exit();
}
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

<h3>
Explore department-wise student projects.
</h3>

</div>

</div>


<!-- RIGHT PANEL -->

<div class="right-panel">

<a href="logout.php" class="logout-btn">Logout</a>

<div class="card">

<h2>Select Department</h2>

<div class="project-list">

<a href="project-type.php?dept=BCA">Computer Science</a>
<a href="project-type.php?dept=ENGLISH">English</a>
<a href="project-type.php?dept=KANNADA">Kannada</a>
<a href="project-type.php?dept=COMMERCE">Commerce</a>
<a href="project-type.php?dept=ECONOMICS">Economics</a>
<a href="project-type.php?dept=RURAL DEVELOPMENT">Rural Development</a>
<a href="project-type.php?dept=HINDI">Hindi</a>
<a href="project-type.php?dept=ARTS">Arts</a>
<a href="project-type.php?dept=JOURNALISM">Journalism</a>
<a href="project-type.php?dept=PHYSICS">Physics</a>
<a href="project-type.php?dept=MATHEMATICS">Mathematics</a>
<a href="project-type.php?dept=SANSKRIT">Sanskrit</a>
<a href="project-type.php?dept=HOME SCIENCE">Home Science</a>
<a href="project-type.php?dept=BOTANY">Botany</a>
<a href="project-type.php?dept=STATISTICS">Statistics</a>
<a href="project-type.php?dept=BUSINESS ADMINISTRATION">Business Administration</a>
<a href="project-type.php?dept=POLITICAL SCIENCE">Political Science</a>
<a href="project-type.php?dept=PSYCHOLOGY">Psychology</a>

</div>

</div>

</div>

</div>

</body>

</html>