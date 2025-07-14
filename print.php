<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include TCPDF library
require_once('TCPDF-main/tcpdf.php');

// Create new PDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tanayaa');
$pdf->SetTitle('PDF Report');
$pdf->SetSubject('Query Results');
$pdf->SetKeywords('PDF, Report, Query');
$pdf->setFontSubsetting(true);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

require_once 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["role"];
    $id = $_POST["id"];
    $heading = ($role == "student") ? "Student Information" : "Professor Information";
    $pdf->Cell(0, 10, $heading, 0, 1, 'C');
        if ($role == "student") {
            $sql = "SELECT * FROM students WHERE Registration_ID = '$id'";
            $result = mysqli_query($conn, $sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key => $value) {
                        $pdf->Cell(60, 10, $key, 1, 0, 'L');
                        $pdf->Cell(0, 10, $value, 1, 1, 'L');
                    }
                }
            } else {
                $pdf->Cell(0, 10, "No student found with ID: $id", 1, 1, 'C');
            }
            $sqlCourses = "SELECT DISTINCT c.Course_ID, c.Academic_Department, c.Programme
            FROM student_courses pc
            JOIN course c ON pc.course_id = c.Course_ID
            WHERE pc.registration_id = '$id'";
    $heading = "Course Information";
    $pdf->Cell(0, 10, $heading, 0, 1, 'C');

$resultCourses = $conn->query($sqlCourses);
if ($resultCourses->num_rows > 0) {
while ($row = $resultCourses->fetch_assoc()) {
    foreach ($row as $key => $value) {
        $pdf->Cell(60, 10, $key, 1, 0, 'L');
        $pdf->Cell(0, 10, $value, 1, 1, 'L');
    }
 }
} else {
    $pdf->Cell(0, 10, "No course found for ID: $id", 1, 1, 'C');
}
$sqlgrade = "SELECT * FROM gradelist WHERE registration_number = '$id'";
$heading = "Grade Information";
$pdf->Cell(0, 10, $heading, 0, 1, 'C');
$resultGrade = $conn->query($sqlgrade);
if ($resultGrade->num_rows > 0) {
while ($row = $resultGrade->fetch_assoc()) {
    foreach ($row as $key => $value) {
        $pdf->Cell(60, 10, $key, 1, 0, 'L');
        $pdf->Cell(0, 10, $value, 1, 1, 'L');
    }
 }
} else {
    $pdf->Cell(0, 10, "No grades found for ID: $id", 1, 1, 'C');
}
$sql = "SELECT p.ProfessorID, p.Name AS ProfessorName
FROM student_courses sc
JOIN course c ON sc.course_id = c.Course_ID
JOIN professor_courses pc ON c.Course_ID = pc.Course_ID
JOIN Professors p ON pc.professor_id = p.ProfessorID
WHERE sc.registration_id = '$id'";

$heading = "Professor Information";
$pdf->Cell(0, 10, $heading, 0, 1, 'C');
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
    foreach ($row as $key => $value) {
        $pdf->Cell(60, 10, $key, 1, 0, 'L');
        $pdf->Cell(0, 10, $value, 1, 1, 'L');
    }
}
} else {
    $pdf->Cell(0, 10, "No professors found for ID: $id", 1, 1, 'C');
}
            $pdf->Output('dynamic_report.pdf', 'D');
            exit;
} elseif ($role == "Professor") {
            $sql = "SELECT * FROM Professors WHERE ProfessorID = '$id'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key => $value) {
                        $pdf->Cell(60, 10, $key, 1, 0, 'L');
                        $pdf->Cell(0, 10, $value, 1, 1, 'L');
                    }
                }
            } else {
                $pdf->Cell(0, 10, "No professor found with ID: $id", 1, 1, 'C');
            }
            $sqlCourses = "SELECT DISTINCT c.Course_ID, c.Academic_Department, c.Programme
            FROM professor_courses pc
            JOIN course c ON pc.Course_ID = c.Course_ID
            WHERE pc.professor_id = '$id'";

$heading = "Course Information";
$pdf->Cell(0, 10, $heading, 0, 1, 'C');

$resultCourses = $conn->query($sqlCourses);
if ($resultCourses->num_rows > 0) {
while ($row = $resultCourses->fetch_assoc()) {
    foreach ($row as $key => $value) {
        // Output data to PDF
        $pdf->Cell(60, 10, $key, 1, 0, 'L');
        $pdf->Cell(0, 10, $value, 1, 1, 'L');
    }
 }
}else {
    $pdf->Cell(0, 10, "No courses found for ID: $id", 1, 1, 'C');
}
 $sqlStudents = "SELECT s.Registration_ID, s.First_Name, s.SURNAME
                 FROM student_courses sc
                 JOIN students s ON sc.Registration_ID = s.Registration_ID
                 JOIN course c ON sc.Course_ID = c.Course_ID
                 JOIN professor_courses pc ON c.Course_ID = pc.Course_ID
                 WHERE pc.professor_id = '$id'";

$heading = "Students Information";
$pdf->Cell(0, 10, $heading, 0, 1, 'C');

 $resultStudents = $conn->query($sqlStudents);
 if ($resultStudents->num_rows > 0) {
 while ($row = $resultStudents->fetch_assoc()) {
    foreach ($row as $key => $value) {
        $pdf->Cell(60, 10, $key, 1, 0, 'L');
        $pdf->Cell(0, 10, $value, 1, 1, 'L');
    }
     }
}else {
    $pdf->Cell(0, 10, "No students found for ID: $id", 1, 1, 'C');
}
            $pdf->Output('dynamic_report.pdf', 'D');
            exit;
        }

}

$conn->close();
?>