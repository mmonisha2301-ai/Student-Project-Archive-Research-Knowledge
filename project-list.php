<?php
session_start();
include "config.php";

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
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
<img src="image/logo.jpg" class="logo">
<h1>SPARK</h1>
<h3>View projects</h3>
</div>

<div class="right-panel">

<?php if(isset($_GET['batch'])){ ?>

<a href="project-list.php" class="back-btn">← Back</a>

<?php } else { ?>

<a href="project-type.php" class="back-btn">← Back</a>

<?php } ?>
<a href="logout.php" class="logout-btn">Logout</a>

<div class="card">

<?php
// ✅ STEP 1: SHOW ALL BATCHES
if(!isset($_GET['batch'])){

    echo "<h2>Project Batches</h2>";

    $query = "SELECT DISTINCT batch FROM projects ORDER BY batch DESC";
    $result = mysqli_query($conn,$query);

    echo "<div class='project-list'>";

    if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_assoc($result)){
            $batch = $row['batch'];

            echo "<a href='project-list.php?batch=$batch' class='batch-btn'>
                    $batch
                  </a>";
        }

    } else {
        echo "<p>No Batches Found</p>";
    }

    echo "</div>";
}
?>

<?php
// ✅ STEP 2: SHOW PROJECTS
if(isset($_GET['batch'])){

    $batch = $_GET['batch'];

    $query = "SELECT * FROM projects WHERE batch='$batch'";
    $result = mysqli_query($conn,$query);

    echo "<h2>$batch Projects</h2>";

    if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_assoc($result)){
?>

<div class="project-item">

<h3><?php echo $row['project_name']; ?></h3>
<p>Guide : <?php echo $row['guide_name']; ?></p>

<a href="uploads/<?php echo $row['file']; ?>" target="_blank" class="view-btn">
View
</a>

<?php if(isset($_SESSION['role']) && $_SESSION['role'] === "staff"){ ?>
<a href="delete.php?id=<?php echo $row['id']; ?>" 
onclick="return confirm('Are you sure?')" 
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