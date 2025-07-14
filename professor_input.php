<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registrationType = $_POST["registration_type"];
    $role = $_POST["role"];
    $ProfessorID = $_POST['id'];

    if ($registrationType == "new" && $role == "Professor") {
        $Name = $_POST["Name"];
        $Department = $_POST["Department"];
        $Designation = $_POST["Designation"];
        $Email1 = $_POST["Email1"];
        $Email2 = !empty($_POST["Email2"]) ? $_POST["Email2"] : null;
        $Phone1 = !empty($_POST["Phone1"]) ? $_POST["Phone1"] : null;
        $Phone2 = !empty($_POST["Phone2"]) ? $_POST["Phone2"] : null;
        $Qualification = !empty($_POST["Qualification"]) ? $_POST["Qualification"] : null;
        $Experience = !empty($_POST["Experience"]) ? $_POST["Experience"] : null;

        $sql = "INSERT INTO Professors (ProfessorID, Name, Department, Designation,
        Email1, Email2, Phone1, Phone2, Qualification, Experience)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssssss", $ProfessorID, $Name, $Department, $Designation, $Email1, $Email2, $Phone1, $Phone2, $Qualification, $Experience);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "<div style='text-align: center;'>";
                echo "New Professor registered successfully!";
                echo "</div>";
            } else {
                echo "<div style='text-align: center;'>";
                echo "Error: Unable to register new Professor.";
                echo "</div>";
            }
            $stmt->close();
        } else {
            echo "<div style='text-align: center;'>";
            echo "Error: Unable to prepare SQL statement.";
            echo "</div>";
        }
    }
}
$conn->close();
?>
