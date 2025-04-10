<?php
include('database.php'); 
$message = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $project_name = $_POST['project_name'];
    $project_description = $_POST['project_description'];
    $project_deadline = $_POST['project_deadline'];
    $project_start_date = $_POST['project_start_date'];
    $statuss = $_POST['status'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ✅ Use prepared statement for safe insertion
    $stmt = $conn->prepare("INSERT INTO todos (project_name, descriptions, start_date, end_date, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $project_name, $project_description, $project_start_date, $project_deadline, $statuss);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?message=Project%20Added%20Successfully");
        exit();
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <link rel="stylesheet" href="./styles.css"> 
</head>
<body>
    <h1>ToDo List</h1>

    <?php
    if (isset($_GET['message'])) {
        echo "<p style='color:green;'>✅ " . htmlspecialchars($_GET['message']) . "</p>";
    }
    if (!empty($message)) {
        echo "<p style='color:red;'>❌ " . htmlspecialchars($message) . "</p>";
    }
    ?>

    <!-- Form to add project -->
    <form action="" method="post" id="input-form">
    <input type="text" name="project_name" placeholder="Project Name" required>
    <br><br>

    <textarea name="project_description" placeholder="Project Description" required></textarea>
    <br><br>

    <input type="date" name="project_start_date" required>
    <br><br>

    <input type="date" name="project_deadline" required>
    <br><br>

    <select name="status" class="select-status" required>
        <option value="">-- Select Status --</option>
        <option value="incompleted">Incompleted</option>
        <option value="Progress">Progress</option>
        <option value="completed">Completed</option>
    </select>
    <br><br>

    <input type="submit" name="submit" value="Add Project">
</form>


    <h2>Project Details</h2>
    <?php
    // ✅ Fetch and show all todos
    $sql = "SELECT * FROM todos ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<strong>Project ID:</strong> " . $row['id'] . "<br>";
            echo "<strong>Name:</strong> " . htmlspecialchars($row['project_name']) . "<br>";
            echo "<strong>Description:</strong> " . htmlspecialchars($row['descriptions']) . "<br>";
            echo "<strong>Start Date:</strong> " . $row['start_date'] . "<br>";
            echo "<strong>End Date:</strong> " . $row['end_date'] . "<br>";
            echo "<strong>Status:</strong> " . $row['status'] . "<br>";
            echo "</div><br>";
        }
    } else {
        echo "<p>No projects found.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
