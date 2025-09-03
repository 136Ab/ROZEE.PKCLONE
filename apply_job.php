<?php
include "db.php";
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "seeker") {
    echo "<script>alert('Only job seekers can apply!'); window.location='login.php';</script>";
    exit;
}
$job_id = $_GET['job_id'];
$uid = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cover = $_POST['cover_letter'];
    $resume = "";

    if(!empty($_FILES['resume']['name'])) {
        $resume = "uploads/" . basename($_FILES['resume']['name']);
        move_uploaded_file($_FILES['resume']['tmp_name'],$resume);
    }

    $sql = "INSERT INTO applications (job_id,seeker_id,cover_letter,resume) 
            VALUES ('$job_id','$uid','$cover','$resume')";
    if($conn->query($sql)){
        echo "<script>alert('Applied Successfully!'); window.location='search_jobs.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Apply Job - Rozee.pk Clone</title>
    <style>
        body{font-family:Arial;background:#e9ecef;padding:20px;}
        .card{background:white;padding:20px;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,.2);width:500px;margin:auto;}
        textarea,input{width:100%;padding:10px;margin:10px 0;border-radius:5px;border:1px solid #ccc;}
        button{background:#0077b6;color:white;padding:10px 20px;border:none;border-radius:5px;cursor:pointer;}
        button:hover{background:#023e8a;}
    </style>
</head>
<body>
<div class="card">
    <h2>Apply for Job</h2>
    <form method="post" enctype="multipart/form-data">
        <textarea name="cover_letter" placeholder="Write a cover letter..." required></textarea>
        <input type="file" name="resume" required>
        <button type="submit">Submit Application</button>
    </form>
</div>
</body>
</html>
