<?php
// error show karne ke liye
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

// jab form submit ho
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $fullname  = trim($_POST['fullname']);
    $email     = trim($_POST['email']);
    $password  = trim($_POST['password']);
    $user_type = trim($_POST['user_type']);

    if ($fullname != "" && $email != "" && $password != "" && $user_type != "") {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (fullname, email, password, user_type) 
                VALUES ('$fullname', '$email', '$hashedPassword', '$user_type')";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>✅ Signup successful!</p>";
        } else {
            echo "<p style='color:red;'>❌ Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:orange;'>⚠️ Please fill all fields!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f7f7f7; text-align:center; }
        form { background:#fff; padding:20px; border-radius:10px; width:300px; margin:50px auto; box-shadow:0 0 10px rgba(0,0,0,0.1); }
        input, select, button { width:90%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; }
        button { background:#28a745; color:#fff; border:none; cursor:pointer; }
        button:hover { background:#218838; }
    </style>
</head>
<body>
    <h2>Create Account</h2>
    <form action="" method="POST">
        <input type="text" name="fullname" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        
        <select name="user_type" required>
            <option value="">-- Select User Type --</option>
            <option value="jobseeker">Job Seeker</option>
            <option value="employer">Employer</option>
        </select><br>

        <button type="submit" name="submit">Sign Up</button>
    </form>
</body>
</html>
