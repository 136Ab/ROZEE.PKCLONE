<?php
include "db.php";
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "employer") {
    echo "<script>alert('Access denied!'); window.location='login.php';</script>";
    exit;
}
$uid = $_SESSION['user_id'];
$sql = "SELECT a.*, u.name, u.email, j.title 
        FROM applications a 
        JOIN users u ON a.seeker_id=u.id 
        JOIN jobs j ON a.job_id=j.id 
        WHERE j.employer_id=$uid";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Applications - Rozee.pk Clone</title>
    <style>
        body{font-family:Arial;background:#f1f2f6;padding:20px;}
        table{width:100%;border-collapse:collapse;background:#fff;box-shadow:0 0 10px rgba(0,0,0,.1);}
        th,td{padding:10px;border:1px solid #ccc;text-align:left;}
        th{background:#0077b6;color:white;}
        tr:hover{background:#f8f9fa;}
        a{color:#0077b6;text-decoration:none;}
    </style>
</head>
<body>
    <h2>Job Applications</h2>
    <table>
        <tr>
            <th>Job Title</th>
            <th>Applicant</th>
            <th>Email</th>
            <th>Cover Letter</th>
            <th>Resume</th>
        </tr>
        <?php while($row=$res->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['cover_letter']; ?></td>
            <td><a href="<?php echo $row['resume']; ?>" target="_blank">View Resume</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
