<?php

include "connect.php";

/* Server-side validation */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$branch = trim($_POST['branch'] ?? '');
$cgpa = $_POST['cgpa'] ?? '';
$aptitude = $_POST['aptitude_score'] ?? '';
$skills = $_POST['skills_count'] ?? '';
$projects = $_POST['projects_count'] ?? '';

if (
    $name === '' ||
    $email === '' ||
    $branch === '' ||
    $cgpa === '' ||
    $aptitude === '' ||
    $skills === '' ||
    $projects === ''
) {
    die("Please fill all required fields.");
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

$cgpa = (float)$cgpa;
$aptitude = (int)$aptitude;
$skills = (int)$skills;
$projects = (int)$projects;


/* Placement Score */

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


/* Save in Database using Prepared Statement */

$sql = "INSERT INTO student
(name, email, branch, cgpa, aptitude_score,
skills_count, projects_count, placement_score, prediction)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Unable to save student data.");
}

$stmt->bind_param(
    "sssdiiids",
    $name,
    $email,
    $branch,
    $cgpa,
    $aptitude,
    $skills,
    $projects,
    $placementScore,
    $prediction
);

if ($stmt->execute()) {

    echo "<h2>Student Data Saved Successfully! ✅</h2>";

    echo "<h3>Placement Score: "
        . number_format($placementScore, 2)
        . "/100</h3>";

    echo "<h3>Prediction: "
        . htmlspecialchars($prediction)
        . "</h3>";

    echo "<br><a href='index.php'>Add Another Student</a>";

    echo "<br><br><a href='view.php'>View Students</a>";

} else {

    echo "Unable to save student data.";
}

$stmt->close();
$conn->close();

?>