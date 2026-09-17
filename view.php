<?php

include "connect.php";

$sql = "SELECT * FROM student";
$result = $conn->query($sql);

if (!$result) {
    die("Unable to load student records.");
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Student Records</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 35px 20px;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e3a8a, #312e81);
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
            overflow-x: auto;
        }

        h1 {
            text-align: center;
            color: #172554;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        th {
            background: #1e3a8a;
            color: white;
            padding: 13px 10px;
            font-size: 14px;
        }

        td {
            padding: 12px 10px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }

        tr:hover {
            background: #f8fafc;
        }

        .high {
            color: green;
            font-weight: bold;
        }

        .medium {
            color: #d97706;
            font-weight: bold;
        }

        .low {
            color: red;
            font-weight: bold;
        }

        .update-btn {
            background: #2563eb;
            color: white;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 2px;
        }

        .delete-btn {
            background: #dc2626;
            color: white;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 2px;
        }

        .update-btn:hover,
        .delete-btn:hover {
            opacity: 0.85;
        }

        .add-btn {
            display: inline-block;
            margin-top: 20px;
            background: #7c3aed;
            color: white;
            padding: 11px 18px;
            text-decoration: none;
            border-radius: 7px;
        }

        .add-btn:hover {
            opacity: 0.9;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Student Placement Records</h1>

    <table>

        <tr>

            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Branch</th>
            <th>CGPA</th>
            <th>Aptitude</th>
            <th>Skills</th>
            <th>Projects</th>
            <th>Placement Score</th>
            <th>Prediction</th>
            <th>Action</th>

        </tr>

        <?php

        while ($row = $result->fetch_assoc()) {

            $prediction = $row['prediction'];

            if ($prediction == "HIGH") {
                $class = "high";
            }
            elseif ($prediction == "MEDIUM") {
                $class = "medium";
            }
            else {
                $class = "low";
            }

        ?>

        <tr>

            <td><?php echo $row['student_id']; ?></td>

            <td><?php echo htmlspecialchars($row['name']); ?></td>

            <td><?php echo htmlspecialchars($row['email']); ?></td>

            <td><?php echo htmlspecialchars($row['branch']); ?></td>

            <td><?php echo $row['cgpa']; ?></td>

            <td><?php echo $row['aptitude_score']; ?></td>

            <td><?php echo $row['skills_count']; ?></td>

            <td><?php echo $row['projects_count']; ?></td>

            <td>
                <?php echo number_format($row['placement_score'], 2); ?>
            </td>

            <td class="<?php echo $class; ?>">
                <?php echo htmlspecialchars($prediction); ?>
            </td>

            <td>

                <a
                    class="update-btn"
                    href="edit.php?id=<?php echo $row['student_id']; ?>"
                >
                    Update
                </a>

                <a
                    class="delete-btn"
                    href="delete.php?id=<?php echo $row['student_id']; ?>"
                    onclick="return confirm('Are you sure you want to delete this student?');"
                >
                    Delete
                </a>

            </td>

        </tr>

        <?php

        }

        ?>

    </table>

    <a class="add-btn" href="index.php">
        + Add New Student
    </a>

</div>

</body>

</html>

<?php

$conn->close();

?>