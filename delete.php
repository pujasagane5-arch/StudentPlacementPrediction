<?php

include "connect.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid student ID.");
}

$id = (int)$_GET['id'];

$sql = "DELETE FROM student WHERE student_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Unable to delete student record.");
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: view.php");
    exit();

} else {

    echo "Unable to delete student record.";
}

$stmt->close();
$conn->close();

?>