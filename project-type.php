<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

// ✅ Get department safely
$dept = $_GET['dept'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
<title>Project Type</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="main-container">

<!-- LEFT PANEL -->
<div class="left-panel">
<img src="image/logo.jpeg" class="logo">
<h1>SPARK</h1>
</div>

<!-- RIGHT PANEL -->
<div class="right-panel">

<!-- ✅ BACK BUTTON (GOES TO DEPARTMENTS) -->
<a href="departments.php" class="back-btn">
← Back
</a>

<a href="logout.php" class="logout-btn">Logout</a>

<div class="card">

<h2>Select Project Type</h2>

<div class="project-list">

<!-- ✅ PASS dept correctly -->
<a href="project-list.php?dept=<?php echo $dept; ?>&type=mini" class="btn">
Mini Project
</a>

<a href="project-list.php?dept=<?php echo $dept; ?>&type=srp" class="btn">
SRP Project
</a>

</div>

<!-- ✅ STAFF ONLY UPLOAD -->
<?php if(isset($_SESSION['role']) && $_SESSION['role'] === "staff"){ ?>
<a href="upload.php?dept=<?php echo $dept; ?>" class="upload-small-btn">
Upload
</a>
<?php } ?>

</div>

</div>
</div>

</body>
</html>