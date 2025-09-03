<?php
include "db.php";

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit;
}

// Handle job posting
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title       = $_POST['title'];
    $company     = $_POST['company'];
    $location    = $_POST['location'];
    $category    = $_POST['category'];
    $type        = $_POST['type'];
    $salary      = $_POST['salary'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $employer_id = $_SESSION['id']; // Logged in user ID

    // Insert into database
    $sql = "INSERT INTO jobs (title, company, location, category, type, salary, description, requirements, employer_id) 
            VALUES ('$title', '$company', '$location', '$category', '$type', '$salary', '$description', '$requirements', '$employer_id')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Job posted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Job</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; margin: 0; padding: 0; }
        .container { width: 50%; margin: 40px auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        form { display: flex; flex-direction: column; }
        label { margin: 10px 0 5px; font-weight: bold; }
        input, select, textarea { padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { margin-top: 20px; padding: 12px; border: none; background: #007BFF; color: #fff; font-size: 16px; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Post a Job</h2>
        <form method="POST">
            <label>Job Title</label>
            <input type="text" name="title" required>

            <label>Company</label>
            <input type="text" name="company" required>

            <label>Location</label>
            <input type="text" name="location" required>

            <label>Category</label>
            <input type="text" name="category" required>

            <label>Job Type</label>
            <select name="type" required>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
                <option value="Remote">Remote</option>
                <option value="Internship">Internship</option>
            </select>

            <label>Salary</label>
            <input type="text" name="salary">

            <label>Description</label>
            <textarea name="description" required></textarea>

            <label>Requirements</label>
            <textarea name="requirements"></textarea>

            <button type="submit">Post Job</button>
        </form>
    </div>
</body>
</html>
