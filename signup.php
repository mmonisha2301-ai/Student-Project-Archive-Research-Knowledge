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
        $stmt = $conn->prepare("INSERT INTO users(username,email,password,role) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss",$username,$email,$hashed,$role);
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

<input type="text" name="username" placeholder="Username" required>

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