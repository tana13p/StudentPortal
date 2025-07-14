<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["role"];
    $id = $_POST["id"];

require_once 'includes/db_connect.php';

    $userTable = ($role == "student") ? "students" : "Professors";
    $userID = ($role == "student") ? "Registration_ID" : "ProfessorID";
    $courseTable = "student_courses";
    $profCourseTable = "professor_courses";

    $conn->begin_transaction();

    try {
        $deleteUserSql = "DELETE FROM $userTable WHERE  $userID= '$id'";
        $conn->query($deleteUserSql);

        if ($role == "student") {
            $deleteCoursesSql = "DELETE FROM $courseTable WHERE registration_id = '$id'";
        } else {
            $deleteCoursesSql = "DELETE FROM $profCourseTable WHERE professor_id = '$id'";
        }
        $conn->query($deleteCoursesSql);
        $conn->commit();

        echo "<div style='text-align: center;'>";
        echo "<p>User and related records deleted successfully.</p>";
        echo "</div>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
} else {
    header("Location: index.php");
    exit;
}
?>
