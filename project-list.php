<?php
session_start();

// ✅ Store values
if(isset($_GET['dept'])) $_SESSION['dept'] = $_GET['dept'];
if(isset($_GET['type'])) $_SESSION['type'] = $_GET['type'];
if(isset($_GET['batch'])) $_SESSION['batch'] = $_GET['batch'];

// ✅ Retrieve values
$dept = $_GET['dept'] ?? ($_SESSION['dept'] ?? '');
$type = $_GET['type'] ?? ($_SESSION['type'] ?? '');
$batch = $_GET['batch'] ?? ($_SESSION['batch'] ?? '');
include "config.php";

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

// ✅ Store values in session
if(isset($_GET['dept'])){
    $_SESSION['dept'] = $_GET['dept'];
}
if(isset($_GET['type'])){
    $_SESSION['type'] = $_GET['type'];
}

// ✅ Use session backup
$dept = $_GET['dept'] ?? ($_SESSION['dept'] ?? '');
$type = $_GET['type'] ?? ($_SESSION['type'] ?? '');
$batch = $_GET['batch'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
<title>Project List</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="main-container">

<div class="left-panel">
<h1>SPARK</h1>
</div>

<div class="right-panel">

<?php
// ✅ If viewing projects (inside batch)
if($batch){
?>
<a href="project-list.php?dept=<?php echo $dept; ?>&type=<?php echo $type; ?>" class="back-btn">
← Back
</a>

<?php
// ✅ If viewing batch list
} else {
?>
<a href="project-type.php?dept=<?php echo $dept; ?>" class="back-btn">
← Back
</a>
<?php } ?>

<a href="logout.php" class="logout-btn">Logout</a>

<div class="card">

<?php
// ✅ STEP 1: SHOW BATCHES
if(!$batch){

    echo "<h2>Project Batches</h2>";

    $query = "SELECT DISTINCT batch FROM projects 
    WHERE UPPER(department)=UPPER('$dept') 
    AND LOWER(project_type)=LOWER('$type')";

    $result = mysqli_query($conn,$query);

    echo "<div class='project-list'>";

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $b = $row['batch'];

            echo "<a href='project-list.php?dept=$dept&type=$type&batch=$b'>
            $b
            </a>";
        }
    } else {
        echo "<p>No Batches Found</p>";
    }

    echo "</div>";
}

// ✅ STEP 2: SHOW PROJECTS
if($batch){

    $query = "SELECT * FROM projects 
    WHERE UPPER(department)=UPPER('$dept') 
    AND LOWER(project_type)=LOWER('$type') 
    AND batch='$batch'";

    $result = mysqli_query($conn,$query);

    echo "<h2>$batch Projects</h2>";

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
?>

<div class="project-item">

<h3><?php echo $row['project_name']; ?></h3>
<p>Guide: <?php echo $row['guide_name']; ?></p>

<a href="uploads/<?php echo $row['file']; ?>" target="_blank" class="view-btn">
View
</a>
<?php if($_SESSION['role']=="staff"){ ?>
<a href="delete.php?id=<?php echo $row['id']; ?>" 
onclick="return confirm('Are you sure you want to delete this project?')" 
class="delete-btn">
🗑️
</a>
<?php } ?>

</div>

<?php
        }
    } else {
        echo "<p>No Projects Found</p>";
    }
}
?>

</div>
</div>
</div>

</body>
</html>