<?php
require 'config/db.php'; // connect to MySQL

echo "<h1>Available Courses</h1>";

try {
    // Fetch all courses with teacher name
    $stmt = $pdo->query("
        SELECT c.id, c.title, c.description, u.name AS teacher
        FROM courses c
        JOIN users u ON c.teacher_id = u.id
    ");

    $courses = $stmt->fetchAll();

    if (count($courses) === 0) {
        echo "<p>No courses available yet.</p>";
    } else {
        echo "<ul>";
        foreach ($courses as $course) {
            echo "<li>";
            echo "<strong>" . htmlspecialchars($course['title']) . "</strong> ";
            echo "(Teacher: " . htmlspecialchars($course['teacher']) . ")<br>";
            echo "<em>" . htmlspecialchars($course['description']) . "</em>";
            echo "</li>";
        }
        echo "</ul>";
    }

} catch (PDOException $e) {
    echo "Error fetching courses: " . $e->getMessage();
}

