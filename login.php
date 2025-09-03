<?php
session_start();
include "db.php";

// Optional: dev-time errors (blank page se bachne ke liye)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$err = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST['email'] ?? "");
    $password = trim($_POST['password'] ?? "");

    if ($email === "" || $password === "") {
        $err = "Please fill all fields.";
    } else {
        // Prepared statement to fetch user by email
        $stmt = $conn->prepare("SELECT id, fullname, email, password, user_type FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $res->num_rows === 1) {
            $row = $res->fetch_assoc();
            $dbHash = $row['password'];

            $ok = false;

            // 1) Try normal hashed verify
            if (password_verify($password, $dbHash)) {
                $ok = true;
            } 
            // 2) Auto-migrate: if old account had plaintext password stored
            else if ($password === $dbHash) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $up = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $up->bind_param("si", $newHash, $row['id']);
                $up->execute();
                $ok = true;
            }

            if ($ok) {
                session_regenerate_id(true);
                $_SESSION['id']        = $row['id'];
                $_SESSION['fullname']  = $row['fullname'];
                $_SESSION['email']     = $row['email'];
                $_SESSION['user_type'] = $row['user_type'];

                // JS redirect as requested
                echo "<script>window.location.href='profile.php';</script>";
                exit;
            } else {
                $err = "Invalid password!";
            }
        } else {
            $err = "No user found with this email!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
    body{font-family:Arial, sans-serif;background:#f4f6f9;margin:0;padding:0;display:flex;align-items:center;justify-content:center;height:100vh;}
    .box{background:#fff;padding:24px;border-radius:14px;box-shadow:0 10px 25px rgba(0,0,0,.08);width:360px;max-width:92%;}
    h2{margin:0 0 10px;color:#0d2b45}
    .sub{margin:0 0 18px;color:#51606b;font-size:14px}
    input{width:100%;padding:12px 14px;margin:8px 0;border:1px solid #d7dfe7;border-radius:10px;outline:none}
    input:focus{border-color:#0ea5e9;box-shadow:0 0 0 3px rgba(14,165,233,.15)}
    button{width:100%;padding:12px 14px;margin-top:8px;border:none;border-radius:10px;background:#0ea5e9;color:#fff;font-weight:700;cursor:pointer}
    button:hover{background:#0284c7}
    .err{color:#d71920;background:#ffe8ea;border:1px solid #ffc7cc;padding:10px;border-radius:10px;margin:10px 0;font-size:14px}
</style>
</head>
<body>
<div class="box">
    <h2>Welcome back</h2>
    <p class="sub">Login to continue</p>
    <?php if(!empty($err)): ?><div class="err"><?php echo htmlspecialchars($err); ?></div><?php endif; ?>
    <form method="POST" onsubmit="return true;">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required minlength="4">
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
