<?php

include "connect.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: view.php");
    exit();
}


/* Get form data */

$id = $_POST['student_id'] ?? '';
$email = trim($_POST['email'] ?? '');
$cgpa = $_POST['cgpa'] ?? '';
$aptitude = $_POST['aptitude_score'] ?? '';
$skills = $_POST['skills_count'] ?? '';
$projects = $_POST['projects_count'] ?? '';


/* Server-side validation */

if (!is_numeric($id) || $id <= 0) {
    die("Invalid student ID.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address.");
}

if (!is_numeric($cgpa) || $cgpa < 0 || $cgpa > 10) {
    die("CGPA must be between 0 and 10.");
}

if (!is_numeric($aptitude) || $aptitude < 0 || $aptitude > 100) {
    die("Aptitude score must be between 0 and 100.");
}

if (!is_numeric($skills) || $skills < 0) {
    die("Skills count cannot be negative.");
}

if (!is_numeric($projects) || $projects < 0) {
    die("Projects count cannot be negative.");
}


/* Convert values */

$id = (int)$id;
$cgpa = (float)$cgpa;
$aptitude = (int)$aptitude;
$skills = (int)$skills;
$projects = (int)$projects;


/* Recalculate placement score */

$cgpaScore = ($cgpa / 10) * 40;
$aptitudeScore = ($aptitude / 100) * 30;
$skillScore = (min($skills, 5) / 5) * 20;
$projectScore = (min($projects, 3) / 3) * 10;

$placementScore =
    $cgpaScore +
    $aptitudeScore +
    $skillScore +
    $projectScore;


/* Prediction */

if ($placementScore >= 80) {
    $prediction = "HIGH";
}
elseif ($placementScore >= 60) {
    $prediction = "MEDIUM";
}
else {
    $prediction = "LOW";
}


/* Update database using Prepared Statement */

$sql = "UPDATE student
        SET email=?,
            cgpa=?,
            aptitude_score=?,
            skills_count=?,
            projects_count=?,
            placement_score=?,
            prediction=?
        WHERE student_id=?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Unable to update student record.");
}

$stmt->bind_param(
    "sdiiidsi",
    $email,
    $cgpa,
    $aptitude,
    $skills,
    $projects,
    $placementScore,
    $prediction,
    $id
);


if ($stmt->execute()) {

    echo "<h2>Student Updated Successfully! ✅</h2>";

    echo "<p>Placement Score: "
        . number_format($placementScore, 2)
        . "/100</p>";

    echo "<p>Prediction: "
        . htmlspecialchars($prediction)
        . "</p>";

    echo "<br><a href='view.php'>View Students</a>";

}
else {

    echo "Unable to update student record.";
}


$stmt->close();
$conn->close();

?>