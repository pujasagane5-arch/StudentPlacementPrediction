<?php

include "connect.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid student ID.");
}

$id = (int)$_GET['id'];

$sql = "SELECT * FROM student WHERE student_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Unable to load student record.");
}

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Student record not found.");
}

$student = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Update Student</title>

    <style>

        body {
            font-family: Arial;
            background: #eef2f7;
            padding: 30px;
        }

        .container {
            width: 450px;
            max-width: 100%;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
        }

        h2 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

    </style>

</head>

<body>

<div class="container">

<h2>Update Student</h2>

<form action="update.php" method="POST">

    <input
        type="hidden"
        name="student_id"
        value="<?php echo (int)$student['student_id']; ?>"
    >

    <label>Name</label>

    <input
        type="text"
        value="<?php echo htmlspecialchars($student['name']); ?>"
        disabled
    >

    <label>Email</label>

    <input
        type="email"
        name="email"
        value="<?php echo htmlspecialchars($student['email']); ?>"
        required
    >

    <label>CGPA</label>

    <input
        type="number"
        step="0.01"
        min="0"
        max="10"
        name="cgpa"
        value="<?php echo htmlspecialchars($student['cgpa']); ?>"
        required
    >

    <label>Aptitude Score</label>

    <input
        type="number"
        min="0"
        max="100"
        name="aptitude_score"
        value="<?php echo htmlspecialchars($student['aptitude_score']); ?>"
        required
    >

    <label>Number of Skills</label>

    <input
        type="number"
        min="0"
        name="skills_count"
        value="<?php echo htmlspecialchars($student['skills_count']); ?>"
        required
    >

    <label>Number of Projects</label>

    <input
        type="number"
        min="0"
        name="projects_count"
        value="<?php echo htmlspecialchars($student['projects_count']); ?>"
        required
    >

    <button type="submit">
        Update Student
    </button>

</form>

<br>

<center>
    <a href="view.php">← Back to Students</a>
</center>

</div>

</body>

</html>

<?php

$stmt->close();
$conn->close();

?>