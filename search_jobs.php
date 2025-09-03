<?php
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

$sql = "SELECT * FROM jobs WHERE title LIKE ? OR company LIKE ? OR location LIKE ? OR category LIKE ?";
$stmt = $conn->prepare($sql);
$like = "%" . $search . "%";
$stmt->bind_param("ssss", $like, $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Job Search</title>
    <style>
        body {font-family: Arial, sans-serif; background: #f4f6f9; margin:0; padding:20px;}
        h2 {color:#333;}
        .job-card {
            background:#fff;
            padding:15px;
            margin:10px 0;
            border-radius:10px;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
        }
        .job-card h3 {margin:0; color:#007bff;}
        .job-card p {margin:5px 0;}
    </style>
</head>
<body>
    <h2>Search Results for "<?php echo htmlspecialchars($search); ?>"</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="job-card">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><b>Company:</b> <?php echo htmlspecialchars($row['company']); ?></p>
                <p><b>Location:</b> <?php echo htmlspecialchars($row['location']); ?></p>
                <p><b>Category:</b> <?php echo htmlspecialchars($row['category']); ?></p>
                <p><b>Type:</b> <?php echo htmlspecialchars($row['type']); ?></p>
                <p><b>Salary:</b> <?php echo htmlspecialchars($row['salary']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No jobs found.</p>
    <?php endif; ?>

</body>
</html>
