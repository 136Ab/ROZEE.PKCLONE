<?php include "db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Rozee.pk Clone - Home</title>
    <style>
        body {font-family: Arial; margin:0; background:#f4f4f9;}
        header {background:#0077b6; color:#fff; padding:15px; text-align:center;}
        nav a {color:white; margin:0 15px; text-decoration:none; font-weight:bold;}
        .jobs, .categories {display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin:20px;}
        .card {background:white; padding:15px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1);}
        .card:hover {transform:scale(1.02); transition:0.3s;}
        .btn {background:#0096c7; color:white; padding:8px 15px; border:none; border-radius:5px; cursor:pointer;}
        .btn:hover {background:#023e8a;}
    </style>
</head>
<body>
<header>
    <h1>Rozee.pk Clone</h1>
    <nav>
        <a href="signup.php">Signup</a>
        <a href="login.php">Login</a>
        <a href="post_job.php">Post Job</a>
        <a href="search_jobs.php">Find Jobs</a>
    </nav>
</header>

<h2 style="text-align:center; margin-top:20px;">Featured Jobs</h2>
<div class="jobs">
<?php
$jobs = $conn->query("SELECT * FROM jobs ORDER BY created_at DESC LIMIT 6");
while($job = $jobs->fetch_assoc()) {
    echo "<div class='card'>
            <h3>{$job['title']}</h3>
            <p><b>Location:</b> {$job['location']}</p>
            <p><b>Type:</b> {$job['job_type']}</p>
            <p><b>Salary:</b> {$job['salary_range']}</p>
            <button class='btn' onclick=\"window.location.href='apply_job.php?job_id={$job['id']}'\">Apply Now</button>
          </div>";
}
?>
</div>
</body>
</html>
