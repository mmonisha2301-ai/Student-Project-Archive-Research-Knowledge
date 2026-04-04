<?php
session_start();
include "config.php";

$error="";

if(isset($_POST['login'])){

$email = trim($_POST['email']);
$password = trim($_POST['password']);

// ✅ Domain check
if(!str_ends_with($email, "@sdmcujire.in")){
    $error = "❌ Use college email only";
} else {

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){

        // ✅ Password check (supports hashed + old plain)
        if(password_verify($password, $row['password']) || $password == $row['password']){

            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = strtolower(trim($row['role']));

            header("Location: departments.php");
            exit();

        } else {
            $error = "❌ Incorrect Password";
        }

    } else {
        $error = "❌ Email not registered";
    }
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="main-container">

<div class="left-panel">
<img src="image/logo.jpeg" class="logo">
<h1>SPARK</h1>
<h3>Student Project Archive & Research Knowledge</h3>
</div>

<div class="right-panel">
<div class="card">

<h2>Login</h2>

<?php
if(isset($_GET['success'])){
    echo "<p style='color:green;'>✅ Registration Successful! Please Login</p>";
}
?>

<form method="POST">

<input type="email" name="email" placeholder="College Email ID" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="login">Login</button>

</form>

<p>Don't have account? <a href="signup.php">Sign Up</a></p>

<p style="color:red;"><?php echo $error; ?></p>

</div>
</div>

</div>

</body>
</html>