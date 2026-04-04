<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();
include "config.php";

// ✅ Secure session check
if(!isset($_SESSION['role']) || $_SESSION['role']!="staff"){
    header("Location: departments.php");
    exit();
}

// ✅ Get department safely
$dept = isset($_GET['dept']) ? htmlspecialchars($_GET['dept']) : '';
?>

<!DOCTYPE html>
<html>

<head>
<title>Upload Project</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="main-container">

<!-- LEFT PANEL -->
<div class="left-panel">

<img src="image/logo.jpeg" class="logo">

<div class="left-content">
<h1>SPARK</h1>
<h3>Upload new student project.</h3>
</div>

</div>

<!-- RIGHT PANEL -->
<div class="right-panel">

<a href="project-type.php?dept=<?php echo $dept; ?>" class="back-btn">← Back</a>

<a href="logout.php" class="logout-btn">Logout</a>

<div class="card">

<h2>Upload Project</h2>

<form action="upload_process.php" method="POST" enctype="multipart/form-data">

<!-- Hidden department -->
<input type="hidden" name="department" value="<?php echo $dept; ?>">

<!-- Project Name -->
<input type="text" name="project_name" placeholder="Project Name" required>

<!-- Guide Name -->
<input type="text" name="guide_name" placeholder="Guide Name" required>

<!-- Project Type -->
<select name="project_type" required>
<option value="">Select Project Type</option>
<option value="mini">Mini Project</option>
<option value="srp">SRP Project</option>
</select>

<!-- ✅ Batch Dropdown (Dynamic Years) -->
<select name="batch" required>
<option value="">Select Batch</option>

<?php
$current_year = date("Y");

// Last 3 years to next 7 years
for($i = $current_year - 3; $i <= $current_year + 7; $i++){
    $next = $i + 1;
    echo "<option value='$i-$next'>$i - $next</option>";
}
?>

</select>

<!-- File Upload -->
<input type="file" name="project_file" required>

<!-- Submit -->
<button type="submit" name="upload">Upload</button>

</form>

</div>

</div>

</div>

</body>
</html>