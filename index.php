<!DOCTYPE html>
<html>

<head>
    <title>Student Placement Prediction</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Student Placement Prediction System</h1>

    <p class="subtitle">
        Predict your placement readiness
    </p>

    <form action="save.php" method="POST">

        <label>Name:</label>
        <input
            type="text"
            name="name"
            required
        >

        <label>Email:</label>
        <input
            type="email"
            name="email"
            required
        >

        <label>Branch:</label>
        <input
            type="text"
            name="branch"
            required
        >

        <label>CGPA:</label>
        <input
            type="number"
            step="0.01"
            name="cgpa"
            min="0"
            max="10"
            required
        >

        <label>Aptitude Score:</label>
        <input
            type="number"
            name="aptitude_score"
            min="0"
            max="100"
            required
        >

        <label>Number of Skills:</label>
        <input
            type="number"
            name="skills_count"
            min="0"
            max="100"
            required
        >

        <label>Number of Projects:</label>
        <input
            type="number"
            name="projects_count"
            min="0"
            max="50"
            required
        >

        <button type="submit">
            Submit Student
        </button>

    </form>

    <a class="page-link" href="view.php">
        View Students
    </a>

</div>

</body>

</html>