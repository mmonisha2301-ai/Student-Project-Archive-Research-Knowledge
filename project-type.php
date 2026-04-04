<?php
session_start();

if(!isset($_SESSION['username'])){
header("Location: login.php");
exit();
}

$dept = isset($_GET['dept']) ? $_GET['dept'] : '';
?>

<!DOCTYPE html>
<html>
<head>
<title>Project Type</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="main-container">

<div class="left-panel">
<img src="image/logo.jpeg" class="logo">
<h1>SPARK</h1>
</div>

<div class="right-panel">

<a href="departments.php" class="back-btn">← Back</a>
<a href="logout.php" class="logout-btn">Logout</a>

<div class="card">
<div class="project-list">

<a href="project-list.php?dept=<?php echo $dept; ?>&type=mini" class="btn">
Mini Project
</a>

<a href="project-list.php?dept=<?php echo $dept; ?>&type=srp" class="btn">
SRP Project
</a>

</div>
<?php  if(isset($_SESSION['role']) && $_SESSION['role'] === "staff"){ ?>

<a href="upload.php?dept=<?php echo $dept; ?>" class="upload-small-btn">Upload</a>
<?php } ?>

</div>

</div>
</div>

</body>
</html>