<?php
session_start();
include "config.php";

$error = "";

if(isset($_POST['signup'])){

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

// ✅ Check college domain
if(!str_ends_with($email, "@sdmcujire.in")){
    $error = "❌ Use college email only (@sdmcujire.in)";
} else {

    // ✅ Check duplicate email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();

    $role = $_POST['role'];
$department = NULL;

if($role === "staff"){
    $department = strtoupper(trim($_POST['department'])); // clean input
}
if($role === "staff" && empty($department)){
    $error = "❌ Department required for staff";
}
if($role === "staff" && empty($_POST['department'])){
    $error = "❌ Please select a department";
}

if($role === "student" && !preg_match('/^[0-9]{6}$/', $username)){
    $error = "❌ Roll number must be 6 digits";
}
    if($result->num_rows > 0){
        $error = "❌ Email already registered";
    } else {

        // ✅ Hash password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // ✅ AUTO ROLE DETECTION
        if(preg_match('/^[0-9]{6}$/', $username)){
            $role = "student";   // exactly 6 digits
        } else {
            $role = "staff";     // anything else
        }

        // ✅ Insert into DB
        $stmt = $conn->prepare("INSERT INTO users(username,email,password,role,department) VALUES(?,?,?,?,?)");
        $stmt->bind_param("sssss",$username,$email,$hashed,$role,$department);

        $stmt->execute();

        // ✅ Redirect to login
        header("Location: login.php?success=1");
        exit();
    }
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Sign Up</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="main-container">

<div class="left-panel">
<img src="image/logo.jpeg" class="logo">
<h1>SPARK</h1>
<h3>Create your account</h3>
</div>

<div class="right-panel">
<div class="card">

<h2>Sign Up</h2>

<form method="POST">

<center>
<div class="role-container">

<label>
<input type="radio" name="role" value="student" required onclick="toggleDept()">
Student
</label>

<label>
<input type="radio" name="role" value="staff" required onclick="toggleDept()">
Staff
</label>

</div></center>

<div id="deptField" style="display:none;">
<select name="department">
<option value="Computer Science">Computer Science</option>
<option value="Commerce">Commerce</option>
<option value="Political Science">Political Science</option>
<option value="Arts">Arts</option>
<option value="Kannada">Kannada</option>
<option value="English">English</option>
</select>
</div>
<script>
function toggleDept(){

    let role = document.querySelector('input[name="role"]:checked').value;
    let dept = document.getElementById("deptField");
    let userField = document.getElementById("userField");

    if(role === "staff"){
        dept.style.display = "block";

        userField.innerHTML = `
        <input type="text" name="username" placeholder="Enter Staff Name" required>
        `;

    } else {
        dept.style.display = "none";

        userField.innerHTML = `
        <input type="text" name="username" placeholder="Enter Roll Number" required>
        `;
    }
}
</script>
<div id="userField">
<input type="text" name="username" placeholder="Name" required>
</div>
<input type="email" name="email" placeholder="College Email ID" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="signup">Register</button>

</form>

<p style="color:red;"><?php echo $error; ?></p>

<p>Already have account? <a href="login.php">Login</a></p>

</div>
</div>

</div>

</body>
</html>